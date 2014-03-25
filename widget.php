<?php

class MantisAdsWidget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct('mantis_ads', 'Mantis Advertisement');
	}

	public function widget($args, $instance)
	{
		$args = wp_parse_args($instance, array(
			'zone'    => null,
			'desktop' => null,
			'mobile'  => null
		));

		if ($args['zone'] && ($args['desktop'] || $args['mobile'])) {
			if (!has_action('wp_footer', 'mantis_ad_footer')) {
				add_action('wp_footer', 'mantis_ad_footer');
			}

			$attrs = array(
				'data-mantis-zone'    => $args['zone'],
				'data-mantis-desktop' => $args['desktop'],
				'data-mantis-mobile'  => $args['mobile']
			);

			$attrs = implode(' ', array_map(function ($v, $k) {
				return "$k='$v'";
			}, $attrs, array_keys($attrs)));

			echo "<div class='mantis-ad'><div $attrs></div></div>";
		}
	}

	public function form($instance)
	{
		$zones = mantis_ad_zones();

		require(MANTIS_ROOT . '/html/widgetform.php');
	}

	public function update($new, $old)
	{
		$zones = mantis_ad_zones();

		if (isset($new['zone'])) {
			foreach ($zones as $zone) {
				if ($zone->zone == $new['zone']) {
					$new['desktop'] = $zone->desktop;
					$new['mobile'] = $zone->mobile;

					break;
				}
			}
		}

		return $new;
	}
}

function mantis_ad_zones()
{
	$site = get_option('mantis_site_id');

	$zones = wp_cache_get('mantis_cache_zones');

	if ($zones === false) {
		$zones = array();

		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://admin.mantisadnetwork.com/api/wordpress/zones/?site=$site");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$data = curl_exec($ch);
			curl_close($ch);

			$zones = json_decode($data) ? : array();
		} catch (Exception $ex) {
			error_log($ex);
		}

		wp_cache_set('mantis_cache_zones', $zones, '', 10);
	}

	return $zones;
}

function mantis_ad_widget()
{
	if (get_option('mantis_site_id')) {
		register_widget('MantisAdsWidget');
	}
}

add_action('widgets_init', 'mantis_ad_widget');

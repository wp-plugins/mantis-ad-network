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
			'zone' => null
		));

		if ($args['zone']) {
			if (!has_action('wp_footer', 'mantis_ad_footer')) {
				add_action('wp_footer', 'mantis_ad_footer', 20);
			}

			$attrs = array(
				'data-mantis-zone' => $args['zone']
			);

			$class = '';

			if($args['mobileFloat']){
				$class = "mantis-float mantis-float-$args[mobileFloat]";

				wp_enqueue_script('jquery');
			}

			$attrs = implode(' ', array_map(function ($v, $k) {
				return "$k='$v'";
			}, $attrs, array_keys($attrs)));

			echo "<div class='mantis-ad $class'><div $attrs></div></div>";
		}
	}

	public function form($instance)
	{
		$zones = mantis_ad_zones();

		require(MANTIS_ROOT . '/html/widgetform.php');
	}

	public function update($new, $old)
	{
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
			curl_setopt($ch, CURLOPT_URL, "http://mantodea.mantisadnetwork.com/wordpress/zones/$site");
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

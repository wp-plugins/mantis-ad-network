<div class="wrap">
	<h2>MANTIS configuration</h2>

	<form method="post" action="options.php">
		<?php settings_fields( 'mantis-settings' ); ?>
		
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Website Identifier:</th>
				<td>
					<input type="text" name="mantis_site_id" value="<?php echo get_option('mantis_site_id'); ?>" />
					<p class="description">This identifier can found in the top right of your <a href="https://admin.mantisadnetwork.com" target="_blank">MANTIS administrative panel.</a></p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">Load Advertisement Code Asynchronously</th>
				<td>
					<select name="mantis_async">
						<option value="0">Turn Off</option>
						<option value="1" <?php echo get_option('mantis_async') ? 'selected="selected"' : ''; ?>>Turn On</option>
					</select>
					<p class="description">When enabled, the loading of MANTIS advertisements will not impact the time it takes to load a page. However, you may notice a slight delay in serving ads with this option enabled.</a></p>
				</td>
			</tr>
		</table>

		<?php submit_button(); ?>
	</form>
</div>



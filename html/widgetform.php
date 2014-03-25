<?php if (count($zones) > 0): ?>
	<select name="<?php echo $this->get_field_name('zone'); ?>">
		<?php foreach ($zones as $zone): ?>
			<option value="<?php echo $zone->zone ?>" <?php echo isset($instance['zone']) && $instance['zone'] == $zone->zone ? 'selected="selected"' : ''?>><?php echo $zone->name; ?></option>
		<?php endforeach; ?>
	</select>
<?php else: ?>
	There was a problem accessing MANTIS, please try again later.
<?php endif; ?>

<?php if (count($zones) > 0): ?>
	<div>
		Zone: <select name="<?php echo $this->get_field_name('zone'); ?>">
			<?php foreach ($zones as $zone): ?>
				<option value="<?php echo $zone->zone ?>" <?php echo isset($instance['zone']) && $instance['zone'] == $zone->zone ? 'selected="selected"' : ''?>><?php echo $zone->name; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div>
		Mobile Float: <select name="<?php echo $this->get_field_name('mobileFloat'); ?>">
			<option value="">Do not float</option>
			<option value="top" <?php echo isset($instance['mobileFloat']) && $instance['mobileFloat'] == 'top' ? 'selected="selected"' : ''?>>Stick to top</option>
			<option value="bottom" <?php echo isset($instance['mobileFloat']) && $instance['mobileFloat'] == 'bottom' ? 'selected="selected"' : ''?>>Stick to bottom</option>
		</select>
	</div>
    <div>
        Responsive: <select name="<?php echo $this->get_field_name('fixed'); ?>">
            <option value="">Dynamicly resize ad</option>
            <option value="1" <?php echo isset($instance['fixed']) && $instance['fixed'] == '1' ? 'selected="selected"' : ''?>>Enforce exact ad size</option>
        </select>
    </div>
<?php else: ?>
	There was a problem accessing MANTIS, please try again later.
<?php endif; ?>

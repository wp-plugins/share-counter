<?php

class ShareCounterWidget extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {

		parent::__construct(
			'sharecounter-id', __('Share Counter', 'sharecounter-locale'), array(
		    'classname' => 'ShareCounterWidget',
		    'description' => __('This widget displays a counter with the total likes, shares, tweets, etc for your website..', 'sharecounter-locale')
			)
		);
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @args			The array of form elements
	 * @instance		The current instance of the widget
	 */
	public function widget($args, $instance) {

		extract($args, EXTR_SKIP);
		$content = get_the_content();

		$url = get_permalink($post_id);
		$json = file_get_contents("http://api.sharedcount.com/?url=" . rawurlencode($url));
		$counts = json_decode($json, true);

		echo $before_widget;

		if (strlen($instance['title']) > 0) {
			echo $before_title . $instance['title'] . $after_title;
		}

		$totalshares = 0;
		$classname = '';
		$totalclassname = '';

		if (strlen($instance['classname']) > 0) {
			$classname = $instance['classname'];
		}

		if (strlen($instance['totalclassname']) > 0) {
			$totalclassname = $instance['totalclassname'];
		}

		if ($instance['twitter'] == '1') {
			echo '<div class="' . $classname . '">' . __('Twitter shares: ', 'sharecounter-locale') . $counts["Twitter"] . '</div>';
			$totalshares += $counts["Twitter"];
		}

		if ($instance['facebook_likes'] == '1') {
			echo '<div class="' . $classname . '">' . __('Facebook likes: ', 'sharecounter-locale') . $counts["Facebook"]["like_count"] . '</div>';
			$totalshares += $counts["Facebook"]["like_count"];
		}

		if ($instance['facebook_shares'] == '1') {
			echo '<div class="' . $classname . '">' . __('Facebook shares: ', 'sharecounter-locale') . $counts["Facebook"]["share_count"] . '</div>';
			$totalshares += $counts["Facebook"]["share_count"];
		}

		if ($instance['googleplus'] == '1') {
			echo '<div class="' . $classname . '">' . __('Google+ shares: ', 'sharecounter-locale') . $counts["GooglePlusOne"] . '</div>';
			$totalshares += $counts["GooglePlusOne"];
		}

		if ($instance['pinterest'] == '1') {
			echo '<div class="' . $classname . '">' . __('Pinterest shares: ', 'sharecounter-locale') . $counts["Pinterest"] . '</div>';
			$totalshares += $counts["Pinterest"];
		}

		if ($instance['linkedin'] == '1') {
			echo '<div class="' . $classname . '">' . __('Linkedin shares: ', 'sharecounter-locale') . $counts["LinkedIn"] . '</div>';
			$totalshares += $counts["LinkedIn"];
		}

		if ($instance['digg'] == '1') {
			echo '<div class="' . $classname . '">' . __('Digg shares: ', 'sharecounter-locale') . $counts["Diggs"] . '</div>';
			$totalshares += $counts["Diggs"];
		}

		if ($instance['reddit'] == '1') {
			echo '<div class="' . $classname . '">' . __('Reddit shares: ', 'sharecounter-locale') . $counts["Reddit"] . '</div>';
			$totalshares += $counts["Reddit"];
		}

		if ($instance['stumbleupon'] == '1') {
			echo '<div class="' . $classname . '">' . __('StumbleUpon shares: ', 'sharecounter-locale') . $counts["StumbleUpon"] . '</div>';
			$totalshares += $counts["StumbleUpon"];
		}

		if ($instance['delicious'] == '1') {
			echo '<div class="' . $classname . '">' . __('Delicious shares: ', 'sharecounter-locale') . $counts["Delicious"] . '</div>';
			$totalshares += $counts["Delicious"];
		}

		if ($instance['totalshares'] == '1') {
			echo '<div class="' . $totalclassname . '">' . __('Total shares: ', 'sharecounter-locale') . $totalshares . '</div>';
		}

		echo $after_widget;
	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @new_instance	The previous instance of values before the update.
	 * @old_instance	The new instance of values to be generated via the update.
	 */
	public function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['classname'] = strip_tags($new_instance['classname']);
		$instance['totalclassname'] = strip_tags($new_instance['totalclassname']);
		$instance['twitter'] = strip_tags($new_instance['twitter']);
		$instance['facebook_likes'] = strip_tags($new_instance['facebook_likes']);
		$instance['facebook_shares'] = strip_tags($new_instance['facebook_shares']);
		$instance['googleplus'] = strip_tags($new_instance['googleplus']);
		$instance['pinterest'] = strip_tags($new_instance['pinterest']);
		$instance['linkedin'] = strip_tags($new_instance['linkedin']);
		$instance['digg'] = strip_tags($new_instance['digg']);
		$instance['reddit'] = strip_tags($new_instance['reddit']);
		$instance['stumbleupon'] = strip_tags($new_instance['stumbleupon']);
		$instance['delicious'] = strip_tags($new_instance['delicious']);
		$instance['totalshares'] = strip_tags($new_instance['totalshares']);

		return $instance;
	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @instance	The array of keys and values for the widget.
	 */
	public function form($instance) {

		$instance = wp_parse_args(
			(array) $instance, array(
		    'title' => __('Share Counter', 'sharecounter-locale'),
		    'classname' => 'shares',
		    'totalclassname' => 'totalshares',
		    'twitter' => '1',
		    'facebook_likes' => '1',
		    'facebook_shares' => '1',
		    'googleplus' => '1',
		    'pinterest' => '1',
		    'linkedin' => '1',
		    'digg' => '1',
		    'reddit' => '1',
		    'stumbleupon' => '1',
		    'delicious' => '1',
		    'totalshares' => '1'
			)
		);
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'sharecounter-locale') ?></label>
			<br/>
			<input type="text" class="widefat" value="<?php echo esc_attr($instance['title']); ?>" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" />
		</p>
		
		<p>
			<input type="checkbox" <?php if ($instance["totalshares"] == "1") echo 'checked="checked"'; ?> value="1" id="<?php echo $this->get_field_id('totalshares'); ?>" name="<?php echo $this->get_field_name('totalshares'); ?>" />
			<label for="<?php echo $this->get_field_id('totalshares'); ?>"><?php _e('Total shares', 'sharecounter-locale') ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('totalclassname'); ?>"><?php _e('Total shares class name:', 'sharecounter-locale') ?></label>
			<br/>
			<input type="text" class="widefat" value="<?php echo esc_attr($instance['totalclassname']); ?>" id="<?php echo $this->get_field_id('totalclassname'); ?>" name="<?php echo $this->get_field_name('totalclassname'); ?>" />
		</p>

		<p>
			<input type="checkbox" <?php if ($instance["twitter"] == "1") echo 'checked="checked"'; ?> value="1" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" />
			<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter shares', 'sharecounter-locale') ?></label>
		</p>

		<p>
			<input type="checkbox" <?php if ($instance["facebook_likes"] == "1") echo 'checked="checked"'; ?> value="1" id="<?php echo $this->get_field_id('facebook_likes'); ?>" name="<?php echo $this->get_field_name('facebook_likes'); ?>" />
			<label for="<?php echo $this->get_field_id('facebook_likes'); ?>"><?php _e('Facebook likes', 'sharecounter-locale') ?></label>
		</p>

		<p>
			<input type="checkbox" <?php if ($instance["facebook_shares"] == "1") echo 'checked="checked"'; ?> value="1" id="<?php echo $this->get_field_id('facebook_shares'); ?>" name="<?php echo $this->get_field_name('facebook_shares'); ?>" />
			<label for="<?php echo $this->get_field_id('facebook_shares'); ?>"><?php _e('Facebook shares', 'sharecounter-locale') ?></label>
		</p>

		<p>
			<input type="checkbox" <?php if ($instance["googleplus"] == "1") echo 'checked="checked"'; ?> value="1" id="<?php echo $this->get_field_id('googleplus'); ?>" name="<?php echo $this->get_field_name('googleplus'); ?>" />
			<label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php _e('Google+ shares', 'sharecounter-locale') ?></label>
		</p>

		<p>
			<input type="checkbox" <?php if ($instance["pinterest"] == "1") echo 'checked="checked"'; ?> value="1" id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" />
			<label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest shares', 'sharecounter-locale') ?></label>
		</p>

		<p>
			<input type="checkbox" <?php if ($instance["linkedin"] == "1") echo 'checked="checked"'; ?> value="1" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" />
			<label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin shares', 'sharecounter-locale') ?></label>
		</p>

		<p>
			<input type="checkbox" <?php if ($instance["digg"] == "1") echo 'checked="checked"'; ?> value="1" id="<?php echo $this->get_field_id('digg'); ?>" name="<?php echo $this->get_field_name('digg'); ?>" />
			<label for="<?php echo $this->get_field_id('digg'); ?>"><?php _e('Digg shares', 'sharecounter-locale') ?></label>
		</p>

		<p>
			<input type="checkbox" <?php if ($instance["reddit"] == "1") echo 'checked="checked"'; ?> value="1" id="<?php echo $this->get_field_id('reddit'); ?>" name="<?php echo $this->get_field_name('reddit'); ?>" />
			<label for="<?php echo $this->get_field_id('reddit'); ?>"><?php _e('Reddit shares', 'sharecounter-locale') ?></label>
		</p>

		<p>
			<input type="checkbox" <?php if ($instance["stumbleupon"] == "1") echo 'checked="checked"'; ?> value="1" id="<?php echo $this->get_field_id('stumbleupon'); ?>" name="<?php echo $this->get_field_name('stumbleupon'); ?>" />
			<label for="<?php echo $this->get_field_id('stumbleupon'); ?>"><?php _e('StumbleUpon shares', 'sharecounter-locale') ?></label>
		</p>

		<p>
			<input type="checkbox" <?php if ($instance["delicious"] == "1") echo 'checked="checked"'; ?> value="1" id="<?php echo $this->get_field_id('delicious'); ?>" name="<?php echo $this->get_field_name('delicious'); ?>" />
			<label for="<?php echo $this->get_field_id('delicious'); ?>"><?php _e('Delicious shares', 'sharecounter-locale') ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('classname'); ?>"><?php _e('Shares class name:', 'sharecounter-locale') ?></label>
			<br/>
			<input type="text" class="widefat" value="<?php echo esc_attr($instance['classname']); ?>" id="<?php echo $this->get_field_id('classname'); ?>" name="<?php echo $this->get_field_name('classname'); ?>" />
		</p>

		<?php
	}

}
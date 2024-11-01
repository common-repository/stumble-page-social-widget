<?php
/*
Plugin Name: Stumble Page Social Widget
Plugin URI: http://www.marijnrongen.com/wordpress-plugins/stumble-page-social-widget/
Description: Place a StumbleUpon badge as a widget, enables visitors to recommend the page via StumbleUpon.
Version: 1.0
Author: Marijn Rongen
Author URI: http://www.marijnrongen.com
*/

class MR_Stumble_Page_Widget extends WP_Widget {
	function MR_Stumble_Page_Widget() {
		$widget_ops = array( 'classname' => 'MR_Stumble_Page_Social_Widget', 'description' => 'Place a StumbleUpon badge as a widget.' );
		$control_ops = array( 'id_base' => 'mr-stumble-page-widget' );
		$this->WP_Widget( 'mr-stumble-page-widget', 'Stumble Page Social Widget', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance) {
		extract( $args );
		$layout = empty($instance['layout']) ? '1' : $instance['layout'];
		echo $before_widget;
		echo "\n	<script src=\"http://www.stumbleupon.com/hostedbadge.php?s=".$instance['layout'];
		if (!empty($instance['url'])) {
			$url = urlencode($instance['url']);
			echo "&r=".$url;
		}
		echo "\"></script>";
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['layout'] = $new_instance['layout'];
		$instance['url'] = strip_tags($new_instance['url']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args((array) $instance, array( 'layout' => 1, 'url' => ''));
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>">Button style:</label>
			<select id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 1 == $instance['layout'] ) echo 'selected="selected"'; ?> value="1">Button count (rectangular box)</option>
				<option <?php if ( 2 == $instance['layout'] ) echo 'selected="selected"'; ?> value="2">Button count (rounded box)</option>
				<option <?php if ( 3 == $instance['layout'] ) echo 'selected="selected"'; ?> value="3">Button count (no box)</option>
				<option <?php if ( 5 == $instance['layout'] ) echo 'selected="selected"'; ?> value="5">Box count</option>
				<option <?php if ( 6 == $instance['layout'] ) echo 'selected="selected"'; ?> value="6">Button large (no count)</option>
				<option <?php if ( 4 == $instance['layout'] ) echo 'selected="selected"'; ?> value="4">Button small (no count)</option>
			</select>
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>">URL to recommend (<b>Optional</b>, leave empty for the URL of the page the button is on):</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>" />
		</p>
		<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("MR_Stumble_Page_Widget");'));
?>
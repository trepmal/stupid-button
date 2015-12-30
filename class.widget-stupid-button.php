<?php

class Widget_Stupid_Button extends WP_Widget {

	var $textdomain = 'stupid-button';

	/**
	 * Setup
	 *
	 * @return void
	 */
	function __construct() {
		// see wp_register_sidebar_widget()
		$widget_ops  = array(
			'classname'   => 'stupid-button',
			'description' => __( 'This is a stupid button', $this->textdomain )
		);
		$control_ops = array(
			// 'width'   => 300, // avoid unless really needed
			// 'id_base' => '',  // defaults to first arg of WP_Widget
		);
		parent::__construct( 'stupid_button', __( 'Stupid Button', $this->textdomain ), $widget_ops, $control_ops );
	}

	/**
	 * Controls output
	 *
	 * @return void
	 */
	function widget( $args, $instance ) {

		// $before_widget, $after_widget, $before_title, $after_title
		extract( $args, EXTR_SKIP );

		echo $before_widget;

		if ( ! empty( $instance['hide_title'] ) ) {
			echo $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title;
		}

		wp_enqueue_script( 'stupid-button', plugin_dir_url( __FILE__ ) . 'stupid-button.js', array('jquery', 'wp-util'), '0.0.1', true );
		wp_localize_script( 'stupid-button', 'stupidButton', array(
			'unknownError' => 'Unknown error.'
		) );
		$total = intval( get_option( 'stupid_button_counter', 0 ) );
		echo '<p><button id="stupid-button-increment">'. __( 'Button', $this->textdomain ) .'</button> <button id="stupid-button-reset">'. __( 'Reset', $this->textdomain ) .'</button></p>';
		echo '<p id="stupid-button-status">' . stupid_button_status_text( $total ) . '</p>';

		echo $after_widget;

	} //end widget()

	/**
	 * Save form
	 *
	 * @return array Widget options
	 */
	function update( $new_instance, $old_instance ) {
		// silly perhaps, but helps us to see that the old
		// values will be the base for anything new that's saved
		$instance = $old_instance;

		// validate & sanitize here
		$instance['title']      = $new_instance['title'];
		$instance['hide_title'] = (bool) $new_instance['hide_title'] ? 1 : 0;
		return $instance;

	} //end update()

	/**
	 * Backend form
	 *
	 * @return void
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'      => __( 'Stupid Button', $this->textdomain ),
			'hide_title' => 0,
		) );
		$title      = $instance['title'];
		$hide_title = $instance['hide_title'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', $this->textdomain ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('hide_title'); ?>"><?php esc_html_e('Hide Title?', $this->textdomain );?>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hide_title'); ?>" name="<?php echo $this->get_field_name('hide_title'); ?>"<?php checked( $hide_title ); ?> />
			</label>
		</p>
		<?php
	} //end form()

}
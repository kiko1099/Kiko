<?php
/**
 * Sponsor Functions
 */
function mf_sponsor_carousel( $category_name ) {
	// Get all of the sponsor from the links
	$sponsors = get_bookmarks( array( 'orderby' => 'rating', 'category_name' => $category_name ) );

	// Split them into chucks of two
	$sponsors = array_chunk( $sponsors, 2, true );

	// Get the output started.
	$output = '';

	// Loop through each block of sponsors
	foreach ($sponsors as $idx => $sponsor) {
		if ( $idx == 0 ) {
			$output .= '<div class="item active">';
		} else {
			$output .= '<div class="item">';
		}
		$output .= '<div class="row-fluid">';

		// Loop through the individual sponsors
		foreach ($sponsor as $spon) {
			$output .= '<div class="span6"><div class="thumb"><a href="' . esc_url( $spon->link_url ) . '"><img src="' . wpcom_vip_get_resized_remote_image_url( $spon->link_image, 125, 105 ) . '" alt="' . esc_attr( $spon->link_name ) . '"></a></div></div>';	
		}
		$output .= '</div></div>';
	}

	return $output;
}

/**
 * Adds Sponsor_Widget widget.
 */
class Sponsor_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Sponsor_Widget', // Base ID
			__('Sponsor Slider', 'make-mini-mf'), // Name
			array( 'description' => __( 'Sponsor Widgets', 'make-mini-mf' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['category'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		echo __( 'Hello, World!', 'make-mini-mf' );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		var_dump( $instance );
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'make-mini-mf' );
		}

		if ( isset( $instance[ 'category' ] ) ) {
			$category = $instance[ 'category' ];
		}

		$terms = get_terms( 'link_category' );
		if ( $terms ) {
			echo '<select name="' . $this->get_field_name('category') . '" id="' . $this->get_field_id('category') .'" class="widefat">';
			foreach( $terms as $term ) {
				echo '<option id="' . $this->get_field_id( 'category' ) . '" name="' . $this->get_field_name( 'category' ) .'" value=' . esc_attr( $term->slug ) . ' ' .  selected( $this->get_field_name( 'category' ), $term->slug ) . '>' . esc_html( $term->name ) . '</option>';
			}
			echo '<select>';
		}
		?>
		</select>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		var_dump( $new_instance );
		var_dump( $old_instance );
		$instance = array();
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Sponsor_Widget

// register Foo_Widget widget
function register_sponsor_widget() {
    register_widget( 'Sponsor_Widget' );
}
add_action( 'widgets_init', 'register_sponsor_widget' );
<?php

function application_init() {
	register_post_type( 'application', array(
		'hierarchical'        => false,
		'public'              => true,
		'show_in_nav_menus'   => true,
		'show_ui'             => true,
		'supports'            => array( 'title' ),
		'has_archive'         => true,
		'query_var'           => true,
		'rewrite'             => true,
		'labels'              => array(
			'name'                => __( 'Applications', 'mini-makerfaire' ),
			'singular_name'       => __( 'Application', 'mini-makerfaire' ),
			'add_new'             => __( 'Add new application', 'mini-makerfaire' ),
			'all_items'           => __( 'Applications', 'mini-makerfaire' ),
			'add_new_item'        => __( 'Add new application', 'mini-makerfaire' ),
			'edit_item'           => __( 'Edit application', 'mini-makerfaire' ),
			'new_item'            => __( 'New application', 'mini-makerfaire' ),
			'view_item'           => __( 'View application', 'mini-makerfaire' ),
			'search_items'        => __( 'Search applications', 'mini-makerfaire' ),
			'not_found'           => __( 'No applications found', 'mini-makerfaire' ),
			'not_found_in_trash'  => __( 'No applications found in trash', 'mini-makerfaire' ),
			'parent_item_colon'   => __( 'Parent application', 'mini-makerfaire' ),
			'menu_name'           => __( 'Applications', 'mini-makerfaire' ),
		),
	) );

}
add_action( 'init', 'application_init' );

function application_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['application'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Application updated. <a target="_blank" href="%s">View application</a>', 'mini-makerfaire'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'mini-makerfaire'),
		3 => __('Custom field deleted.', 'mini-makerfaire'),
		4 => __('Application updated.', 'mini-makerfaire'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Application restored to revision from %s', 'mini-makerfaire'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Application published. <a href="%s">View application</a>', 'mini-makerfaire'), esc_url( $permalink ) ),
		7 => __('Application saved.', 'mini-makerfaire'),
		8 => sprintf( __('Application submitted. <a target="_blank" href="%s">Preview application</a>', 'mini-makerfaire'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Application scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview application</a>', 'mini-makerfaire'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Application draft updated. <a target="_blank" href="%s">Preview application</a>', 'mini-makerfaire'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'application_updated_messages' );

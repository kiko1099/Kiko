<?php

	function application_init() {
		register_post_type( 'application', array(
			'hierarchical'        => false,
			'public'              => true,
			'show_in_nav_menus'   => true,
			'show_ui'             => true,
			'supports'            => array( 'title', 'editor' ),
			'has_archive'         => true,
			'query_var'           => true,
			'rewrite'             => true,
			'labels'              => array(
				'name'                => __( 'Applications', 'make-mini-mf' ),
				'singular_name'       => __( 'Application', 'make-mini-mf' ),
				'add_new'             => __( 'Add new application', 'make-mini-mf' ),
				'all_items'           => __( 'Applications', 'make-mini-mf' ),
				'add_new_item'        => __( 'Add new application', 'make-mini-mf' ),
				'edit_item'           => __( 'Edit application', 'make-mini-mf' ),
				'new_item'            => __( 'New application', 'make-mini-mf' ),
				'view_item'           => __( 'View application', 'make-mini-mf' ),
				'search_items'        => __( 'Search applications', 'make-mini-mf' ),
				'not_found'           => __( 'No applications found', 'make-mini-mf' ),
				'not_found_in_trash'  => __( 'No applications found in trash', 'make-mini-mf' ),
				'parent_item_colon'   => __( 'Parent application', 'make-mini-mf' ),
				'menu_name'           => __( 'Applications', 'make-mini-mf' ),
			),
		) );
	}
	add_action( 'init', 'application_init' );


	function application_updated_messages( $messages ) {
		global $post;

		$permalink = get_permalink( $post );

		$messages['application'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __( 'Application updated. <a target="_blank" href="%s">View application</a>', 'make-mini-mf' ), esc_url( $permalink ) ),
			2 => __( 'Custom field updated.', 'make-mini-mf' ),
			3 => __( 'Custom field deleted.', 'make-mini-mf' ),
			4 => __( 'Application updated.', 'make-mini-mf' ),
			/* translators: %s: date and time of the revision */
			5 => isset( $_GET['revision'] ) ? sprintf( __( 'Application restored to revision from %s', 'make-mini-mf' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __( 'Application published. <a href="%s">View application</a>', 'make-mini-mf' ), esc_url( $permalink ) ),
			7 => __( 'Application saved.', 'make-mini-mf' ),
			8 => sprintf( __( 'Application submitted. <a target="_blank" href="%s">Preview application</a>', 'make-mini-mf' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
			9 => sprintf( __( 'Application scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview application</a>', 'make-mini-mf' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
			10 => sprintf( __( 'Application draft updated. <a target="_blank" href="%s">Preview application</a>', 'make-mini-mf' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		);

		return $messages;
	}
	add_filter( 'post_updated_messages', 'application_updated_messages' );
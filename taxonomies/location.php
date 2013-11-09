<?php

	function location_init() {
		register_taxonomy( 'location', array( 'application', 'event-items' ), array(
			'hierarchical'            => true,
			'public'                  => true,
			'show_in_nav_menus'       => true,
			'show_ui'                 => true,
			'query_var'               => 'location',
			'rewrite'                 => true,
			'capabilities'            => array(
				'manage_terms'  => 'edit_posts',
				'edit_terms'    => 'edit_posts',
				'delete_terms'  => 'edit_posts',
				'assign_terms'  => 'edit_posts'
			),
			'labels'                  => array(
				'name'                       =>  __( 'Locations', 'make-mini-mf' ),
				'singular_name'              =>  __( 'Location', 'make-mini-mf' ),
				'search_items'               =>  __( 'Search locations', 'make-mini-mf' ),
				'popular_items'              =>  __( 'Popular locations', 'make-mini-mf' ),
				'all_items'                  =>  __( 'All locations', 'make-mini-mf' ),
				'parent_item'                =>  __( 'Parent location', 'make-mini-mf' ),
				'parent_item_colon'          =>  __( 'Parent location:', 'make-mini-mf' ),
				'edit_item'                  =>  __( 'Edit location', 'make-mini-mf' ),
				'update_item'                =>  __( 'Update location', 'make-mini-mf' ),
				'add_new_item'               =>  __( 'New location', 'make-mini-mf' ),
				'new_item_name'              =>  __( 'New location', 'make-mini-mf' ),
				'separate_items_with_commas' =>  __( 'Locations separated by comma', 'make-mini-mf' ),
				'add_or_remove_items'        =>  __( 'Add or remove locations', 'make-mini-mf' ),
				'choose_from_most_used'      =>  __( 'Choose from the most used locations', 'make-mini-mf' ),
				'menu_name'                  =>  __( 'Locations', 'make-mini-mf' ),
			),
		) );

	}
	add_action( 'init', 'location_init' );

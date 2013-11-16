<?php

	function type_init() {
		register_taxonomy( 'type', array( 'application' ), array(
			'hierarchical'            => false,
			'public'                  => true,
			'show_in_nav_menus'       => true,
			'show_ui'                 => true,
			'query_var'               => 'type',
			'rewrite'                 => true,
			'capabilities'            => array(
				'manage_terms'  => 'edit_posts',
				'edit_terms'    => 'edit_posts',
				'delete_terms'  => 'edit_posts',
				'assign_terms'  => 'edit_posts'
			),
			'labels'                  => array(
				'name'                       =>  __( 'Types of Applications', 'make-mini-mf' ),
				'singular_name'              =>  __( 'Type', 'make-mini-mf' ),
				'search_items'               =>  __( 'Search types', 'make-mini-mf' ),
				'popular_items'              =>  __( 'Popular types', 'make-mini-mf' ),
				'all_items'                  =>  __( 'All types', 'make-mini-mf' ),
				'parent_item'                =>  __( 'Parent type', 'make-mini-mf' ),
				'parent_item_colon'          =>  __( 'Parent type:', 'make-mini-mf' ),
				'edit_item'                  =>  __( 'Edit type', 'make-mini-mf' ),
				'update_item'                =>  __( 'Update type', 'make-mini-mf' ),
				'add_new_item'               =>  __( 'New type', 'make-mini-mf' ),
				'new_item_name'              =>  __( 'New type', 'make-mini-mf' ),
				'separate_items_with_commas' =>  __( 'Types separated by comma', 'make-mini-mf' ),
				'add_or_remove_items'        =>  __( 'Add or remove types', 'make-mini-mf' ),
				'choose_from_most_used'      =>  __( 'Choose from the most used types', 'make-mini-mf' ),
				'menu_name'                  =>  __( 'Types', 'make-mini-mf' ),
			),
		) );

	}
	add_action( 'init', 'type_init' );

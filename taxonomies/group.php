<?php

	function mf_group_init() {
		register_taxonomy( 'group', array( 'application' ), array(
			'hierarchical'            => true,
			'public'                  => true,
			'show_in_nav_menus'       => true,
			'show_ui'                 => true,
			'query_var'               => 'group',
			'rewrite'                 => true,
			'capabilities'            => array(
				'manage_terms'  => 'edit_posts',
				'edit_terms'    => 'edit_posts',
				'delete_terms'  => 'edit_posts',
				'assign_terms'  => 'edit_posts'
			),
			'labels'                  => array(
				'name'                       =>  __( 'Groups', 'make-mini-mf' ),
				'singular_name'              =>  __( 'Group', 'make-mini-mf' ),
				'search_items'               =>  __( 'Search groups', 'make-mini-mf' ),
				'popular_items'              =>  __( 'Popular groups', 'make-mini-mf' ),
				'all_items'                  =>  __( 'All groups', 'make-mini-mf' ),
				'parent_item'                =>  __( 'Parent group', 'make-mini-mf' ),
				'parent_item_colon'          =>  __( 'Parent group:', 'make-mini-mf' ),
				'edit_item'                  =>  __( 'Edit group', 'make-mini-mf' ),
				'update_item'                =>  __( 'Update group', 'make-mini-mf' ),
				'add_new_item'               =>  __( 'New group', 'make-mini-mf' ),
				'new_item_name'              =>  __( 'New group', 'make-mini-mf' ),
				'separate_items_with_commas' =>  __( 'Groups separated by comma', 'make-mini-mf' ),
				'add_or_remove_items'        =>  __( 'Add or remove groups', 'make-mini-mf' ),
				'choose_from_most_used'      =>  __( 'Choose from the most used groups', 'make-mini-mf' ),
				'menu_name'                  =>  __( 'Groups', 'make-mini-mf' ),
			),
		) );

	}
	add_action( 'init', 'mf_group_init' );
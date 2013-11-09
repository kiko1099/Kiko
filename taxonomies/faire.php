<?php
	
	/**
	 * Adds the faire taxonomy
	 * @return void
	 *
	 * @version  1.0
	 * @since    0.5a
	 */
	function faire_init() {
		register_taxonomy( 'faire', array( 'application', 'event-items' ), array(
			'hierarchical'            => true,
			'public'                  => true,
			'show_in_nav_menus'       => true,
			'show_ui'                 => true,
			'query_var'               => 'faire',
			'rewrite'                 => true,
			'capabilities'            => array(
				'manage_terms'  => 'edit_posts',
				'edit_terms'    => 'edit_posts',
				'delete_terms'  => 'edit_posts',
				'assign_terms'  => 'edit_posts'
			),
			'labels'                  => array(
				'name'                       =>  __( 'Faires', 'make-mini-mf' ),
				'singular_name'              =>  __( 'Faire', 'make-mini-mf' ),
				'search_items'               =>  __( 'Search faires', 'make-mini-mf' ),
				'popular_items'              =>  __( 'Popular faires', 'make-mini-mf' ),
				'all_items'                  =>  __( 'All faires', 'make-mini-mf' ),
				'parent_item'                =>  __( 'Parent faire', 'make-mini-mf' ),
				'parent_item_colon'          =>  __( 'Parent faire:', 'make-mini-mf' ),
				'edit_item'                  =>  __( 'Edit faire', 'make-mini-mf' ),
				'update_item'                =>  __( 'Update faire', 'make-mini-mf' ),
				'add_new_item'               =>  __( 'New faire', 'make-mini-mf' ),
				'new_item_name'              =>  __( 'New faire', 'make-mini-mf' ),
				'separate_items_with_commas' =>  __( 'Faires separated by comma', 'make-mini-mf' ),
				'add_or_remove_items'        =>  __( 'Add or remove faires', 'make-mini-mf' ),
				'choose_from_most_used'      =>  __( 'Choose from the most used faires', 'make-mini-mf' ),
				'menu_name'                  =>  __( 'Faires', 'make-mini-mf' ),
			),
		) );

	}
	add_action( 'init', 'faire_init' );


	/**
	 * Adds a custom interface for assigning our archive pages the proper taxonomy.
	 * This extra code is nessecary because we only want to load this interface on pages with the page-topics.php template
	 */
	function make_faire_topic_metabox() {
		$template_file = get_post_meta( get_the_ID(), '_wp_page_template', true );

		// We only want to load our meta box when the Faire Tax Archive Page template is selected
		if ( $template_file == 'page-topics.php' ) {
			add_meta_box( 'make_faire_topic', __( 'Faire', 'make-mini-mf' ), 'make_faire_topic', 'page', 'side', 'default' );
		}
	}
	add_action( 'add_meta_boxes', 'make_faire_topic_metabox' );



	/**
	 * outputs our faire taxonomy for selection
	 * @return void
	 */
	function make_faire_topic() {
		global $post;

		$terms = get_terms( 'faire', array( 'hide_empty' => false ) );
		$current_term = get_post_meta( $post->ID, '_faire-tax-archive', true );

		// Add our security checkpoint
		wp_nonce_field( 'save_faire_archive_tax', 'make-faire-tax', false );
		
		$output = '<select name="faire-tax" id="tag-dropdown">';
		$output .= '<option value="none">' . __( 'Select A Faire', 'make-mini-mf' ) . '</option>';

		foreach ( $terms as $term ) {
			$output .= '<option value="' . esc_attr( $term->slug ) . '"' . selected( esc_attr( $current_term ), esc_attr( $term->slug ), false ) . '>' . esc_html( $term->name ) . '</option>';
		}

		$output .= '</select>';

		echo $output;
	}


	/**
	 * Saves our custom meta box on post save
	 */
	function make_faire_topic_save_metabox( $post_id ) {
		
		// Make sure we passed the right nonce...
		if ( isset( $_POST['make-faire-tax'] ) && ! wp_verify_nonce( $_POST['make-faire-tax'], 'save_faire_archive_tax' ) )
			return false;

		// Check the user privileges...
		if ( ! current_user_can( 'edit_pages', $post_id ) )
			return false;

		// Make sure auto save isn't running either...
		if ( defined('DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return false;

		if ( isset( $_POST['faire-tax'] ) && ! empty( $_POST['faire-tax'] ) )
			update_post_meta( $post_id, '_faire-tax-archive', sanitize_text_field( $_POST['faire-tax'] ) );
	}
	add_action( 'save_post', 'make_faire_topic_save_metabox' );


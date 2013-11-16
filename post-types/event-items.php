<?php 
	function event_items_init() {
		register_post_type( 'event-items', array(
			'hierarchical'        => false,
			'public'              => true,
			'show_in_nav_menus'   => true,
			'show_ui'             => true,
			'supports'            => array( 'thumbnail' ),
			'has_archive'         => true,
			'query_var'           => true,
			'rewrite'             => true,
			'labels'              => array(
				'name'                => __( 'Event Items', 'make-mini-mf' ),
				'singular_name'       => __( 'Event Items', 'make-mini-mf' ),
				'add_new'             => __( 'Add a new event item', 'make-mini-mf' ),
				'all_items'           => __( 'Event items', 'make-mini-mf' ),
				'add_new_item'        => __( 'Add a new event item', 'make-mini-mf' ),
				'edit_item'           => __( 'Edit event items', 'make-mini-mf' ),
				'new_item'            => __( 'New event item', 'make-mini-mf' ),
				'view_item'           => __( 'View event items', 'make-mini-mf' ),
				'search_items'        => __( 'Search event items', 'make-mini-mf' ),
				'not_found'           => __( 'No event items found', 'make-mini-mf' ),
				'not_found_in_trash'  => __( 'No event items found in trash', 'make-mini-mf' ),
				'parent_item_colon'   => __( 'Parent event items', 'make-mini-mf' ),
				'menu_name'           => __( 'Event items', 'make-mini-mf' ),
			),
		) );

	}
	add_action( 'init', 'event_items_init' );


	/**
	 * Some users like to schedule applications to a stage. When they are done scheduleing, they like to press, "preview changes" on the schedule edit screen.
	 * This is no bueno because it tries to load the page template for the event items post type, which is nothing more than a way to connect locations and applications at a certain time.
	 * This function will fix that by listening for this post type request and we'll redirect to the application ID assigned to it.
	 * @return void
	 */
	function mf_redirect_to_parent_permalink() {
		global $post;

		if ( get_post_type() == 'event-items' ) {
			$app_id = get_post_meta( $post->ID, 'mfei_record', true );

			if ( ! empty( $app_id ) && absint( $app_id ) ) {
				wp_safe_redirect( get_permalink( $app_id ) );
				exit();
			}
		}
	}
	add_action( 'template_redirect', 'mf_redirect_to_parent_permalink' );


	/**
	 * Function to generate a mailto: link with the presentation details.
	 */
	function mf_schedule_mailto( $meta ) {
		if ( isset( $meta['mfei_record'][0] ) ) {
			$linked_post = get_post( $meta['mfei_record'][0] );
			$json = json_decode( $linked_post->post_content );
			$loc = get_the_terms( $linked_post->ID, 'location' );
			$email = esc_url( 'mailto:' . $json->email );
			$subject = '?&subject=Event+Scheduled: ' . esc_attr( $linked_post->post_title );
			$body = rawurlencode(
				"Event: " . esc_attr( $linked_post->post_title ) . "\n" .
				"Start Time: " . esc_attr( $meta['mfei_start'][0] ) . "\n" .
				"End Time: " . esc_attr( $meta['mfei_stop'][0] ) . "\n" .
				"Location: " . esc_attr( $loc[0]->name ) .  "\n" );
			$url = add_query_arg( array( 'subject' => $subject ),  $email );
			$url = add_query_arg( array( 'body' => $body ), $url );
			echo '<p><a href="' . $url . '" class="button" target="_blank">' . __( 'Email Presenter Schedule', 'make-mini-mf' ) . '</a></p>';
		}
	}

	
	/* 
	* Callback for adding meta box to EVENT ITEM
	* =====================================================================*/
	function makerfaire_add_meta_boxes() {
		add_meta_box( 'ei-details', __( 'Event Item Details', 'make-mini-mf' ), 'makerfaire_meta_box', 'event-items', 'normal', 'default' );
	}


	/* 
	* Display EVENT ITEM Form
	*
	* @param object $post Post being edited
	* =====================================================================*/
	function makerfaire_meta_box( $post ) {
		
		$meta = array(
			'mfei_day'    	=> __( 'Saturday', 'make-mini-mf' ),
			'mfei_start'  	=> '8:00 AM',
			'mfei_stop'   	=> '8:30 AM',
			'mfei_record' 	=> '',
			'mfei_coverage'	=> '',
		);
		
		if ( $post->post_status == 'publish' ) 
			$meta = get_post_custom( $post->ID ); ?>

		<style>#ei-details label{font-weight:bold; display:block; margin:15px 0 5px 0;} #ei-details select,#ei-details input[type=text]{width:200px}</style>
		<?php wp_nonce_field('mfei_nonce', 'mfei_submit_nonce'); ?>
		<label><?php _e( 'Day', 'make-mini-mf' ); ?></label>
		<select name="mfei_day">
			<option value="Saturday" <?php selected( $meta['mfei_day'][0], 'Saturday' ); ?>><?php _e( 'Saturday', 'make-mini-mf' ); ?></option>
			<option value="Sunday" <?php selected( $meta['mfei_day'][0], 'Sunday' ); ?>><?php _e( 'Sunday', 'make-mini-mf' ); ?></option>
		</select>
		<label><?php _e( 'Start Time', 'make-mini-mf' ); ?></label>
		<select name="mfei_start">
			<?php makerfaire_create_time( $meta['mfei_start'][0] ); ?>
		</select>
		<label><?php _e( 'Stop Time', 'make-mini-mf' ); ?></label>
		<select name="mfei_stop">
			<?php makerfaire_create_time( $meta['mfei_stop'][0] ); ?>
		</select>
		<label><?php _e( 'Coverage Video Link', 'make-mini-mf' ); ?></label>
		<input type="text" name="mfei_coverage" id="mfei_coverage" value="<?php echo ( !empty( $meta['mfei_coverage'][0] ) ) ? esc_url ( $meta['mfei_coverage'][0] ) : ''; ?>" />
		<label><?php _e( 'Record Number - MUST BE VALID APPLICATION ID', 'make-mini-mf' ); ?></label>
		<?php
			// Check if we are loading from a referring post and add that ID to our Record field
			if ( isset( $_GET['refer_id'] ) && ! empty( $_GET['refer_id'] ) ) {
				echo  '<input type="text" name="mfei_record" id="mfei_record" value="' . intval( $_GET['refer_id'] ) . '" />';
			} else {
				$id = ( !empty( $meta['mfei_record'][0] ) ) ? esc_attr( $meta['mfei_record'][0] ) : '';
				echo '<input type="text" name="mfei_record" id="mfei_record" value="' . $id . '" />';
			} 
		?>
		<a title="Edit event items" href="#" class="post-edit-link"><?php _e( 'View Application', 'make-mini-mf' ); ?></a> <?php _e( '(opens new window with given application)', 'make-mini-mf' ); ?>
		<label><?php _e( 'Schedule Completed', 'make-mini-mf' ); ?></label>
		<input name="mfei_schedule_completed" type="checkbox" value="1" /> &nbsp; <?php _e( 'Event is Scheduled', 'make-mini-mf' ); ?>
		<script>		
			jQuery( '#ei-details a' ).click( function() {
				window.open('/wp-admin/post.php?post=' + jQuery( '#mfei_record' ).val() + '&action=edit', '_blank');
			});
		</script>
		<?php mf_schedule_mailto( $meta ); ?>
	<?php }


	/* 
	* Saves Event Item Meta as well as the connected MakerFaire Application
	*
	* @param int $id Updated Post ID
	* =====================================================================*/
	function makerfaire_create_time( $val ) {

		// Set some variables. 
		$start_time = "10:00:00"; // Time to start at...
		$end_time = "10:00:00"; // Not sure why setting at or below 10 gives us the correct time frame...

		while ( strtotime( $start_time ) >= strtotime( $end_time ) ) {
			$time = date( 'g:i A', strtotime( $start_time ) );

			echo '<option value="' . $time . '"' . selected( $val, $time ) . '>' . date( 'g:i A', strtotime( $start_time ) ) . '</option>';

			$start_time = date( 'H:i:s', strtotime( "$start_time 5 minutes" ) );
		}
	}
	add_action( 'add_meta_boxes', 'makerfaire_add_meta_boxes' );



	/* 
	* Saves Event Item Meta as well as the connected MakerFaire Application
	*
	* @param int $id Updated Post ID
	* =====================================================================*/
	function makerfaire_update_event( $id ) {

		if ( empty( $_POST ) || get_post_type( $id ) != 'event-items' || $_POST['post_status'] != 'publish' )
			return false;
		
		if ( !isset( $_POST['mfei_submit_nonce'] ) || !wp_verify_nonce( $_POST['mfei_submit_nonce'], 'mfei_nonce' ) )
			return false;
		
		//CONFIRM THAT MFEI RECORD IS AN APPLICATION
		$is_mf_form = get_post_type( intval( $_POST['mfei_record'] ) ) == 'mf_form';

		$meta = array(
			'mfei_day'    => sanitize_text_field( $_POST['mfei_day'] ),
			'mfei_start'  => sanitize_text_field( $_POST['mfei_start'] ),
			'mfei_stop'   => sanitize_text_field( $_POST['mfei_stop'] ),
			'mfei_record' => $is_mf_form ? intval( $_POST['mfei_record'] ) : 0,
			'mfei_coverage' => esc_url( $_POST['mfei_coverage'] ),
		);

		foreach( $meta as $meta_key => $meta_value ) {
			update_post_meta( $id, $meta_key, $meta_value );	
		}
		
		
		if ( !$is_mf_form )
			return;
		
		//UDPATE LOCATIONS OF CONNECTED APPLICATION
		$locs = $_POST['tax_input']['location'];
		unset($locs[0]);
		
		$san_locs = array();
		foreach( $locs as $loc ) {
			$san_locs[] = intval( $loc );
		}
		
		wp_set_post_terms( $meta['mfei_record'], $san_locs, 'location' );
		
		//UPDATE SCHEDULED STATUS OF CONNECTED APPLICATION
		update_post_meta( $meta['mfei_record'], '_ef_editorial_meta_checkbox_schedule-completed', ( isset( $_POST['mfei_schedule_completed'] ) ? 1 : 0 ) );
	}

	/* SAVE POST HOOK */
	add_action( 'save_post', 'makerfaire_update_event' );





	  
	/* 
	* Add Custom Event Item Columns
	*
	* @param array $cs Array of default columns
	* =====================================================================*/
	function makerfaire_add_column( $cs ) { 

		unset( $cs['title'], $cs['date'] );
		
		$ncs = array(
			'event_id'     => 'Event ID',
			'location'     => 'Location',
			'day'          => 'Day',		
			'start_time'   => 'Start Time',
			'stop_time'    => 'Stop Time',
			'project_name' => 'Project Name',
			'project_id'   => 'Project ID'
		);
		
		return array_merge( $cs, $ncs );
	}  
	/* 
	* Add data to custom Event Item Column
	*
	* @param string $column_name Column ID
	* @param int $post_ID Row Post ID
	* =====================================================================*/
	function makerfaire_add_name_to_column( $column_name, $post_ID ) { 

		switch( $column_name ) {
			case 'event_id' :
				
				edit_post_link( 'Event ID : '.$post_ID , '', '', $post_ID );		
				break;
				
			case 'project_id' :
				
				echo intval( get_post_meta( $post_ID, 'mfei_record', true ) );			
				break;
				
			case 'day' :
			
				echo esc_html( get_post_meta( $post_ID, 'mfei_day', true ) );
				break;
				
			case 'project_name' :
			
				$id = get_post_meta( $post_ID, 'mfei_record', true );
				edit_post_link( get_the_title( $id ), '', '', $id );
				break;
				
			case 'start_time' :
			
				echo esc_html( get_post_meta( $post_ID, 'mfei_start', true ) );		
				break;
				
			case 'stop_time' :
				
				echo esc_html( get_post_meta( $post_ID, 'mfei_stop', true ) );		
				break;
				
			case 'location' :
			
				$locs = get_the_terms( $post_ID, 'location' );
				$loca = array();
				
				foreach ($locs as $loc) {
					$loca[] = esc_html( $loc->name );
				}	
				
				echo implode( ', ', $loca );
				
				break;
		}
	}
	/* CUSTOM COLUMNS HOOKS */
	add_filter( 'manage_event-items_posts_columns',         'makerfaire_add_column', 10);
	add_action( 'manage_event-items_posts_custom_column',   'makerfaire_add_name_to_column', 10, 2);




	/* 
	* Add Sortable Columns to Event Item List
	*
	* @param array $cs Default Sortable Columns
	* =====================================================================*/
	function makerfaire_columns_sortable( $cs ) {
		$cs['day']          = 'day';
		$cs['start_time']   = 'start_time';
		$cs['stop_time']    = 'stop_time';
		$cs['project_id']   = 'project_id';
		
		return $cs;
	}
	/* 
	* Filter WP Query with Meta Data / Taxonomy Data
	*
	* @param array $vars All Default Query Variables
	* =====================================================================*/
	function makerfaire_columns_orderby( $vars ) {
		
		if ( is_admin() && isset( $vars['orderby'] ) && $vars['post_type'] == 'event-items' ) {
			
			switch( $vars['orderby'] ) {
				case 'day' :
					$vars = array_merge( $vars, array(
						'meta_key' => 'mfei_day',
						'orderby'  => 'meta_value'
					) );
				break;
				case 'start_time' :
					$vars = array_merge( $vars, array(
						'meta_key' => 'mfei_start',
						'orderby'  => 'meta_value'
					) );
				break;	
				case 'stop_time' :
					$vars = array_merge( $vars, array(
						'meta_key' => 'mfei_stop',
						'orderby'  => 'meta_value'
					) );
				break;
				case 'project_id' :
					$vars = array_merge( $vars, array(
						'meta_key' => 'mfei_record',
						'orderby'  => 'meta_value'
					) );
				break;
			}		
		} 
		if ( is_admin() && isset( $vars['location'] ) && $vars['location'] != 0 && $vars['post_type'] == 'event-items' ) { 
			$loc = get_term( $vars['location'], 'location' );
			$vars['location'] = $loc->name;
		}

		return $vars;
	}
	/* CUSTOM SORTABLE COLUMNS HOOKS */
	add_filter( 'manage_edit-event-items_sortable_columns', 'makerfaire_columns_sortable' );
	add_filter( 'request', 'makerfaire_columns_orderby' );




	/* 
	* Add Location Taxonomy filter to posts
	* =====================================================================*/
	function makerfaire_manage_posts() {
		$location = ( !empty( $_GET['location'] ) ) ? intval( $_GET['location'] ) : '';
		if( !isset( $_GET['post_type'] ) || $_GET['post_type'] != 'event-items' )
			return;
		
		$args = array(
			'show_option_all' => __( "View All Locations", 'make-mini-mf' ),
			'taxonomy'        => 'location',
			'name'            => 'location',
			'selected'        => $location,
		);
		wp_dropdown_categories($args); 
		echo '<style>select[name="m"]{display:none}</style>';
	}
	/* CUSTOM FILTER HOOK */
	add_action('restrict_manage_posts','makerfaire_manage_posts');


	/**
	 * Add a type dropdown to the admin screen.
	 *
	 * Need a way to filter all of the different types of applications in the admin area.
	 *
	 */
	function mf_restrict_listings_by_type( $type ) {
		global $typenow;
		global $wp_query;

		if ($typenow == 'mf_form' ) {
			wp_dropdown_categories(
				array(
					'walker'			=> new SH_Walker_TaxonomyDropdown(),
					'value'				=> 'slug',
					'show_option_all'	=> 'Types',
					'taxonomy'			=> 'type',
					'name'				=> 'type',
					'orderby'			=> 'name',
					'selected'			=> $type,
					'hierarchical'		=> true,
					'hide_empty'		=> false
					)
			);
		}
	}

	add_action('restrict_manage_posts','mf_restrict_listings_by_type');


	/**
	 * Add a faire dropdown to the admin screen.
	 *
	 * Need a way to filter all of the different faires the admin area.
	 *
	 */
	function mf_restrict_listings_by_faire() {
		global $typenow;
		global $wp_query;

		if ($typenow == 'mf_form' ) {
			wp_dropdown_categories(
				array(
					'walker'			=> new SH_Walker_TaxonomyDropdown(),
					'value'				=> 'slug',
					'show_option_all'	=>  'View All Faires',
					'taxonomy'			=>  'faire',
					'name'				=>  'faire',
					'orderby'			=>  'name',
					'selected'			=> ( !empty( $wp_query->query['faire'] ) ) ? $wp_query->query['faire'] : '',
					'hierarchical'		=>  true,
					'hide_empty'		=>  false
					)
			);
		}
	}

	add_action('restrict_manage_posts','mf_restrict_listings_by_faire');

	/* 
	 * A walker class to use that extends wp_dropdown_categories and allows it to use the term's slug as a value rather than ID.
	 *
	 * See http://core.trac.wordpress.org/ticket/13258
	 *
	 * Usage, as normal:
	 * wp_dropdown_categories($args);
	 *
	 * But specify the custom walker class, and (optionally) a 'id' or 'slug' for the 'value' parameter:
	 * $args=array('walker'=> new SH_Walker_TaxonomyDropdown(), 'value'=>'slug', .... );
	 * wp_dropdown_categories($args);
	 * 
	 * If the 'value' parameter is not set it will use term ID for categories, and the term's slug for other taxonomies in the value attribute of the term's <option>.
	*/

	class SH_Walker_TaxonomyDropdown extends Walker_CategoryDropdown {

		function start_el ( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
			$pad = str_repeat('&nbsp;', $depth * 3);
			$cat_name = apply_filters('list_cats', $category->name, $category);

			if( !isset($args['value']) ){
				$args['value'] = ( $category->taxonomy != 'category' ? 'slug' : 'id' );
			}

			$value = ($args['value']=='slug' ? $category->slug : $category->term_id );

			$output .= "\t<option class=\"level-$depth\" value=\"".$value."\"";
			if ( $value === (string) $args['selected'] ){ 
				$output .= ' selected="selected"';
			}
			$output .= '>';
			$output .= $pad.$cat_name;
			if ( $args['show_count'] )
				$output .= '&nbsp;&nbsp;('. $category->count .')';

			$output .= "</option>\n";
		}

	}

	/**
	 * Wrapper for wp_dropdown_categories to easily add new dropdowns.
	 */
	function mf_generate_dropdown( $tax, $selected ) {
		wp_dropdown_categories(
			array(
				'show_option_all'	=> ( $tax == 'post_tag' ) ? 'Tag' : ucwords( $tax ),
				'taxonomy'			=> $tax,
				'orderby'			=> 'name',
				'selected'			=> $selected,
				'hierarchical'		=> true,
				'hide_empty'		=> false,
				'name'				=> $tax,
				)
		);	
	}
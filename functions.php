<?php
	
	// Load some resources
	require_once( 'plugins/applications/applications.php' );
	require_once( 'plugins/public-pages/makers.php' );
	require_once( 'plugins/public-pages/sponsor.php' );
	require_once( 'plugins/tgm-plugin-activation/class-tgm-plugin-activation.php' );
	require_once( 'plugins/tgm-plugin-activation/plugins.php' );
	require_once( 'post-types/application.php' );
	require_once( 'post-types/event-items.php' );
	require_once( 'taxonomies/type.php' );
	require_once( 'taxonomies/location.php' );
	require_once( 'taxonomies/faire.php' );
	require_once( 'taxonomies/group.php' );

	// Load ACF
	define( 'ACF_LITE', true );
	include_once('plugins/acf/advanced-custom-fields/acf.php' );
	include_once('plugins/acf/acf-options-page/acf-options-page.php' );
	include_once('plugins/acf/acf-repeater/acf-repeater.php' );
	include_once('plugins/acf/advanced-custom-field-repeater-collapser/acf_repeater_collapser.php' );

	
	// Allow the link manager
	add_filter( 'pre_option_link_manager_enabled', '__return_true' );

	// Set a theme version :)
	define( 'THEME_VERSION', '0.5a' );
	

	/**
	 * Sets a notification that we are using an alpha version of the theme
	 * TODO: Remove when we are ready to go live 
	 * @return html
	 */
	function make_dev_notification() { ?>
		<div id="message" class="error"><p>This theme is under development and is not ready for public useage. <a href="https://github.com/Make-Magazine/minimakerfaire-original">We recommend our original Mini Maker Faire theme</a>.</p></div>
	<?php }
	add_action( 'admin_notices', 'make_dev_notification' );


	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 */
	if ( ! function_exists( 'make_theme_setup' ) ) :
		function make_theme_setup() {

			/*
	         * Make theme available for translation.
	         * Translations can be filed in the /languages/ directory.
	         */
	        load_theme_textdomain( 'make-mini-mf', get_template_directory() . '/languages' );


			/**
			 * Add default posts and comments RSS feed links to head
			 */
			add_theme_support( 'automatic-feed-links' );


			/**
			 * Enable support for Post Thumbnails on posts and pages
			 *
			 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );


			/**
			 * Register custom image sizes
			 */
			add_image_size( 'schedule-thumb', 140, 140, true );


			/**
			 * Enable support for custom header image
			 */
			$args = array(
				'width'         => 940,
				'height'        => 140,
				'default-image' => get_template_directory_uri() . '/images/eastbay_mmf_logos_wordpress.gif',
			);
			add_theme_support( 'custom-header', $args );


			/**
			 * This theme uses wp_nav_menu() in one location.
			 */
			register_nav_menus( array(
				'header-menu' => __( 'Header Menu', 'make-mini-mf' ),
				'footer-menu' => __( 'Footer Menu', 'make-mini-mf' ),
			) );
		}
	endif;
	add_action( 'after_setup_theme', 'make_theme_setup' );


	/**
	 * Enqueue any custom Scripts or styles
	 * @return void
	 */
	function make_add_resources() {
		// Stylesheets
		wp_enqueue_style( 'make-styles', get_stylesheet_directory_uri() . '/css/style.css', null, THEME_VERSION );

		// JavaScripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'make-bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), THEME_VERSION, true );
		wp_enqueue_script( 'make-countdown', get_stylesheet_directory_uri() . '/js/jquery.countdown..min.js', array( 'jquery' ), THEME_VERSION, true );
	}
	add_action( 'wp_enqueue_scripts', 'make_add_resources' );


	/**
	 * Register Widgetized areas
	 * @return void
	 */
	function makerfaire_widgets_init() {
		register_sidebar( array(
			'name' => 'Maker Faire Calendar',
			'id' => 'home_right_1',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h4 class="more-faires">',
			'after_title' => '</h4>',
		) );

		register_sidebar( array(
			'name' => 'Sidebar',
			'id' => 'sidebar',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h4 class="heading">',
			'after_title' => '</h4>',
		) );

		register_sidebar( array(
			'name' => 'Footer 1',
			'id' => 'footer-1',
			'before_widget' => '<div id="footer-widget-1" class="span4">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		) );

		register_sidebar( array(
			'name' => 'Footer 2',
			'id' => 'footer-2',
			'before_widget' => '<div id="footer-widget-2" class="span4">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		) );

		register_sidebar( array(
			'name' => 'Footer 3',
			'id' => 'footer-3',
			'before_widget' => '<div id="footer-widget-3" class="span4">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		) );

	}
	add_action( 'widgets_init', 'makerfaire_widgets_init' );


	/**
	 * Adds the bootstrap carousel nav links
	 * @param  [type] $atts [description]
	 * @return [type]       [description]
	 *
	 * @version  0.1
	 * @since    0.5a
	 */
	function makerfaire_carousel_shortcode( $atts ) {
		extract( shortcode_atts( array( 'id' => 'biggins'), $atts ) );
		
		return 	'<a class="carousel-control left" href="#' . esc_attr( $id ) . '" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#' . esc_attr( $id ) . '" data-slide="next">&rsaquo;</a>';
	}
	add_shortcode( 'arrows', 'makerfaire_carousel_shortcode' );


	/**
	 * TODO: Add description
	 * @return [type] [description]
	 */
	function makerfaire_get_news() {
		$url = 'http://makezine.com/maker-faire-news/';
		$output = wpcom_vip_file_get_contents( $url, 3, 60,  array( 'obey_cache_control_header' => false ) );
		return $output;
	}
	add_shortcode('news', 'makerfaire_get_news');



	/**
	 * Deprecated code or uneeded for MMF below?
	 */
	


	/**
	 * TODO: Add description
	 * @return [type] [description]
	 */
	function makerfaire_news_rss() { ?>
		<div class="newsies">
			<div class="news post">
				<h3 style="color: #fc040c;"><a href="http://makezine.com/tag/maker-faire/"><?php _e( 'Latest Maker Faire News', 'make-mini-mf' ); ?></a></h3>
				<?php $fs = makerfaire_index_feed();

					foreach( $fs as $f ) : $a = $f['i']->get_authors(); ?>
						<h4><a href="<?php echo esc_url($f['i']->get_link()); ?>"><?php echo esc_html($f['i']->get_title()); ?></a></h4>
						<div class="row">
							<div class="span2">
								<a href="<?php echo esc_url($f['i']->get_link()); ?>" title="<?php echo esc_attr($f['i']->get_title()); ?>"><img class="thumbnail faire-thumb " alt="<?php echo esc_attr($f['i']->get_title()); ?>" src="<?php echo esc_url($f['src']); ?>" /></a>
							</div>
							<div class="span6">
								<?php echo str_replace( array( $f['img'], '<p><a href="' . $f['i']->get_link() . '">Read the full article on MAKE</a></p>' ), '', html_entity_decode( esc_html( $f['i']->get_description() ) ) ); ?>
								<p class="read_more" style="margin:10px 0"><strong><a class="btn btn-primary btn-mini" href="<?php echo esc_url( $f['i']->get_link() ); ?>"><?php _e( 'Read full story &raquo;', 'make-mini-mf' ); ?></a></strong></p>
							
								<ul class="unstyled">
									<li><?php _e( 'Posted by', 'make-mini-mf' ); ?> <?php echo esc_html( $a[0]->name ); ?> | <?php echo esc_html( $f['i']->get_date() ); ?></li>
									<li><?php _e( 'Categories:', 'make-mini-mf' ); ?> <?php foreach( $f['i']->get_categories() as $cat ) { echo esc_html( $cat->term . ', ' ); } ?></li>
								</ul>
							</div>
						</div>
					<?php endforeach;
				?> 
			</div>
		</div>
		<h4><a href="http://makezine.com/tag/maker-faire/"><?php _e( 'Read More &rarr;', 'make-mini-mf' ); ?></a></h4>
	<?php }

	
	/**
	 * TODO: Add description
	 * @param  [type] $title [description]
	 * @return [type]        [description]
	 */
	function mf_clean_title( $title ) {
	    $title = str_replace( '&nbsp;', ' ', $title );
	    return $title;
	}
	add_filter( 'the_title', 'mf_clean_title', 10, 2 );


	/**
	 * TODO: Add description
	 * @param  [type] $allowedposttags [description]
	 * @param  [type] $context         [description]
	 * @return [type]                  [description]
	 */
	function mf_allow_data_atts( $allowedposttags, $context ) {
		$tags = array( 'div', 'a', 'li' );
		$new_attributes = array( 'data-toggle' => true );
	 
		foreach ( $tags as $tag ) {
			if ( isset( $allowedposttags[ $tag ] ) && is_array( $allowedposttags[ $tag ] ) )
				$allowedposttags[ $tag ] = array_merge( $allowedposttags[ $tag ], $new_attributes );
		}
		
		return $allowedposttags;
	}
	add_filter( 'wp_kses_allowed_html', 'mf_allow_data_atts', 10, 2 );


	/**
	 * TODO: Add description
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	function mf_filter_tiny_mce_before_init( $options ) { 
		if ( ! isset( $options['extended_valid_elements'] ) ) 
			$options['extended_valid_elements'] = ''; 

		$options['extended_valid_elements'] .= ',a[data*|class|id|style|href]';
		$options['extended_valid_elements'] .= ',li[data*|class|id|style]';
		$options['extended_valid_elements'] .= ',div[data*|class|id|style]';

		return $options; 
	}
	add_filter( 'tiny_mce_before_init', 'mf_filter_tiny_mce_before_init' ); 


	/**
	 * TODO: Add description
	 */
	add_filter( 'jetpack_open_graph_tags', function( $tags ) {
		global $post;

		if ($post->post_type == 'mf_form') {
			$json = json_decode( $post->post_content );
			$tags['og:description'] = $json->public_description;	
		} else {
			setup_postdata($post);
			$tags['og:description'] = get_the_excerpt();
		}
		
		return $tags;
	}, 10 );

	/**
	 * Hide Maker Faire applications from past faires
	 *
	 * In the past, CS had a method for only selecting the current 
	 * faire for applications. We want to do the same here, and prevent
	 * all applications from showing up in the edit screen.
	 *
	 * Have to use slug, RE: See http://core.trac.wordpress.org/ticket/13258
	 *
	 * @global $query
	 *
	 */
	function mf_hide_faires( $query ) {
		if ( is_admin() && $query->is_main_query() ) {
			$tax_query = array(
				array(
					'taxonomy'	=> 'faire',
					'field'		=> 'slug',
					'terms'		=> 'world-maker-faire-new-york-2013',
					'operator'	=> 'IN',
				)
			);
			$query->set( 'tax_query', $tax_query );
		}
	}

	// add_action( 'pre_get_posts', 'mf_hide_faires' );



	/**
	 * Counts the post numbers for the Dashboard.
	 */
	function mf_add_magazine_article_counts() {
			if ( !post_type_exists( 'mf_form' ) ) {
				 return;
			}

			$num_posts = wp_count_posts( 'mf_form' );
			$num = number_format_i18n( $num_posts->accepted );
			$text = _n( 'Application', 'Applications', intval($num_posts->accepted) );
			if ( current_user_can( 'edit_posts' ) ) {
				$url = admin_url( 'edit.php?post_type=mf_form' );
				$num = '<a href="'.$url.'">'.$num.'</a>';
				$text = '<a href="'.$url.'">'.$text.'</a>';
			}
			echo '<td class="first b b-mf_form">' . $num . '</td>';
			echo '<td class="t mf_form">' . $text . '</td>';

			echo '</tr>';

			if ($num_posts->proposed > 0) {
				$num = number_format_i18n( $num_posts->proposed );
				$text = _n( 'Applications Pending', 'Applications Pending', intval($num_posts->proposed) );
				if ( current_user_can( 'edit_posts' ) ) {
					$url = admin_url( 'edit.php?post_status=proposed&post_type=mf_form' );
					$num = '<a href="' . $url . '">' . $num . '</a>';
					$text = '<a href="' . $url . '">' . $text . '</a>';
				}
				echo '<td class="first b b-recipes">' . $num . '</td>';
				echo '<td class="t recipes">' . $text . '</td>';

				echo '</tr>';
			}
	}

	add_action('right_now_content_table_end', 'mf_add_magazine_article_counts');

	function mf_send_hipchat_notification( $message = 'Default Message', $from = 'MakeBot' ) {
		$base 		= 'https://api.hipchat.com/v1/rooms/message';
		$auth_token = '9f4f9113e8eeb3754da520d295ca59';
		$room 		= 198932;
		$notify 	= 1;

		$opts = array( 
			'auth_token'=> $auth_token, 
			'room_id'	=> $room, 
			'from' 		=> $from, 
			'notify' 	=> $notify,
			'message'	=> urlencode( $message ),
			'color'		=> 'green'
		);

		$url = add_query_arg( $opts, $base );
		$json = wpcom_vip_file_get_contents( $url );
	}

	// Redirect mobile users on iOS or Android to their app stores if set.
	function mf_page_redirect_to_app_stores() {
		if ( ! is_page( 'app' ) && function_exists( 'jetpack_is_mobile' ) )
			return;
	 
		$redirect_to = '';
	 
	 	if ( Jetpack_User_Agent_Info::is_iphone_or_ipod() )
			$redirect_to = 'https://itunes.apple.com/us/app/maker-faire-the-official-app/id641794889';
		elseif ( Jetpack_User_Agent_Info::is_android() )
			$redirect_to = 'https://play.google.com/store/apps/details?id=com.xomodigital.makerfaire';
	 	
		if ( ! empty( $redirect_to ) ) {
			wp_redirect( $redirect_to, 301 );  // Permanent redirect
			exit;
		}
	}
	add_action( 'template_redirect', 'mf_page_redirect_to_app_stores' );


	add_action( 'admin_head', 'make_cpt_icons' );
	/**
	 * Adds icons for the custom post types that are in the admin.
	 */
	function make_cpt_icons() { ?>
		<style type="text/css" media="screen">
			.icon16.icon-event-items:before,
			#adminmenu #menu-posts-event-items div.wp-menu-image:before {
				content: '\f145';
			}
			.icon16.icon-dashboard:before,
			#adminmenu #menu-dashboard div.wp-menu-image:before {
				content: '\f226';
			}
			.icon16.icon-post:before,
			#adminmenu #menu-posts div.wp-menu-image:before {
				content: '\f109';
			}
			.icon16.icon-media:before,
			#adminmenu #menu-media div.wp-menu-image:before {
				content: '\f104';
			}
			.icon16.icon-comments:before,
			#adminmenu #menu-comments div.wp-menu-image:before {
				content: '\f101';
			}
			.icon16.icon-page:before,
			#adminmenu #menu-pages div.wp-menu-image:before {
				content: '\f105';
			}
			.icon16.icon-post:before,
			#adminmenu #menu-posts-mf_form div.wp-menu-image:before {
				content: '\f116';
			}
			.icon16.icon-post:before,
			#adminmenu #menu-posts-maker div.wp-menu-image:before {
				content: '\f307';
			}
			.icon16.icon-appearance:before,
			#adminmenu #menu-appearance div.wp-menu-image:before {
				content: '\f100';
			}
			.icon16.icon-plugins:before,
			#adminmenu #menu-plugins div.wp-menu-image:before {
				content: '\f106';
			}
			.icon16.icon-users:before,
			#adminmenu #menu-users div.wp-menu-image:before {
				content: '\f110';
			}
			.icon16.icon-tools:before,
			#adminmenu #menu-tools div.wp-menu-image:before {
				content: '\f107';
			}
			.icon16.icon-settings:before,
			#adminmenu #menu-settings div.wp-menu-image:before {
				content: '\f111';
			}
		</style>
	<?php }

	if(function_exists("register_field_group")) {
		register_field_group(array (
			'id' => 'mini_application-information',
			'title' => 'Application Information',
			'fields' => array (
				array (
					'key' => 'field_5286a43dd6552',
					'label' => __('Description'),
					'name' => 'description',
					'type' => 'wysiwyg',
					'instructions' => __('This text will also be used on your Maker sign. Be descriptive! Some HTML allowed.'),
					'required' => 1,
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'formatting' => 'html',
				),
				array (
					'key' => 'field_5286a246e0f62',
					'label' => __('Form Type'),
					'name' => 'form_type',
					'type' => 'radio',
					'required' => 1,
					'choices' => array (
						'booth-exhibit' => 'Maker booth or exhibit',
						'commercial-booth' => 'Commercial maker booth (primarily sales booth)',
						'workshop-presentation' => 'Workshop or Presentation',
						'performer' => 'Performer',
						'exhibit-sponsor' => 'Exhibiting sponsor',
					),
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => '',
					'layout' => 'vertical',
				),
				array (
					'key' => 'field_5286a46bd6553',
					'label' => __('Hands On'),
					'name' => 'hands-on',
					'type' => 'true_false',
					'instructions' => __('Does your exhibit include a hands-on activity? If so, please include that in your exhibit description.'),
					'required' => 1,
					'message' => '',
					'default_value' => 0,
				),
				array (
					'key' => 'field_5286a4a8d6554',
					'label' => __('Project Website'),
					'name' => 'project-website',
					'type' => 'text',
					'instructions' => __('Project Website Address (URL)'),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286a5d1d6555',
					'label' => __('Project Photo'),
					'name' => 'project-photo',
					'type' => 'image',
					'save_format' => 'object',
					'preview_size' => 'full',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286ad0949e7e',
					'label' => __('Maker'),
					'name' => 'maker',
					'type' => 'repeater',
					'instructions' => __('Add each maker that you want to include in your public profile.'),
					'sub_fields' => array (
						array (
							'key' => 'field_name',
							'label' => __('Name'),
							'name' => 'name',
							'type' => 'text',
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'formatting' => 'html',
							'maxlength' => '',
						),
						array (
							'key' => 'field_make_image',
							'label' => __('Maker Photo'),
							'name' => 'maker-photo',
							'type' => 'image',
							'save_format' => 'object',
							'preview_size' => 'medium',
							'library' => 'all',
						),
						array (
							'key' => 'field_email',
							'label' => __('Email'),
							'name' => 'email',
							'type' => 'text',
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'formatting' => '',
							'maxlength' => '',
						),
						array (
							'key' => 'field_org',
							'label' => __('Organization/Company'),
							'name' => 'org-company',
							'type' => 'text',
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'formatting' => '',
							'maxlength' => '',
						),
						array (
							'key' => 'field_twitter',
							'label' => __('Twitter Username'),
							'name' => 'twitter',
							'instructions' => __('Don\'t include the @ symbol.'),
							'type' => 'text',
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '@',
							'append' => '',
							'formatting' => '',
							'maxlength' => '',
						),
					),
					'row_min' => 1,
					'row_limit' => '',
					'layout' => 'row',
					'button_label' => 'Add an additional maker',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'application',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'default',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 0,
		));
	}
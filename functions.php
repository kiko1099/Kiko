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

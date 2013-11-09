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
				'header-menu' => __( 'Header Menu' )
			) );
		}
	endif;


	/**
	 * Enqueue any custom Scripts or styles
	 * @return void
	 */
	function make_add_resources() {
		// Stylesheets
		wp_enqueue_style( 'make-styles', get_stylesheet_directory_uri() . '/css/style.css', null, THEME_VERSION );

		// JavaScripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'make-bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), THEME_VERSION );
		wp_enqueue_script( 'make-countdown', get_stylesheet_directory_uri() . '/js/jquery.countdown.js', array( 'jquery' ), THEME_VERSION, true );
	}
	add_action( 'wp_enqueue_scripts', 'make_add_resources' );


	/**
	 * Enqueue any custom scripts or styles for the admin area
	 * TODO: remove this first version in favor of the Post Locker Plugin - http://wordpress.org/plugins/hide-post-locker/
	 * @return void
	 */
	function make_add_admin_resources() {
		if ( get_post_type() == 'mf_form' && is_admin() )
			wp_enqueue_script( 'make-custom-post-lock', get_stylesheet_directory_uri() . '/js/expand-post-edit.js', array( 'jquery' ), THEME_VERSION );
	}
	add_action( 'admin_enqueue_scripts', 'make_add_admin_resources' );


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

	}
	add_action( 'widgets_init', 'makerfaire_widgets_init' );


	/**
	 * Deprecated code or uneeded for MMF below?
	 */
	
	function makerfaire_get_news() {
		$url = 'http://makezine.com/maker-faire-news/';
		$output = wpcom_vip_file_get_contents( $url, 3, 60,  array( 'obey_cache_control_header' => false ) );
		return $output;
	}
	add_shortcode('news', 'makerfaire_get_news');


	function makerfaire_carousel_shortcode( $atts ) {
		extract( shortcode_atts( array( 'id' => 'biggins'), $atts ) );
		
		return 	'<a class="carousel-control left" href="#' . esc_attr( $id ) . '" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#' . esc_attr( $id ) . '" data-slide="next">&rsaquo;</a>';
	}
	add_shortcode( 'arrows', 'makerfaire_carousel_shortcode' );

	function makerfaire_data_toggle() {
		return '<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#ny2012">New York 2012</a></li>
			<li><a data-toggle="tab" href="#d2012">Detroit 2012</a></li>
			<li><a data-toggle="tab" href="#ba2012">Bay Area 2012</a></li>
			<li><a data-toggle="tab" href="#ny2011">New York 2011</a></li>
			<li><a data-toggle="tab" href="#d2011">Detroit 2011</a></li>
			<li><a data-toggle="tab" href="#ba2011">Bay Area 2011</a></li>
			<li><a data-toggle="tab" href="#ny2010">New York 2010</a></li>
			<li><a data-toggle="tab" href="#d2010">Detroit 2010</a></li>
			<li><a data-toggle="tab" href="#ba2010">Bay Area 2010</a></li>
			<li><a data-toggle="tab" href="#ba2009">Bay Area 2009</a></li>
			<li><a data-toggle="tab" href="#a2008">Austin 2008</a></li>
			<li><a data-toggle="tab" href="#ba2008">Bay Area 2008</a></li>
			<li><a data-toggle="tab" href="#a2007">Austin 2007</a></li>
		</ul>';
	}

	add_shortcode( 'tabs', 'makerfaire_data_toggle' );

	function makerfaire_newsletter_shortcode() {

			$output = '<form action="http://makermedia.createsend.com/t/r/s/jjuruj/" method="post" class="form-horizontal" id="subForm">
				<fieldset>
				
				<legend>Sign up for the Maker Faire Newsletter</legend>
				
				<div class="control-group">
					<label for="name" class="control-label">Your Name:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="cm-name" id="name" size="35" />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="jjuruj-jjuruj">Your Email:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="cm-jjuruj-jjuruj" id="jjuruj-jjuruj" size="35" />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="cm621683"></label>
					<div class="controls">
						<label class="checkbox">
							<input type="checkbox" name="cm-fo-dduult" id="cm621683" value="621683" />
							Please let me know when the Call for Makers goes out!
						</label>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="optionsCheckbox">Any chance we could interest you in...</label>
					<div class="controls">
					</div>
					<div class="controls">
						<label for="MAKENewsletter" class="checkbox">
							<input type="checkbox" name="cm-ol-jjuylk" id="MAKENewsletter" />
							The MAKE Newsletter?
						</label>
					</div>
				</div>
				
				<div class="form-actions">
					<input type="submit" value="Subscribe" class="btn btn-primary" />
				</div>
				
				</fieldset>
			</form>';

		return $output;
	}

	add_shortcode( 'newsletter', 'makerfaire_newsletter_shortcode' );

	function makerfaire_news_rss() { ?>
		<div class="newsies">
			<div class="news post">
				<h3 style="color: #fc040c;"><a href="http://makezine.com/tag/maker-faire/">Latest Maker Faire News</a></h3>
				<?php 
				$fs = makerfaire_index_feed();

				foreach($fs as $f) : $a = $f['i']->get_authors(); ?>
					<h4><a href="<?php echo esc_url($f['i']->get_link()); ?>"><?php echo esc_html($f['i']->get_title()); ?></a></h4>
					<div class="row">
						<div class="span2">
							<a href="<?php echo esc_url($f['i']->get_link()); ?>" title="<?php echo esc_attr($f['i']->get_title()); ?>"><img class="thumbnail faire-thumb " alt="<?php echo esc_attr($f['i']->get_title()); ?>" src="<?php echo esc_url($f['src']); ?>" /></a>
						</div>
						<div class="span6">
						<?php echo str_replace(array($f['img'], '<p><a href="'.$f['i']->get_link().'">Read the full article on MAKE</a></p>'), '', html_entity_decode(esc_html($f['i']->get_description()))); ?>
						<p class="read_more" style="margin:10px 0"><strong>
						<a class="btn btn-primary btn-mini" href="<?php echo esc_url($f['i']->get_link()); ?>">Read full story &raquo;</a></strong></p>
						
							<ul class="unstyled">
								<li>Posted by <?php echo esc_html($a[0]->name); ?> | <?php echo esc_html($f['i']->get_date()); ?></li>
								<li>Categories: <?php foreach($f['i']->get_categories() as $cat) : echo esc_html($cat->term.', '); endforeach; ?></li>
							</ul>
						</div>
					</div>
				<?php endforeach; ?> 
			</div>
		</div>
		<h4><a href="http://makezine.com/tag/maker-faire/">Read More &rarr;</a></h4>
	<?php }

	


	function mf_quick_links_box() {
		add_meta_box( 'quickly', 'Quick Links', 'mf_quick_links', 'mf_form' );
	}
	// This function echoes the content of our meta box
	function mf_quick_links() {
		$output = '<div id="project-id-search"><label for="project-id" class="screen-reader-text">Search by Project ID</label><input type="search" name="search-proj-id" id="project-id" /><input type="submit" value="Search by ID" id="search-submit" class="button" /></div><ul class="subsubsub">
			<li class="all"><a href="edit.php?post_type=mf_form" class="current">All</a> |</li>
			<li class="trash"><a href="edit.php?post_status=trash&amp;post_type=mf_form">Trash</a> |</li>
			<li class="proposed"><a href="edit.php?post_status=proposed&amp;post_type=mf_form" title="Application proposed; waiting for acceptance.">Proposed</a> |</li>
			<li class="waiting-for-info"><a href="edit.php?post_status=waiting-for-info&amp;post_type=mf_form" title="Question has been emailed to Maker, waiting for response.">Waiting for Info</a> |</li>
			<li class="accepted"><a href="edit.php?post_status=accepted&amp;post_type=mf_form" title="Application is accepted to Maker Faire.">Accepted</a> |</li>
			<li class="cancelled"><a href="edit.php?post_status=cancelled&amp;post_type=mf_form" title="Accepted application is cancelled; This project will not attend Maker Faire after all.">Cancelled</a> |</li>
			<li class="in-progress"><a href="edit.php?post_status=in-progress&amp;post_type=mf_form" title="">In Progress</a></li>
		</ul>
		<div class="clear"></div>';
		echo $output;
	}

	if (is_admin())
		add_action('admin_menu', 'mf_quick_links_box');
		
	function mf_clean_title( $title ) {
	    $title = str_replace('&nbsp;', ' ', $title);
	    return $title;
	}
	add_filter('the_title', 'mf_clean_title', 10, 2);


	function mf_release_shortcode() {
		$request_id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : null);
		$output = '<iframe src="' . esc_url( 'http://db.makerfaire.com/pa/' .  $request_id ) . '" width="620" height="2000" scrolling="auto" frameborder="0"> [Your user agent does not support frames or is currently configured not to display frames.] </iframe>';
		return $output;
	}

	add_shortcode( 'release', 'mf_release_shortcode' );


	add_filter( 'wp_kses_allowed_html', 'mf_allow_data_atts', 10, 2 );
	function mf_allow_data_atts( $allowedposttags, $context ) {
		$tags = array( 'div', 'a', 'li' );
		$new_attributes = array( 'data-toggle' => true );
	 
		foreach ( $tags as $tag ) {
			if ( isset( $allowedposttags[ $tag ] ) && is_array( $allowedposttags[ $tag ] ) )
				$allowedposttags[ $tag ] = array_merge( $allowedposttags[ $tag ], $new_attributes );
		}
		
		return $allowedposttags;
	}


	add_filter('tiny_mce_before_init', 'mf_filter_tiny_mce_before_init'); 
	function mf_filter_tiny_mce_before_init( $options ) { 

		if ( ! isset( $options['extended_valid_elements'] ) ) 
			$options['extended_valid_elements'] = ''; 

		$options['extended_valid_elements'] .= ',a[data*|class|id|style|href]';
		$options['extended_valid_elements'] .= ',li[data*|class|id|style]';
		$options['extended_valid_elements'] .= ',div[data*|class|id|style]';

		return $options; 
	}


	function mf_allow_my_post_types( $allowed_post_types ) {
		$allowed_post_types[] = 'mf_form';
		return $allowed_post_types;
	}

	add_filter( 'rest_api_allowed_post_types', 'mf_allow_my_post_types');


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
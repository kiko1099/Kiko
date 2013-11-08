<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#" lang="en">
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object#">
	<meta charset="utf-8">
	<meta name="apple-itunes-app" content="app-id=463248665"/>

	<title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo( 'description' ) : wp_title( '' ); ?></title>
	<meta name="description" content="<?php if ( is_single() ) {
			echo wp_trim_words( strip_shortcodes( get_the_content( '...' ) ), 20 );
		} else {
			echo bloginfo( 'name' ) . ' - ' . bloginfo( 'description' );
		}
	?>" />

	<?php wp_head(); ?>

	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-XXXXX-X']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	</script>

	</head>


	<body id="bootstrap-js" <?php body_class(); ?>>
		<header id="header">
			<div class="container">
				<div class="row">
	
					<div class="span12">
						<p class="tagline"><?php echo bloginfo( 'description' ); ?></p>
					</div>
	
					<div class="span12">
			
						<!-- Custom Header Here -->
						<h1>
							<a href="<?php echo home_url( '/' ); ?>"><img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" title="<?php echo bloginfo( 'name' ); ?>" alt="<?php echo bloginfo( 'description' ); ?>" /></a>
						</h1>
			
					</div>
				
					<div class="span12">
						<div class="nav navi">

							<?php
								$defaults = array(
									'theme_location'  => '',
									'menu'            => 'header-menu',
									'container'       => false,
									'container_class' => '',
									'container_id'    => '',
									'menu_class'      => 'menu',
									'menu_id'         => '',
									'echo'            => true,
									'fallback_cb'     => 'wp_page_menu',
									'before'          => '',
									'after'           => '',
									'link_before'     => '<div>',
									'link_after'      => '</div>',
									'items_wrap'      => '<ul id="%1$s" class="%2$s nav nav-pills">%3$s</ul>',
									'depth'           => 1,
									'walker'          => ''
								);
								wp_nav_menu( $defaults );
							?>
					
						</div><!--end nav wrapper-->
					</div>
			
				</div>	
			</div>
		</header>
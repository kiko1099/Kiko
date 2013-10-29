<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#" lang="en">
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object#">
	<meta charset="utf-8">
	<meta name="apple-itunes-app" content="app-id=463248665"/>

	<title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
	<meta name="description" content="<?php if ( is_single() ) {
				echo wp_trim_words( strip_shortcodes( get_the_content('...') ), 20 );
			} else {
				bloginfo( 'name' );
				echo " - ";
				bloginfo('description');
			}
	?>" />

	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-51157-7']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	</script>

	<?php wp_head(); ?>

	</head>


<body id="bootstrap-js" <?php body_class(); ?>>

<header id="header">

	<div class="container">

			<div class="row">
			
				<div class="span5">
			
					<h1><a href="http://makerfaire.com" title="Maker Faire"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/logo.jpg" width="380" alt="Maker Faire" title="Maker Faire"></a></h1>
			
				</div>
				
				<div class="span7">
			
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
								'items_wrap'      => '<ul id="%1$s" class="%2$s" style="margin-left:12px;">%3$s</ul>',
								'depth'           => 0,
								'walker'          => ''
							);

						wp_nav_menu( $defaults );	

						?>
					
					</div><!--end nav wrapper-->
					
				</div>
			
			</div>
		
		</div>
		
	</div>


</header>
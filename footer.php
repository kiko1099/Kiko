		<div class="clear"></div>
		<div class="beige">

			<div class="container">	
	
				<footer>
					<div class="row">
						
						<?php dynamic_sidebar( 'footer-1' ); ?>
				
						<?php dynamic_sidebar( 'footer-2' ); ?>
							
						<?php dynamic_sidebar( 'footer-3' ); ?>
		
					</div>
			
					<div class="row">
			
						<div class="span12">
							
							<?php 
								wp_nav_menu( array(
									'theme_location'  => 'footer-menu',
									'container'       => false,
									'link_before'     => '<div>',
									'link_after'      => '</div>',
									'items_wrap'      => '<ul id="%1$s" class="%2$s nav nav-pills">%3$s</ul>',
								) );
							?>
					
						</div>
			
					</div>
				</footer>
		
			</div>
	
		</div>

		<?php wp_footer(); ?>

	</body>
</html>
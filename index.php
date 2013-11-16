<?php get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<article <?php post_class(); ?>>

					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

					<p class="meta top">By <?php the_author_posts_link(); ?>, <?php the_time( 'Y/m/d \@ g:i a' ) ?></p>

					<?php the_content(); ?>

					<div class="media">
						
						<a href="" class="pull-left" title="">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), 88 ); ?>
						</a>
						
						<div class="media-body well">
						
							<p><?php _e( 'Posted by', 'make-mini-mf' ); ?> <?php the_author_posts_link(); ?> | <?php the_time( 'l F jS, Y g:i A' ); ?></p>
							<p><?php _e( 'Categories:' ); ?> <?php the_category(', '); ?> | <?php comments_popup_link(); ?> <?php edit_post_link( __( ' | Edit', 'make-mini-mf' ) ); ?></p>

						</div>

					</div>
				
				</article>
				
			<?php endwhile; ?>

				<ul class="pager">
			
					<li class="previous"><?php previous_posts_link( __( '&larr; Previous Page', 'make-mini-mf' ) ); ?></li>
					<li class="next"><?php next_posts_link( __( 'Next Page &rarr;', 'make-mini-mf' ) ); ?></li>
				
				</ul>
			
			<?php else : ?>
			
				<p><?php _e( 'Sorry, no posts matched your criteria.', 'make-mini-mf' ); ?></p>
			
			<?php endif; ?>

		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>
	
</div><!--Container-->

<?php get_footer(); ?>
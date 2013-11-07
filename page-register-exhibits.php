<?php // Template Name: Register Exhibits ?>

<?php get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<article <?php post_class(); ?>>

					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

					<?php the_content(); ?>
					<?php
						// To update the form, please adjust the PHP array in class.exhibits.php
						mf_applications_display_form( $mf_application_exhibits->settings, $mf_application_exhibits->form );
					?>
				
				</article>
				
			<?php endwhile; ?>
	
			<?php else: ?>
			
				<p><?php _e('Sorry, no posts matched your criteria.', 'make-mini-mf' ); ?></p>
			
			<?php endif; ?>

		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>
	
</div><!--Container-->

<?php get_footer(); ?>
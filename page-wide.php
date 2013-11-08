<?php get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span12">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<article <?php post_class(); ?>>

					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

					<?php the_content(); ?>
				
				</article>
				
			<?php endwhile; ?>

			<?php else: ?>
			
				<p><?php _e( 'Sorry, no posts matched your criteria.', 'make-mini-mf' ); ?></p>
			
			<?php endif; ?>

		</div><!--Content-->

	</div>
	
</div><!--Container-->

<?php get_footer(); ?>
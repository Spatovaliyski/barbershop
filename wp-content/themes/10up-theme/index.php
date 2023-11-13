<?php
/**
 * The main template file
 *
 * @package TenUpTheme
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<div class="container">
				<h2><?php the_title(); ?></h2>
				<?php the_content(); ?>
			</div><!-- .container -->
		<?php endwhile; ?>
	<?php endif; ?>
<?php
get_footer();

<?php
/**
 * This template part displays the hero section of a page, which includes a title and a featured image.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TenUpTheme
 *
 * @param array $args {
 *     An array of arguments.
 *
 *     @type string $title          - Title of the hero section.
 *     @type string $featured_image - Featured image of the hero section.
 * }
 */

extract( $args );
?>

<section class="section section-intro">
	<div class="section__container">
		<div class="section__content">
			<div class="section-heading">
				
				<?php if ( !empty ( $args['title'] ) ) : ?>
					<h1 class="section-heading__title"><?php echo esc_html__( $args['title'], '10up-theme' ); ?></h1>
				<?php endif; ?>

				<h4 class="section-heading__subtitle"><?php esc_html_e( 'Elevate your look with precision styling at our neighborhood barbershop', '10up-theme' ); ?></h4>
				<a href="#" class="button button__primary"><?php esc_html_e( 'See more', '10up-theme' ); ?></a>
			</div>
			
			<figure class="section-figure">
				<?php if ( !empty( $args['featured_image'] ) ) : ?>
					<?php echo $args['featured_image']; ?>
				<?php endif; ?>
			</figure>
		</div>
	</div>
</section>
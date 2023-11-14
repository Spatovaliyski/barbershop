<?php
/**
 * Template part for displaying a simple CTA section.
 * This is a hardcoded template part, but it can be extended to be dynamic with: ACF / Custom Post Types / Gutenberg Blocks, etc.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TenUpTheme
 */

extract( $args );
?>

<section class="section section-cta">
	<div class="section__container">
		<div class="section-heading section-heading--centered">
			<h2 class="section-heading__title"><?php esc_html_e( 'Ready for that new look?', '10up-theme' ); ?></h2>
		</div>

		<div class="section__content">
			<a href="<?php echo home_url('/book-an-hour'); ?>" class="button button__primary"><?php esc_html_e( "Let's begin", '10up-theme' ); ?></a>
		</div>
	</div>
</section>
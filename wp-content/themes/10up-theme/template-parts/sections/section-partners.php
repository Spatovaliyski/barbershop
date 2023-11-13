<?php
/**
 * This template part displays partner logos in a section.
 * This is a hardcoded template part, but it can be extended to be dynamic with: ACF / Custom Post Types / Gutenberg Blocks, etc.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TenUpTheme
 * 
 */

extract( $args );
?>

<section class="section section__background--gradient-left">
	<div class="section__container">
		<div class="section__content">
			<div class="partner-logos">
				<img class="partner-logos__logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-placeholder.png" alt="Placeholder logo">
				<img class="partner-logos__logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-placeholder.png" alt="Placeholder logo">
				<img class="partner-logos__logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-placeholder.png" alt="Placeholder logo">
				<img class="partner-logos__logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-placeholder.png" alt="Placeholder logo">
			</div>
		</div>
	</div>
</section>
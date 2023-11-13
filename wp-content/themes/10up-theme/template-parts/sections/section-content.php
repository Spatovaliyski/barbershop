<?php
/**
 * Template part for displaying The content of a page wrapped in a section.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TenUpTheme
 */

extract( $args );
?>

<section class="section">
	<div class="section__container">
		<div class="section__content">
			<?php echo the_content(); ?>
		</div>
	</div>
</section>
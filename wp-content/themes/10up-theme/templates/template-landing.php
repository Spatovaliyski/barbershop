<?php
/**
 * Template Name: Booking Landing Page
 *
 * @package TenUpTheme
 */

get_header();
?>

<?php get_template_part( 'template-parts/sections/section', 'intro', [
	'title' => get_the_title(),
	'featured_image' => get_the_post_thumbnail(),
] ); ?>

<?php get_template_part( 'template-parts/sections/section', 'partners'); ?>

<?php get_template_part( 'template-parts/sections/section', 'services' ); ?>

<?php get_template_part( 'template-parts/sections/section', 'gallery-grid' ); ?>

<?php get_template_part( 'template-parts/sections/section', 'cta' ); ?>

<?php get_footer(); ?>
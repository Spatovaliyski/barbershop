<?php
/**
 * Template part that displays the return status for a failed Booking submission.
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TenUpTheme
 */

extract( $args );
?>

<section class="section">
	<div class="section__container">
		<div class="section-heading section-heading--centered">
			<h2 class="section-heading__title"><?php esc_html_e( "Oops! We couldn't create this booking.", "10up-theme" ); ?></h2>
			<h2 class="section-heading__subtitle"><?php esc_html_e( "Would you like to try again?", "10up-theme" ); ?></h2>
		</div>

		<div class="section__content">
			<a href="#" class="button button__primary"><?php esc_html_e( "Let's begin", '10up-theme' ); ?></a>
		</div>
	</div>
</section>


<?php
/**
 * Template part that displays the return status for a successful Booking submission.
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TenUpTheme
 */

extract( $args );
?>

<section class="section">
	<div class="section__container">
		<div class="section-heading">
			<h2 class="section-heading__title"><?php esc_html_e( "You've successfuly booked an appointment", "10up-theme" ); ?></h2>
			<h3 class="section-heading__subtitle"><?php esc_html_e( "Below are listed all the details for the booking", "10up-theme" ); ?></h3>
		</div>

		<div class="section__content">
			<div><h4>Name:</h4><?php echo $args['customer']; ?></div>
			<div><h4>Date and Time: </h4><?php echo (new DateTime($args['datetime']))->format('j F Y - H:i'); ?></div>
			<div><h4>Services:</h4><?php echo $args['services']; ?></div>
		</div>
	</div>
</section>


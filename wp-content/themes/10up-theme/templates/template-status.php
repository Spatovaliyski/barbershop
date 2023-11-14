<?php
/**
 * Template Name: Booking Status Page
 *
 * @package TenUpTheme
 */

get_header();
?>

<?php
$status = $_GET['status'];
$datetime = $_GET['datetime'];
$customer = $_GET['customer'];
$services = $_GET['services'];

if ($status === NULL) {
	get_template_part('template-parts/statuses/status', 'fail');
} else if ($status === 'success') {
	get_template_part('template-parts/statuses/status', 'success', array(
		'datetime' => $datetime,
		'customer' => $customer,
		'services' => $services
	));
} else {
	get_template_part('template-parts/statuses/status', 'default');
}

?>

<?php get_footer(); ?>
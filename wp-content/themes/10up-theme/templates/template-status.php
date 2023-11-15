<?php
/**
 * Template Name: Booking Status Page
 *
 * @package TenUpTheme
 */

get_header();
?>

<?php
/**
 * This file is responsible for displaying the status of a customer's service request.
 * 
 * @param string|null $status The status of the service request. Can be 'success', 'fail', or null.
 * @param string|null $datetime The date and time of the service request.
 * @param string|null $customer The name of the customer who requested the service.
 * @param string|null $services The type of service requested by the customer.
 * 
 * @return void
 */
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
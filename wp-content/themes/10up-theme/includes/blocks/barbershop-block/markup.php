<?php
/**
 * The markup for the Barbershop Booking block.
 *
 * @package 10up-theme
 */

// Get the block attributes.
$attributes = $attributes ?? [];
$services   = $attributes['services'] ?? [];

/**
 * Get the days in the current month.
 *
 * @return int The number of days in the current month.
 */

function get_days_in_month() {
	$current_date = new DateTime();
	return (int) $current_date->format( 't' );
}

/**
 * Get the days in the current month.
 *
 * @return array An array of days in the current month with date and is_past_day.
 */
function get_days() {
	$current_date = new DateTime();
	$days_in_month = get_days_in_month();
	$days = [];
	for ( $i = 1; $i <= $days_in_month; $i++ ) {
		$date        = new DateTime( "{$current_date->format( 'Y-m' )}-{$i}" );
		$is_past_day = $date < new DateTime();
		$days[]      = [
			'date'        => $date,
			'is_past_day' => $is_past_day,
		];
	}
	return $days;
}

/**
 * Get the first day of the current month.
 *
 * @return DateTime The first day of the current month.
 */
function get_first_day_of_month() {
	$current_date = new DateTime();
	return new DateTime( "{$current_date->format( 'Y-m' )}-01" );
}

/**
 * Get the day of the week for the first day of the current month.
 *
 * @return int The day of the week for the first day of the current month.
 */
function get_day_of_week() {
	$first_day_of_month = get_first_day_of_month();
	return (int) $first_day_of_month->format( 'w' );
}

/**
 * Get the hours.
 *
 * @return array An array of hours.
 */

function get_hours() {
	$hours = [];
	for ( $i = 9; $i <= 18; $i++ ) {
		$hours[] = sprintf( '%02d:00', $i % 24 );
	}
	return $hours;
}

/**
 * Get the booking data.
 *
 * @return array An array of booking data with services, day, and hour.
 */

function get_booking() {
	return [
		'services' => $services ?? [],
		'day'      => '',
		'hour'     => '',
	];
}

/**
 * Get the total cost.
 *
 * @param array $booking An array of booking data with services, day, and hour.
 * @return int The total cost of the booking.
 */
function get_total_cost($booking) {
	$total_cost = 0;
	foreach ( $booking['services'] as $service ) {
		foreach ( $services as $s ) {
			if ( $s['name'] === $service ) {
				$total_cost += $s['price'];
				break;
			}
		}
	}
	return $total_cost;
}
?>

<div <?php echo get_block_wrapper_attributes(); // phpcs:ignore ?> class="barbershop-block">
	<h2>Barbershop Booking</h2>
	<div class="barbershop-block__step barbershop-block__step--service active">
		<h4 class="barbershop-block__step-title">Choose the type of service</h4>
		<div class="barbershop-block__step-items">
			<?php foreach ( $services as $service ) : ?>
				<label>
					<input type="checkbox" name="services" data-price="<?php echo esc_attr( $service['price'] ); ?>" value="<?php echo esc_attr( $service['name'] ); ?>" <?php checked( in_array( $service['name'], get_booking()['services'], true ) ); ?>>
					<span><?php echo esc_html( $service['name'] ); ?> - €<?php echo esc_html( $service['price'] ); ?></span>
				</label>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="barbershop-block__step barbershop-block__step--calendar">
		<h4 class="barbershop-block__step-title">Choose a day</h4>
		<div class="barbershop-block__calendar--hint">
			<p>Monday</p>
			<p>Tuesday</p>
			<p>Wednesday</p>
			<p>Thursday</p>
			<p>Friday</p>
			<p>Saturday</p>
			<p>Sunday</p>
		</div>
		<div class="barbershop-block__step-items" data-startday="<?php echo esc_attr( get_day_of_week() ); ?>">
			<?php foreach ( get_days() as $day ) : ?>
				<label>
					<input type="radio" name="day" value="<?php echo esc_attr( $day['date']->format( 'Y-m-d' ) ); ?>" <?php checked( get_booking()['day'] === $day['date']->format( 'Y-m-d' ) ); ?> <?php disabled( $day['is_past_day'] ); ?>>
					<span class="<?php echo $day['is_past_day'] ? 'past-date' : ''; ?>"><?php echo esc_html( $day['date']->format( 'j' ) ); ?></span>
				</label>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="barbershop-block__step barbershop-block__step--hour">
		<h4 class="barbershop-block__step-title">Choose a timeslot</h4>
		<div class="barbershop-block__step-items">
			<?php foreach ( get_hours() as $hour ) : ?>
				<label>
					<input type="radio" name="hour" value="<?php echo esc_attr( $hour ); ?>" <?php checked( get_booking()['hour'] === $hour ); ?>>
					<span><?php echo esc_html( $hour ); ?></span>
				</label>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="barbershop-block__step barbershop-block__step--name">
		<h4 class="barbershop-block__step-title">And finally, Your name and surname</h4>
		<div class="barbershop-block__step-items">
			<div class="barbershop-block__textinput">
				<label for="person_name">Name and Surname</label>
				<input type="text" name="person_name">
			</div>
		</div>
	</div>
	<div class="barbershop-block__step barbershop-block__step--final">
		<div class="barbershop-block__metadata">
			<span>Total cost: €</span>
			<span id="total-cost"><?php echo esc_html( get_total_cost(get_booking()) ); ?></span>
		</div>

		<form>
			<?php foreach ( get_booking()['services'] as $service ) : ?>
				<input type="hidden" name="services[]" value="<?php echo esc_attr( $service ); ?>">
			<?php endforeach; ?>
			<input type="hidden" name="day" value="<?php echo esc_attr( get_booking()['day'] ); ?>">
			<input type="hidden" name="hour" value="<?php echo esc_attr( get_booking()['hour'] ); ?>">
			<button class="button button__primary" type="submit">Book Now</button>
		</form>
	</div>
</div>

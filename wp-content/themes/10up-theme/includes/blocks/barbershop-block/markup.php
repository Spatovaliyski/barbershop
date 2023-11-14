<?php
/**
 * The markup for the Barbershop Booking block.
 *
 * @package TenUpTheme\Blocks\Barbershop
 *
 * @var array $attributes The block attributes.
 * @var array $services   The services.
 */
?>

<?php
/**
 * Get the block wrapper attributes.
 */
$attributes = $attributes ?? [];
$services   = $attributes['services'] ?? [];

/**
 * Get the days in the current month.
 *
 * @return int The number of days in the current month.
 */
if ( ! function_exists( 'get_days_in_month' ) ) {
	function get_days_in_month() {
		$current_date = new DateTime();
		return (int) $current_date->format( 't' );
	}
}

/**
 * Get the days in the current month.
 *
 * @return array An array of days in the current month with date and is_past_day.
 */
if ( ! function_exists( 'get_days' ) ) {
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
}

/**
 * Get the first day of the current month.
 *
 * @return DateTime The first day of the current month.
 */
if ( ! function_exists( 'get_first_day_of_month' ) ) {
	function get_first_day_of_month() {
		$current_date = new DateTime();
		return new DateTime( "{$current_date->format( 'Y-m' )}-01" );
	}
}

/**
 * Get the day of the week for the first day of the current month.
 *
 * @return int The day of the week for the first day of the current month.
 */
if ( ! function_exists( 'get_day_of_week' ) ) {
	function get_day_of_week() {
		$first_day_of_month = get_first_day_of_month();
		return (int) $first_day_of_month->format( 'w' );
	}
}

/**
 * Get the hours.
 *
 * @return array An array of hours.
 */

if ( ! function_exists( 'get_hours' ) ) {
	function get_hours() {
		$hours = [];
		for ( $i = 9; $i <= 18; $i++ ) {
			$hours[] = sprintf( '%02d:00', $i % 24 );
		}
		return $hours;
	}
}

/**
 * Get the booking data.
 *
 * @return array An array of booking data with services, day, and hour.
 */

if ( ! function_exists( 'get_booking' ) ) {
	function get_booking() {
		global $services;
		return [
			'services' => $services ?? [],
			'day'      => '',
			'hour'     => '',
			'name'		 => '',
		];
	}
}

/**
 * Get the total cost.
 *
 * @param array $booking An array of booking data with services, day, and hour.
 * @return int The total cost of the booking.
 */
if ( ! function_exists( 'get_total_cost' ) ) {
	function get_total_cost($booking) {
		global $services;
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
}
?>

<?php
/**
 * Chunk the implementation in steps. Each step is written as a modifier in the end
 */
?>
<div <?php echo get_block_wrapper_attributes(); // phpcs:ignore ?> class="barbershop-block">
	<form id="barbershop_form" method="post">
		<?php 
		/**
		 * Step: Services. This is linked to the Block editor's inspector controls, printing out all available ones
		 * 
		 * @uses $services, get_booking()
		 */
		?>
		<div class="barbershop-block__step barbershop-block__step--service active">
			<h4 class="barbershop-block__step-title"><?php esc_html_e( 'Choose the type of service', '10up-theme' ); ?></h4>
			<div class="barbershop-block__step-items">
				<?php foreach ( $services as $service ) : ?>
					<label>
						<input type="checkbox" name="services" data-price="<?php echo esc_attr( $service['price'] ); ?>" value="<?php echo esc_attr( $service['name'] ); ?>" <?php checked( in_array( $service['name'], get_booking()['services'], true ) ); ?>>
						<span><?php echo esc_html( $service['name'] ); ?> - €<?php echo esc_html( $service['price'] ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
		</div>

		<?php 
		/**
		 * Step: Calendar. We're running with the current month and disabling past days 
		 * 
		 * @uses get_days(), get_day_of_week(), get_booking(), 
		 */
		?>
		<div class="barbershop-block__step barbershop-block__step--calendar">
			<h4 class="barbershop-block__step-title"><?php esc_html_e( 'Choose a day', '10up-theme' ); ?></h4>
			<div class="barbershop-block__calendar--hint">
				<p><?php esc_html_e( 'Monday', '10up-theme' ); ?></p>
				<p><?php esc_html_e( 'Tuesday', '10up-theme' ); ?></p>
				<p><?php esc_html_e( 'Wednesday', '10up-theme' ); ?></p>
				<p><?php esc_html_e( 'Thursday', '10up-theme' ); ?></p>
				<p><?php esc_html_e( 'Friday', '10up-theme' ); ?></p>
				<p><?php esc_html_e( 'Saturday', '10up-theme' ); ?></p>
				<p><?php esc_html_e( 'Sunday', '10up-theme' ); ?></p>
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

		<?php 
		/**
		 * Step: Hour picker. Picks an available hour from the provided list. Currently hardcoded amount of hours
		 * 
		 * @uses get_hours(), get_booking()
		 */
		?>
		<div class="barbershop-block__step barbershop-block__step--hour">
			<h4 class="barbershop-block__step-title"><?php esc_html_e( 'Choose a timeslot', '10up-theme' ); ?></h4>
			<div class="barbershop-block__step-items">
				<?php foreach ( get_hours() as $hour ) : ?>
					<label>
						<input type="radio" name="hour" value="<?php echo esc_attr( $hour ); ?>" <?php checked( get_booking()['hour'] === $hour ); ?>>
						<span><?php echo esc_html( $hour ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
		</div>

		<?php 
		/**
		 * Step: Name. Linked with the final step. We use this input to generate the Custom Post Type's title
		 */
		?>
		<div class="barbershop-block__step barbershop-block__step--name">
			<h4 class="barbershop-block__step-title"><?php esc_html_e( 'And finally, Your First and Last name', '10up-theme' ); ?></h4>
			<div class="barbershop-block__step-items">
				<div class="barbershop-block__textinput">
					<label for="customer"><?php esc_html_e( 'First and Last name', '10up-theme' ); ?></label>
					<input type="text" name="customer" required />
				</div>
			</div>
		</div>

		<?php 
		/**
		 * Step: Final. Let's build and push the data through the API
		 * 
		 * @uses get_booking(), get_total_cost()
		 */
		?>
		<div class="barbershop-block__step barbershop-block__step--final">
			<div class="barbershop-block__metadata">
				<span><?php esc_html_e( 'Total cost:', '10up-theme' ); ?> €</span>
				<span id="total-cost"><?php echo esc_html( get_total_cost(get_booking()) ); ?></span>
			</div>

			<button id="create_booking" class="button button__primary" type="submit"><?php esc_html_e( 'Book Now', '10up-theme' ); ?></button>
		</div>
	</form>
</div>

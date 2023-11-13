<?php
/**
 * Registering a Barbershop bookings CPT with custom meta data.
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin;

/**
 * @package TenUpPlugin
 */
class Bookings extends \TenUpPlugin\Module {

	/**
	 * Allow the autoloader to register this class in WP admin.
	 */
	public function can_register() {
		return true;
	}

	/**
	 * Hooking into the init action to register the CPT and meta data.
	 */
	public function register() {
		add_action( 'init', [ $this, 'register_post_type' ] );
		add_action( 'init', [ $this, 'register_editor_template' ] );
		add_action( 'init', [ $this, 'register_rating_meta' ] );
	}

	/**
	 * Registers the `rating` post meta for the `booking` post type, used to store the rating for a booking.
	 */
	public function register_rating_meta() {
		register_post_meta(
			'booking',
			'rating',
			array(
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'integer',
			)
		);
	}

	/**
	 * This is the callback that registers the 'booking' CPT.
	 */
	public function register_post_type() {

		// Set labels for the CPT.
		$labels = [
			'name'               => __( 'Bookings', 'post type general name', 'tenup-plugin' ),
			'singular_name'      => __( 'Booking', 'post type singular name', 'tenup-plugin' ),
			'menu_name'          => __( 'Bookings', 'admin menu', 'tenup-plugin' ),
			'name_admin_bar'     => __( 'Booking', 'add new on admin bar', 'tenup-plugin' ),
			'add_new'            => __( 'Add New', 'booking', 'tenup-plugin' ),
			'add_new_item'       => __( 'Add New Booking', 'tenup-plugin' ),
			'new_item'           => __( 'New Booking', 'tenup-plugin' ),
			'edit_item'          => __( 'Edit Booking', 'tenup-plugin' ),
			'view_item'          => __( 'View Booking', 'tenup-plugin' ),
			'all_items'          => __( 'All Bookings', 'tenup-plugin' ),
			'search_items'       => __( 'Search Bookings', 'tenup-plugin' ),
			'parent_item_colon'  => __( 'Parent Bookings:', 'tenup-plugin' ),
			'not_found'          => __( 'No bookings found.', 'tenup-plugin' ),
			'not_found_in_trash' => __( 'No bookings found in Trash.', 'tenup-plugin' ),
		];

		// Adding some args and what functionality we want to support.
		$args = [
			'labels'             => $labels,
			'description'        => __( 'The powerhouse for your barbershop bookings in WordPress.', 'tenup-plugin' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'	     => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'booking' ],
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'supports'           => [ 'title', 'editor', 'author', 'custom-fields' ],
		];

		// And finally... register it.
		register_post_type( 'booking', $args );
	}

	/**
	 * Set the template for the booking editor, loading the custom block from the theme.
	 */
	public function register_editor_template() {
		$post_type_object = get_post_type_object( 'booking' );
		$post_type_object->template = [
			['tenup/booking'],
		];
	}

	/**
	 * Registers the `booking_datetime` post meta for the `booking` post type, used to store the booking date and time.
	 */
	public function register_booking_datetime_meta() {
		register_post_meta(
			'booking',
			'booking_datetime',
			array(
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			)
		);
	}

	/**
	 * Add a metabox to the booking editor screen to allow the user to select the booking date and time.
	 */
	public function add_booking_datetime_metabox() {
		add_meta_box(
			'booking_datetime',
			'Booking Date and Time',
			array( $this, 'render_booking_datetime_metabox' ),
			'booking',
			'side',
			'high'
		);
	}

	/**
	 * Render the booking datetime metabox.
	 *
	 * @param WP_Post $post The current post object.
	 */
	public function render_booking_datetime_metabox( $post ) {
		// Retrieve the current booking datetime, if it exists.
		$booking_datetime = get_post_meta( $post->ID, 'booking_datetime', true );

		// Our markup for the metabox. No need for anything complex here, an input is enough.
		?>
		<label for="booking_datetime"><?php esc_html_e( 'Booking Date and Time:', 'tenup-plugin' ); ?></label>
		<input type="datetime-local" id="booking_datetime" name="booking_datetime" value="<?php echo esc_attr( $booking_datetime ); ?>">
		<?php
	}

	/**
	 * Save the booking datetime when the booking is saved or updated.
	 *
	 * @param int $post_id The ID of the current post.
	 */
	public function save_booking_datetime( $post_id ) {
		// Check if the booking datetime was submitted.
		if ( isset( $_POST['booking_datetime'] ) ) {
			// Sanitize the submitted booking datetime.
			$booking_datetime = sanitize_text_field( $_POST['booking_datetime'] );

			// Update the booking datetime post meta.
			update_post_meta( $post_id, 'booking_datetime', $booking_datetime );
		}
	}
}
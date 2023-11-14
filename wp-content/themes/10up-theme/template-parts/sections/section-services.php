<?php
/**
 * This template part displays the provided services by the Barbershop.
 * This is a hardcoded template part, but it can be extended to be dynamic with: ACF / Custom Post Types / Gutenberg Blocks, etc.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TenUpTheme
 *
 */

extract( $args );

// Load the JSON file with the base64 encoded images
$services_icons = json_decode( file_get_contents( get_template_directory() . '/assets/images/services-icons.json' ), true );
?>

<section class="section" id="services">
	<div class="section__container">
		<div class="section-heading section-heading--centered">
				<h4 class="section-heading__accent heading-thin heading-small heading-uppercase"><?php esc_html_e( 'OUR SERVICES', '10up-theme' ); ?></h4>
				<h2 class="section-heading__title"><?php esc_html_e( 'Where we excel at', '10up-theme' ); ?></h2>
		</div>

		<div class="section__content">
			<div class="barbershop-services">
				<div class="barbershop-services__item">
					<img class="barbershop-services__icon" src="<?php echo $services_icons['haircut']; ?>" alt="Haircut">
					<h4 class="barbershop-services__title">Haircut</h4>
					<p class="barbershop-services__description">Our experienced barbers will give you the perfect haircut that suits your style and personality.</p>
				</div>
				<div class="barbershop-services__item--featured">
					<img class="barbershop-services__icon" src="<?php echo $services_icons['trim']; ?>" alt="Beard Trim">
					<h4 class="barbershop-services__title">Beard Trim</h4>
					<p class="barbershop-services__description">Get your beard trimmed by our skilled barbers who will give you the perfect look.</p>
				</div>
				<div class="barbershop-services__item">
					<img class="barbershop-services__icon" src="<?php echo $services_icons['treatment']; ?>" alt="Treatment">
					<h4 class="barbershop-services__title"><?php esc_html_e( 'Treatment', '10up-theme' ); ?></h4>
					<p class="barbershop-services__description"><?php esc_html_e( 'Our hair treatment will leave your hair feeling soft, smooth, and healthy.', '10up-theme' ); ?></p>
				</div>
				<div class="barbershop-services__item">
					<img class="barbershop-services__icon" src="<?php echo $services_icons['wash']; ?>" alt="Wash">
					<h4 class="barbershop-services__title"><?php esc_html_e( 'Wash', '10up-theme' ); ?></h4>
					<p class="barbershop-services__description"><?php esc_html_e( 'Our hair wash will leave your hair feeling clean and refreshed.', '10up-theme' ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>
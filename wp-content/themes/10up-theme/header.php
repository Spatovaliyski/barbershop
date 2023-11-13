<?php
/**
 * The template for displaying the header.
 *
 * @package TenUpTheme
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>

		<header id="masthead" class="site-header">
			<div class="site-header__inner">
				<div class="site-branding">
					<p class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</p>
					<?php if ( get_bloginfo( 'description' ) ) : ?>
						<p class="site-description"><?php bloginfo( 'description' ); ?></p>
					<?php endif; ?>
				</div>

				<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'tenup-theme' ); ?>">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<span class="menu-toggle__text"><?php esc_html_e( 'Menu', 'tenup-theme' ); ?></span>
						<span class="menu-toggle__icon" aria-hidden="true">
							<span class="line"></span>
							<span class="line"></span>
							<span class="line"></span>
						</span>
					</button>
					<?php
					wp_nav_menu( array(
						'container' => 'div',
						'container_class' => 'menu-container',
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'menu',
						'fallback_cb'    => false,
					) );
					?>
				</nav>

				<aside class="navigation-appointments">
					<nav id="secondary-navigation" class="secondary-navigation" aria-label="<?php esc_attr_e( 'Secondary Menu', 'tenup-theme' ); ?>">
						<?php
						wp_nav_menu( array(
							'container' => 'div',
							'container_class' => 'menu-container',
							'theme_location' => 'secondary',
							'menu_id'        => 'secondary-menu',
							'menu_class'     => 'menu',
							'fallback_cb'    => false,
						) );
						?>
					</nav>
				</aside><!-- .navigation-appointments -->
			</div>
			</header>

			<a href="#main" class="skip-to-content-link visually-hidden-focusable"><?php esc_html_e( 'Skip to main content', 'tenup-theme' ); ?></a>

			<main id="main" role="main" tabindex="-1">
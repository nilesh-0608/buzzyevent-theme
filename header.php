<?php
/**
 * Document head and site header.
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'buzzyevent' ); ?></a>

<header class="site-header">
	<div class="be-shell site-header__inner">
		<div class="site-branding">
			<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php endif; ?>

			<p class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				</a>
			</p>
		</div>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav">
			<span class="nav-toggle__bars" aria-hidden="true"></span>
			<span><?php esc_html_e( 'Menu', 'buzzyevent' ); ?></span>
		</button>

		<nav id="primary-nav" class="primary-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'buzzyevent' ); ?>">
			<?php buzzyevent_primary_nav(); ?>
		</nav>
	</div>
</header>

<main id="content" class="be-main">

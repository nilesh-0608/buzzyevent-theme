<?php
/**
 * 404 — nothing found at this URL.
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="be-shell">
	<section class="be-404">
		<p class="be-eyebrow"><?php esc_html_e( 'Dead end', 'buzzyevent' ); ?></p>

		<p class="be-404__code" aria-hidden="true">404</p>

		<h1><?php esc_html_e( 'This page does not exist', 'buzzyevent' ); ?></h1>

		<p><?php esc_html_e( 'The link may be out of date, or the page may have moved. Try a search, or start again from the homepage.', 'buzzyevent' ); ?></p>

		<?php get_search_form(); ?>

		<p class="be-404__actions">
			<a class="be-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Back to the homepage', 'buzzyevent' ); ?>
			</a>
		</p>
	</section>
</div>

<?php
get_footer();

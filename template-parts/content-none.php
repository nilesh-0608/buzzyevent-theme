<?php
/**
 * Shown when a listing or search returns no posts.
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;
?>
	<section class="be-none">
		<p class="be-eyebrow"><?php esc_html_e( 'Nothing here', 'buzzyevent' ); ?></p>

		<h2><?php esc_html_e( 'No posts found', 'buzzyevent' ); ?></h2>

		<?php if ( is_search() ) : ?>
			<p><?php esc_html_e( 'That search came back empty. Try a different word or a broader term.', 'buzzyevent' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'There is nothing published in this part of the site yet.', 'buzzyevent' ); ?></p>
			<p>
				<a class="be-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php esc_html_e( 'Back to the homepage', 'buzzyevent' ); ?>
				</a>
			</p>
		<?php endif; ?>
	</section>

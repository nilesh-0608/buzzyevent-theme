<?php
/**
 * One post card, used inside .be-grid listings.
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;

$buzzyevent_excerpt = buzzyevent_card_excerpt();
?>
<li>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'be-card' ); ?>>
		<?php buzzyevent_card_media(); ?>

		<?php
		the_title(
			'<h2 class="be-card__title"><a href="' . esc_url( get_permalink() ) . '">',
			'</a></h2>'
		);
		?>

		<?php if ( '' !== $buzzyevent_excerpt ) : ?>
			<p class="be-card__excerpt"><?php echo esc_html( $buzzyevent_excerpt ); ?></p>
		<?php endif; ?>

		<footer class="be-card__footer">
			<?php buzzyevent_entry_meta(); ?>

			<a class="be-readmore" href="<?php echo esc_url( get_permalink() ); ?>">
				<?php esc_html_e( 'Read article', 'buzzyevent' ); ?>
				<span class="screen-reader-text">
					<?php
					printf(
						/* translators: %s: post title. */
						esc_html__( ': %s', 'buzzyevent' ),
						esc_html( wp_strip_all_tags( get_the_title() ) )
					);
					?>
				</span>
			</a>
		</footer>
	</article>
</li>

<?php
/**
 * Site footer and document close.
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;
?>
</main><!-- #content -->

<footer class="site-footer">
	<div class="be-shell site-footer__inner">
		<p>
			<?php
			printf(
				/* translators: 1: current year, 2: site name. */
				esc_html__( '&copy; %1$s %2$s', 'buzzyevent' ),
				esc_html( gmdate( 'Y' ) ),
				esc_html( get_bloginfo( 'name' ) )
			);
			?>
		</p>

		<p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'buzzyevent' ); ?></a>
			<span aria-hidden="true"> &middot; </span>
			<a href="<?php echo esc_url( get_feed_link() ); ?>"><?php esc_html_e( 'RSS feed', 'buzzyevent' ); ?></a>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

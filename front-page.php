<?php
/**
 * Front page: hero plus the latest posts grid.
 *
 * Works whether the front page is "your latest posts" (main query) or a
 * static page (secondary query, paginated through the `page` query var).
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;

get_header();

list( $buzzyevent_line_one, $buzzyevent_line_two ) = buzzyevent_hero_lines();

$buzzyevent_tagline = trim( wp_strip_all_tags( get_bloginfo( 'description' ) ) );
?>

<section class="be-hero">
	<div class="be-shell be-hero__inner">
		<p class="be-eyebrow"><?php esc_html_e( 'Notes on building for the web', 'buzzyevent' ); ?></p>

		<h1 class="be-hero__title">
			<span class="be-hero__line"><?php echo esc_html( $buzzyevent_line_one ); ?></span>
			<?php if ( '' !== $buzzyevent_line_two ) : ?>
				<span class="be-hero__line be-accent"><?php echo esc_html( $buzzyevent_line_two ); ?></span>
			<?php endif; ?>
		</h1>

		<?php if ( '' !== $buzzyevent_tagline ) : ?>
			<p class="be-hero__text"><?php echo esc_html( $buzzyevent_tagline ); ?></p>
		<?php endif; ?>

		<div class="be-hero__actions">
			<a class="be-btn" href="#latest"><?php esc_html_e( 'Read the latest', 'buzzyevent' ); ?></a>
			<a class="be-btn be-btn--ghost" href="<?php echo esc_url( get_feed_link() ); ?>">
				<?php esc_html_e( 'Subscribe by RSS', 'buzzyevent' ); ?>
			</a>
		</div>
	</div>
</section>

<section id="latest" class="be-section">
	<div class="be-shell">
		<div class="be-section__head">
			<p class="be-eyebrow"><?php esc_html_e( 'Articles', 'buzzyevent' ); ?></p>
			<h2 class="be-section__title">
				<?php esc_html_e( 'Everything published', 'buzzyevent' ); ?>
				<span class="be-accent"><?php esc_html_e( 'so far', 'buzzyevent' ); ?></span>
			</h2>
		</div>

		<?php
		if ( is_home() ) :
			// The front page IS the posts page: use the main query.
			if ( have_posts() ) :
				echo '<ul class="be-grid">';

				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content' );
				endwhile;

				echo '</ul>';

				the_posts_pagination(
					array(
						'class'              => 'be-pagination',
						'mid_size'           => 1,
						'prev_text'          => esc_html__( 'Previous', 'buzzyevent' ),
						'next_text'          => esc_html__( 'Next', 'buzzyevent' ),
						'screen_reader_text' => esc_html__( 'Posts navigation', 'buzzyevent' ),
					)
				);
			else :
				get_template_part( 'template-parts/content-none' );
			endif;

		else :
			// Static front page: run a secondary query for the post list.
			$buzzyevent_paged = (int) get_query_var( 'page' );

			if ( $buzzyevent_paged < 1 ) {
				$buzzyevent_paged = (int) get_query_var( 'paged' );
			}

			if ( $buzzyevent_paged < 1 ) {
				$buzzyevent_paged = 1;
			}

			$buzzyevent_query = new WP_Query(
				array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'posts_per_page'      => 9,
					'paged'               => $buzzyevent_paged,
					'ignore_sticky_posts' => true,
				)
			);

			if ( $buzzyevent_query->have_posts() ) :
				echo '<ul class="be-grid">';

				while ( $buzzyevent_query->have_posts() ) :
					$buzzyevent_query->the_post();
					get_template_part( 'template-parts/content' );
				endwhile;

				echo '</ul>';

				if ( $buzzyevent_query->max_num_pages > 1 ) {
					if ( get_option( 'permalink_structure' ) ) {
						$buzzyevent_base = user_trailingslashit( trailingslashit( home_url( '/' ) ) . 'page/%#%', 'paged' );
					} else {
						$buzzyevent_base = add_query_arg( 'page', '%#%', home_url( '/' ) );
					}

					$buzzyevent_links = paginate_links(
						array(
							'base'      => esc_url_raw( $buzzyevent_base ),
							'format'    => '',
							'current'   => $buzzyevent_paged,
							'total'     => (int) $buzzyevent_query->max_num_pages,
							'mid_size'  => 1,
							'prev_text' => esc_html__( 'Previous', 'buzzyevent' ),
							'next_text' => esc_html__( 'Next', 'buzzyevent' ),
							'type'      => 'plain',
						)
					);

					if ( ! empty( $buzzyevent_links ) ) {
						echo '<nav class="be-pagination" aria-label="' . esc_attr__( 'Posts navigation', 'buzzyevent' ) . '">';
						echo '<div class="nav-links">' . wp_kses_post( $buzzyevent_links ) . '</div>';
						echo '</nav>';
					}
				}

				wp_reset_postdata();
			else :
				wp_reset_postdata();
				get_template_part( 'template-parts/content-none' );
			endif;
		endif;
		?>
	</div>
</section>

<?php
get_footer();

<?php
/**
 * Search results.
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="be-page-head">
	<div class="be-shell">
		<p class="be-eyebrow"><?php esc_html_e( 'Search', 'buzzyevent' ); ?></p>

		<h1 class="be-page-head__title">
			<?php
			printf(
				/* translators: %s: search query. */
				esc_html__( 'Results for %s', 'buzzyevent' ),
				'<span class="be-accent">' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>

		<div class="be-page-head__desc">
			<?php get_search_form(); ?>
		</div>
	</div>
</div>

<section class="be-section">
	<div class="be-shell">
		<?php if ( have_posts() ) : ?>
			<ul class="be-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content' );
				endwhile;
				?>
			</ul>

			<?php
			the_posts_pagination(
				array(
					'class'              => 'be-pagination',
					'mid_size'           => 1,
					'prev_text'          => esc_html__( 'Previous', 'buzzyevent' ),
					'next_text'          => esc_html__( 'Next', 'buzzyevent' ),
					'screen_reader_text' => esc_html__( 'Search results navigation', 'buzzyevent' ),
				)
			);
			?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content-none' ); ?>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();

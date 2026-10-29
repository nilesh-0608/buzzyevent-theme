<?php
/**
 * Fallback template: blog index and anything without a more specific template.
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="be-page-head">
	<div class="be-shell">
		<p class="be-eyebrow"><?php esc_html_e( 'The blog', 'buzzyevent' ); ?></p>
		<h1 class="be-page-head__title">
			<?php
			if ( is_home() && ! is_front_page() && get_option( 'page_for_posts' ) ) {
				echo esc_html( get_the_title( (int) get_option( 'page_for_posts' ) ) );
			} else {
				esc_html_e( 'Latest articles', 'buzzyevent' );
			}
			?>
		</h1>
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
					'screen_reader_text' => esc_html__( 'Posts navigation', 'buzzyevent' ),
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

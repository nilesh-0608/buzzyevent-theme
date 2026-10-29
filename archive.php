<?php
/**
 * Archive template: categories, tags, authors and date archives.
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;

get_header();

$buzzyevent_description = get_the_archive_description();
?>

<div class="be-page-head">
	<div class="be-shell">
		<p class="be-eyebrow"><?php esc_html_e( 'Archive', 'buzzyevent' ); ?></p>

		<h1 class="be-page-head__title">
			<?php echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ); ?>
		</h1>

		<?php if ( ! empty( $buzzyevent_description ) ) : ?>
			<div class="be-page-head__desc"><?php echo wp_kses_post( $buzzyevent_description ); ?></div>
		<?php endif; ?>
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
					'screen_reader_text' => esc_html__( 'Archive navigation', 'buzzyevent' ),
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

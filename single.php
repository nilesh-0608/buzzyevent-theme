<?php
/**
 * Single post.
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'be-article' ); ?>>
		<div class="be-shell">
			<header class="be-article__header">
				<p class="be-eyebrow"><?php esc_html_e( 'Article', 'buzzyevent' ); ?></p>

				<?php the_title( '<h1 class="be-article__title">', '</h1>' ); ?>

				<?php buzzyevent_entry_meta(); ?>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="be-article__thumb">
					<?php the_post_thumbnail( 'large', array( 'loading' => 'eager' ) ); ?>
				</figure>
			<?php endif; ?>

			<div class="entry-content">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<nav class="be-pagination" aria-label="' . esc_attr__( 'Page navigation', 'buzzyevent' ) . '"><div class="nav-links">',
						'after'  => '</div></nav>',
					)
				);
				?>
			</div>

			<?php
			$buzzyevent_tags = get_the_tag_list( '', '', '' );

			if ( ! is_wp_error( $buzzyevent_tags ) && ! empty( $buzzyevent_tags ) ) :
				?>
				<footer class="be-article__footer">
					<p class="be-eyebrow"><?php esc_html_e( 'Tagged', 'buzzyevent' ); ?></p>
					<p class="be-pills"><?php echo wp_kses_post( $buzzyevent_tags ); ?></p>
				</footer>
			<?php endif; ?>

			<?php
			the_post_navigation(
				array(
					'class'              => 'be-postnav',
					'prev_text'          => '%title',
					'next_text'          => '%title',
					'screen_reader_text' => esc_html__( 'Continue reading', 'buzzyevent' ),
				)
			);
			?>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</article>
	<?php
endwhile;

get_footer();

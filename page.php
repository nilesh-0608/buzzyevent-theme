<?php
/**
 * Static page.
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
				<?php the_title( '<h1 class="be-article__title">', '</h1>' ); ?>
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
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</article>
	<?php
endwhile;

get_footer();

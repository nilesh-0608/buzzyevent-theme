<?php
/**
 * Comments area.
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;

// Bail if the post is password protected and the visitor has not unlocked it.
if ( post_password_required() ) {
	return;
}

$buzzyevent_count = (int) get_comments_number();
?>

<section id="comments" class="be-comments">
	<?php if ( $buzzyevent_count > 0 ) : ?>
		<h2 class="be-comments__title">
			<?php
			printf(
				/* translators: %s: comment count. */
				esc_html( _n( '%s comment', '%s comments', $buzzyevent_count, 'buzzyevent' ) ),
				esc_html( number_format_i18n( $buzzyevent_count ) )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => esc_html__( 'Older comments', 'buzzyevent' ),
				'next_text' => esc_html__( 'Newer comments', 'buzzyevent' ),
			)
		);
		?>
	<?php endif; ?>

	<?php if ( ! comments_open() && $buzzyevent_count > 0 ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'buzzyevent' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'        => esc_html__( 'Leave a comment', 'buzzyevent' ),
			'title_reply_to'     => esc_html__( 'Reply to %s', 'buzzyevent' ),
			'class_submit'       => 'be-btn',
			'comment_notes_after' => '',
		)
	);
	?>
</section>

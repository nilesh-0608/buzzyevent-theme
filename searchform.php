<?php
/**
 * Search form.
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;

$buzzyevent_search_id = 'be-search-' . wp_unique_id();
?>
<form class="be-searchform" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $buzzyevent_search_id ); ?>">
		<?php esc_html_e( 'Search for:', 'buzzyevent' ); ?>
	</label>

	<input
		class="be-searchform__field"
		id="<?php echo esc_attr( $buzzyevent_search_id ); ?>"
		type="search"
		name="s"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		placeholder="<?php esc_attr_e( 'Search articles&hellip;', 'buzzyevent' ); ?>"
	>

	<button class="be-btn" type="submit"><?php esc_html_e( 'Search', 'buzzyevent' ); ?></button>
</form>

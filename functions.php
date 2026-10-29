<?php
/**
 * Buzzy Event theme setup, assets and head cleanup.
 *
 * @package BuzzyEvent
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'BUZZYEVENT_VERSION' ) ) {
	define( 'BUZZYEVENT_VERSION', '1.0.0' );
}

/**
 * Theme supports, menus and content width.
 */
function buzzyevent_setup() {
	load_theme_textdomain( 'buzzyevent', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 320,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'buzzyevent' ),
		)
	);

	if ( ! isset( $GLOBALS['content_width'] ) ) {
		$GLOBALS['content_width'] = 720;
	}
}
add_action( 'after_setup_theme', 'buzzyevent_setup' );

/**
 * Front-end styles and the one small nav script.
 */
function buzzyevent_enqueue_assets() {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	// Google Fonts: Manrope for headings, DM Sans for body copy.
	wp_enqueue_style(
		'buzzyevent-fonts',
		'https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&family=Manrope:wght@500;600;700;800&display=swap',
		array(),
		null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- External font API.
	);

	$style_path    = $dir . '/style.css';
	$style_version = file_exists( $style_path ) ? (string) filemtime( $style_path ) : BUZZYEVENT_VERSION;

	wp_enqueue_style(
		'buzzyevent-style',
		$uri . '/style.css',
		array( 'buzzyevent-fonts' ),
		$style_version
	);

	$script_path = $dir . '/assets/js/navigation.js';

	if ( file_exists( $script_path ) ) {
		wp_enqueue_script(
			'buzzyevent-navigation',
			$uri . '/assets/js/navigation.js',
			array(),
			(string) filemtime( $script_path ),
			true
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'buzzyevent_enqueue_assets' );

/**
 * Preconnect to the Google Fonts hosts; drop the emoji CDN hint.
 *
 * @param array  $hints         URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
 */
function buzzyevent_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
		$hints[] = 'https://fonts.googleapis.com';
	}

	if ( 'dns-prefetch' === $relation_type ) {
		foreach ( $hints as $key => $hint ) {
			$url = is_array( $hint ) && isset( $hint['href'] ) ? $hint['href'] : $hint;

			if ( is_string( $url ) && false !== strpos( $url, 's.w.org' ) ) {
				unset( $hints[ $key ] );
			}
		}

		$hints = array_values( $hints );
	}

	return $hints;
}
add_filter( 'wp_resource_hints', 'buzzyevent_resource_hints', 10, 2 );

/**
 * Trim unused core head output. Block library CSS is deliberately kept.
 */
function buzzyevent_clean_head() {
	// Emoji support.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	// Legacy / fingerprinting head tags.
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );

	// oEmbed discovery + host JS only. The REST route and responsive embeds stay.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
}
add_action( 'init', 'buzzyevent_clean_head' );

/**
 * Keep the emoji SVG CDN out of the page entirely.
 *
 * @return bool
 */
function buzzyevent_disable_emoji_svg() {
	return false;
}
add_filter( 'emoji_svg_url', 'buzzyevent_disable_emoji_svg' );

/**
 * Menu fallback used when no 'primary' menu has been assigned yet.
 */
function buzzyevent_menu_fallback() {
	$pages = wp_list_pages(
		array(
			'title_li' => '',
			'depth'    => 1,
			'echo'     => false,
		)
	);

	if ( empty( $pages ) ) {
		return;
	}

	echo '<ul class="nav-list">' . wp_kses_post( $pages ) . '</ul>';
}

/**
 * Render the primary navigation, with the page-list fallback.
 */
function buzzyevent_primary_nav() {
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'menu_id'        => 'primary-menu',
			'menu_class'     => 'nav-list',
			'container'      => '',
			'depth'          => 1,
			'fallback_cb'    => 'buzzyevent_menu_fallback',
		)
	);
}

/**
 * Entry meta: date plus category pills. Safe when a post has no categories.
 */
function buzzyevent_entry_meta() {
	printf(
		'<p class="be-meta"><time datetime="%1$s">%2$s</time>%3$s</p>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		'<span>' . esc_html( get_the_author() ) . '</span>'
	);

	if ( 'post' !== get_post_type() ) {
		return;
	}

	$categories = get_the_category();

	if ( empty( $categories ) ) {
		return;
	}

	echo '<p class="be-pills">';

	foreach ( $categories as $category ) {
		printf(
			'<a href="%1$s">%2$s</a>',
			esc_url( get_category_link( $category->term_id ) ),
			esc_html( $category->name )
		);
	}

	echo '</p>';
}

/**
 * A short, always-present summary for a post card.
 *
 * @param int $words Word cap for the generated summary.
 * @return string
 */
function buzzyevent_card_excerpt( $words = 28 ) {
	if ( has_excerpt() ) {
		$text = get_the_excerpt();
	} else {
		$text = wp_strip_all_tags( strip_shortcodes( get_the_content() ) );
	}

	$text = trim( preg_replace( '/\s+/', ' ', (string) $text ) );

	if ( '' === $text ) {
		return '';
	}

	return wp_trim_words( $text, (int) $words, '&hellip;' );
}

/**
 * Featured image for a card, or a lettered placeholder panel.
 */
function buzzyevent_card_media() {
	$permalink = get_permalink();

	if ( has_post_thumbnail() ) {
		printf( '<a class="be-card__media" href="%s" aria-hidden="true" tabindex="-1">', esc_url( $permalink ) );
		the_post_thumbnail(
			'large',
			array(
				'loading' => 'lazy',
				'alt'     => '',
			)
		);
		echo '</a>';

		return;
	}

	$title   = wp_strip_all_tags( get_the_title() );
	if ( '' === $title ) {
		$initial = '#';
	} elseif ( function_exists( 'mb_substr' ) ) {
		$initial = mb_substr( $title, 0, 1 );
	} else {
		$initial = substr( $title, 0, 1 );
	}

	printf(
		'<span class="be-card__media be-card__media--empty" aria-hidden="true">%s</span>',
		esc_html( $initial )
	);
}

/**
 * Two-line hero heading built from the site name, line two accent coloured.
 *
 * @return array{0:string,1:string} First and second line (second may be empty).
 */
function buzzyevent_hero_lines() {
	$name = trim( wp_strip_all_tags( get_bloginfo( 'name' ) ) );

	if ( '' === $name ) {
		return array( '', '' );
	}

	$split = strrpos( $name, ' ' );

	if ( false === $split ) {
		return array( $name, '' );
	}

	return array( substr( $name, 0, $split ), substr( $name, $split + 1 ) );
}

/**
 * Add a body class so templates can be targeted predictably.
 *
 * @param array $classes Body classes.
 * @return array
 */
function buzzyevent_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'be-listing';
	}

	return $classes;
}
add_filter( 'body_class', 'buzzyevent_body_classes' );

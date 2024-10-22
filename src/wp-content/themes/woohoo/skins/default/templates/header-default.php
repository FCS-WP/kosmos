<?php
/**
 * The template to display default site header
 *
 * @package WOOHOO
 * @since WOOHOO 1.0
 */

$woohoo_header_css   = '';
$woohoo_header_image = get_header_image();
$woohoo_header_video = woohoo_get_header_video();
if ( ! empty( $woohoo_header_image ) && woohoo_trx_addons_featured_image_override( is_singular() || woohoo_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$woohoo_header_image = woohoo_get_current_mode_image( $woohoo_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $woohoo_header_image ) || ! empty( $woohoo_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $woohoo_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $woohoo_header_image ) {
		echo ' ' . esc_attr( woohoo_add_inline_css_class( 'background-image: url(' . esc_url( $woohoo_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( woohoo_is_on( woohoo_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight woohoo-full-height';
	}
	$woohoo_header_scheme = woohoo_get_theme_option( 'header_scheme' );
	if ( ! empty( $woohoo_header_scheme ) && ! woohoo_is_inherit( $woohoo_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $woohoo_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $woohoo_header_video ) ) {
		get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( woohoo_is_on( woohoo_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>

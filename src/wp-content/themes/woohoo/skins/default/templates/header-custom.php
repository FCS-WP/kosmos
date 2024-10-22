<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WOOHOO
 * @since WOOHOO 1.0.06
 */

$woohoo_header_css   = '';
$woohoo_header_image = get_header_image();
$woohoo_header_video = woohoo_get_header_video();
if ( ! empty( $woohoo_header_image ) && woohoo_trx_addons_featured_image_override( is_singular() || woohoo_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$woohoo_header_image = woohoo_get_current_mode_image( $woohoo_header_image );
}

$woohoo_header_id = woohoo_get_custom_header_id();
$woohoo_header_meta = get_post_meta( $woohoo_header_id, 'trx_addons_options', true );
if ( ! empty( $woohoo_header_meta['margin'] ) ) {
	woohoo_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( woohoo_prepare_css_value( $woohoo_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $woohoo_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $woohoo_header_id ) ) ); ?>
				<?php
				echo ! empty( $woohoo_header_image ) || ! empty( $woohoo_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
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

	// Custom header's layout
	do_action( 'woohoo_action_show_layout', $woohoo_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>

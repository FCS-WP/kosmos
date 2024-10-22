<?php
/**
 * The Header: Logo and main menu
 *
 * @package WOOHOO
 * @since WOOHOO 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( woohoo_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'woohoo_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'woohoo_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('woohoo_action_body_wrap_attributes'); ?>>

		<?php do_action( 'woohoo_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'woohoo_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('woohoo_action_page_wrap_attributes'); ?>>

			<?php do_action( 'woohoo_action_page_wrap_start' ); ?>

			<?php
			$woohoo_full_post_loading = ( woohoo_is_singular( 'post' ) || woohoo_is_singular( 'attachment' ) ) && woohoo_get_value_gp( 'action' ) == 'full_post_loading';
			$woohoo_prev_post_loading = ( woohoo_is_singular( 'post' ) || woohoo_is_singular( 'attachment' ) ) && woohoo_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $woohoo_full_post_loading && ! $woohoo_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="woohoo_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'woohoo_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'woohoo' ); ?></a>
				<?php if ( woohoo_sidebar_present() ) { ?>
				<a class="woohoo_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'woohoo_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'woohoo' ); ?></a>
				<?php } ?>
				<a class="woohoo_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'woohoo_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'woohoo' ); ?></a>

				<?php
				do_action( 'woohoo_action_before_header' );

				// Header
				$woohoo_header_type = woohoo_get_theme_option( 'header_type' );
				if ( 'custom' == $woohoo_header_type && ! woohoo_is_layouts_available() ) {
					$woohoo_header_type = 'default';
				}
				get_template_part( apply_filters( 'woohoo_filter_get_template_part', "templates/header-" . sanitize_file_name( $woohoo_header_type ) ) );

				// Side menu
				if ( in_array( woohoo_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'woohoo_action_after_header' );

			}
			?>

			<?php do_action( 'woohoo_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( woohoo_is_off( woohoo_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $woohoo_header_type ) ) {
						$woohoo_header_type = woohoo_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $woohoo_header_type && woohoo_is_layouts_available() ) {
						$woohoo_header_id = woohoo_get_custom_header_id();
						if ( $woohoo_header_id > 0 ) {
							$woohoo_header_meta = woohoo_get_custom_layout_meta( $woohoo_header_id );
							if ( ! empty( $woohoo_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$woohoo_footer_type = woohoo_get_theme_option( 'footer_type' );
					if ( 'custom' == $woohoo_footer_type && woohoo_is_layouts_available() ) {
						$woohoo_footer_id = woohoo_get_custom_footer_id();
						if ( $woohoo_footer_id ) {
							$woohoo_footer_meta = woohoo_get_custom_layout_meta( $woohoo_footer_id );
							if ( ! empty( $woohoo_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'woohoo_action_page_content_wrap_class', $woohoo_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'woohoo_filter_is_prev_post_loading', $woohoo_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( woohoo_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'woohoo_action_page_content_wrap_data', $woohoo_prev_post_loading );
			?>>
				<?php
				do_action( 'woohoo_action_page_content_wrap', $woohoo_full_post_loading || $woohoo_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'woohoo_filter_single_post_header', woohoo_is_singular( 'post' ) || woohoo_is_singular( 'attachment' ) ) ) {
					if ( $woohoo_prev_post_loading ) {
						if ( woohoo_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'woohoo_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$woohoo_path = apply_filters( 'woohoo_filter_get_template_part', 'templates/single-styles/' . woohoo_get_theme_option( 'single_style' ) );
					if ( woohoo_get_file_dir( $woohoo_path . '.php' ) != '' ) {
						get_template_part( $woohoo_path );
					}
				}

				// Widgets area above page
				$woohoo_body_style   = woohoo_get_theme_option( 'body_style' );
				$woohoo_widgets_name = woohoo_get_theme_option( 'widgets_above_page' );
				$woohoo_show_widgets = ! woohoo_is_off( $woohoo_widgets_name ) && is_active_sidebar( $woohoo_widgets_name );
				if ( $woohoo_show_widgets ) {
					if ( 'fullscreen' != $woohoo_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					woohoo_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $woohoo_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'woohoo_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $woohoo_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'woohoo_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'woohoo_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="woohoo_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( woohoo_is_singular( 'post' ) || woohoo_is_singular( 'attachment' ) )
							&& $woohoo_prev_post_loading 
							&& woohoo_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'woohoo_action_between_posts' );
						}

						// Widgets area above content
						woohoo_create_widgets_area( 'widgets_above_content' );

						do_action( 'woohoo_action_page_content_start_text' );

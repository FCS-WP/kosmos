<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WOOHOO
 * @since WOOHOO 1.0
 */

if ( woohoo_sidebar_present() ) {
	
	$woohoo_sidebar_type = woohoo_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $woohoo_sidebar_type && ! woohoo_is_layouts_available() ) {
		$woohoo_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $woohoo_sidebar_type ) {
		// Default sidebar with widgets
		$woohoo_sidebar_name = woohoo_get_theme_option( 'sidebar_widgets' );
		woohoo_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $woohoo_sidebar_name ) ) {
			dynamic_sidebar( $woohoo_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$woohoo_sidebar_id = woohoo_get_custom_sidebar_id();
		do_action( 'woohoo_action_show_layout', $woohoo_sidebar_id );
	}
	$woohoo_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $woohoo_out ) ) {
		$woohoo_sidebar_position    = woohoo_get_theme_option( 'sidebar_position' );
		$woohoo_sidebar_position_ss = woohoo_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $woohoo_sidebar_position );
			echo ' sidebar_' . esc_attr( $woohoo_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $woohoo_sidebar_type );

			$woohoo_sidebar_scheme = apply_filters( 'woohoo_filter_sidebar_scheme', woohoo_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $woohoo_sidebar_scheme ) && ! woohoo_is_inherit( $woohoo_sidebar_scheme ) && 'custom' != $woohoo_sidebar_type ) {
				echo ' scheme_' . esc_attr( $woohoo_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="woohoo_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'woohoo_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $woohoo_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$woohoo_title = apply_filters( 'woohoo_filter_sidebar_control_title', 'float' == $woohoo_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'woohoo' ) : '' );
				$woohoo_text  = apply_filters( 'woohoo_filter_sidebar_control_text', 'above' == $woohoo_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'woohoo' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $woohoo_title ); ?>"><?php echo esc_html( $woohoo_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'woohoo_action_before_sidebar', 'sidebar' );
				woohoo_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $woohoo_out ) );
				do_action( 'woohoo_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'woohoo_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}

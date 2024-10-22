<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WOOHOO
 * @since WOOHOO 1.0
 */

// Header sidebar
$woohoo_header_name    = woohoo_get_theme_option( 'header_widgets' );
$woohoo_header_present = ! woohoo_is_off( $woohoo_header_name ) && is_active_sidebar( $woohoo_header_name );
if ( $woohoo_header_present ) {
	woohoo_storage_set( 'current_sidebar', 'header' );
	$woohoo_header_wide = woohoo_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $woohoo_header_name ) ) {
		dynamic_sidebar( $woohoo_header_name );
	}
	$woohoo_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $woohoo_widgets_output ) ) {
		$woohoo_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $woohoo_widgets_output );
		$woohoo_need_columns   = strpos( $woohoo_widgets_output, 'columns_wrap' ) === false;
		if ( $woohoo_need_columns ) {
			$woohoo_columns = max( 0, (int) woohoo_get_theme_option( 'header_columns' ) );
			if ( 0 == $woohoo_columns ) {
				$woohoo_columns = min( 6, max( 1, woohoo_tags_count( $woohoo_widgets_output, 'aside' ) ) );
			}
			if ( $woohoo_columns > 1 ) {
				$woohoo_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $woohoo_columns ) . ' widget', $woohoo_widgets_output );
			} else {
				$woohoo_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $woohoo_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'woohoo_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $woohoo_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $woohoo_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'woohoo_action_before_sidebar', 'header' );
				woohoo_show_layout( $woohoo_widgets_output );
				do_action( 'woohoo_action_after_sidebar', 'header' );
				if ( $woohoo_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $woohoo_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'woohoo_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}

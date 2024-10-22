<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WOOHOO
 * @since WOOHOO 1.0.10
 */

// Footer sidebar
$woohoo_footer_name    = woohoo_get_theme_option( 'footer_widgets' );
$woohoo_footer_present = ! woohoo_is_off( $woohoo_footer_name ) && is_active_sidebar( $woohoo_footer_name );
if ( $woohoo_footer_present ) {
	woohoo_storage_set( 'current_sidebar', 'footer' );
	$woohoo_footer_wide = woohoo_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $woohoo_footer_name ) ) {
		dynamic_sidebar( $woohoo_footer_name );
	}
	$woohoo_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $woohoo_out ) ) {
		$woohoo_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $woohoo_out );
		$woohoo_need_columns = true;   //or check: strpos($woohoo_out, 'columns_wrap')===false;
		if ( $woohoo_need_columns ) {
			$woohoo_columns = max( 0, (int) woohoo_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $woohoo_columns ) {
				$woohoo_columns = min( 4, max( 1, woohoo_tags_count( $woohoo_out, 'aside' ) ) );
			}
			if ( $woohoo_columns > 1 ) {
				$woohoo_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $woohoo_columns ) . ' widget', $woohoo_out );
			} else {
				$woohoo_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $woohoo_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'woohoo_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $woohoo_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $woohoo_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'woohoo_action_before_sidebar', 'footer' );
				woohoo_show_layout( $woohoo_out );
				do_action( 'woohoo_action_after_sidebar', 'footer' );
				if ( $woohoo_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $woohoo_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'woohoo_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}

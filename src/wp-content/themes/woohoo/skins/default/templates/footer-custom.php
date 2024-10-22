<?php
/**
 * The template to display default site footer
 *
 * @package WOOHOO
 * @since WOOHOO 1.0.10
 */

$woohoo_footer_id = woohoo_get_custom_footer_id();
$woohoo_footer_meta = get_post_meta( $woohoo_footer_id, 'trx_addons_options', true );
if ( ! empty( $woohoo_footer_meta['margin'] ) ) {
	woohoo_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( woohoo_prepare_css_value( $woohoo_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $woohoo_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $woohoo_footer_id ) ) ); ?>
						<?php
						$woohoo_footer_scheme = woohoo_get_theme_option( 'footer_scheme' );
						if ( ! empty( $woohoo_footer_scheme ) && ! woohoo_is_inherit( $woohoo_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $woohoo_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'woohoo_action_show_layout', $woohoo_footer_id );
	?>
</footer><!-- /.footer_wrap -->

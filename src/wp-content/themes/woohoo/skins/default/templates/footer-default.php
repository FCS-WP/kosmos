<?php
/**
 * The template to display default site footer
 *
 * @package WOOHOO
 * @since WOOHOO 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$woohoo_footer_scheme = woohoo_get_theme_option( 'footer_scheme' );
if ( ! empty( $woohoo_footer_scheme ) && ! woohoo_is_inherit( $woohoo_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $woohoo_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->

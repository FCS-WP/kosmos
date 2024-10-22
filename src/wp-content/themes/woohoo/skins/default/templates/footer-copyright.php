<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WOOHOO
 * @since WOOHOO 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$woohoo_copyright_scheme = woohoo_get_theme_option( 'copyright_scheme' );
if ( ! empty( $woohoo_copyright_scheme ) && ! woohoo_is_inherit( $woohoo_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $woohoo_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$woohoo_copyright = woohoo_get_theme_option( 'copyright' );
			if ( ! empty( $woohoo_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$woohoo_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $woohoo_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$woohoo_copyright = woohoo_prepare_macros( $woohoo_copyright );
				// Display copyright
				echo wp_kses( nl2br( $woohoo_copyright ), 'woohoo_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>

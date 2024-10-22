<?php
/**
 * The template to display the socials in the footer
 *
 * @package WOOHOO
 * @since WOOHOO 1.0.10
 */


// Socials
if ( woohoo_is_on( woohoo_get_theme_option( 'socials_in_footer' ) ) ) {
	$woohoo_output = woohoo_get_socials_links();
	if ( '' != $woohoo_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php woohoo_show_layout( $woohoo_output ); ?>
			</div>
		</div>
		<?php
	}
}

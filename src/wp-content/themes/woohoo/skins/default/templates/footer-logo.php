<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WOOHOO
 * @since WOOHOO 1.0.10
 */

// Logo
if ( woohoo_is_on( woohoo_get_theme_option( 'logo_in_footer' ) ) ) {
	$woohoo_logo_image = woohoo_get_logo_image( 'footer' );
	$woohoo_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $woohoo_logo_image['logo'] ) || ! empty( $woohoo_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $woohoo_logo_image['logo'] ) ) {
					$woohoo_attr = woohoo_getimagesize( $woohoo_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $woohoo_logo_image['logo'] ) . '"'
								. ( ! empty( $woohoo_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $woohoo_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'woohoo' ) . '"'
								. ( ! empty( $woohoo_attr[3] ) ? ' ' . wp_kses_data( $woohoo_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $woohoo_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $woohoo_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}

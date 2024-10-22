<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WOOHOO
 * @since WOOHOO 1.0
 */

$woohoo_args = get_query_var( 'woohoo_logo_args' );

// Site logo
$woohoo_logo_type   = isset( $woohoo_args['type'] ) ? $woohoo_args['type'] : '';
$woohoo_logo_image  = woohoo_get_logo_image( $woohoo_logo_type );
$woohoo_logo_text   = woohoo_is_on( woohoo_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$woohoo_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $woohoo_logo_image['logo'] ) || ! empty( $woohoo_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $woohoo_logo_image['logo'] ) ) {
            if ( empty( $woohoo_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($woohoo_logo_image['logo']) && (int) $woohoo_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$woohoo_attr = woohoo_getimagesize( $woohoo_logo_image['logo'] );
				echo '<img src="' . esc_url( $woohoo_logo_image['logo'] ) . '"'
						. ( ! empty( $woohoo_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $woohoo_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $woohoo_logo_text ) . '"'
						. ( ! empty( $woohoo_attr[3] ) ? ' ' . wp_kses_data( $woohoo_attr[3] ) : '' )
						. '>';
			}
		} else {
			woohoo_show_layout( woohoo_prepare_macros( $woohoo_logo_text ), '<span class="logo_text">', '</span>' );
			woohoo_show_layout( woohoo_prepare_macros( $woohoo_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}

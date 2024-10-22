<?php
/**
 * The template to display Admin notices
 *
 * @package WOOHOO
 * @since WOOHOO 1.0.64
 */

$woohoo_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$woohoo_skins_args = get_query_var( 'woohoo_skins_notice_args' );
?>
<div class="woohoo_admin_notice woohoo_skins_notice notice notice-info is-dismissible" data-notice="skins">
	<?php
	// Theme image
	$woohoo_theme_img = woohoo_get_file_url( 'screenshot.jpg' );
	if ( '' != $woohoo_theme_img ) {
		?>
		<div class="woohoo_notice_image"><img src="<?php echo esc_url( $woohoo_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'woohoo' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="woohoo_notice_title">
		<?php esc_html_e( 'New skins available', 'woohoo' ); ?>
	</h3>
	<?php

	// Description
	$woohoo_total      = $woohoo_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$woohoo_skins_msg  = $woohoo_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $woohoo_total, 'woohoo' ), $woohoo_total ) . '</strong>'
							: '';
	$woohoo_total      = $woohoo_skins_args['free'];
	$woohoo_skins_msg .= $woohoo_total > 0
							? ( ! empty( $woohoo_skins_msg ) ? ' ' . esc_html__( 'and', 'woohoo' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $woohoo_total, 'woohoo' ), $woohoo_total ) . '</strong>'
							: '';
	$woohoo_total      = $woohoo_skins_args['pay'];
	$woohoo_skins_msg .= $woohoo_skins_args['pay'] > 0
							? ( ! empty( $woohoo_skins_msg ) ? ' ' . esc_html__( 'and', 'woohoo' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $woohoo_total, 'woohoo' ), $woohoo_total ) . '</strong>'
							: '';
	?>
	<div class="woohoo_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'woohoo' ), $woohoo_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="woohoo_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $woohoo_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'woohoo' );
			?>
		</a>
	</div>
</div>

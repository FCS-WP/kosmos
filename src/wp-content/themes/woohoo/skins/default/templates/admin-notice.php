<?php
/**
 * The template to display Admin notices
 *
 * @package WOOHOO
 * @since WOOHOO 1.0.1
 */

$woohoo_theme_slug = get_option( 'template' );
$woohoo_theme_obj  = wp_get_theme( $woohoo_theme_slug );
?>
<div class="woohoo_admin_notice woohoo_welcome_notice notice notice-info is-dismissible" data-notice="admin">
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
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'woohoo' ),
				$woohoo_theme_obj->get( 'Name' ) . ( WOOHOO_THEME_FREE ? ' ' . __( 'Free', 'woohoo' ) : '' ),
				$woohoo_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="woohoo_notice_text">
		<p class="woohoo_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $woohoo_theme_obj->description ) );
			?>
		</p>
		<p class="woohoo_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'woohoo' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="woohoo_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=woohoo_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'woohoo' );
			?>
		</a>
	</div>
</div>

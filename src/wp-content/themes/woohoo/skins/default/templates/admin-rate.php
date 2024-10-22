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
<div class="woohoo_admin_notice woohoo_rate_notice notice notice-info is-dismissible" data-notice="rate">
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
	<h3 class="woohoo_notice_title"><a href="<?php echo esc_url( woohoo_storage_get( 'theme_rate_url' ) ); ?>" target="_blank">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Rate our theme "%s", please', 'woohoo' ),
				$woohoo_theme_obj->get( 'Name' ) . ( WOOHOO_THEME_FREE ? ' ' . __( 'Free', 'woohoo' ) : '' )
			)
		);
		?>
	</a></h3>
	<?php

	// Description
	?>
	<div class="woohoo_notice_text">
		<p><?php echo wp_kses_data( __( "We are glad you chose our WP theme for your website. You've done well customizing your website and we hope that you've enjoyed working with our theme.", 'woohoo' ) ); ?></p>
		<p><?php echo wp_kses_data( __( "It would be just awesome if you spend just a minute of your time to rate our theme or the customer service you've received from us.", 'woohoo' ) ); ?></p>
		<p class="woohoo_notice_text_info"><?php echo wp_kses_data( __( '* We love receiving your reviews! Every time you leave a review, our CEO Henry Rise gives $5 to homeless dog shelter! Save the planet with us!', 'woohoo' ) ); ?></p>
	</div>
	<?php

	// Buttons
	?>
	<div class="woohoo_notice_buttons">
		<?php
		// Link to the theme download page
		?>
		<a href="<?php echo esc_url( woohoo_storage_get( 'theme_rate_url' ) ); ?>" class="button button-primary" target="_blank"><i class="dashicons dashicons-star-filled"></i> 
			<?php
			// Translators: Add theme name
			echo esc_html( sprintf( __( 'Rate theme %s', 'woohoo' ), $woohoo_theme_obj->name ) );
			?>
		</a>
		<?php
		// Link to the theme support
		?>
		<a href="<?php echo esc_url( woohoo_storage_get( 'theme_support_url' ) ); ?>" class="button" target="_blank"><i class="dashicons dashicons-sos"></i> 
			<?php
			esc_html_e( 'Support', 'woohoo' );
			?>
		</a>
		<?php
		// Link to the theme documentation
		?>
		<a href="<?php echo esc_url( woohoo_storage_get( 'theme_doc_url' ) ); ?>" class="button" target="_blank"><i class="dashicons dashicons-book"></i> 
			<?php
			esc_html_e( 'Documentation', 'woohoo' );
			?>
		</a>
	</div>
</div>

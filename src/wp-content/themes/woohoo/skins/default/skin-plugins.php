<?php
/**
 * Required plugins
 *
 * @package WOOHOO
 * @since WOOHOO 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$woohoo_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'woohoo' ),
	'page_builders' => esc_html__( 'Page Builders', 'woohoo' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'woohoo' ),
	'socials'       => esc_html__( 'Socials and Communities', 'woohoo' ),
	'events'        => esc_html__( 'Events and Appointments', 'woohoo' ),
	'content'       => esc_html__( 'Content', 'woohoo' ),
	'other'         => esc_html__( 'Other', 'woohoo' ),
);
$woohoo_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'woohoo' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'woohoo' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $woohoo_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'woohoo' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'woohoo' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $woohoo_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'woohoo' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'woohoo' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $woohoo_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'woohoo' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'woohoo' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $woohoo_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'woohoo' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'woohoo' ),
		'required'    => false,
		'logo'        => 'woocommerce.png',
		'group'       => $woohoo_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'woohoo' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'woohoo' ),
		'required'    => false,
		'logo'        => 'elegro-payment.png',
		'group'       => $woohoo_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'woohoo' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'woohoo' ),
		'required'    => false,
		'logo'        => 'instagram-feed.png',
		'group'       => $woohoo_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'woohoo' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'woohoo' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $woohoo_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'woohoo' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'booked.png',
		'group'       => $woohoo_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'woohoo' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'the-events-calendar.png',
		'group'       => $woohoo_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'woohoo' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'woohoo' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $woohoo_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'woohoo' ),
		'description' => '',
		'required'    => false,
		'logo'        => woohoo_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $woohoo_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'woohoo' ),
		'description' => '',
		'required'    => false,
		'logo'        => woohoo_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $woohoo_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'woohoo' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => woohoo_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $woohoo_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'woohoo' ),
		'description' => '',
		'required'    => false,
		'logo'        => woohoo_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $woohoo_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'woohoo' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => woohoo_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $woohoo_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'woohoo' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => woohoo_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $woohoo_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'woohoo' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $woohoo_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'woohoo' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $woohoo_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'woohoo' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'woohoo' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $woohoo_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'woohoo' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'woohoo' ),
		'required'    => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $woohoo_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'woohoo' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'woohoo' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $woohoo_theme_required_plugins_groups['other'],
	),
);

if ( WOOHOO_THEME_FREE ) {
	unset( $woohoo_theme_required_plugins['js_composer'] );
	unset( $woohoo_theme_required_plugins['booked'] );
	unset( $woohoo_theme_required_plugins['the-events-calendar'] );
	unset( $woohoo_theme_required_plugins['calculated-fields-form'] );
	unset( $woohoo_theme_required_plugins['essential-grid'] );
	unset( $woohoo_theme_required_plugins['revslider'] );
	unset( $woohoo_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $woohoo_theme_required_plugins['trx_updater'] );
	unset( $woohoo_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
woohoo_storage_set( 'required_plugins', $woohoo_theme_required_plugins );

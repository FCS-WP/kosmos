<?php
/**
 * Skin Setup
 *
 * @package WOOHOO
 * @since WOOHOO 1.76.0
 */


//--------------------------------------------
// SKIN DEFAULTS
//--------------------------------------------

// Return theme's (skin's) default value for the specified parameter
if ( ! function_exists( 'woohoo_theme_defaults' ) ) {
	function woohoo_theme_defaults( $name='', $value='' ) {
		$defaults = array(
			'page_width'          => 1290,
			'page_boxed_extra'  => 60,
			'page_fullwide_max' => 1920,
			'page_fullwide_extra' => 130,
			'sidebar_width'       => 410,
			'sidebar_gap'       => 40,
			'grid_gap'          => 30,
			'rad'               => 0,
		);
		if ( empty( $name ) ) {
			return $defaults;
		} else {
			if ( empty( $value ) && isset( $defaults[ $name ] ) ) {
				$value = $defaults[ $name ];
			}
			return $value;
		}
	}
}


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)


//--------------------------------------------
// SKIN SETTINGS
//--------------------------------------------
if ( ! function_exists( 'woohoo_skin_setup' ) ) {
	add_action( 'after_setup_theme', 'woohoo_skin_setup', 1 );
	function woohoo_skin_setup() {

		$GLOBALS['WOOHOO_STORAGE'] = array_merge( $GLOBALS['WOOHOO_STORAGE'], array(

			// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
			'theme_pro_key'       => 'env-axiom',

			'theme_doc_url'       => '//woohoo.axiomthemes.com/doc',

			'theme_demofiles_url' => '//demofiles.axiomthemes.com/woohoo/',
			
			'theme_rate_url'      => '//themeforest.net/download',

			'theme_custom_url'    => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

			'theme_support_url'   => '//themerex.net/support/',

			'theme_download_url'  => '//themeforest.net/user/axiomthemes/portfolio',        // Axiom

			'theme_video_url'     => '//www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',   // Axiom

			'theme_privacy_url'   => '//axiomthemes.com/privacy-policy/',                   // Axiom

			'portfolio_url'       => '//themeforest.net/user/axiomthemes/portfolio',        // Axiom

			// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
			// (i.e. 'children,kindergarten')
			'theme_categories'    => '',
		) );
	}
}


// Add/remove/change Theme Settings
if ( ! function_exists( 'woohoo_skin_setup_settings' ) ) {
	add_action( 'after_setup_theme', 'woohoo_skin_setup_settings', 1 );
	function woohoo_skin_setup_settings() {
		// Example: enable (true) / disable (false) thumbs in the prev/next navigation
		woohoo_storage_set_array( 'settings', 'thumbs_in_navigation', false );
		woohoo_storage_set_array2( 'required_plugins', 'latepoint', 'install', false);
	}
}



//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'woohoo_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'woohoo_skin_setup_fonts', 1 );
	function woohoo_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be:
		// - Google fonts (specify name, family and styles)
		// - Adobe fonts (specify name, family and link URL)
		// - uploaded fonts (specify name, family), placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		woohoo_storage_set(
			'load_fonts', array(
				// Google font
				array(
					'name'   => 'Oswald',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'wght@300;400;500;600;700',
				),
                array(
                    'name'   => 'Roboto',
                    'family' => 'sans-serif',
                    'link'   => '',
                    'styles' => 'ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700',
                ),
                array(
                    'name'   => 'Lora',
                    'family' => 'sans-serif',
                    'link'   => '',
                    'styles' => 'ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700',
                ),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		woohoo_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

        // Settings of the main tags.
        // Default value of 'font-family' may be specified as reference to the array $load_fonts (see above)
        // or as comma-separated string.
        // In the second case (if 'font-family' is specified manually as comma-separated string):
        //    1) Font name with spaces in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
        //    2) If font-family inherit a value from the 'Main text' - specify 'inherit' as a value
        // example:
        // Correct:   'font-family' => basekit_get_load_fonts_family_string( $load_fonts[0] )
        // Correct:   'font-family' => 'Roboto,sans-serif'
        // Correct:   'font-family' => '"PT Serif",sans-serif'
        // Incorrect: 'font-family' => 'Roboto, sans-serif'
        // Incorrect: 'font-family' => 'PT Serif,sans-serif'

		$font_description = esc_html__( 'Font settings for the %s of the site. To ensure that the elements scale properly on mobile devices, please use only the following units: "rem", "em" or "ex"', 'woohoo' );

		woohoo_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'woohoo' ) ),
					'font-family'     => 'Roboto,sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.62em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.57em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'woohoo' ) ),
					'font-family'     => '',			// Example: '"PR Serif",serif',
					'font-size'       => '',			// Example: '1.286rem',
					'font-weight'     => '',			// Example: '400',
					'font-style'      => '',			// Example: 'normal',
					'line-height'     => '',			// Example: '1.75em',
					'text-decoration' => '',			// Example: 'none',
					'text-transform'  => '',			// Example: 'none',
					'letter-spacing'  => '',			// Example: '',
					'margin-top'      => '',			// Example: '0em',
					'margin-bottom'   => '',			// Example: '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'woohoo' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '3.167em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.08em',
					'margin-bottom'   => '0.52em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'woohoo' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '2.611em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.021em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.77em',
					'margin-bottom'   => '0.56em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'woohoo' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '1.944em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.086em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.94em',
					'margin-bottom'   => '0.72em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'woohoo' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '1.556em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.214em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.15em',
					'margin-bottom'   => '0.83em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'woohoo' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '1.333em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.417em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.3em',
					'margin-bottom'   => '0.84em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'woohoo' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '1.056em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.474em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.75em',
					'margin-bottom'   => '1.1em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'woohoo' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '1.7em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'woohoo' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '13px',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '21px',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '1.2px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'woohoo' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '15px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'woohoo' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '14px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '1.1px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'woohoo' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '1.65px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'woohoo' ) ),
					'font-family'     => 'Roboto,sans-serif',
					'font-size'       => '14px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'other' => array(
					'title'           => esc_html__( 'Other', 'woohoo' ),
					'description'     => sprintf( $font_description, esc_html__( 'specific elements', 'woohoo' ) ),
					'font-family'     => 'Lora,sans-serif',
				),
			)
		);

		// Font presets
		woohoo_storage_set(
			'font_presets', array(
				'karla' => array(
								'title'  => esc_html__( 'Karla', 'woohoo' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Dancing Script',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
													// Google font
													array(
														'name'   => 'Sansita Swashed',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Dancing Script",fantasy',
														'font-size'       => '1.25rem',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
														'font-size'       => '4em',
													),
													'h2'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h3'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h4'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h5'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h6'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'logo'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'button'  => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'submenu' => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
												),
							),
				'roboto' => array(
								'title'  => esc_html__( 'Roboto', 'woohoo' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Noto Sans JP',
														'family' => 'serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
													// Google font
													array(
														'name'   => 'Merriweather',
														'family' => 'sans-serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Noto Sans JP",serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
												),
							),
				'garamond' => array(
								'title'  => esc_html__( 'Garamond', 'woohoo' ),
								'load_fonts' => array(
													// Adobe font
													array(
														'name'   => 'Europe',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
													// Adobe font
													array(
														'name'   => 'Sofia Pro',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Sofia Pro",sans-serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Europe,sans-serif',
													),
												),
							),
			)
		);
	}
}


//--------------------------------------------
// COLOR SCHEMES
//--------------------------------------------
if ( ! function_exists( 'woohoo_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'woohoo_skin_setup_schemes', 1 );
	function woohoo_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		woohoo_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'woohoo' ),
					'description' => esc_html__( 'Colors of the main content area', 'woohoo' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'woohoo' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'woohoo' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'woohoo' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'woohoo' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'woohoo' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'woohoo' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'woohoo' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'woohoo' ),
				),
			)
		);

		woohoo_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'woohoo' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'woohoo' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'woohoo' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'woohoo' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'woohoo' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'woohoo' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'woohoo' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'woohoo' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'woohoo' ),
					'description' => esc_html__( 'Color of the text inside this block', 'woohoo' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'woohoo' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'woohoo' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'woohoo' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'woohoo' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'woohoo' ),
					'description' => esc_html__( 'Color of the links inside this block', 'woohoo' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'woohoo' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'woohoo' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Accent 2', 'woohoo' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'woohoo' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Accent 2 hover', 'woohoo' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'woohoo' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Accent 3', 'woohoo' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'woohoo' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Accent 3 hover', 'woohoo' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'woohoo' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'woohoo' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F6F7F8', //ok +
					'bd_color'         => '#D8D8D8', //ok +

					// Text and links colors
					'text'             => '#818181', //ok +
					'text_light'       => '#ABABAB', //ok +
					'text_dark'        => '#060606', //ok +
					'text_link'        => '#FF6300', //ok +
					'text_hover'       => '#E85500', //ok +
					'text_link2'       => '#E80D0D', //ok +
					'text_hover2'      => '#D90505', //ok +
					'text_link3'       => '#C5A48E', //ok +
					'text_hover3'      => '#AB8E7A', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#F0EDE9', //ok +
					'alter_bd_color'   => '#D8D8D8', //ok +
					'alter_bd_hover'   => '#C9C6C3', //ok +
					'alter_text'       => '#818181', //ok +
					'alter_light'      => '#ABABAB', //ok +
					'alter_dark'       => '#060606', //ok +
					'alter_link'       => '#FF6300', //ok +
					'alter_hover'      => '#E85500', //ok +
					'alter_link2'      => '#E80D0D', //ok +
					'alter_hover2'     => '#D90505', //ok +
					'alter_link3'      => '#C5A48E', //ok +
					'alter_hover3'     => '#AB8E7A', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#060606', //ok +
					'extra_bg_hover'   => '#272323', //ok +
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#A7A7A7', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#ffffff', //ok
					'extra_link'       => '#FF6300', //ok +
					'extra_hover'      => '#ffffff', //ok
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok
					'input_bg_hover'   => 'transparent', //ok
					'input_bd_color'   => '#D8D8D8', //ok +
					'input_bd_hover'   => '#C9C6C3', //ok +
					'input_text'       => '#818181', //ok +
					'input_light'      => '#ABABAB', //ok +
					'input_dark'       => '#060606', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#060606', //ok +
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#ffffff', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'woohoo' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#272323', //ok +
					'bd_color'         => '#3C3F47', //ok +

					// Text and links colors
					'text'             => '#A7A7A7', //ok +
					'text_light'       => '#95908C', //ok +
					'text_dark'        => '#FCFCFC', //ok +
					'text_link'        => '#FF6300', //ok +
					'text_hover'       => '#E85500', //ok +
					'text_link2'       => '#E80D0D', //ok +
					'text_hover2'      => '#D90505', //ok +
					'text_link3'       => '#C5A48E', //ok +
					'text_hover3'      => '#AB8E7A', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#060606', //ok +
					'alter_bg_hover'   => '#3B3636', //ok +
					'alter_bd_color'   => '#2E2C28', //ok +
					'alter_bd_hover'   => '#3E3B35', //ok +
					'alter_text'       => '#A7A7A7', //ok +
					'alter_light'      => '#95908C', //ok +
					'alter_dark'       => '#FCFCFC', //ok +
					'alter_link'       => '#FF6300', //ok +
					'alter_hover'      => '#E85500', //ok +
					'alter_link2'      => '#E80D0D', //ok +
					'alter_hover2'     => '#D90505', //ok +
					'alter_link3'      => '#C5A48E', //ok +
					'alter_hover3'     => '#AB8E7A', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#060606', //ok +
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#A7A7A7', //ok +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#ffffff', //ok
					'extra_link'       => '#FF6300', //ok +
					'extra_hover'      => '#ffffff', //ok
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent', //ok
					'input_bg_hover'   => '#transparent', //ok
					'input_bd_color'   => '#2E2C28', //ok +
					'input_bd_hover'   => '#3E3B35', //ok +
					'input_text'       => '#A7A7A7', //ok +
					'input_light'      => '#95908C', //ok +
					'input_dark'       => '#FCFCFC', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FCFCFC', //ok +
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#060606', //ok +
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#060606', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'default'
			'light' => array(
				'title'    => esc_html__( 'Light', 'woohoo' ),
				'internal' => true,
				'colors'   => array(

                    // Whole block border and background
                    'bg_color'         => '#FFFFFF', //ok
                    'bd_color'         => '#D8D8D8', //ok +

                    // Text and links colors
                    'text'             => '#818181', //ok +
                    'text_light'       => '#ABABAB', //ok +
                    'text_dark'        => '#060606', //ok +
                    'text_link'        => '#FF6300', //ok +
                    'text_hover'       => '#E85500', //ok +
                    'text_link2'       => '#E80D0D', //ok +
                    'text_hover2'      => '#D90505', //ok +
                    'text_link3'       => '#C5A48E', //ok +
                    'text_hover3'      => '#AB8E7A', //ok +

                    // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                    'alter_bg_color'   => '#F6F7F8', //ok
                    'alter_bg_hover'   => '#F0EDE9', //ok +
                    'alter_bd_color'   => '#D8D8D8', //ok +
                    'alter_bd_hover'   => '#C9C6C3', //ok +
                    'alter_text'       => '#818181', //ok +
                    'alter_light'      => '#ABABAB', //ok +
                    'alter_dark'       => '#060606', //ok +
                    'alter_link'       => '#FF6300', //ok +
                    'alter_hover'      => '#E85500', //ok +
                    'alter_link2'      => '#E80D0D', //ok +
                    'alter_hover2'     => '#D90505', //ok +
                    'alter_link3'      => '#C5A48E', //ok +
                    'alter_hover3'     => '#AB8E7A', //ok +

                    // Extra blocks (submenu, tabs, color blocks, etc.)
                    'extra_bg_color'   => '#060606', //ok +
                    'extra_bg_hover'   => '#3f3d47',
                    'extra_bd_color'   => '#313131',
                    'extra_bd_hover'   => '#575757',
                    'extra_text'       => '#A7A7A7', //ok +
                    'extra_light'      => '#afafaf',
                    'extra_dark'       => '#ffffff', //ok
                    'extra_link'       => '#FF6300', //ok +
                    'extra_hover'      => '#ffffff', //ok
                    'extra_link2'      => '#80d572',
                    'extra_hover2'     => '#8be77c',
                    'extra_link3'      => '#ddb837',
                    'extra_hover3'     => '#eec432',

                    // Input fields (form's fields and textarea)
                    'input_bg_color'   => 'transparent', //ok
                    'input_bg_hover'   => 'transparent', //ok
                    'input_bd_color'   => '#D8D8D8', //ok +
                    'input_bd_hover'   => '#C9C6C3', //ok +
                    'input_text'       => '#818181', //ok +
                    'input_light'      => '#ABABAB', //ok +
                    'input_dark'       => '#060606', //ok +

                    // Inverse blocks (text and links on the 'text_link' background)
                    'inverse_bd_color' => '#67bcc1',
                    'inverse_bd_hover' => '#5aa4a9',
                    'inverse_text'     => '#1d1d1d',
                    'inverse_light'    => '#333333',
                    'inverse_dark'     => '#060606', //ok +
                    'inverse_link'     => '#ffffff', //ok
                    'inverse_hover'    => '#ffffff', //ok

                    // Additional (skin-specific) colors.
                    // Attention! Set of colors must be equal in all color schemes.
                    //---> For example:
                    //---> 'new_color1'         => '#rrggbb',
                    //---> 'alter_new_color1'   => '#rrggbb',
                    //---> 'inverse_new_color1' => '#rrggbb',
				),
			),
		);
		woohoo_storage_set( 'schemes', $schemes );
		woohoo_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> woohoo_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'woohoo' ),
		//---> 	'description' => __( 'Description of the new color 1', 'woohoo' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		woohoo_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'text_light_08'       => array(
					'color' => 'text_light',
					'alpha' => 0.8,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
                'alter_dark_015'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.15,
                ),
                'alter_dark_02'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.2,
                ),
                'alter_dark_05'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.5,
                ),
                'alter_dark_08'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.8,
                ),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
                'text_dark_003'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.03,
                ),
                'text_dark_005'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.05,
                ),
                'text_dark_008'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.08,
                ),
				'text_dark_015'      => array(
					'color' => 'text_dark',
					'alpha' => 0.15,
				),
				'text_dark_02'      => array(
					'color' => 'text_dark',
					'alpha' => 0.2,
				),
                'text_dark_03'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.3,
                ),
                'text_dark_05'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
                'text_dark_08'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.8,
                ),
                'text_link_007'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.07,
                ),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
                'text_link_03'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.3,
                ),
				'text_link_04'      => array(
					'color' => 'text_link',
					'alpha' => 0.4,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link2_08'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.8,
                ),
                'text_link2_007'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.07,
                ),
				'text_link2_02'      => array(
					'color' => 'text_link2',
					'alpha' => 0.2,
				),
                'text_link2_03'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.3,
                ),
				'text_link2_05'      => array(
					'color' => 'text_link2',
					'alpha' => 0.5,
				),
                'text_link3_007'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.07,
                ),
				'text_link3_02'      => array(
					'color' => 'text_link3',
					'alpha' => 0.2,
				),
                'text_link3_03'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.3,
                ),
                'inverse_text_03'      => array(
                    'color' => 'inverse_text',
                    'alpha' => 0.3,
                ),
                'inverse_link_08'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.8,
                ),
                'inverse_hover_08'      => array(
                    'color' => 'inverse_hover',
                    'alpha' => 0.8,
                ),
				'text_dark_blend'   => array(
					'color'      => 'text_dark',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		woohoo_storage_set(
			'schemes_simple', array(
				'text_link'        => array(
					'alter_hover'      => 1,
					'extra_link'       => 1,
					'inverse_bd_color' => 0.85,
					'inverse_bd_hover' => 0.7,
				),
				'text_hover'       => array(
					'alter_link'  => 1,
					'extra_hover' => 1,
				),
				'text_link2'       => array(
					'alter_hover2' => 1,
					'extra_link2'  => 1,
				),
				'text_hover2'      => array(
					'alter_link2'  => 1,
					'extra_hover2' => 1,
				),
				'text_link3'       => array(
					'alter_hover3' => 1,
					'extra_link3'  => 1,
				),
				'text_hover3'      => array(
					'alter_link3'  => 1,
					'extra_hover3' => 1,
				),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
				'inverse_bd_color' => array(),
				'inverse_bd_hover' => array(),
			)
		);

		// Parameters to set order of schemes in the css
		woohoo_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// Color presets
		woohoo_storage_set(
			'color_presets', array(
				'autumn' => array(
								'title'  => esc_html__( 'Autumn', 'woohoo' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	),
												'dark' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	)
												)
							),
				'green' => array(
								'title'  => esc_html__( 'Natural Green', 'woohoo' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	),
												'dark' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	)
												)
							),
			)
		);
	}
}


//--------------------------------------------
// THUMBS
//--------------------------------------------
if ( ! function_exists( 'woohoo_skin_setup_thumbs' ) ) {
	add_action( 'after_setup_theme', 'woohoo_skin_setup_thumbs', 1 );
	function woohoo_skin_setup_thumbs() {
		woohoo_storage_set(
			'theme_thumbs', apply_filters(
				'woohoo_filter_add_thumb_sizes', array(
					// Width of the image is equal to the content area width (without sidebar)
					// Height is fixed
					'woohoo-thumb-huge'        => array(
						'size'  => array( 1290, 725, true ), //ok
						'title' => esc_html__( 'Huge image', 'woohoo' ),
						'subst' => 'trx_addons-thumb-huge',
					),
					// Width of the image is equal to the content area width (with sidebar)
					// Height is fixed
					'woohoo-thumb-big'         => array(
						'size'  => array( 840, 473, true ), //ok
						'title' => esc_html__( 'Large image', 'woohoo' ),
						'subst' => 'trx_addons-thumb-big',
					),

					// Width of the image is equal to the 1/3 of the content area width (without sidebar)
					// Height is fixed
					'woohoo-thumb-med'         => array(
						'size'  => array( 410, 230, true ),
						'title' => esc_html__( 'Medium image', 'woohoo' ),
						'subst' => 'trx_addons-thumb-medium',
					),

					// Small square image (for avatars in comments, etc.)
					'woohoo-thumb-tiny'        => array(
						'size'  => array( 120, 120, true ),
						'title' => esc_html__( 'Small square avatar', 'woohoo' ),
						'subst' => 'trx_addons-thumb-tiny',
					),

					// Width of the image is equal to the content area width (with sidebar)
					// Height is proportional (only downscale, not crop)
					'woohoo-thumb-masonry-big' => array(
						'size'  => array( 840, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry Large (scaled)', 'woohoo' ),
						'subst' => 'trx_addons-thumb-masonry-big',
					),

					// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
					// Height is proportional (only downscale, not crop)
					'woohoo-thumb-masonry'     => array(
						'size'  => array( 410, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry (scaled)', 'woohoo' ),
						'subst' => 'trx_addons-thumb-masonry',
					),

					'woohoo-thumb-rectangle' => array(
						'size'  => array( 570, 696, true ), // old - 480x586
						'title' => esc_html__( 'Rectangle', 'woohoo' ),
						'subst' => 'trx_addons-thumb-rectangle',
					),

                    'woohoo-thumb-medium-square' => array(
                        'size'  => array( 650, 572, true ),
                        'title' => esc_html__( 'Square medium', 'woohoo' ),
                        'subst' => 'trx_addons-thumb-medium-square',
                    ),

					'woohoo-thumb-square' => array(
						'size'  => array( 890, 664, true ),
						'title' => esc_html__( 'Square', 'woohoo' ),
						'subst' => 'trx_addons-thumb-square',
					),

				)
			)
		);
	}
}


//--------------------------------------------
// BLOG STYLES
//--------------------------------------------
if ( ! function_exists( 'woohoo_skin_setup_blog_styles' ) ) {
	add_action( 'after_setup_theme', 'woohoo_skin_setup_blog_styles', 1 );
	function woohoo_skin_setup_blog_styles() {

		$blog_styles = array(
			'excerpt' => array(
				'title'   => esc_html__( 'Standard', 'woohoo' ),
				'archive' => 'index',
				'item'    => 'templates/content-excerpt',
				'styles'  => 'excerpt',
				'icon'    => "images/theme-options/blog-style/excerpt.png",
			),
			'band'    => array(
				'title'   => esc_html__( 'Band', 'woohoo' ),
				'archive' => 'index',
				'item'    => 'templates/content-band',
				'styles'  => 'band',
				'icon'    => "images/theme-options/blog-style/band.png",
			),
			'classic' => array(
				'title'   => esc_html__( 'Classic', 'woohoo' ),
				'archive' => 'index',
				'item'    => 'templates/content-classic',
				'columns' => array( 2, 3, 4 ),
				'styles'  => 'classic',
				'icon'    => "images/theme-options/blog-style/classic-%d.png",
				'new_row' => true,
			),
		);
		if ( ! WOOHOO_THEME_FREE ) {
			$blog_styles['classic-masonry']   = array(
				'title'   => esc_html__( 'Classic Masonry', 'woohoo' ),
				'archive' => 'index',
				'item'    => 'templates/content-classic',
				'columns' => array( 2, 3, 4 ),
				'styles'  => array( 'classic', 'masonry' ),
				'scripts' => 'masonry',
				'icon'    => "images/theme-options/blog-style/classic-masonry-%d.png",
				'new_row' => true,
			);
			$blog_styles['portfolio'] = array(
				'title'   => esc_html__( 'Portfolio', 'woohoo' ),
				'archive' => 'index',
				'item'    => 'templates/content-portfolio',
				'columns' => array( 2, 3, 4 ),
				'styles'  => 'portfolio',
				'icon'    => "images/theme-options/blog-style/portfolio-%d.png",
				'new_row' => true,
			);
			$blog_styles['portfolio-masonry'] = array(
				'title'   => esc_html__( 'Portfolio Masonry', 'woohoo' ),
				'archive' => 'index',
				'item'    => 'templates/content-portfolio',
				'columns' => array( 2, 3, 4 ),
				'styles'  => array( 'portfolio', 'masonry' ),
				'scripts' => 'masonry',
				'icon'    => "images/theme-options/blog-style/portfolio-masonry-%d.png",
				'new_row' => true,
			);
		}
		woohoo_storage_set( 'blog_styles', apply_filters( 'woohoo_filter_add_blog_styles', $blog_styles ) );
	}
}


//--------------------------------------------
// SINGLE STYLES
//--------------------------------------------
if ( ! function_exists( 'woohoo_skin_setup_single_styles' ) ) {
	add_action( 'after_setup_theme', 'woohoo_skin_setup_single_styles', 1 );
	function woohoo_skin_setup_single_styles() {

		woohoo_storage_set( 'single_styles', apply_filters( 'woohoo_filter_add_single_styles', array(
			'style-1'   => array(
				'title'       => esc_html__( 'Style 1', 'woohoo' ),
				'description' => esc_html__( 'Fullwidth image is above the content area, the title and meta are over the image', 'woohoo' ),
				'styles'      => 'style-1',
				'icon'        => "images/theme-options/single-style/style-1.png",
			),
			'style-2'   => array(
				'title'       => esc_html__( 'Style 2', 'woohoo' ),
				'description' => esc_html__( 'Fullwidth image is above the content area, the title and meta are inside the content area', 'woohoo' ),
				'styles'      => 'style-2',
				'icon'        => "images/theme-options/single-style/style-2.png",
			),
			'style-3'   => array(
				'title'       => esc_html__( 'Style 3', 'woohoo' ),
				'description' => esc_html__( 'Fullwidth image is above the content area, the title and meta are below the image', 'woohoo' ),
				'styles'      => 'style-3',
				'icon'        => "images/theme-options/single-style/style-3.png",
			),
			'style-4'   => array(
				'title'       => esc_html__( 'Style 4', 'woohoo' ),
				'description' => esc_html__( 'Boxed image is above the content area, the title and meta are above the image', 'woohoo' ),
				'styles'      => 'style-4',
				'icon'        => "images/theme-options/single-style/style-4.png",
			),
			'style-5'   => array(
				'title'       => esc_html__( 'Style 5', 'woohoo' ),
				'description' => esc_html__( 'Boxed image is inside the content area, the title and meta are above the content area', 'woohoo' ),
				'styles'      => 'style-5',
				'icon'        => "images/theme-options/single-style/style-5.png",
			),
			'style-6'   => array(
				'title'       => esc_html__( 'Style 6', 'woohoo' ),
				'description' => esc_html__( 'Boxed image, the title and meta are inside the content area, the title and meta are above the image', 'woohoo' ),
				'styles'      => 'style-6',
				'icon'        => "images/theme-options/single-style/style-6.png",
			),
			'style-7'   => array(
				'title'       => esc_html__( 'Style 7', 'woohoo' ),
				'description' => esc_html__( 'Fullwidth image is above the content area, the title and meta are below the image', 'woohoo' ),
				'styles'      => 'style-7',
				'icon'        => "images/theme-options/single-style/style-7.png",
			),
		) ) );
	}
}

if ( ! function_exists( 'woohoo_skin_upgrade_style' ) ) {
	add_action( 'wp_enqueue_scripts', 'woohoo_skin_upgrade_style', 2040 );
	function woohoo_skin_upgrade_style() {
		$woohoo_url = woohoo_get_file_url( woohoo_skins_get_current_skin_dir() . 'skin-upgrade-style.css' );
		if ( '' != $woohoo_url ) {
		
			wp_enqueue_style( 'woohoo-skin-upgrade-style-' . esc_attr( woohoo_skins_get_current_skin_name() ), $woohoo_url, array(), null );
		}
	}
}

// Activation methods
if ( ! function_exists( 'woohoo_skin_filter_activation_methods2' ) ) {
    add_filter( 'trx_addons_filter_activation_methods', 'woohoo_skin_filter_activation_methods2', 11, 1 );
    function woohoo_skin_filter_activation_methods2( $args ) {
        $args['elements_key'] = true;
        return $args;
    }
}
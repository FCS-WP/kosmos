<div class="front_page_section front_page_section_contacts<?php
	$woohoo_scheme = woohoo_get_theme_option( 'front_page_contacts_scheme' );
	if ( ! empty( $woohoo_scheme ) && ! woohoo_is_inherit( $woohoo_scheme ) ) {
		echo ' scheme_' . esc_attr( $woohoo_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( woohoo_get_theme_option( 'front_page_contacts_paddings' ) );
	if ( woohoo_get_theme_option( 'front_page_contacts_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$woohoo_css      = '';
		$woohoo_bg_image = woohoo_get_theme_option( 'front_page_contacts_bg_image' );
		if ( ! empty( $woohoo_bg_image ) ) {
			$woohoo_css .= 'background-image: url(' . esc_url( woohoo_get_attachment_url( $woohoo_bg_image ) ) . ');';
		}
		if ( ! empty( $woohoo_css ) ) {
			echo ' style="' . esc_attr( $woohoo_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$woohoo_anchor_icon = woohoo_get_theme_option( 'front_page_contacts_anchor_icon' );
	$woohoo_anchor_text = woohoo_get_theme_option( 'front_page_contacts_anchor_text' );
if ( ( ! empty( $woohoo_anchor_icon ) || ! empty( $woohoo_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_contacts"'
									. ( ! empty( $woohoo_anchor_icon ) ? ' icon="' . esc_attr( $woohoo_anchor_icon ) . '"' : '' )
									. ( ! empty( $woohoo_anchor_text ) ? ' title="' . esc_attr( $woohoo_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_contacts_inner
	<?php
	if ( woohoo_get_theme_option( 'front_page_contacts_fullheight' ) ) {
		echo ' woohoo-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$woohoo_css      = '';
			$woohoo_bg_mask  = woohoo_get_theme_option( 'front_page_contacts_bg_mask' );
			$woohoo_bg_color_type = woohoo_get_theme_option( 'front_page_contacts_bg_color_type' );
			if ( 'custom' == $woohoo_bg_color_type ) {
				$woohoo_bg_color = woohoo_get_theme_option( 'front_page_contacts_bg_color' );
			} elseif ( 'scheme_bg_color' == $woohoo_bg_color_type ) {
				$woohoo_bg_color = woohoo_get_scheme_color( 'bg_color', $woohoo_scheme );
			} else {
				$woohoo_bg_color = '';
			}
			if ( ! empty( $woohoo_bg_color ) && $woohoo_bg_mask > 0 ) {
				$woohoo_css .= 'background-color: ' . esc_attr(
					1 == $woohoo_bg_mask ? $woohoo_bg_color : woohoo_hex2rgba( $woohoo_bg_color, $woohoo_bg_mask )
				) . ';';
			}
			if ( ! empty( $woohoo_css ) ) {
				echo ' style="' . esc_attr( $woohoo_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$woohoo_caption     = woohoo_get_theme_option( 'front_page_contacts_caption' );
			$woohoo_description = woohoo_get_theme_option( 'front_page_contacts_description' );
			if ( ! empty( $woohoo_caption ) || ! empty( $woohoo_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $woohoo_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo ! empty( $woohoo_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $woohoo_caption, 'woohoo_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description
				if ( ! empty( $woohoo_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo ! empty( $woohoo_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $woohoo_description ), 'woohoo_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$woohoo_content = woohoo_get_theme_option( 'front_page_contacts_content' );
			$woohoo_layout  = woohoo_get_theme_option( 'front_page_contacts_layout' );
			if ( 'columns' == $woohoo_layout && ( ! empty( $woohoo_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ( ( ! empty( $woohoo_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo ! empty( $woohoo_content ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $woohoo_content, 'woohoo_kses_content' );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $woohoo_layout && ( ! empty( $woohoo_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div><div class="column-2_3">
				<?php
			}

			// Shortcode output
			$woohoo_sc = woohoo_get_theme_option( 'front_page_contacts_shortcode' );
			if ( ! empty( $woohoo_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo ! empty( $woohoo_sc ) ? 'filled' : 'empty'; ?>">
					<?php
					woohoo_show_layout( do_shortcode( $woohoo_sc ) );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $woohoo_layout && ( ! empty( $woohoo_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>

		</div>
	</div>
</div>

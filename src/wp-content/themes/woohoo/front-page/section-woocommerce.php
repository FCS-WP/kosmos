<?php
$woohoo_woocommerce_sc = woohoo_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $woohoo_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$woohoo_scheme = woohoo_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $woohoo_scheme ) && ! woohoo_is_inherit( $woohoo_scheme ) ) {
			echo ' scheme_' . esc_attr( $woohoo_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( woohoo_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( woohoo_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$woohoo_css      = '';
			$woohoo_bg_image = woohoo_get_theme_option( 'front_page_woocommerce_bg_image' );
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
		$woohoo_anchor_icon = woohoo_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$woohoo_anchor_text = woohoo_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $woohoo_anchor_icon ) || ! empty( $woohoo_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $woohoo_anchor_icon ) ? ' icon="' . esc_attr( $woohoo_anchor_icon ) . '"' : '' )
											. ( ! empty( $woohoo_anchor_text ) ? ' title="' . esc_attr( $woohoo_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( woohoo_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' woohoo-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$woohoo_css      = '';
				$woohoo_bg_mask  = woohoo_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$woohoo_bg_color_type = woohoo_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $woohoo_bg_color_type ) {
					$woohoo_bg_color = woohoo_get_theme_option( 'front_page_woocommerce_bg_color' );
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
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$woohoo_caption     = woohoo_get_theme_option( 'front_page_woocommerce_caption' );
				$woohoo_description = woohoo_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $woohoo_caption ) || ! empty( $woohoo_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $woohoo_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $woohoo_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $woohoo_caption, 'woohoo_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $woohoo_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $woohoo_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $woohoo_description ), 'woohoo_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $woohoo_woocommerce_sc ) {
						$woohoo_woocommerce_sc_ids      = woohoo_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$woohoo_woocommerce_sc_per_page = count( explode( ',', $woohoo_woocommerce_sc_ids ) );
					} else {
						$woohoo_woocommerce_sc_per_page = max( 1, (int) woohoo_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$woohoo_woocommerce_sc_columns = max( 1, min( $woohoo_woocommerce_sc_per_page, (int) woohoo_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$woohoo_woocommerce_sc}"
										. ( 'products' == $woohoo_woocommerce_sc
												? ' ids="' . esc_attr( $woohoo_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $woohoo_woocommerce_sc
												? ' category="' . esc_attr( woohoo_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $woohoo_woocommerce_sc
												? ' orderby="' . esc_attr( woohoo_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( woohoo_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $woohoo_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $woohoo_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

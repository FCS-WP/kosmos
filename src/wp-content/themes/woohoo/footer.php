<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WOOHOO
 * @since WOOHOO 1.0
 */

							do_action( 'woohoo_action_page_content_end_text' );
							
							// Widgets area below the content
							woohoo_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'woohoo_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'woohoo_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'woohoo_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'woohoo_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$woohoo_body_style = woohoo_get_theme_option( 'body_style' );
					$woohoo_widgets_name = woohoo_get_theme_option( 'widgets_below_page' );
					$woohoo_show_widgets = ! woohoo_is_off( $woohoo_widgets_name ) && is_active_sidebar( $woohoo_widgets_name );
					$woohoo_show_related = woohoo_is_single() && woohoo_get_theme_option( 'related_position' ) == 'below_page';
					if ( $woohoo_show_widgets || $woohoo_show_related ) {
						if ( 'fullscreen' != $woohoo_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $woohoo_show_related ) {
							do_action( 'woohoo_action_related_posts' );
						}

						// Widgets area below page content
						if ( $woohoo_show_widgets ) {
							woohoo_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $woohoo_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'woohoo_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'woohoo_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! woohoo_is_singular( 'post' ) && ! woohoo_is_singular( 'attachment' ) ) || ! in_array ( woohoo_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="woohoo_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'woohoo_action_before_footer' );

				// Footer
				$woohoo_footer_type = woohoo_get_theme_option( 'footer_type' );
				if ( 'custom' == $woohoo_footer_type && ! woohoo_is_layouts_available() ) {
					$woohoo_footer_type = 'default';
				}
				get_template_part( apply_filters( 'woohoo_filter_get_template_part', "templates/footer-" . sanitize_file_name( $woohoo_footer_type ) ) );

				do_action( 'woohoo_action_after_footer' );

			}
			?>

			<?php do_action( 'woohoo_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'woohoo_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'woohoo_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>
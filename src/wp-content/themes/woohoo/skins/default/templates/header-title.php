<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WOOHOO
 * @since WOOHOO 1.0
 */

// Page (category, tag, archive, author) title

if ( woohoo_need_page_title() ) {
	woohoo_sc_layouts_showed( 'title', true );
	woohoo_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								woohoo_show_post_meta(
									apply_filters(
										'woohoo_filter_post_meta_args', array(
											'components' => join( ',', woohoo_array_get_keys_by_value( woohoo_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', woohoo_array_get_keys_by_value( woohoo_get_theme_option( 'counters' ) ) ),
											'seo'        => woohoo_is_on( woohoo_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$woohoo_blog_title           = woohoo_get_blog_title();
							$woohoo_blog_title_text      = '';
							$woohoo_blog_title_class     = '';
							$woohoo_blog_title_link      = '';
							$woohoo_blog_title_link_text = '';
							if ( is_array( $woohoo_blog_title ) ) {
								$woohoo_blog_title_text      = $woohoo_blog_title['text'];
								$woohoo_blog_title_class     = ! empty( $woohoo_blog_title['class'] ) ? ' ' . $woohoo_blog_title['class'] : '';
								$woohoo_blog_title_link      = ! empty( $woohoo_blog_title['link'] ) ? $woohoo_blog_title['link'] : '';
								$woohoo_blog_title_link_text = ! empty( $woohoo_blog_title['link_text'] ) ? $woohoo_blog_title['link_text'] : '';
							} else {
								$woohoo_blog_title_text = $woohoo_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $woohoo_blog_title_class ); ?>">
								<?php
								$woohoo_top_icon = woohoo_get_term_image_small();
								if ( ! empty( $woohoo_top_icon ) ) {
									$woohoo_attr = woohoo_getimagesize( $woohoo_top_icon );
									?>
									<img src="<?php echo esc_url( $woohoo_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'woohoo' ); ?>"
										<?php
										if ( ! empty( $woohoo_attr[3] ) ) {
											woohoo_show_layout( $woohoo_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $woohoo_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $woohoo_blog_title_link ) && ! empty( $woohoo_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $woohoo_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $woohoo_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'woohoo_action_breadcrumbs' );
						$woohoo_breadcrumbs = ob_get_contents();
						ob_end_clean();
						woohoo_show_layout( $woohoo_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WOOHOO
 * @since WOOHOO 1.71.0
 */

$woohoo_template_args = get_query_var( 'woohoo_template_args' );

$woohoo_columns       = 1;

$woohoo_expanded      = ! woohoo_sidebar_present() && woohoo_get_theme_option( 'expand_content' ) == 'expand';

$woohoo_post_format   = get_post_format();
$woohoo_post_format   = empty( $woohoo_post_format ) ? 'standard' : str_replace( 'post-format-', '', $woohoo_post_format );

if ( is_array( $woohoo_template_args ) ) {
	$woohoo_columns    = empty( $woohoo_template_args['columns'] ) ? 1 : max( 1, $woohoo_template_args['columns'] );
	$woohoo_blog_style = array( $woohoo_template_args['type'], $woohoo_columns );
	if ( ! empty( $woohoo_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $woohoo_columns > 1 ) {
	    $woohoo_columns_class = woohoo_get_column_class( 1, $woohoo_columns, ! empty( $woohoo_template_args['columns_tablet']) ? $woohoo_template_args['columns_tablet'] : '', ! empty($woohoo_template_args['columns_mobile']) ? $woohoo_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $woohoo_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $woohoo_post_format ) );
	woohoo_add_blog_animation( $woohoo_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$woohoo_hover      = ! empty( $woohoo_template_args['hover'] ) && ! woohoo_is_inherit( $woohoo_template_args['hover'] )
							? $woohoo_template_args['hover']
							: woohoo_get_theme_option( 'image_hover' );
	$woohoo_components = ! empty( $woohoo_template_args['meta_parts'] )
							? ( is_array( $woohoo_template_args['meta_parts'] )
								? $woohoo_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $woohoo_template_args['meta_parts'] ) )
								)
							: woohoo_array_get_keys_by_value( woohoo_get_theme_option( 'meta_parts' ) );
	woohoo_show_post_featured( apply_filters( 'woohoo_filter_args_featured',
		array(
			'no_links'   => ! empty( $woohoo_template_args['no_links'] ),
			'hover'      => $woohoo_hover,
			'meta_parts' => $woohoo_components,
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $woohoo_template_args['thumb_size'] )
								? $woohoo_template_args['thumb_size']
								: woohoo_get_thumb_size( 
								in_array( $woohoo_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( woohoo_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $woohoo_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$woohoo_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$woohoo_show_title = get_the_title() != '';
		$woohoo_show_meta  = count( $woohoo_components ) > 0 && ! in_array( $woohoo_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $woohoo_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'woohoo_filter_show_blog_categories', $woohoo_show_meta && in_array( 'categories', $woohoo_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'woohoo_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						woohoo_show_post_meta( apply_filters(
															'woohoo_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $woohoo_hover, 1
															)
											);
						?>
					</div>
					<?php
					$woohoo_components = woohoo_array_delete_by_value( $woohoo_components, 'categories' );
					do_action( 'woohoo_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'woohoo_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'woohoo_action_before_post_title' );
					if ( empty( $woohoo_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'woohoo_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $woohoo_template_args['excerpt_length'] ) && ! in_array( $woohoo_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$woohoo_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'woohoo_filter_show_blog_excerpt', empty( $woohoo_template_args['hide_excerpt'] ) && woohoo_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				woohoo_show_post_content( $woohoo_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'woohoo_filter_show_blog_meta', $woohoo_show_meta, $woohoo_components, 'band' ) ) {
			if ( count( $woohoo_components ) > 0 ) {
				do_action( 'woohoo_action_before_post_meta' );
				woohoo_show_post_meta(
					apply_filters(
						'woohoo_filter_post_meta_args', array(
							'components' => join( ',', $woohoo_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'woohoo_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'woohoo_filter_show_blog_readmore', ! $woohoo_show_title || ! empty( $woohoo_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $woohoo_template_args['no_links'] ) ) {
				do_action( 'woohoo_action_before_post_readmore' );
				woohoo_show_post_more_link( $woohoo_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'woohoo_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $woohoo_template_args ) ) {
	if ( ! empty( $woohoo_template_args['slider'] ) || $woohoo_columns > 1 ) {
		?>
		</div>
		<?php
	}
}

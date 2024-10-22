<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WOOHOO
 * @since WOOHOO 1.0
 */

$woohoo_template_args = get_query_var( 'woohoo_template_args' );
$woohoo_columns = 1;
if ( is_array( $woohoo_template_args ) ) {
	$woohoo_columns    = empty( $woohoo_template_args['columns'] ) ? 1 : max( 1, $woohoo_template_args['columns'] );
	$woohoo_blog_style = array( $woohoo_template_args['type'], $woohoo_columns );
	if ( ! empty( $woohoo_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $woohoo_columns > 1 ) {
	    $woohoo_columns_class = woohoo_get_column_class( 1, $woohoo_columns, ! empty( $woohoo_template_args['columns_tablet']) ? $woohoo_template_args['columns_tablet'] : '', ! empty($woohoo_template_args['columns_mobile']) ? $woohoo_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $woohoo_columns_class ); ?>">
		<?php
	}
}
$woohoo_expanded    = ! woohoo_sidebar_present() && woohoo_get_theme_option( 'expand_content' ) == 'expand';
$woohoo_post_format = get_post_format();
$woohoo_post_format = empty( $woohoo_post_format ) ? 'standard' : str_replace( 'post-format-', '', $woohoo_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $woohoo_post_format ) );
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
			'thumb_size' => ! empty( $woohoo_template_args['thumb_size'] )
							? $woohoo_template_args['thumb_size']
							: woohoo_get_thumb_size( strpos( woohoo_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $woohoo_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$woohoo_template_args
	) );

	// Title and post meta
	$woohoo_show_title = get_the_title() != '';
	$woohoo_show_meta  = count( $woohoo_components ) > 0 && ! in_array( $woohoo_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $woohoo_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'woohoo_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'woohoo_action_before_post_title' );
				if ( empty( $woohoo_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'woohoo_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'woohoo_filter_show_blog_excerpt', empty( $woohoo_template_args['hide_excerpt'] ) && woohoo_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'woohoo_filter_show_blog_meta', $woohoo_show_meta, $woohoo_components, 'excerpt' ) ) {
				if ( count( $woohoo_components ) > 0 ) {
					do_action( 'woohoo_action_before_post_meta' );
					woohoo_show_post_meta(
						apply_filters(
							'woohoo_filter_post_meta_args', array(
								'components' => join( ',', $woohoo_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'woohoo_action_after_post_meta' );
				}
			}

			if ( woohoo_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'woohoo_action_before_full_post_content' );
					the_content( '' );
					do_action( 'woohoo_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'woohoo' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'woohoo' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				woohoo_show_post_content( $woohoo_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'woohoo_filter_show_blog_readmore',  ! isset( $woohoo_template_args['more_button'] ) || ! empty( $woohoo_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $woohoo_template_args['no_links'] ) ) {
					do_action( 'woohoo_action_before_post_readmore' );
					if ( woohoo_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						woohoo_show_post_more_link( $woohoo_template_args, '<p>', '</p>' );
					} else {
						woohoo_show_post_comments_link( $woohoo_template_args, '<p>', '</p>' );
					}
					do_action( 'woohoo_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $woohoo_template_args ) ) {
	if ( ! empty( $woohoo_template_args['slider'] ) || $woohoo_columns > 1 ) {
		?>
		</div>
		<?php
	}
}

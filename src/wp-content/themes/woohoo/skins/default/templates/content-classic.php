<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WOOHOO
 * @since WOOHOO 1.0
 */

$woohoo_template_args = get_query_var( 'woohoo_template_args' );

if ( is_array( $woohoo_template_args ) ) {
	$woohoo_columns    = empty( $woohoo_template_args['columns'] ) ? 2 : max( 1, $woohoo_template_args['columns'] );
	$woohoo_blog_style = array( $woohoo_template_args['type'], $woohoo_columns );
    $woohoo_columns_class = woohoo_get_column_class( 1, $woohoo_columns, ! empty( $woohoo_template_args['columns_tablet']) ? $woohoo_template_args['columns_tablet'] : '', ! empty($woohoo_template_args['columns_mobile']) ? $woohoo_template_args['columns_mobile'] : '' );
} else {
	$woohoo_blog_style = explode( '_', woohoo_get_theme_option( 'blog_style' ) );
	$woohoo_columns    = empty( $woohoo_blog_style[1] ) ? 2 : max( 1, $woohoo_blog_style[1] );
    $woohoo_columns_class = woohoo_get_column_class( 1, $woohoo_columns );
}
$woohoo_expanded   = ! woohoo_sidebar_present() && woohoo_get_theme_option( 'expand_content' ) == 'expand';

$woohoo_post_format = get_post_format();
$woohoo_post_format = empty( $woohoo_post_format ) ? 'standard' : str_replace( 'post-format-', '', $woohoo_post_format );

?><div class="<?php
	if ( ! empty( $woohoo_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( woohoo_is_blog_style_use_masonry( $woohoo_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $woohoo_columns ) : esc_attr( $woohoo_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $woohoo_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $woohoo_columns )
				. ' post_layout_' . esc_attr( $woohoo_blog_style[0] )
				. ' post_layout_' . esc_attr( $woohoo_blog_style[0] ) . '_' . esc_attr( $woohoo_columns )
	);
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
								: explode( ',', $woohoo_template_args['meta_parts'] )
								)
							: woohoo_array_get_keys_by_value( woohoo_get_theme_option( 'meta_parts' ) );

	woohoo_show_post_featured( apply_filters( 'woohoo_filter_args_featured',
		array(
			'thumb_size' => ! empty( $woohoo_template_args['thumb_size'] )
				? $woohoo_template_args['thumb_size']
				: woohoo_get_thumb_size(
				'classic' == $woohoo_blog_style[0]
						? ( strpos( woohoo_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $woohoo_columns > 2 ? 'big' : 'huge' )
								: ( $woohoo_columns > 2
									? ( $woohoo_expanded ? 'square' : 'square' )
									: ($woohoo_columns > 1 ? 'square' : ( $woohoo_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( woohoo_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $woohoo_columns > 2 ? 'masonry-big' : 'full' )
								: ($woohoo_columns === 1 ? ( $woohoo_expanded ? 'huge' : 'big' ) : ( $woohoo_columns <= 2 && $woohoo_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $woohoo_hover,
			'meta_parts' => $woohoo_components,
			'no_links'   => ! empty( $woohoo_template_args['no_links'] ),
        ),
        'content-classic',
        $woohoo_template_args
    ) );

	// Title and post meta
	$woohoo_show_title = get_the_title() != '';
	$woohoo_show_meta  = count( $woohoo_components ) > 0 && ! in_array( $woohoo_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $woohoo_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'woohoo_filter_show_blog_meta', $woohoo_show_meta, $woohoo_components, 'classic' ) ) {
				if ( count( $woohoo_components ) > 0 ) {
					do_action( 'woohoo_action_before_post_meta' );
					woohoo_show_post_meta(
						apply_filters(
							'woohoo_filter_post_meta_args', array(
							'components' => join( ',', $woohoo_components ),
							'seo'        => false,
							'echo'       => true,
						), $woohoo_blog_style[0], $woohoo_columns
						)
					);
					do_action( 'woohoo_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'woohoo_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'woohoo_action_before_post_title' );
				if ( empty( $woohoo_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'woohoo_action_after_post_title' );
			}

			if( !in_array( $woohoo_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'woohoo_filter_show_blog_readmore', ! $woohoo_show_title || ! empty( $woohoo_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $woohoo_template_args['no_links'] ) ) {
						do_action( 'woohoo_action_before_post_readmore' );
						woohoo_show_post_more_link( $woohoo_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'woohoo_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $woohoo_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('woohoo_filter_show_blog_excerpt', empty($woohoo_template_args['hide_excerpt']) && woohoo_get_theme_option('excerpt_length') > 0, 'classic')) {
			woohoo_show_post_content($woohoo_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $woohoo_template_args['more_button'] )) {
			if ( empty( $woohoo_template_args['no_links'] ) ) {
				do_action( 'woohoo_action_before_post_readmore' );
				woohoo_show_post_more_link( $woohoo_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'woohoo_action_after_post_readmore' );
			}
		}
		$woohoo_content = ob_get_contents();
		ob_end_clean();
		woohoo_show_layout($woohoo_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!

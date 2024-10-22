<?php
/**
 * The Portfolio template to display the content
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

$woohoo_post_format = get_post_format();
$woohoo_post_format = empty( $woohoo_post_format ) ? 'standard' : str_replace( 'post-format-', '', $woohoo_post_format );

?><div class="
<?php
if ( ! empty( $woohoo_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( woohoo_is_blog_style_use_masonry( $woohoo_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $woohoo_columns ) : esc_attr( $woohoo_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $woohoo_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $woohoo_columns )
		. ( 'portfolio' != $woohoo_blog_style[0] ? ' ' . esc_attr( $woohoo_blog_style[0] )  . '_' . esc_attr( $woohoo_columns ) : '' )
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

	$woohoo_hover   = ! empty( $woohoo_template_args['hover'] ) && ! woohoo_is_inherit( $woohoo_template_args['hover'] )
								? $woohoo_template_args['hover']
								: woohoo_get_theme_option( 'image_hover' );

	if ( 'dots' == $woohoo_hover ) {
		$woohoo_post_link = empty( $woohoo_template_args['no_links'] )
								? ( ! empty( $woohoo_template_args['link'] )
									? $woohoo_template_args['link']
									: get_permalink()
									)
								: '';
		$woohoo_target    = ! empty( $woohoo_post_link ) && false === strpos( $woohoo_post_link, home_url() )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$woohoo_components = ! empty( $woohoo_template_args['meta_parts'] )
							? ( is_array( $woohoo_template_args['meta_parts'] )
								? $woohoo_template_args['meta_parts']
								: explode( ',', $woohoo_template_args['meta_parts'] )
								)
							: woohoo_array_get_keys_by_value( woohoo_get_theme_option( 'meta_parts' ) );

	// Featured image
	woohoo_show_post_featured( apply_filters( 'woohoo_filter_args_featured',
		array(
			'hover'         => $woohoo_hover,
			'no_links'      => ! empty( $woohoo_template_args['no_links'] ),
			'thumb_size'    => ! empty( $woohoo_template_args['thumb_size'] )
								? $woohoo_template_args['thumb_size']
								: woohoo_get_thumb_size(
									woohoo_is_blog_style_use_masonry( $woohoo_blog_style[0] )
										? (	strpos( woohoo_get_theme_option( 'body_style' ), 'full' ) !== false || $woohoo_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( woohoo_get_theme_option( 'body_style' ), 'full' ) !== false || $woohoo_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => woohoo_is_blog_style_use_masonry( $woohoo_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $woohoo_components,
			'class'         => 'dots' == $woohoo_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $woohoo_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $woohoo_post_link )
												? '<a href="' . esc_url( $woohoo_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $woohoo_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $woohoo_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $woohoo_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
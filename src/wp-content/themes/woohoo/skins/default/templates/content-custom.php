<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WOOHOO
 * @since WOOHOO 1.0.50
 */

$woohoo_template_args = get_query_var( 'woohoo_template_args' );
if ( is_array( $woohoo_template_args ) ) {
	$woohoo_columns    = empty( $woohoo_template_args['columns'] ) ? 2 : max( 1, $woohoo_template_args['columns'] );
	$woohoo_blog_style = array( $woohoo_template_args['type'], $woohoo_columns );
} else {
	$woohoo_blog_style = explode( '_', woohoo_get_theme_option( 'blog_style' ) );
	$woohoo_columns    = empty( $woohoo_blog_style[1] ) ? 2 : max( 1, $woohoo_blog_style[1] );
}
$woohoo_blog_id       = woohoo_get_custom_blog_id( join( '_', $woohoo_blog_style ) );
$woohoo_blog_style[0] = str_replace( 'blog-custom-', '', $woohoo_blog_style[0] );
$woohoo_expanded      = ! woohoo_sidebar_present() && woohoo_get_theme_option( 'expand_content' ) == 'expand';
$woohoo_components    = ! empty( $woohoo_template_args['meta_parts'] )
							? ( is_array( $woohoo_template_args['meta_parts'] )
								? join( ',', $woohoo_template_args['meta_parts'] )
								: $woohoo_template_args['meta_parts']
								)
							: woohoo_array_get_keys_by_value( woohoo_get_theme_option( 'meta_parts' ) );
$woohoo_post_format   = get_post_format();
$woohoo_post_format   = empty( $woohoo_post_format ) ? 'standard' : str_replace( 'post-format-', '', $woohoo_post_format );

$woohoo_blog_meta     = woohoo_get_custom_layout_meta( $woohoo_blog_id );
$woohoo_custom_style  = ! empty( $woohoo_blog_meta['scripts_required'] ) ? $woohoo_blog_meta['scripts_required'] : 'none';

if ( ! empty( $woohoo_template_args['slider'] ) || $woohoo_columns > 1 || ! woohoo_is_off( $woohoo_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $woohoo_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( woohoo_is_off( $woohoo_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $woohoo_custom_style ) ) . "-1_{$woohoo_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $woohoo_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $woohoo_columns )
					. ' post_layout_' . esc_attr( $woohoo_blog_style[0] )
					. ' post_layout_' . esc_attr( $woohoo_blog_style[0] ) . '_' . esc_attr( $woohoo_columns )
					. ( ! woohoo_is_off( $woohoo_custom_style )
						? ' post_layout_' . esc_attr( $woohoo_custom_style )
							. ' post_layout_' . esc_attr( $woohoo_custom_style ) . '_' . esc_attr( $woohoo_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'woohoo_action_show_layout', $woohoo_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $woohoo_template_args['slider'] ) || $woohoo_columns > 1 || ! woohoo_is_off( $woohoo_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}

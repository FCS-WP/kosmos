<?php
/**
 * The template to display single post
 *
 * @package WOOHOO
 * @since WOOHOO 1.0
 */

// Full post loading
$full_post_loading          = woohoo_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = woohoo_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = woohoo_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$woohoo_related_position   = woohoo_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$woohoo_posts_navigation   = woohoo_get_theme_option( 'posts_navigation' );
$woohoo_prev_post          = false;
$woohoo_prev_post_same_cat = woohoo_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( woohoo_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	woohoo_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'woohoo_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $woohoo_posts_navigation ) {
		$woohoo_prev_post = get_previous_post( $woohoo_prev_post_same_cat );  // Get post from same category
		if ( ! $woohoo_prev_post && $woohoo_prev_post_same_cat ) {
			$woohoo_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $woohoo_prev_post ) {
			$woohoo_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $woohoo_prev_post ) ) {
		woohoo_sc_layouts_showed( 'featured', false );
		woohoo_sc_layouts_showed( 'title', false );
		woohoo_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $woohoo_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/content', 'single-' . woohoo_get_theme_option( 'single_style' ) ), 'single-' . woohoo_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $woohoo_related_position, 'inside' ) === 0 ) {
		$woohoo_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'woohoo_action_related_posts' );
		$woohoo_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $woohoo_related_content ) ) {
			$woohoo_related_position_inside = max( 0, min( 9, woohoo_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $woohoo_related_position_inside ) {
				$woohoo_related_position_inside = mt_rand( 1, 9 );
			}

			$woohoo_p_number         = 0;
			$woohoo_related_inserted = false;
			$woohoo_in_block         = false;
			$woohoo_content_start    = strpos( $woohoo_content, '<div class="post_content' );
			$woohoo_content_end      = strrpos( $woohoo_content, '</div>' );

			for ( $i = max( 0, $woohoo_content_start ); $i < min( strlen( $woohoo_content ) - 3, $woohoo_content_end ); $i++ ) {
				if ( $woohoo_content[ $i ] != '<' ) {
					continue;
				}
				if ( $woohoo_in_block ) {
					if ( strtolower( substr( $woohoo_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$woohoo_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $woohoo_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $woohoo_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$woohoo_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $woohoo_content[ $i + 1 ] && in_array( $woohoo_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$woohoo_p_number++;
					if ( $woohoo_related_position_inside == $woohoo_p_number ) {
						$woohoo_related_inserted = true;
						$woohoo_content = ( $i > 0 ? substr( $woohoo_content, 0, $i ) : '' )
											. $woohoo_related_content
											. substr( $woohoo_content, $i );
					}
				}
			}
			if ( ! $woohoo_related_inserted ) {
				if ( $woohoo_content_end > 0 ) {
					$woohoo_content = substr( $woohoo_content, 0, $woohoo_content_end ) . $woohoo_related_content . substr( $woohoo_content, $woohoo_content_end );
				} else {
					$woohoo_content .= $woohoo_related_content;
				}
			}
		}

		woohoo_show_layout( $woohoo_content );
	}

	// Comments
	do_action( 'woohoo_action_before_comments' );
	comments_template();
	do_action( 'woohoo_action_after_comments' );

	// Related posts
	if ( 'below_content' == $woohoo_related_position
		&& ( 'scroll' != $woohoo_posts_navigation || woohoo_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || woohoo_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'woohoo_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $woohoo_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $woohoo_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $woohoo_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $woohoo_prev_post ) ); ?>"
			<?php do_action( 'woohoo_action_nav_links_single_scroll_data', $woohoo_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();

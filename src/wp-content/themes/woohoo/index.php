<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package WOOHOO
 * @since WOOHOO 1.0
 */

$woohoo_template = apply_filters( 'woohoo_filter_get_template_part', woohoo_blog_archive_get_template() );

if ( ! empty( $woohoo_template ) && 'index' != $woohoo_template ) {

	get_template_part( $woohoo_template );

} else {

	woohoo_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$woohoo_stickies   = is_home()
								|| ( in_array( woohoo_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) woohoo_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$woohoo_post_type  = woohoo_get_theme_option( 'post_type' );
		$woohoo_args       = array(
								'blog_style'     => woohoo_get_theme_option( 'blog_style' ),
								'post_type'      => $woohoo_post_type,
								'taxonomy'       => woohoo_get_post_type_taxonomy( $woohoo_post_type ),
								'parent_cat'     => woohoo_get_theme_option( 'parent_cat' ),
								'posts_per_page' => woohoo_get_theme_option( 'posts_per_page' ),
								'sticky'         => woohoo_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $woohoo_stickies )
															&& count( $woohoo_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		woohoo_blog_archive_start();

		do_action( 'woohoo_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'woohoo_action_before_page_author' );
			get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'woohoo_action_after_page_author' );
		}

		if ( woohoo_get_theme_option( 'show_filters' ) ) {
			do_action( 'woohoo_action_before_page_filters' );
			woohoo_show_filters( $woohoo_args );
			do_action( 'woohoo_action_after_page_filters' );
		} else {
			do_action( 'woohoo_action_before_page_posts' );
			woohoo_show_posts( array_merge( $woohoo_args, array( 'cat' => $woohoo_args['parent_cat'] ) ) );
			do_action( 'woohoo_action_after_page_posts' );
		}

		do_action( 'woohoo_action_blog_archive_end' );

		woohoo_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'woohoo_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}

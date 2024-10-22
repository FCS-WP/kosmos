<?php
/**
 * The template to display the background video in the header
 *
 * @package WOOHOO
 * @since WOOHOO 1.0.14
 */
$woohoo_header_video = woohoo_get_header_video();
$woohoo_embed_video  = '';
if ( ! empty( $woohoo_header_video ) && ! woohoo_is_from_uploads( $woohoo_header_video ) ) {
	if ( woohoo_is_youtube_url( $woohoo_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $woohoo_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php woohoo_show_layout( woohoo_get_embed_video( $woohoo_header_video ) ); ?></div>
		<?php
	}
}

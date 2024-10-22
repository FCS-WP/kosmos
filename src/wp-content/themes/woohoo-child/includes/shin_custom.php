<?php
add_action('wp_enqueue_scripts', 'shin_scripts');
function shin_scripts()
{
	$version = time();

	// Load CSS
	wp_enqueue_style('main-style-css', THEME_URL . '-child' . '/assets/main/main.css', array(), $version, 'all');
// 	wp_enqueue_style('vanilla-celendar-css', THEME_URL . '-child' . '/assets/main/vanilla-calendar.min.css', array(), $version, 'all');
	// Load JS
// 	wp_enqueue_script('main-scripts-js', THEME_URL . '-child' . '/assets/main/main.js', array('jquery'), $version, true);
}



<?php
/*
Plugin Name: Numeric Shortlinks
Description: Adds support for numeric shortlinks like <code>http://example.com/123</code>
Version: 1.1
Author: Kaspars Dambis	
*/


add_filter( 'pre_get_shortlink', 'numeric_shortlink_head', 10, 4 );

function numeric_shortlink_head( $return, $id, $context, $slugs ) {
	if ( is_singular() ) 
		return home_url( '/' . get_queried_object_id() );

	return $return;
}


add_action( 'template_redirect', 'maybe_numeric_shortlink_redirect' );

function maybe_numeric_shortlink_redirect() {
	// Get the trailing part of the URI
	$maybe_post_id = end( explode( '/', trim( $_SERVER['REQUEST_URI'], '/' ) ) );
	
	// Check if it is numeric
	if ( ! is_numeric( $maybe_post_id ) )
		return;
	
	// Redirect
	if ( $post_url = get_permalink( $uri_int ) ) {
		wp_redirect( $post_url, 301 );
		exit;	
	}
}


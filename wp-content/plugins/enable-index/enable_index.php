<?php
/*
Plugin Name: Enable index.php
Plugin URI: http://ilikewordpress.com/loading-wordpress-from-index-php
Description: This plugin allows a blog installed at root to be addressed by /index.php. Remedies stripping of filename by includes/canonical.php
Author: Steve Johnson
Version: 1.0
Author URI: http://ilikewordpress.com/
*/
 
/*
*    Applies filter to redirect_canonical to defeat
*    stripping of index.php file
*/
 
function fix_index( $requested_url ) {
 if ( get_bloginfo( 'url' ) == $requested_url )
 return false;
}
add_filter( 'redirect_canonical', 'fix_index' );
 
?>
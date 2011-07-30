<?php

// Register widgetized areas

if (!function_exists('the_widgets_init')) {
	function the_widgets_init() {
	    if ( !function_exists('register_sidebars') )
	        return;
	
	    register_sidebar(array(
	    	'name' => 'Primary',
	    	'id' => 'primary',
	    	'description' => "Normal full width Sidebar",
	    	'before_widget' => '<section id="%1$s" class="widget %2$s">',
	    	'after_widget' => '</section>',
	    	'before_title' => '<h3>',
	    	'after_title' => '</h3>'
	    ));
			}
}

add_action( 'init', 'the_widgets_init' );
?>
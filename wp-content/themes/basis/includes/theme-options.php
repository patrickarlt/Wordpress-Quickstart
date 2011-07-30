<?php

$seo_post_types = array('post','page');
define("SEOPOSTTYPES", serialize($seo_post_types));

//Global options setup
add_action('init','woo_global_options');
function woo_global_options(){
	// Populate WooThemes option in array for use in theme
	global $woo_options;
	$woo_options = get_option('woo_options');
}

add_action('admin_head','woo_options');  
if (!function_exists('woo_options')) {
function woo_options(){
	
// VARIABLES
$themename = "Needmore";
$manualurl = 'http://needmoredesigns.com';
$shortname = "needmore";

$GLOBALS['template_path'] = get_bloginfo('template_directory');

//Access the WordPress Categories via an Array
$woo_categories = array();  
$woo_categories_obj = get_categories('hide_empty=0');
foreach ($woo_categories_obj as $woo_cat) {
    $woo_categories[$woo_cat->cat_ID] = $woo_cat->cat_name;}
$categories_tmp = array_unshift($woo_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$woo_pages = array();
$woo_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($woo_pages_obj as $woo_page) {
    $woo_pages[$woo_page->ID] = $woo_page->post_name; }
$woo_pages_tmp = array_unshift($woo_pages, "Select a page:");       

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post"); 

//Testing 
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

//More Options
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

// THIS IS THE DIFFERENT FIELDS
$options = array();   

$options[] = array( "name" => "General Settings",
										"icon" => "general",
                    "type" => "heading");
                        
$options[] = array( "name" => "Post/Page Comments",
										"desc" => "Select if you want to enable/disable comments on posts and/or pages. ",
										"id" => $shortname."_comments",
										"type" => "select2",
										"options" => array("post" => "Posts Only", "page" => "Pages Only", "both" => "Pages / Posts", "none" => "None") );                                                                                                         
 					                   
$options[] = array( "name" => "Dynamic Images",
										"icon" => "image",
									   "type" => "heading");  
				    				   
$options[] = array( "name" => "Enable WordPress Post Thumbnail Support",
										"desc" => "Use WordPress post thumbnail support to assign a post thumbnail.",
										"id" => $shortname."_post_image_support",
										"std" => "true",
										"class" => "collapsed",
										"type" => "checkbox"); 

$options[] = array( "name" => "Dynamically Resize Post Thumbnail",
										"desc" => "The post thumbnail will be dynamically resized using native WP resize functionality. <em>(Requires PHP 5.2+)</em>",
										"id" => $shortname."_pis_resize",
										"std" => "true",
										"class" => "hidden",
										"type" => "checkbox"); 									   
					
$options[] = array( "name" => "Hard Crop Post Thumbnail",
										"desc" => "The image will be cropped to match the target aspect ratio.",
										"id" => $shortname."_pis_hard_crop",
										"std" => "true",
										"class" => "hidden last",
										"type" => "checkbox"); 									   

$options[] = array( "name" => "Enable Dynamic Image Resizer",
										"desc" => "This will enable the thumb.php script. It dynamically resizes images on your site.",
										"id" => $shortname."_resize",
										"std" => "true",
										"type" => "checkbox");    
                    
$options[] = array( "name" => "Automatic Image Thumbs",
										"desc" => "If no image is specified in the 'image' custom field then the first uploaded post image is used.",
										"id" => $shortname."_auto_img",
										"std" => "false",
										"type" => "checkbox");    

$options[] = array( "name" => "Thumbnail Image Dimensions",
										"desc" => "Enter an integer value i.e. 250 for the desired size which will be used when dynamically creating the images.",
										"id" => $shortname."_image_dimensions",
										"std" => "",
										"type" => array(
														array(  'id' => $shortname. '_thumb_h',
																'type' => 'text',
																'std' => 250,
																'meta' => 'Height')
								  ));

$options[] = array( "name" => "Show thumbnail in Single Posts",
										"desc" => "Show the attached image in the single post page.",
										"id" => $shortname."_thumb_single",
										"class" => "collapsed",
										"std" => "false",
										"type" => "checkbox");    

$options[] = array( "name" => "Single Image Dimensions",
										"desc" => "Enter an integer value i.e. 250 for the image size. Max width is 576.",
										"id" => $shortname."_image_dimensions",
										"std" => "",
										"class" => "hidden last",
										"type" => array(
														array(  'id' => $shortname. '_single_h',
																'type' => 'text',
																'std' => 250,
																'meta' => 'Height')
								  ));
                                              
update_option('woo_template',$options);      
update_option('woo_themename',$themename);   
update_option('woo_shortname',$shortname);
update_option('woo_manual',$manualurl);
                                     
// Woo Metabox Options
// Start name with underscore to hide custom key from the user
$woo_metaboxes = array();
   
update_option('woo_custom_template',$woo_metaboxes);    

//Only show SEO on these registered post types

}
}
?>
<?php

//Add a nag to install the options framework plugin
//See : http://wptheming.com/options-framework-plugin
if ( !function_exists( 'optionsframework_add_page' ) && current_user_can('edit_theme_options') ) {
    function portfolio_options_default() {
        add_submenu_page('themes.php', 'Theme Options', 'Theme Options', 'edit_theme_options', 'options-framework','optionsframework_page_notice');
    }
    add_action('admin_menu', 'portfolio_options_default');
}
 
if ( !function_exists( 'optionsframework_page_notice' ) ) {
	function optionsframework_page_notice() { ?>

		<div class="wrap">
		<?php screen_icon( 'themes' ); ?>
		<h2><?php _e('Theme Options'); ?></h2>
		<p><b>If you would like to use the Portfolio Press theme options, please install the <a href="https://github.com/devinsays/options-framework-plugin">Options Framework</a> plugin.</b></p>
		<p>Once the plugin is activated you will have option to:</p>
		<ul class="ul-disc">
		<li>Upload a logo image</li>
		<li>Change the sidebar position</li>
		<li>Change the menu position</li>
		<li>Display the portfolio on the home page</li>
		<li>Hide the portfolio image on the single post</li>
		<li>Update the footer text</li>
		</ul>

		<p>If you don't need these options, the plugin is not required and the theme will use default settings.</p>
		</div>
	<?php
	}
}

//Register Jquery and Modernizer with Wordpress
function register_scripts() {

  //Replace Wordpress jQuery with the latest jQuery  unless we are on an admin page
  if(!is_admin()){
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', get_bloginfo('template_directory').'/js/jquery-latest.min.js');
  }
  
  //Register Modernizr with Wordpress
  wp_register_script( 'modernizr', get_bloginfo('template_directory').'/js/modernizr-latest.min.js');
  
}
 
add_action('init', 'register_scripts');

//Custom Styles for TinyMCE Editor
//http://codex.wordpress.org/Function_Reference/add_editor_style
add_editor_style('css/editor.css');

// Add Wordpress Navigation Menu
if(function_exists('wp_nav_menu')){
	add_theme_support('nav-menus');
	register_nav_menus(array(
		'primary-menu' => 'Primary Menu'
	));
}

// Add Widgetized Sidebar
if(function_exists('register_sidebar')){
	register_sidebar(array(
		'name' => 'Primary Sidebar',
		'description' => '',
		'before_widget' => '<section>',
		'after_widget'  => '</section>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
}

//Add Featured Images
if(function_exists('add_theme_support')){
  add_theme_support('post-thumbnails', array('page', 'post'));
  add_image_size('demo', 200, 200, true);
}

//Add RSS link to header automatically
if(function_exists('add_theme_support')) {
	add_theme_support('automatic-feed-links');
}

//Custom Excerpt
function new_excerpt_more(){
	return '&hellip;';
}

add_filter('excerpt_more', 'new_excerpt_more');

//Custom Excerpt Length
function new_excerpt_length(){
	return 300;
}

add_filter('excerpt_length', 'new_excerpt_length');

//Conditionals for checking next/previous posts
//Note: Why isn't this in core yet?
function is_next_post(){
  global $post;
  $next_post = get_adjacent_post(false,'',false);
  return ($next_post) ? true : false;
}

function is_previous_post(){
  global $post;
  $previous_post = get_adjacent_post(false,'',true);
  return ($previous_post) ? true : false;
}

//Function for geting the next/previous post url
//Note: Why isn't this in core yet?
function get_previous_post_url(){
  global $post;
  return get_permalink(get_adjacent_post(false,'',true));
}

function get_next_post_url(){
  global $post;
  return get_permalink(get_adjacent_post(false,'',false));
}

function next_post_url(){
  echo get_next_post_url();
}

function previous_post_url(){
  echo get_previous_post_url();
}

//Function for geting the next/previous post title
//Note: Why isn't this in core yet?
function get_previous_post_title(){
  global $post;
  $prev_post = get_adjacent_post(false,'',true);
  return get_the_title($prev_post->ID);
}

function get_next_post_title(){
  global $post;
  $next_post = get_adjacent_post(false,'',false);
  return get_permalink($prev_post->ID);
}

function next_post_title(){
  echo get_next_post_title();
}

function previous_post_title(){
  echo get_previous_post_title();
}

//Add Classes to pager buttons
//http://wpcanyon.com/tipsandtricks/adding-attributes-to-previous-and-next-post-links/
//Note: Why isn't this in core yet?
function posts_previous_link_attributes(){
	return 'class="previous button"';
}

function posts_next_link_attributes(){
	return 'class="next button"';
}

add_filter('next_post_link_attributes', 'posts_next_link_attributes');
add_filter('previous_post_link_attributes', 'posts_previous_link_attributes');

add_filter('next_posts_link_attributes', 'posts_next_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_previous_link_attributes');

//Post Slug Function
//Note: Why isn't this in core yet?
function the_slug(){
  global $post;
  echo $post->post_name;
}

function get_the_slug(){
  global $post;
  return $post->post_name;
}

//Frist/Last Even/Odd for Post Class 
//Note: Why isn't this in core yet?
function first_last_even_odd_post_class($classes){
  
  global $wp_query;
  
  $current_post = $wp_query->current_post;
  $total_posts = $wp_query->post_count;
  
  if($current_post == 0){
    $classes[] = "first";
  }
  
  if($current_post == $total_posts){
    $classes[] = "last ";
  }
  
  if ($current_post % 2) {
    $classes[] = "even";
  } else {
    $classes[] = "odd" ;
  }
  
  return $classes;
  
}

add_filter('post_class', 'first_last_even_odd_post_class');

//Add Post/Page Slug To Body Classes
//From: http://36flavours.com/2011/02/wordpress-append-page-slug-to-body-class/
function add_body_class($classes){
  global $post;

  if (isset($post)){
    $classes[] = $post->post_type . '-' . $post->post_name;
  }
  return $classes;
}

add_filter('body_class', 'add_body_class');

//Remove generator from head for secutiry reasons
remove_action('wp_head', 'wp_generator');

// Custom HTML5 Pingback Markup
function custom_pings($comment, $args, $depth) {

	$GLOBALS['comment'] = $comment; ?>
	
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class();?>>
		<article>
			<header class="comment-author vcard">
				<span class="author"><?php comment_author_link(); ?></span> - 
				<time datetime="<?php comment_time('c');?>"><?php comment_date(); ?></span>
			</header>
			<?php comment_text(); ?>
		</article>
   <!-- </li> is added by wordpress automatically -->
<?php 
}

// Custom HTML5 Comment Markup
function custom_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
     <article>
       <header class="comment-author vcard">
          <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
          
          <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
          
          <time datetime="<?php comment_time('c');?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a></time>
          
       </header>
       
       <?php if ($comment->comment_approved == '0') : ?>
          <em><?php _e('Your comment is awaiting moderation.') ?></em>
          <br />
       <?php endif; ?>

       <?php comment_text() ?>

       <nav>
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
         <?php edit_comment_link(__('(Edit)'),'  ','') ?>
       </nav>
     </article>
    <!-- </li> is added by wordpress automatically -->
<?php
}

// Custom Functions for CSS/Javascript Versioning
$GLOBALS["TEMPLATE_URL"] = get_bloginfo('template_url')."/";
$GLOBALS["TEMPLATE_RELATIVE_URL"] = wp_make_link_relative($GLOBALS["TEMPLATE_URL"]);

// Add ?v=[last modified time] to style sheets
function versioned_stylesheet($relative_url, $add_attributes=""){
  echo '<link rel="stylesheet" href="'.versioned_resource($relative_url).'" '.$add_attributes.'>'."\n";
}

// Add ?v=[last modified time] to javascripts
function versioned_javascript($relative_url, $add_attributes=""){
  echo '<script src="'.versioned_resource($relative_url).'" '.$add_attributes.'></script>'."\n";
}

// Add ?v=[last modified time] to a file url
function versioned_resource($relative_url){
  $file = $_SERVER["DOCUMENT_ROOT"].$relative_url;
  $file_version = "";

  if(file_exists($file)) {
    $file_version = "?v=".filemtime($file);
  }

  return $relative_url.$file_version;
}
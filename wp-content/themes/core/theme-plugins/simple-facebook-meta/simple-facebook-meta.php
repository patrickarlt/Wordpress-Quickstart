<?php
/*
Plugin Name: Simple Facebook Meta
Plugin URI: http://developers.facebook.com/docs/reference/plugins/like#
Description: Automatically adds metadata for the facebook like button to a page.
Author: Patrick Arlt
Version: 0.01
Author URI: http://patrickarlt.com
*/

/* Helper to get the first image from a post */
function ss_first_image() {
	global $post, $posts;
	$first_img = '';
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches[1][0];
	return $first_img;
};

function facebook_meta_image(){
	if(is_single()){
		global $post;
		if(function_exists('has_post_thumbnail')){
			if(has_post_thumbnail($post->ID)){
				$img_data = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
				$fb_img_url = $img_data[0];
			}
		}
		if(empty($fb_img_url)){
			$fb_img_url = ss_first_image();
		}
		if(empty($fb_img_url)){
			$fb_img_url = get_bloginfo('stylesheet-directory')."/images/fb-default.png";
		}
	}
	return $fb_img_url;
}

/* Add Facebook metadata to wp_head() */
function add_facebook_meta(){
	if(is_single()): global $post;
		$site_url = parse_url(get_bloginfo('url')); ?>	
		<!-- Facebook metadata -->
		<meta property="og:title" content="<?php echo $post->post_title; ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?php echo(get_permalink($post->ID)); ?>" />
		<meta property="og:site_name" content="<?php echo $site_url['host']; ?>" />
		<meta property="og:image" content="<?php echo facebook_meta_image(); ?>" />
	<?php endif; ?>

	<?php if(is_front_page()): ?>
		<!-- Facebook metadata -->
    <meta property="og:title" content="<?php get_bloginfo('name'); ?>" />
    <meta property="og:type" content="company" />
    <meta property="og:url" content="<?php echo(get_bloginfo('url')); ?>" />
    <meta property="og:image" content="<?php echo $fb_img_url = get_bloginfo('stylesheet-directory'); ?>/images/logo.png" />
    <meta property="og:site_name" content="<?php get_bloginfo('name'); ?>" />
	<?php endif;?>
<?php };

add_action('wp_head', 'add_facebook_meta');

/* Add social scripts to wp_footer() so they dont block */
function add_social_scripts(){ ?>
  <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
  <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<?php };

add_action('wp_footer', 'add_social_scripts');

//Return a simple"Like" button
function get_like_button(){
	return("<fb:like href='".get_permalink($post->ID)."' layout='button_count' style='overflow:visible;' show_faces='false' width='90' font='lucida grande'></fb:like>");
};

//Return a simple "Tweet" buttons
function get_tweet_button(){
	return("<a href='http://twitter.com/share' class='twitter-share-button' data-url='". get_permalink($post->ID)."' data-text='". get_the_title($post->ID)."' data-count='horizontal'>Tweet</a>");
};

//Echo a simple "Like" Button
function the_like_button(){
	echo(get_like_button());
};

//Echo a simple "Tweet" Button
function the_tweet_button(){
	echo(get_tweet_button());
};

?>
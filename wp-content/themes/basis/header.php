<!doctype html>

<html lang="en" class="no-js">
<head>
  <meta charset="utf-8">

  <!-- www.phpied.com/conditional-comments-block-downloads/ -->
  <!--[if IE]><![endif]-->

	<title><?php wp_title(); ?></title>

	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory')?>/images/favicon.png">
	
  <?php versioned_stylesheet($GLOBALS["TEMPLATE_RELATIVE_URL"]."style.css") ?>
	
	<?php wp_enqueue_script( $handle = 'modernizr'); ?>
  <?php wp_enqueue_script( $handle = 'jquery'); ?>
  	
	<!-- Wordpress Head Items -->
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <?php wp_head(); ?>

</head>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <body <?php body_class('ie ie6'); ?>> <![endif]-->
<!--[if IE 7 ]>    <body <?php body_class('ie ie7'); ?>> <![endif]-->
<!--[if IE 8 ]>    <body <?php body_class('ie ie8'); ?>> <![endif]-->
<!--[if IE 9 ]>    <body <?php body_class('ie ie9'); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body <?php body_class('not-ie'); ?>> <!--<![endif]-->

<div id="wrapper">

  <header>
    <h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
  </header>
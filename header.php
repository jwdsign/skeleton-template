<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta name="title" content="<?php wp_title( '|', true, 'right' ); ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="<?php wp_title(); ?>">

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<meta content="True" name="HandheldFriendly">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
	<meta name="viewport" content="width=device-width">

	<?php wp_head(); ?>

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!--[if lte IE 7]><script src="js/lte-ie7.js"></script><![endif]-->
	<script type="text/javascript">
	$j=jQuery.noConflict();
	$j(function() {
	$j('#nav-button').click(function() {
	$j(this).toggleClass('nav-toggled');
	$j('#mobile-menu, #wrapper').toggleClass('nav-toggled');
    	})
		});
  	</script>
</head>

<body <?php body_class($class); ?> >
 
 <?php get_template_part('mobile-menu'); ?> 

<div id="wrapper">
<span id="nav-button" title="Navigation">&#xe017;</span>

<header role="banner">
<img class="custom_header" src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" title="" />
</header>

<?php get_template_part('main-menu'); ?> 

<div id="main" role="main">
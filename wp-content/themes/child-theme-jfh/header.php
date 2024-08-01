<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]>
	<script defer src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php if ( get_header_image() ) : ?>

	<div class="dropshadowimg"><img src="<?php header_image(); ?>" width="100%" height="auto" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></div>
	<?php endif; ?>
	<header id="masthead" class="site-header" role="banner">         
		<div class="header-main">
<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
				<button class="menu-toggle"><?php _e( 'Primary Menu', 'twentyfourteen' ); ?></button>
				<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'twentyfourteen' ); ?></a>
<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu' ) ); ?></nav>
<div class="search-toggle">
<a href="#search-container" class="screen-reader-text" aria-expanded="false" aria-controls="search-container">
<?php _e( 'Search', 'twentyfourteen' ); ?></a>
</div>
</div>
<div id="search-container" class="search-box-wrapper hide">
<div class="search-box">
<?php get_search_form(); ?>
</div>
</div>
</header><!-- #masthead -->
<div id="site-header">
<h16><a href="tel://01375 366700">01375 366700</a></h16>
<div class="logo">
 <a href="https://www.johnfhunt.co.uk/"><img src="/wp-content/uploads/2017/10/John-F-Hunt-Final-LOGOmm2.png" height="37px" width="240px" /></a>
</div>
<div class="footer-social-icons">
    <ul class="social-icons">
        <li><a href="https://twitter.com/johnfhunt_group" target="_blank" class="social-icon"> <i class="fa fa-twitter"></i></a></li>
        <li><a href="https://www.youtube.com/channel/UCOWyyn0YcmWp-njZ30eC9Hg" target="_blank" class="social-icon"> <i class="fa fa-youtube"></i></a></li>
        <li><a href="https://www.linkedin.com/company/john-f-hunt-group" target="_blank" class="social-icon"> <i class="fa fa-linkedin"></i></a></li>
    </ul>
</div>
</div>
<div id="main" class="site-main">
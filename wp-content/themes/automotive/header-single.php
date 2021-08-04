<!DOCTYPE html>
<html <?php language_attributes(); ?>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/selectBox/jquery.selectBox.css"/>
<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
<script>document.documentElement.className += ' wf-loading';</script>
<style>.wf-loading .nav a{font-family:Arial;visibility: hidden;}.wf-loading .side-widget h3 {font-family:cursive;visibility: hidden;}.wf-active .nav a {visibility: visible;}.wf-active .side-widget h3 {visibility: visible;}
</style>
<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Roboto+Condensed:400,700:latin'] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
 <script src="<?php bloginfo('template_url'); ?>/assets/js/html2pdf/html2pdf.bundle-min.js"></script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 center-block">
					<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {  echo '<div class="col-sm-6 hidden-xs" id="logo">'.get_custom_logo().'</div>';
            ?><div class="col-sm-6 hidden-xs" id="phone">
            <?php dynamic_sidebar('phone'); ?>
          </div>
          <?php } elseif  (get_header_image() != '') { ?>  <img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo( 'name' ); ?>" /><?php
          } else {
          if (display_header_text()==true){
          $description = get_bloginfo( 'description', 'display' );
?>        <div class="col-sm-6 hidden-xs" id="logo"><h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<p class="site-description"><?php echo $description; ?></p>
					</div>
          <?php } ?>
					<div class="col-sm-6 hidden-xs" id="phone">
					<?php dynamic_sidebar('phone'); ?>
				</div><?php } ?>
			</div>
		</div>
	</div>
<div class="row pad">
		<div class="col-sm-12 head">
			<nav id="menu"  class="navbar navbar-default"  role="navigation">
			<div class="container">
            	<div class="navbar-header navbar-default">
					<button class="navbar-toggle menu" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
					</button>
					<button class="navbar-toggle search" type="button" data-toggle="collapse" data-target=".search-button">
                    	<span class="sr-only"><?php _e('Toggle Search','language');?></span>
						<span class="glyphicon glyphicon-search"></span>
					</button>
					<a class="logo visible-xs" href="<?php bloginfo('url'); ?>"><?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?></a>
					<?php else : ?>
            	<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>
						<?php endif; ?>
				   </div>
            <div class="collapse navbar-collapse bs-navbar-collapse">
                <?php wp_nav_menu( array(
					'menu' 				=> 'Menu',
					'theme_location' 	=> 'header-menu',
					'container' 		=> false,
					'menu_class'		=> 'nav navbar-nav',
					'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
					'walker'            => new wp_bootstrap_navwalker(),
					)
				);?>
            </div>
				<div class="collapse navbar-collapse search-button" id="searchbar"></div>
        <?php if ( has_nav_menu( 'save-menu' ) ) {
        wp_nav_menu( array('theme_location' => 'save-menu') );} ?>
        	</div>
    	</nav>
	</div>
</div>
<div class="loading-msg">
  <div class="loader-hold">
		<div class="loader" data-loader="circle-side">
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="text"><?php _e('Searching Inventory...','language');?>
	</div>
</div>
<div id="compare"><?php  do_action( 'auto_del_before_ajax_search_result' );?></div>

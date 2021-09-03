<?php
get all poated cars
/*
Template Name: Inventory Page
*/
?>
<?php get_header(); ?>
<div class="col-sm-9 home col-sm-push-3" id="content">
	<?php cps_ajax_search_results(); ?>
</div>
<div class="col-sm-3 col col-sm-pull-9">
	<?php if ( ! dynamic_sidebar( 'search' ) ) : ?>
	<?php endif; ?>
	<?php if ( ! dynamic_sidebar('sidebar')) : ?>
	<?php endif; ?>
</div>
</div>
<?php get_footer(); ?>

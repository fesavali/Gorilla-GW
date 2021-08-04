<?php /* Template Name: Free Car Appraisal */ ?>
<?php get_header(); ?>
<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'gt-trade-car-classifieds/index.php' ) ) {
	require_once( ABSPATH . 'wp-content/plugins/gt-trade-car-classifieds/template-free.php' );
	} else { ?>
		<div class="col-sm-9 col-md-push-3" id="content">
				 <?php cps_ajax_search_results(); ?>
	 		<div class="detail-page-content hideOnSearch">
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<h1 class="blog-post-title">
					<a  href="<?php the_permalink();?>"><?php the_title();?></a>
				</h1>
			<div class="blog-post">
					<div style="clear:both"></div>
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail('large'); } ?>
				<?php the_content();  ?>
			</div>
			<?php endwhile;?>
        </div>
	</div>
<?php } ?>
<div class="col-sm-3 col-md-pull-9">
	<?php if ( ! dynamic_sidebar('search')) : endif; ?>
	<?php if ( ! dynamic_sidebar('sidebar')) : endif; ?>
</div>
<div style="clear:both"></div>
<?php get_footer(); ?>

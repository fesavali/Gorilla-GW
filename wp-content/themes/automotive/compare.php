<?php
/**
 *
 * Template Name: Compare Listings
 */
?>
<?php get_header(); ?>
<div class='container-fluid compare-page'>
     <div class="row">
			<div class="col-sm-9 col-md-push-3" id="content">
				<?php cps_ajax_search_results(); ?>
	 			<div class="detail-page-content hideOnSearch">
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div class="blog-post hideOnSearch">
					<h1><a href="<?php the_permalink() ?>"><?php the_title();?></a></h1>
						<div style="clear:both"></div>
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail('large'); } ?>
					<?php echo do_shortcode('[s2f_comparing_list]');?>
					<?php the_content();  ?>
				</div>
				<?php endwhile;?>
            </div>
		</div>
		<div class="col-sm-3 col-md-pull-9">
			<?php if ( ! dynamic_sidebar('search')) : endif; ?>
			<?php if ( ! dynamic_sidebar('sidebar')) :   endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>

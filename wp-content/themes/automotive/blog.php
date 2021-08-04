<?php
/*
Template Name: Blog
*/
?>
<?php get_header(); ?>
<div class="col-sm-9 col-sm-push-3" id="content">
		<div class="cpsAjaxLoaderSingle"></div>
		<?php cps_ajax_search_results(); ?>
			<div class="detail-page-content hideOnSearch">
				<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$the_query = new WP_Query( 'post_type=post&paged='.$paged.'' );
					while ( $the_query->have_posts() ) : $the_query->the_post();
					global $more;
					$more = 0;
					?>
				      <div class="blog-post">
						<h1><a href="<?php the_permalink() ?>"><?php the_title();?></a></h1>
						<div style="clear:both"></div>
						<?php if ( has_post_thumbnail() ) { the_post_thumbnail('large'); } ?>
						<?php the_content(__('Read more','language')); ?>
					</div>
				<?php endwhile;wp_reset_postdata();?>
				<?php theme_pagination( $the_query->max_num_pages); ?>
            </div>
		</div>
		<div class="col-sm-3 col col-sm-pull-9"><!-- Start Col 3 -->
			<?php if ( ! dynamic_sidebar( 'search' ) ) : ?>
			<?php endif; ?>
			<?php if ( ! dynamic_sidebar('sidebar')) : ?>
			<?php endif; ?>
		</div><!-- End Col 3 -->
	</div><!-- End Row -->
</div><!-- End Container -->
<?php get_footer(); ?>

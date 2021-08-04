<?php
/*
Template Name: Financing Application
*/
?>
<?php get_header(); ?>
		<div class="col-sm-9 col-sm-push-3" id="content">
			<div class="cpsAjaxLoaderSingle"></div>
				<?php cps_ajax_search_results(); ?>
					<div class="detail-page-content hideOnSearch">
						<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
							<div class="blog-post  financing">
								<h1><a href="<?php the_permalink() ?>"><?php the_title();?></a></h1>
							<div style="clear:both"></div>
							<?php if ( has_post_thumbnail() ) { the_post_thumbnail('large'); } ?>
								<div class="contact-us-page">
										<?php the_content();?>
							<div style="clear: both"></div>
					</div>	</div>
				<?php endwhile; ?>
            </div>
		</div>
		<div class="col-sm-3 col col-sm-pull-9">
			<?php if ( ! dynamic_sidebar( 'search' ) ) : ?>
			<?php endif; ?>
			<?php if ( ! dynamic_sidebar('sidebar')) : ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>

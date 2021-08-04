<?php get_header(); ?>
	<div class="col-sm-9 col-sm-push-3" id="content">
		<div class="cpsAjaxLoaderSingle"></div>
		<?php cps_ajax_search_results(); ?>
			<div class="detail-page-content hideOnSearch">
				<h1 class="cat-title"><?php printf( __( 'Search Results for: %s', 'language' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
				<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>
				<div class="blog-post">
					<h2><a href="<?php the_permalink() ?>"><?php the_title();?></a></h2>
					<div style="clear:both"></div>
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail('large'); } ?>
					<?php the_content();  ?>
				</div>
				<?php endwhile;
					else: ?>
					<div class="blog-post">
						<h2><p><?php _e('No Results Found','language');?></p></h2>
					</div>
				<?php endif;?>
				<?php theme_pagination( $wp_query->max_num_pages); ?>
			</div>
		</div>
		<div class="col-sm-3 col col-sm-pull-9"><!-- Start Col 3 -->
			<?php if ( ! dynamic_sidebar( 'search' ) ) : endif; ?>
			<?php if ( ! dynamic_sidebar('sidebar')) : endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>

<?php get_header(); ?>
	<div class="col-sm-9 col-sm-push-3" id="content">
		<div class="cpsAjaxLoaderSingle"></div>
		<?php cps_ajax_search_results(); ?>
			<div class="detail-page-content hideOnSearch">
				<h1 class="cat-title">
				<?php if ( is_tag() ) {
						 __( 'Tag Archives: %s', 'language' );
				} elseif ( is_archive() ) {
					wp_title(''); __(' Category','language'); 
				} else {
					echo wp_title( '', false, right ); 
				} ?></h1>

				<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>
				<div class="blog-post">                 	 
					<h2><a href="<?php the_permalink() ?>"><?php the_title();?></a></h2>
					<div style="clear:both"></div>	
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail('large'); } ?>
					<?php the_content();  ?>
				</div>
				<?php endwhile;
					else: ?>
					<div class="no-post">
						<h3><?php _e('No, Results Found','language');?></h3>
						<p><?php _e('Sorry, No Posts found!','language');?></p>
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
<?php get_header(); ?>
	<div class="col-sm-9 col-sm-push-3" id="content">
		<?php cps_ajax_search_results(); ?>
			<div class="detail-page-content hideOnSearch">
				<div class="blog-post">
					<h1><?php _e('404 Page Not Found!', 'language');?></h1>
			<p><?php _e('Sorry, no results found. Please try another search', 'language');?></p>
				</div>
			</div>
		</div>
		<div class="col-sm-3 col col-sm-pull-9"><!-- Start Col 3 -->
			<?php if (! dynamic_sidebar('search')) : endif; ?>
			<?php if (! dynamic_sidebar('sidebar')) : endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>

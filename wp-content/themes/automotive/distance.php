<?php /* Template Name: Search By Distance */ ?>
<?php get_header('common'); ?>
	<div class="outer-common">
		<?php echo do_shortcode( '[geolocation_search]' );  ?>
			<div class="col-sm-3  col-sm-pull-9  page-template">
				<?php if ( ! dynamic_sidebar('search-sidebar')) : endif; ?>
				<?php if ( ! dynamic_sidebar('sidebar')) : endif; ?>
			</div>
	</div>
</div>
<?php get_footer(); ?>

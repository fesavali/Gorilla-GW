<?php
	get_header();
	global $fields;
	$fields = get_post_meta($post->ID, 'mod1', true);
	$blogurl = get_bloginfo('template_url');
	$surl = get_bloginfo('url'); ?>
		<div class="col-sm-9 home col-sm-push-3" id="content">
		<?php cps_ajax_search_results(); ?>
					<div class="col-sm-12 hideOnSearch"><?php
					$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
					$q = new WP_Query(['post_type' => 'gtcd','posts_per_page' => get_option('posts_per_page'), get_query_var( 'taxonomy' ) => get_query_var( 'term' ),'paged' => $paged]);
					$temp_query = $wp_query;
					$wp_query = null;
					$wp_query = $q;
					if ( $q->have_posts() ) :
					while ( $q->have_posts() ) : $q->the_post();
					global $fields;
					$fields = get_post_meta($post->ID, 'mod1', true);
	$fields_2 = get_post_meta($post->ID, 'mod2', true);
	$blogurl = get_bloginfo('template_url');
	$surl = get_bloginfo('url');?>
<div class="result-car hideOnSearch">
	<div class="row">
	<a class="result-car-link" href="<?php echo get_permalink($post->ID);?>" rel="bookmark">
	<?php
	echo '<div class="col-sm-4 col-results">';
	echo gorilla_img ($post->ID,'medium');?>
	<div class="status-tag <?php echo $fields['statustag'];?>"><?php echo $fields['statustag'];?></div>
	</div>
<div class="col-sm-5 result-detail-wrapper col-results">
	<p class="vehicle-name"><span class="mini-hide"><?php if ( $fields['year']){ echo $fields['year'].' ';}else {  echo ''; }?></span><?php get_template_part('assets/template-parts/makemodel'); ?></p>
  <p class="miles-style"><?php if ( $fields['miles']){ echo $fields['miles'].' '.get_theme_mod('miles_text','Miles');} elseif ($fields['miles'] == '0' ){ echo _e('0','language').' '.get_theme_mod('miles_text','Miles');} else {echo '';}  ?></p><p class="car-info"><?php if (isset( $fields['transmission'])){ echo  get_theme_mod('transmission_text','Transmission').': '.$fields['transmission'];}else {  echo ''; };?>
<?php if (isset( $fields_2['cylinders'])){ echo ', '.$fields_2['cylinders'].' '.get_theme_mod('enginecylinders_text','Miles').', ';}else {  echo ''; };?><?php if (isset($fields['exterior']) &&  (!empty($fields['exterior']))) {
        echo '<span class="mini-hide"> / Color: '.$fields['exterior'].'</span> - '; } else { echo ''; }; ?><?php if (isset($fields['interior'])) {  echo '<span class="mini-hide">'.$fields['interior'].'</span>';  } else { echo ''; }; ?><?php if (isset( $fields['epamileage'])){ echo ', <span class="mini-hide">'.$fields['epamileage'].'</span>';} else {  echo ''; };?></p><p class="title-tag">
        <?php echo wp_trim_words($post->post_content, 26); ?>
</p>
<?php
		$terms = get_the_term_list( $post->ID, 'features', '<ul class="feat-style"><li>', ',</li><li>', '</li></ul>');
		$max_terms = 4;
		$terms_array = explode( ',', $terms, $max_terms + 1 );
		array_pop( $terms_array );
		$terms = implode( ' ', $terms_array );
		echo strip_tags( $terms,'<ul><li>' );?>
		</div>
		<div class="col-sm-3 col-results">
			<div class="inventory-right">
				<p class="price-style results"><?php get_template_part( 'assets/template-parts/currencyprice' ); ?> </p>
				<?php if (!empty($fields['stock'])){ echo '<p class="stock-inventory">'.get_theme_mod('stock_text','Stock').' # : '.$fields['stock'].'</p>';} else { echo ''; } ?>
		<p class="location-tag"> <?php get_template_part('assets/template-parts/location');?> </p>
		<p><a class="btn btn-primary" href="<?php echo get_permalink($post->ID);?>"><?php _e('View Details','language');?></a></p>
		</div>
		</div>
		<div style="clear:both;"></div>
	</a>
	</div>
</div>
<?php endwhile; endif;wp_reset_postdata();?>
<div class="bottom-pagination hideOnSearch">
		<p><a id="link" href="#top"><?php _e('BACK TO TOP','language');?></a></p>
		<p class="paging">
			<?php wp_reset_postdata(); pagination_nav(); $wp_query = NULL; $wp_query = $temp_query;?>
       </p>
</div>
<?php
$wp_query = NULL;
$wp_query = $temp_query;
?>
</div></div>
		<div class="col-sm-3 col col-sm-pull-9">
			<?php if ( ! dynamic_sidebar( 'search' ) ) : ?>
			<?php endif; ?>
			<?php if ( ! dynamic_sidebar('sidebar')) : ?>
		<?php endif; ?>
	</div>
</div>
<?php get_footer(); ?>

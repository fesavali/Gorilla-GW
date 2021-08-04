<?php get_header('single'); ?>
	<?php if (have_posts()) :  while (have_posts()) : the_post(); global $fields;$video_source;$video_id;
     $video_source = get_post_meta($post->ID, 'video_meta_box_source', true);
     $fields = get_post_meta($post->ID, 'mod1', true);$fields2 = get_post_meta($post->ID, 'mod2', true);?>
			  <?php cps_ajax_search_results_single(); ?>
			  <div class="col-sm-9 col-sm-push-3 hideOnSearch">
			  	<div class="row">
			  		<div class="col-sm-8">
					<div id="wrap">
						<div id="myCarousel" class="carousel slide hideOnSearch single" data-interval="false" data-ride="carousel">
							<div class="carousel-inner">
								<?php gallery_single($post->ID, 'full'); ?>
							</div>
						</div>
						<div id="my-thumbs-list" class="carousel">
							<ul class="carousel-thumbs hideOnSearch thumbnail">
								<?php gallery_thumbs($post->ID, 'thumbnail'); ?>
							</ul>
 						</div>
 					</div>
 				<div style="clear: both"></div>
 				<ul class="nav nav-tabs hideOnSearch" role="tablist" id="myTabs">
					<?php $content = get_the_content();
                    if (!empty($content)) {
                        ?>
					<li class="active">
						<a href="#overview" role="tab" data-toggle="tab">
							<?php _e('Overview', 'automotive'); ?>
									</a>
						</li>
						<?php } ?>
<?php $taxonomy = get_the_terms($post->ID, 'features');
if (! empty($taxonomy)) {
    ?><li><a href="#features" role="tab" data-toggle="tab">
		  					<?php _e('Features', 'automotive'); ?>
          				</a>
		  			</li>
						<?php } ?>
						<?php $video_id = get_post_meta($post->ID, 'video_meta_box_videoid', true);

                        if ((!empty($video_id))) { ?>
		  			<li>
		  				<a href="#video" role="tab" data-toggle="tab">
		  					<?php _e('Video', 'automotive'); ?>
          				</a>
		  			</li>
					<?php } ?>
		  			<li>
		  				<a href="#contact" role="tab" data-toggle="tab">
		  					<?php _e('Contact Us', 'automotive');?>
          				</a>
		  			</li>
          		</ul>
		  	<div class="tab-content hideOnSearch">
			  	<div class="tab-pane active" id="overview">
						<?php $content = get_the_content();
                        if (!empty($content)) {
                            ?>
			<ul class="overview">
			<?php
                $content = get_the_content();
                $content = preg_replace("/<img[^>]+\>/i", " ", $content);
                $content = apply_filters('the_content', $content);
                $content = str_replace(']]>', ']]>', $content); ?><h1><?php if ($fields['year']) {
                           echo $fields['year'];
                            } else {
                                echo '';
                            } ?></span>
			<?php } ?>
	<?php get_template_part('assets/template-parts/makemodel'); ?>
				</p></h1><?php
                echo '<span class="car-overview"><h2>'.the_title().'</h2></span>';
                echo '<span class="car-overview">'.wpautop(the_content()).'</span>';
            ?>
			</ul>
    </div>
    <div class="tab-pane fade" id="features">
    <div class="item-list">
		<ul class="features  features-list">
		<?php	if (get_the_terms($post->ID, 'features')) {
                $taxonomy = get_the_terms($post->ID, 'features');
                foreach ($taxonomy as $taxonomy_term) {
                    ?> <li><?php echo $taxonomy_term->name; ?></li><?php
                }
            }
            ?>
        </ul>
	</div>
    </div>
<div class="tab-pane fade" id="contact">

<?php

    $page = get_posts(
    array(
        'name'      => 'contact-form-tab',
        'post_type' => 'page'
    )
);
if ($page) {
    echo do_shortcode($page[0]->post_content);
}
?>
	<div style="clear:both"></div>
</div>
	<div class="tab-pane fade" id="video">
		<ul class="video">
			<li><?php $video_source = get_post_meta($post->ID, 'video_meta_box_source', true);
$video_id = get_post_meta($post->ID, 'video_meta_box_videoid', true);		if (($video_source == "vimeo") && !empty($video_id)) {
    ?>
			<div class="embed-responsive embed-responsive-16by9">
				<iframe src="https://player.vimeo.com/video/<?php echo $video_id; ?>?title=0&amp;portrait=0&amp;color=e275c7" class="embed-responsive-item" webkitAllowFullScreen allowFullScreen></iframe>
			</div>
			<?php
} elseif (($video_source == "youtube") && !empty($video_id)) {
        ?>
			<div class="embed-responsive embed-responsive-16by9">
				<iframe src="https://www.youtube.com/embed/<?php echo $video_id; ?>" class="embed-responsive-item" allowfullscreen></iframe>
			</div>
			<?php
    } ?>
			</li>
		</ul>
    </div>
    </div>
	<div style="clear: both"></div>
</div>
<?php endwhile; endif; ?>
<div class="col-sm-4 single-sidebar hideOnSearch">
	<span class="info-single">

		<h3 class="price-single">
			<?php get_template_part('assets/template-parts/currencyprice'); ?>
		</h3>
		<div class="buttons-action">

			<a  type="button" class="btn btn-default btn-lg offer" href="mailto:<?php echo get_the_author_meta('user_email');?>?subject=<?php _e('Vehicle information request', 'automotive');?>&body=<?php _e('I would like to request more information about your', 'automotive');echo ' '.$fields['year'] ?> <?php echo get_template_part('assets/template-parts/makemodel').' '.	 __('with Stock Number #', 'automotive'). $fields['stock'];?>">
					<i class="far fa-envelope"></i> <?php _e(get_theme_mod('imt7', 'Request Information'), 'automotive');?>
			</a>
		</div>
			<?php if (! dynamic_sidebar('carsticker')) :  endif;?>
			<?php if (! dynamic_sidebar('carfax')) :  endif;?>
			<?php if (! dynamic_sidebar('nhtsa')) :  endif;?>
	<ul class="quick-list quick-glance hideOnSearch ">
	<li><?php get_template_part('assets/template-parts/location'); ?></li>
				<?php global $user_ID;
                if (get_the_author_meta('phone', $user_ID)  == true) {
                    echo '<li><p>'.__('Phone: ', 'automotive').'</p>'.get_the_author_meta('phone').'</li>';
                } else {
                    echo '';
                }
                if (!empty($fields['miles'])) {
                    echo '<li><p>'.get_theme_mod('miles_text', 'Miles').':</p> '.$fields['miles'].'</li>';
                }
          if (!empty($fields['vehicletype'])) {
              echo '<li><p>'.get_theme_mod('vehicle_type_text', 'Body').':</p> '.$fields['vehicletype'].'</li>';
          }
        if (!empty($fields['drive'])) {
            echo '<li><p>'.get_theme_mod('drive_text', 'Drive').':</p> '.$fields['drive'].'</li>';
        }
        if (!empty($fields['transmission']) && $fields['transmission'] != "None") {
            echo '<li><p>'.get_theme_mod('transmission_text', 'Transmission').':</p> '.$fields['transmission'].'</li>';
        }
        if (!empty($fields['exterior'])) {
            echo '<li><p>'.get_theme_mod('exterior_text', 'Exterior color').':</p> '.$fields['exterior'].'</li>';
        }
                if (!empty($fields['interior'])) {
                    echo '<li><p>'.get_theme_mod('interior_text', 'Interior color').':</p> '.$fields['interior'].'</li>';
                }
                if (!empty($fields['epamileage'])) {
                    echo '<li><p>'.get_theme_mod('epa_mileage_text', 'EPA Mileage').':</p> '.$fields['epamileage'].'</li>';
                }
                if (!empty($fields['stock'])) {
                    echo '<li><p>'.get_theme_mod('stock_text', 'Stock').':</p> '.$fields['stock'].'</li>';
                }
                if (!empty($fields['CityMPG'])) {
                    echo '<li><p>'.get_theme_mod('citympg_text', 'City MPG').':</p> '.$fields['CityMPG'].'</li>';
                }
                if (!empty($fields['HighwayMPG'])) {
                    echo '<li><p>'.get_theme_mod('highwaympg_text', 'Highway MPG').':</p> '.$fields['HighwayMPG'].'</li>';
                }
                if (!empty($fields['VIN'])) {
                    echo '<li><p>'.get_theme_mod('vin_text', 'VIN').':</p> '.$fields['VIN'].'</li>';
                }
                if (!empty($fields['vin'])) {
                    echo '<li><p>'.get_theme_mod('vin_text', 'VIN').':</p> '.$fields['vin'].'</li>';
                }?>
   				<div style="clear: both"></div>
   			</ul>
			<?php if (! dynamic_sidebar('specs')) : ?>
			<?php endif; ?>
				</span>
			</span>
		</div>
	</div>
</div>
<div class="col-sm-3 col-sm-pull-9">
	<?php if (! dynamic_sidebar('search')) : endif; ?>
	<?php if (! dynamic_sidebar('sidebar')) :   endif; ?>
</div>
<div class="col-sm-12">
	<?php if (! dynamic_sidebar('featured')) : endif; ?>
</div>
</div>
<?php get_footer(); ?>

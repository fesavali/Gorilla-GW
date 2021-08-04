<?php

// $options = my_get_theme_options();


$fields = get_post_meta($post->ID, 'mod1', true);  if (get_theme_mod('currency_placement') == 'left'){ echo  get_theme_mod('currency_symbol');get_template_part( 'assets/template-parts/decimalseparator' );} else { echo get_template_part( 'assets/template-parts/decimalseparator' ).' '.get_theme_mod('currency_symbol');}

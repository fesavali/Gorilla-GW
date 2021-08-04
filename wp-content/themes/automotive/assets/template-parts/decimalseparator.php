<?php

// $options = my_get_theme_options();

$fields = get_post_meta($post->ID, 'mod1', true);  if (get_theme_mod('decimal_separator') == 'comma'){ echo  number_format ($fields['price']);} else { echo number_format ($fields['price'],0,',','.');}

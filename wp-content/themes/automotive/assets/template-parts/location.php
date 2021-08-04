<?php global $post,$myparent;
	  $taxonomy = 'location';
	  $terms = wp_get_post_terms( $post->ID, $taxonomy );
	foreach ( $terms as $term ) {
		if ($term->parent != 0)
		{
		$child_term = $term;
		echo ' '.$child_term->name.', ';
		break;
		}
    }
	foreach ( $terms as $term ){
		if ($term->parent == 0){
		$myparent = $term;
		echo ''.$myparent->name;
		break;
		}
	}
?>

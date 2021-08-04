<?php
function cps_add_query_vars($qvars)
{
    $qvars[] = 'searchquery';
    return $qvars;
}
function cps_template_redirect_file()
{
    global $wp_query;
    if ($wp_query->get('searchquery')) {
        if (file_exists(TEMPLATEPATH . '/custom-search.php')) {
            include(TEMPLATEPATH . '/custom-search.php');
            exit;
        }
    }
}
add_filter('query_vars', 'cps_add_query_vars');
add_action('template_redirect', 'cps_template_redirect_file');
    $use_ajax = get_option('cps_use_ajax');
    $options['makemodelhide'] = null;
    $options['featureshide'] = null;
        $array_taxonomy = array( 'makemodel', 'features','location');
        if (($options['makemodelhide']) == 'on') {
            $array_taxonomy = array_diff($array_taxonomy, array('makemodel'));
        }
        if (($options['state_hide']) == 'on') {
            $array_taxonomy = array_diff($array_taxonomy, array('location'));
        }
if (($options['featureshide']) == 'on') {
    $array_taxonomy = array_diff($array_taxonomy, array('features'));
}
        $posts_per_page = get_option('posts_per_page');
        $CPS_OPTIONS = array(
            'meta_boxes_vars' => array($meta_boxes,$feat_boxes),
            'taxonomies' =>  $array_taxonomy,
            'per_page' => get_option('posts_per_page'),
            'use_ajax' => (bool)$use_ajax,
            'price_range' =>  get_theme_mod( 'price_range_text',10000 ),
            'year_range' => 1,
            'post_types' => array('gtcd')
        );
        if (isset($_GET['searchquery'])) {
            $search_query = $_GET['searchquery'];
            $pieces = explode('/', $search_query);
            $new_parts = array();
            foreach ($pieces as $piece) {
                if (!trim($piece)) {
                    continue;
                }
                preg_match('/(?P<key>[^-]+)-(?P<val>.+)/', $piece, $matches);
                if (isset($matches['key']) && isset($matches['val'])) {
                    $_GET[$matches['key']] = $matches['val'];
                }
            }
        }
add_action('wp_ajax_ajax_custom_search', 'cps_ajax_search');
add_action('wp_ajax_nopriv_ajax_custom_search', 'cps_ajax_search');
function cps_search_form()
{
    global $CPS_OPTIONS; ?>
            <form method="post"  id="form_nor" class="advSearch" data-domain="<?php echo get_site_url() ?>" >
                <?php
                cps_display_taxonomy_search_form($CPS_OPTIONS['taxonomies']);
    foreach ($CPS_OPTIONS['meta_boxes_vars'] as $meta_boxes) {
        cps_display_meta_box_search_form($meta_boxes);
    }
    $available_search_types = 2; //1 - both, 2 - only regular, 3 - only instant
    if ($available_search_types == 1) {
    } elseif ($available_search_types == 2) {
        ?>
                    <input type="hidden" name="cps_use_ajax" id="cps_use_ajax" value="1" />
                <?php
    } else {
        ?>
                    <input type="hidden" name="cps_use_ajax" id="cps_use_ajax" value="0" />
                <?php
    } ?>
                 <button type="submit" class="form-button"><i class="fa fa-search"></i> <?php  _e( get_theme_mod('search_button_text','Search'),'automotive'); ?></button>
            </form>
            <?php
}
function cps_load_scripts_and_styles()
{
    global $CPS_OPTIONS;
}
function show_year_dropdown($min, $max, $step = 1)
{
    if ($min > $max || $step < 1) {
        return;
    }

    for ($i = $min; $i <= $max; $i += $step) : ?>

        <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>

    <?php endfor;
}
function show_price_dropdown($min, $max, $step = 1, $currency = '$')
{
    if ($min > $max || $step < 1) {
        return;
    }

    for ($i = $min; $i <= $max; $i += $step) : ?>

        <option value="<?php echo $i; ?>" ><?php echo $currency . number_format($i); ?></option>

    <?php endfor;
} ?>
<?php
        function cps_display_meta_box_search_form($meta_boxes)
        {
            global $CPS_OPTIONS;
            if (is_array($meta_boxes)) {
                foreach ($meta_boxes as $metaBox) {

                  if (isset($metaBox['hide_in_search']) && $metaBox['hide_in_search'] === 'on') {
                      continue;
                  }

                    switch ($metaBox['type']) {
                case 'text':
                case 'textarea':
    ?>
                    <div class="input_text"><label><?php $metaBox['title']; ?></label>
                        <input type="text" name="<?php echo $metaBox['name']; ?>" value="" /></div>
        <?php


    // no break
            case 'year_range':

                    $Range = cps_get_range('_'.$metaBox['name']);
                    if (!isset($Range->min) || !isset($Range->max)) {
                        return;
                    }
                    $formatted = number_format($Range->max);

    ?>
                    <div class="year-dropdowns-container">
                        <div class="year-dropdown-min">
                            <select id="year-dropdown-min">
                                <option value="<?php echo get_theme_mod('year_range_text',1990); ?>"><?php echo get_theme_mod('from_year_text','From: Year');?></option>
                                <?php show_year_dropdown( get_theme_mod('year_range_text',1990), date('Y', strtotime('+1 years')), $CPS_OPTIONS['year_range'], ''); ?>
                            </select>
                        </div>
                        <div class="year-dropdown-max">
                            <select id="year-dropdown-max">
                                <option value="<?php echo get_theme_mod('year_range_text',1990); ?>"><?php echo get_theme_mod('to_year_text','To: Year');?></option>
                                <?php show_year_dropdown(get_theme_mod('year_range_text',1990), date('Y', strtotime('+1 years')), $CPS_OPTIONS['year_range'], ''); ?>
                            </select>
                        </div>
                        <input type="hidden" id="year-dropdown-input" name="<?php echo $metaBox['name']?>" value="" />
                    </div>

                    <script type="text/javascript">
                      jQuery(document).ready(function($){
                        var minDropdown = $('#year-dropdown-min');
                        var maxDropdown = $('#year-dropdown-max');
                        var input = $('#year-dropdown-input');
                        minDropdown.add(maxDropdown).change(function(){
                          input.val(minDropdown.val() + '-' + maxDropdown.val());
                        });
                      });
                    </script>

    <?php


            break;
                case 'range':

                    $Range = cps_get_range('_'.$metaBox['name']);
                    if (!isset($Range->min) || !isset($Range->max)) {
                        return;
                    }
                    $formatted = number_format($Range->max);

    ?>
                    <div class="price-dropdowns-container">
                        <div class="price-dropdown-min">
                            <select id="price-dropdown-min">
                                <option value="<?php echo $Range->min; ?>"><?php echo get_theme_mod('min_price_text','Min Price');?></option>
                                <?php show_price_dropdown($Range->min, $Range->max + $CPS_OPTIONS['price_range'], $CPS_OPTIONS['price_range'], get_theme_mod('currency_symbol','$')); ?>
                            </select>
                        </div>
                        <div class="price-dropdown-max">
                            <select id="price-fdropdown-max">
                                <option value="<?php echo $Range->max; ?>"><?php echo get_theme_mod('max_price_text','Max Price');?></option>
                                <?php show_price_dropdown($Range->min, $Range->max + $CPS_OPTIONS['price_range'], $CPS_OPTIONS['price_range'], get_theme_mod('currency_symbol','$'));  ?>
                            </select>
                        </div>
                        <input type="hidden" id="price-dropdown-input" name="<?php echo $metaBox['name']?>" value="" />
                    </div>

                    <script type="text/javascript">
                      jQuery(document).ready(function($){
                        var minDropdown = $('#price-dropdown-min');
                        var maxDropdown = $('#price-dropdown-max');
                        var input = $('#price-dropdown-input');

                        // minDropdown.val(minDropdown.find("option:first").val());
                        // maxDropdown.val(maxDropdown.find("option:last").val());

                        minDropdown.add(maxDropdown).change(function(){
                          input.val(minDropdown.val() + '-' + maxDropdown.val());
                        });
                      });
                    </script>





        <?php
                break;
                case 'checkbox':
    ?>
                    <div class="checkbox">
                        <label><?php $metaBox['title']; ?></label>
                        <input type="checkbox" name="<?php echo $metaBox['name']?>" value="<?php echo $metaBox['options'][1] ?>" />
                    </div>
    <?php
                break;
                case 'radio':
                    echo '<div class="radio">';
                    foreach ($metaBox['options'] as $radio_value) {
                        echo '<input type="radio" name="'.$metaBox['name'].'" value="'.$radio_value.'" /> <span class="rlabel">'.$radio_value.'</span>';
                    }
                    echo '</div>';
                break;
                case 'dropdown':
                    echo '<div class="drop">';
                    echo '<select  class="'.$metaBox['class'].'" name="'.$metaBox['name'].'">';
                    echo '<option value="">'.$metaBox['title'].'</option>';
                    if (is_array($metaBox['options'])) {
                        foreach ($metaBox['options'] as $dropdown_key => $dropdown_value) {
                            echo '<option class="level-0" value="'.$dropdown_value.'">'.$dropdown_value.'</option>';
                        }
                    }
                    echo '</select></div>';
                break;
            }
          }
            }
        }


function cps_ajax_search($meta_boxes)
{
    $posts = cps_search_posts(); ?>
<div class="top-single-bar">
  <div class="searchSort"> <!-- search sort starts -->
      <div class="sort_each_item"><?php echo get_theme_mod('sort_by_text','Sort By'); ?></div>
      <div  class="sort_filters" id="filt_1">
      <?php cps_sort_by('miles')  ?><span class="sort_seperator hide-for-small">&nbsp;-&nbsp;</span>
      </div>
      <div class="sort_filters" id="filt_2">
      <?php cps_sort_by('year') ?><span class="sort_seperator hide-for-small">&nbsp;-&nbsp;</span>
       </div>
       <div class="sort_filters" id="filt_3">
      <?php cps_sort_by('price') ?>
      </div>
</div>
<script>
    $('#filt_1 .sort_each_item > a').text('<?php echo get_theme_mod('miles_text','Miles'); ?>');
    $('#filt_2 .sort_each_item > a').text('<?php echo get_theme_mod('year_text','Year'); ?>');
    $('#filt_3 .sort_each_item > a').text('<?php echo get_theme_mod('price_text','Price'); ?>');
</script>
<div class="clear"></div>
</div>
<div style="clear:both"></div>
<div class=" hideOnSearch">
<?php wp_reset_postdata(); ?>
<?php $displayed = array();
    if (!empty($posts)): foreach ($posts as $post):
        if (in_array($post->ID, $displayed)):
        continue; else:
        $displayed[] = $post->ID;
    endif; ?>
<?php global $fields, $fields3;
    $fields = get_post_meta($post->ID, 'mod1', true);
        $fields3 = get_post_meta($post->ID, 'mod3', true); ?>
<?php $blogurl = get_bloginfo('template_url'); ?>
<?php $surl = get_bloginfo('url'); ?>
<div class="result-car"> <!-- result car -->
    <div class="row">

<?php
    echo '<div class="col-sm-4 col-results">';
    ?>
    <a class="result-car-link" href="<?php echo get_permalink($post->ID); ?>" rel="bookmark">
    <?php
    echo gorilla_img($post->ID, 'medium');
    ?>
    </a>
    <?php
    if (!empty($fields['statustag']) && $fields['statustag'] != 'None') {
        ?>
                            <div class="status-tag <?php echo $fields['statustag']; ?>"><?php echo $fields['statustag']; ?></div><?php
    } else {
        echo '';
    }
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if ( is_plugin_active( 'gt-carfax-reports/index.php' )
        && isset($fields3['Carfax']) && ($fields3['Carfax'] == 'Yes')):
                ?>
                                    <div class="carfax-results"><a target="_blank" href='http://www.carfax.com/cfm/ccc_DisplayHistoryRpt.cfm?partner=WDB_0&vin=
                                <?php echo $fields['VIN']; ?>'><img src='<?php echo get_bloginfo('template_url'); ?>/assets/images/common/carfax.png'>
                            </a></div><?php  endif;  ?>
    </div>
<div class="col-sm-5 result-detail-wrapper col-results">  <!-- result detail wrapper -->
    <p class="vehicle-name"><span class="mini-hide"><?php if ($fields['year']) {
        echo $fields['year'];
    } else {
        echo '';
    } ?></span> <?php
          $taxonomy = 'makemodel';
    $terms = wp_get_post_terms($post->ID, $taxonomy);
    foreach ($terms as $term) {
        if ($term->parent == 0) {
            $myparent = $term;
            echo ''.$myparent->name.'';
        }
    }
    foreach ($terms as $term) {
        if ($term->parent != 0) {
            $child_term = $term;
            echo ' '.$child_term->name.'';
        }
    } ?>
</p>
    <p class="miles-style"><?php if ($fields['miles']) {
        echo $fields['miles']; echo ' '.get_theme_mod('miles_text','Miles');
    } elseif ($fields['miles'] == '0') {
        echo '0'; echo ' '.get_theme_mod('miles_text','Miles');
    } else {
        echo '';
    } ?></p>
    <p class="car-info"><?php if (isset($fields['transmission'])) {
        echo get_theme_mod('transmission_text','Transmission').': '.$fields['transmission'];
    } else {
        echo '';
    }; ?>
    <?php if (isset($fields['exterior']) &&  (!empty($fields['exterior']))) {
        echo '<span class="mini-hide"> / Color: '.$fields['exterior'].'</span> - ';
        ;
    } else {
        echo '';
    }; ?><?php if (isset($fields['interior'])) {
        echo '<span class="mini-hide">'.$fields['interior'].'</span>';
    } else {
        echo '';
    }; ?><?php if (isset($fields['epamileage'])) {
        echo ', <span class="mini-hide">'.$fields['epamileage'].'</span>';
    } else {
        echo '';
    }; ?></p>
    <p class="title-tag">
        <?php echo wp_trim_words($post->post_content, 26); ?>
</p>
<?php $terms = get_the_term_list( $post->ID, 'features', '<ul class="feat-style"><li>', ',</li><li>', '</li></ul>');
          $max_terms = 4;
          $terms_array = explode( ',', $terms, $max_terms + 1 );
          array_pop( $terms_array );
          $terms = implode( ' ', $terms_array );
          echo strip_tags( $terms,'<ul><li>' );  ?>

    </div> <!--   result detail wrapper ends -->
        <div class="col-sm-3 col-results">
            <div class="inventory-right">
                <p class="price-style results">

          <?php if (get_theme_mod('currency_placement','left') == 'left'){ echo  get_theme_mod('currency_symbol','$'); if (get_theme_mod('decimal_separator','comma') == 'comma'){ echo  number_format ($fields['price']);} else { echo number_format ($fields['price'],0,',','.');}} else { if (get_theme_mod('decimal_separator','comma') == 'comma'){ echo  number_format ($fields['price']);} else { echo number_format ($fields['price'],0,',','.');}; echo ' '.get_theme_mod('currency_symbol','$');}
?>

        </p>
                    <?php    if (!empty($fields['stock'])) {
        echo '<p class="stock-inventory">'.get_theme_mod('stock_text','Stock').' # : '.$fields['stock'].'</p>';
    } else {
        echo '';
    } ?>
                    <p class="location-tag">
                        <?php
                                $taxonomy = 'location';
    $terms = wp_get_post_terms($post->ID, $taxonomy);
    foreach ($terms as $term) {
        if ($term->parent != 0) {
            $child_term = $term;
            echo ' '.$child_term->name.', ';
        }
    }
    foreach ($terms as $term) {
        if ($term->parent == 0) {
            $myparent = $term;
            echo ''.$myparent->name.'';
        }
    } ?>
                </p>
                <?php
if (class_exists('S2F_Comparing_Public')) {
        ?>
<p><a class="btn btn-primary" href="<?php echo get_permalink($post->ID); ?>"><?php _e(get_theme_mod('view_details_text','View Details'), 'automotive'); ?></a></p>

<div class="col-sm-6 button">
<?php
echo do_action('auto_del_child_after_result_buttons', $post->ID); ?></div>
<?php
    } else {
        ?>   <p><a class="btn btn-primary" href="<?php echo get_permalink($post->ID); ?>"><?php _e(get_theme_mod('view_details_text','View Details'), 'automotive'); ?></a></p><?php
    } ?>
        </div>
    </div>
          <div style="clear:both;"></div>
    <!-- </a> -->
    </div>
</div> <!-- result car ends -->
<?php endforeach; else: ?>
    <p style="padding:30px;" class="not-found"><?php _e('Sorry, no listings matched your criteria.', 'automotive'); ?></p>
<?php endif; ?>
            <div class="bottom-pagination"> <!-- Pagination starts -->
                        <p><a id="link" href="#top"><?php _e(get_theme_mod('back_to_top_text','BACK TO TOP'), 'automotive'); ?></a></p>
                        <p class="paging">
                            <?php cps_show_pagination() ?>
                        </p>
                        <div style="clear: both"></div>
                  </div>  <!-- Pagination ends -->
                </div>
    <?php
    exit;
}
function cps_breadcrumbs()
{
    global $CPS_OPTIONS;
    $i = 0;
    $link = isset($_GET['cps_use_ajax']) && $_GET['cps_use_ajax'] ? '#search/' : get_site_url().'/search/';
    if (isset($CPS_OPTIONS['taxonomies']) && !empty($CPS_OPTIONS['taxonomies'])) {
        foreach ($CPS_OPTIONS['taxonomies'] as $taxonomy) {
            if (isset($_GET[$taxonomy]) && trim($_GET[$taxonomy] != '')) {
                $term = get_term_by('name', $_GET[$taxonomy], $taxonomy);
                $ins_par = '';
                $separator = $i ? '<span><strong> &raquo; </strong></span>': '';
                $link .= $i ? '/' : '';
                $child_link = $link . $taxonomy . '-' . $_GET[$taxonomy];
                $ready_link = $child_link . '/';
                if (isset($_GET['cps_use_ajax']) && $_GET['cps_use_ajax']) {
                    $ready_link =  'javascript:manual_hashchange(\'' . urlencode($child_link) . '/\');';
                }
                $parent_term = get_term_by('id', $term->parent, $taxonomy);
                $ins_par .= getAllParentTermsLinks($parent_term, $link, $taxonomy, $ins_par);
                echo $separator . $ins_par .'<a href="' . $ready_link . '">' . $_GET[$taxonomy] . '</a>';
                $i++;
            }
        }
    }
    foreach ($CPS_OPTIONS['meta_boxes_vars'] as $meta_boxes) {
        foreach ($meta_boxes as $metaBox) {
            if (isset($_GET[$metaBox['name']]) && trim($_GET[$metaBox['name']]) != '') {
                $separator = $i ? '<span><strong> &raquo; </strong></span>': '';
                $link .= $i ? '/' : '';
                $link .= $metaBox['name'].'-'.$_GET[$metaBox['name']];
                $ready_link = $link . '/';
                if (isset($_GET['cps_use_ajax']) && $_GET['cps_use_ajax']) {
                    $ready_link =  'javascript:manual_hashchange(\'' . urlencode($link) . '/\');';
                }
                echo "$separator <a href=\"" . $ready_link . "\" class='cps_breadcrumbs'>" . $metaBox['title'] . ': ' .$_GET[$metaBox['name']]."</a>";
                $i++;
            }
        }
    }
}
function getAllParentTermsLinks($parent_term, $link, $taxonomy, $ins_par)
{
    if ($parent_term) {
        $parent_link = $link . $taxonomy . '-' . $parent_term->name;
        $ready_parent_link = $parent_link . '/';
        if (isset($_GET['cps_use_ajax']) && $_GET['cps_use_ajax']) {
            $ready_parent_link =  'javascript:manual_hashchange(\'' . urlencode($parent_link) . '/\');';
        }
        $ins_par = '<a href="' . $ready_parent_link . '">' . $parent_term->name . '</a>->' . $ins_par;
        $another_parent_term = get_term_by('id', $parent_term->parent, $taxonomy);
        return getAllParentTermsLinks($another_parent_term, $link, $taxonomy, $ins_par);
    } else {
        return $ins_par;
    }
}
function cps_get_current_link()
{
    global $CPS_OPTIONS;
    $link = isset($_GET['cps_use_ajax']) && $_GET['cps_use_ajax'] ? '#search/' : get_site_url().'/search/';
    $i = 0;
    if (isset($CPS_OPTIONS['taxonomies']) && !empty($CPS_OPTIONS['taxonomies'])) {
        foreach ($CPS_OPTIONS['taxonomies'] as $taxonomy) {
            if (isset($_GET[$taxonomy]) && trim($_GET[$taxonomy] != '')) {
                $link .= $i ? '/' : '';
                $link .= $taxonomy.'-'.$_GET[$taxonomy];
                $i++;
            }
        }
    }
    foreach ($CPS_OPTIONS['meta_boxes_vars'] as $meta_boxes) {
        foreach ($meta_boxes as $metaBox) {
            if (isset($_GET[$metaBox['name']]) && trim($_GET[$metaBox['name']]) != '') {
                $link .= $i ? '/' : '';
                $link .= $metaBox['name'].'-'.$_GET[$metaBox['name']];
                $i++;
            }
        }
    }
    $link .= $i === 0 ? '' : '/';
    if (isset($_GET['order'])) {
        $link .='order-'.$_GET['order'].'/';
    }
    if (isset($_GET['orderdirection'])) {
        $link .='orderdirection-'.$_GET['orderdirection'].'/';
    }
    return $link;
}

function cps_show_pagination()
{
    global $RES_COUNT;
    global $CPS_OPTIONS;
    $links_count = ceil($RES_COUNT/$CPS_OPTIONS['per_page']);
    if ($links_count<2) {
        return;
    }
    $link = cps_get_current_link();
    if (isset($_GET['page']) && $_GET['page']<=0) {
        $_GET['page'] = 1;
    }
    for ($i=1;$i<=$links_count;$i++) {
        $cur_class = '';
        if (isset($_GET['page']) && $_GET['page'] == $i) {
            $cur_class = 'current';
        }
        if (isset($_GET['cps_use_ajax']) && $_GET['cps_use_ajax']) {
            $ready_link = 'javascript:manual_hashchange("' . urlencode($link) . 'page-' . $i . '/")';
        } else {
            $ready_link = $link . "page-$i/";
        }
        echo "<a href='{$ready_link}' class='convertUrl $cur_class'>$i</a>";
    }
}
function cps_sort_by($field)
{
    global $CPS_OPTIONS;
    $order_asc = null;
    $order_desc = null;
    $bOrderAsc = true;
    $link = isset($_GET['cps_use_ajax']) && $_GET['cps_use_ajax'] ? '#search/' : get_site_url().'/search/';
    $i = 0;

    if (isset($CPS_OPTIONS['taxonomies']) && !empty($CPS_OPTIONS['taxonomies'])) {
        foreach ($CPS_OPTIONS['taxonomies'] as $taxonomy) {
            if (isset($_GET[$taxonomy]) && trim($_GET[$taxonomy] != '')) {
                $link .= $i ? '/' : '';
                $link .= $taxonomy.'-'.$_GET[$taxonomy];
                $i++;
            }
        }
    }
    $cur_meta_box = array();
    foreach ($CPS_OPTIONS['meta_boxes_vars'] as $meta_boxes) {
        if (isset($meta_boxes[$field]['name'])) {
            $cur_meta_box = $meta_boxes;
        }
        if (is_array($meta_boxes)) {
            foreach ($meta_boxes as $metaBox) {
                if (isset($_GET[$metaBox['name']]) && (is_array($_GET[$metaBox['name']]) || trim($_GET[$metaBox['name']]) != '')) {
                    $link .= $i ? '/' : '';
                    if (is_array($_GET[$metaBox['name']])) {
                        foreach ($_GET[$metaBox['name']] as $value) {
                            $link .= urlencode($metaBox['name'] . '[]-' . $value) . '/';
                        }
                        $link = substr($link, 0, -1);
                    } else {
                        $link .= $metaBox['name'].'-'.$_GET[$metaBox['name']];
                    }
                    $i++;
                }
            }
        }
    }
    $link .= $i ? '/' : '';
    $link .= "order-$field";
    if (!isset($_GET['orderdirection']) && isset($_GET['order']) && $_GET['order'] == $cur_meta_box[$field]['name']) {
        $link .= "/orderdirection-desc";
        $bOrderAsc = false;
    }
    if (isset($_GET['order']) && $_GET['order'] == $cur_meta_box[$field]['name']) {
    }
    $link .= '/';
    if (isset($_GET['cps_use_ajax']) && $_GET['cps_use_ajax']) {
        $page_num = isset($_GET['page']) ? $_GET['page'] : 1;
        $link =  'javascript:manual_hashchange(\'' . urlencode($link) .'\');';
    }
    echo "<div class='sort_each_item'><a  href=\"" . $link . "\"> ".ucfirst($cur_meta_box [$field]['name'])."</a>";
    echo "<div class='sorting'>";
    echo "<a href=\"" . $link . "\">".($bOrderAsc ? $order_asc : $order_desc)."</a>";
    echo "</div></div>";
}
function cps_get_terms($taxonomy)
{
    global $wpdb;
    $q = "
            SELECT
                term.name
                FROM {$wpdb->term_taxonomy} tt
                INNER JOIN {$wpdb->terms} term ON term.term_id = tt.term_id
                WHERE taxonomy = '$taxonomy'
        ";
    $result = $wpdb->get_col($q);
    return $result;
}
function cps_get_range($custom_field_key)
{
    global $wpdb;
    $q = "
            SELECT
                MAX(CAST(pm.meta_value AS SIGNED)) AS max,
                MIN(CAST(pm.meta_value AS SIGNED)) AS min
            FROM {$wpdb->postmeta} pm
            WHERE pm.meta_key = '$custom_field_key'
        ";
    $result = $wpdb->get_row($q);
    return $result;
}
function cps_display_taxonomy_search_form($taxonomy_names)
{
    if (get_theme_mod('hide_in_search_state','off') && get_theme_mod('hide_in_search_state','off') == "off") {
        ?>
<script type="text/javascript">
    $(function()
    {
        $('#location').change(function()
        {
            var $mainCat=$('#location :selected').attr('data-value');
            if(!$mainCat){
                $mainCat = $('#location').val();
            }
            // .call ajax
            $("#city").empty();
            $.ajax
            (
            {
                url:"<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php",
                type:'POST',
                data:'action=call_location&main_catid=' + $mainCat,
                success:function(results)
                {
                    options = $(results);
if(options.length > 1){
$("#city").removeAttr("disabled");
} else {
if(!$("#city").is(':disabled')){
$("#city").attr("disabled", "disabled");
}
}
$("#city").append(results);
$("#city").selectBox('destroy');
$("#city").selectBox();
                }
            }
        );
        });
    });
</script>
<?php
 wp_dropdown_categories(array(
    'orderby' => 'name',
    'order'=> 'ASC',
                'show_count' => '0' ,
                'selected' => '1' ,
                'hierarchical' => '1' ,
                'depth' => '1' ,
                'hide_empty' => '1' ,
                'exclude' => '1' ,
                'class' => 'dropdown',
                'show_option_none' => get_theme_mod('state_text','Select State'),
                'option_none_value' => '',
                'name' => 'location' ,
                'taxonomy' => 'location' ,
                'walker' => new Walker_CategoryDropdown_Custom() ,
            )); ?>

<select name="location" id="city"  class="dropdown" disabled="disabled"><option value=""><?php echo get_theme_mod('city_text','City (Select State First)'); ?></option></select>
<?php
    } else {
        echo '';
    } ?>
<?php
if (get_theme_mod('hide_in_search_make','off') && get_theme_mod('hide_in_search_make','off') == "off") {
        ?>
<script type="text/javascript">
    $(function()
    {
        $('#makemodel').change(function()
        {
            var $mainCat=$('#makemodel :selected').attr('data-value');
            if(!$mainCat){
                $mainCat = $('#makemodel').val();
            }
            $("#model").empty();
            $.ajax
            (
            {
                url:"<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php",
                type:'POST',
                data:'action=name_call&main_catid=' + $mainCat,
                success:function(results)
                {
                    options = $(results);
if(options.length > 1){
$("#model").removeAttr("disabled");
} else {
if(!$("#model").is(':disabled')){
$("#model").attr("disabled", "disabled");
}
}
$("#model").append(results);
$("#model").selectBox('destroy');
$("#model").selectBox();
                }
            }
        );
        });
    });
</script>
<?php
 wp_dropdown_categories(array(

                'orderby' => 'name',
                'order'=> 'ASC',
                'show_count' => '0' ,
                'selected' => '1' ,
                'hierarchical' => '1' ,
                'depth' => '1' ,
                'hide_empty' => '0' ,
                'exclude' => '1' ,
                'class' => 'dropdown',
                'show_option_none' =>  get_theme_mod('make_text','All Makes'),
                'option_none_value' =>  '',
                'name' => 'makemodel' ,
                'taxonomy' => 'makemodel' ,
                'walker' => new Walker_CategoryDropdown_Custom() ,
            )); ?>
<select name="makemodel" id="model"  class="dropdown" disabled="disabled"><option value=""><?php echo get_theme_mod('model_text','Model (Select Make First)'); ?></option></select>
<?php
    } else {
        echo '';
    } ?>
<?php
}
function generate_dropdown_options($hTerm)
{
    if (is_array($hTerm)) {
        foreach ($hTerm as $tChild) {
            echo '<option value="'.trim($tChild->name).'">'.$tChild->title.'</option>';
        }
    } else {
        echo '<option value="'.trim($hTerm->name).'">&raquo;'.$hTerm->title.'</option>';
    }
}
    $RES_COUNT = 0;
function cps_search_posts()
{
    global $CPS_OPTIONS;
    global $wpdb;
    $join  = '';
    $where = '';
    $order = '';
    $joinedMeta = array();
    $i = 0;
    foreach ($CPS_OPTIONS['meta_boxes_vars'] as $meta_boxes) {
        if (is_array($meta_boxes)) {
            foreach ($meta_boxes as $metaBox) {
                $mb_name = $metaBox['name'];
                if (isset($_GET[$mb_name]) && trim($_GET[$mb_name]) != '') {
                    $join .= " JOIN $wpdb->postmeta meta$i
                ON meta$i.post_id = p.ID
                AND meta$i.meta_key = '_$mb_name' ";
                    if ($metaBox['type'] === 'range') {
                        $pieces = explode('-', $_GET[$mb_name]);
                        $where .= " AND meta$i.meta_value BETWEEN $pieces[0]+0 AND $pieces[1]+0 ";
                    } else {
                        $where .= " AND meta$i.meta_value = '{$_GET[$mb_name]}' ";
                    }
                    $joinedMeta["meta$i"] = $mb_name;
                    if (isset($_GET["order"])) {
                        if ($_GET["order"] === $mb_name) {
                            $asc = isset($_GET["orderdirection"]) ? $_GET["orderdirection"] : 'ASC';
                            $order .= " meta$i.meta_value $asc ";
                        }
                    }
                    $i++;
                } else {
                    if (isset($_GET["order"])) {
                        if ($_GET["order"] === $mb_name) {
                            $asc = isset($_GET["orderdirection"]) ? $_GET["orderdirection"] : 'ASC';
                            $join .= " LEFT JOIN $wpdb->postmeta meta$i
                ON meta$i.post_id = p.ID
                AND meta$i.meta_key = '_$mb_name' ";
                            if ($mb_name == 'price') {
                                $order .= " meta$i.meta_value+0 $asc ";
                            } else {
                                $order .= " meta$i.meta_value+0 $asc ";
                            }
                            $i++;
                        }
                    }
                }
            }
        }
    }
    $is_search_by_tax = false;
    if (isset($CPS_OPTIONS['taxonomies']) && !empty($CPS_OPTIONS['taxonomies'])) {
        foreach ($CPS_OPTIONS['taxonomies'] as $taxonomy) {
            if (isset($_GET[$taxonomy]) && trim($_GET[$taxonomy] != '')) {
                $sAlias = preg_replace('#\W#', '_', $_GET[$taxonomy]);
                $is_search_by_tax = true;
                $where .= " AND terms_" .$sAlias . ".name = '{$_GET[$taxonomy]}' ";
                $join .= "
             JOIN $wpdb->term_relationships tr_" .$sAlias . " ON tr_" .$sAlias . ".object_id = p.ID
             JOIN $wpdb->term_taxonomy tt_" .$sAlias . " ON tr_" .$sAlias . ".term_taxonomy_id = tt_" .$sAlias . ".term_taxonomy_id
             JOIN $wpdb->terms terms_" .$sAlias . " ON terms_" .$sAlias . ".term_id = tt_" .$sAlias . ".term_id
          ";
            }
        }
    }
    $page_num = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page_num <= 0) {
        $page_num = 1;
    }
    $from = $CPS_OPTIONS['per_page']*($page_num-1);
    $count = $CPS_OPTIONS['per_page'];
    $order_by = '';
    if (!empty($order)) {
        $order_by = "ORDER BY ".rtrim($order, ',');
    }
    if (isset($asc)) {
        $asc = isset($_GET["orderdirection"]) ? $_GET["orderdirection"] : 'DESC';
    }
    $in_posts = implode("','", $CPS_OPTIONS['post_types']);
    global $wpdb;
    $main_query = "SELECT p.* FROM {$wpdb->base_prefix}posts p WHERE p.post_status = 'publish' AND p.post_type IN ('$in_posts') ORDER BY p.ID DESC LIMIT $from, $count";
    $sub_query = "SELECT * FROM ($main_query) p $join $where $order_by";
    if ($join && $order_by) {
        $new_query=$sub_query;
    } else {
        $new_query=$main_query;
        $asc = isset($_GET["orderdirection"]) ? $_GET["orderdirection"] : 'DESC';
        $order_by = "ORDER BY p.post_date $asc";
    }
    $query = "
            SELECT
            p.*
            FROM {$wpdb->base_prefix}posts p
            INNER
            JOIN {$wpdb->base_prefix}postmeta pm
            ON pm.post_id = p.ID
            $join
            WHERE p.post_status = 'publish' AND pm.meta_key = '_year'
            -- Only custom posts:
            AND p.post_type IN ('$in_posts')
            $where
            $order_by
            LIMIT $from, $count";
    global $RES_COUNT,$wpdb;
    $RES_COUNT = $wpdb->get_var("
            SELECT
            count(p.ID)
            FROM {$wpdb->base_prefix}posts p
            $join
            WHERE p.post_status = 'publish'
             -- Only custom posts:
            AND p.post_type IN ('$in_posts')
            $where
            ");
    $old_style=2;
    if ($old_style >= 1) {
        return $wpdb->get_results($query);
    }
    return $wpdb->get_results($new_query);
}
function cps_ajax_search_results()
{
    echo "<div id='cps_ajax_search_results' class='col-sm-12'></div>";
}
function cps_ajax_search_results_single()
{
    echo "<div id='cps_ajax_search_results' class='col-sm-9 col-sm-push-3'></div>";
}
?>

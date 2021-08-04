<?php
function Automotive_Customize_register($wp_customize)
{
    $wp_customize->remove_section('static_front_page');
    $wp_customize->get_section('colors')->title = __('Automotive Colors');
    $wp_customize->get_section('header_image')->title = __('Automotive Header Image');
    $wp_customize->get_section('title_tagline')->title = __('Automotive Logo');
    $wp_customize->get_section('background_image')->title = __('Automotive Background');
}
add_action('customize_register', 'automotive_customize_register', 50);

class Automotive_Customize
{
    public static function register($wp_customize)
    {
        $wp_customize->add_setting(
         'logo_text_color',
        array(
           'default' => '#fff',
           'sanitize_callback' => 'sanitize_hex_color',
           'type' => 'theme_mod',
           'capability' => 'edit_theme_options',
           'transport' => 'postMessage',
        )
     );
        $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'mytheme_logo_text_color',
        array(
           'label' => __('Logo', 'automotive'),
           'section' => 'colors',
           'description' =>  __('Text Color', 'automotive'),
           'settings' => 'logo_text_color',
           'priority' => 1,
        )
     ));
        $wp_customize->add_setting(
         'menu_background_hover',
         array(
            'default' => '#ae2b2e',
            'sanitize_callback' => 'sanitize_hex_color',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
         )
      );
        $wp_customize->add_control(new WP_Customize_Color_Control(
         $wp_customize,
         'mytheme_menu_back_color_hover',
         array(
            'label' => __('Menu Hover/Active', 'automotive'),
            'description' => __('Menu background hover/active color.', 'automotive'),
            'section' => 'colors',
            'settings' => 'menu_background_hover',
            'priority' => 2,
         )
      ));
        $wp_customize->add_setting(
          'headers_color',
         array(
            'default' => '#ae2b2e',
            'sanitize_callback' => 'sanitize_hex_color',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
         )
      );
        $wp_customize->add_control(new WP_Customize_Color_Control(
         $wp_customize,
         'mytheme_headers_color',
         array(
            'label' => __('Header Color', 'automotive'),
            'section' => 'colors',
            'description' => __('Widgets header background color.', 'automotive'),
            'settings' => 'headers_color',
            'priority' => 3,
         )
      ));
        $wp_customize->add_setting(
          'headers_text_color',
         array(
            'default' => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
         )
      );
        $wp_customize->add_control(new WP_Customize_Color_Control(
         $wp_customize,
         'mytheme_header_text_color',
         array(
            'label' => __('Widgets Header Color', 'automotive'),
            'section' => 'colors',
            'description' => __('Widgets header text color.', 'automotive'),
            'settings' => 'headers_text_color',
            'priority' => 4,
         )
      ));
        $wp_customize->add_setting(
          'buttons_background_color',
         array(
            'default' => '#ae2b2e',
            'sanitize_callback' => 'sanitize_hex_color',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
         )
      );
        $wp_customize->add_control(new WP_Customize_Color_Control(
         $wp_customize,
         'mytheme_buttons_background_color',
         array(
            'label' => __('Buttons', 'automotive'),
            'section' => 'colors',
            'description' =>  __('Buttons background color', 'automotive'),
            'settings' => 'buttons_background_color',
            'priority' => 5,
         )
      ));
    }
    public static function header_output()
    {
        ?>
    <style type="text/css">
        <?php self::generate_css('a.learn-more,#footer h3,.footer h3,.side-widget h3 a,.side-widget h3,.nav.nav-tabs li.active a,.col-sm-9 .title h1', 'color', 'headers_text_color'); ?>
        <?php self::generate_css('.selectBox.dropdown .selectBox-label:hover', 'color', 'search_color_hover'); ?>
        <?php self::generate_css('.site-title a,.site-description', 'color', 'logo_text_color'); ?>
        <?php self::generate_css('.featured-bottom h3,.container-fluid.footer h3,.tricol-product-list h2,a.dropdown-toggle:focus,button.navbar-toggle.menu:hover,button.navbar-toggle.search:hover,#footer h3,.container-fluid.footer h3,#respond #submit-comment,.side-widget h3,p.contact-submit input.pushbutton-wide', 'background', 'headers_color'); ?>
    <?php self::generate_css('.nav.navbar-nav li a', 'color', 'menu_text_color'); ?>
    <?php self::generate_css('.inventory-right .btn-primary,.search-button,.detail-btn,.form-button,.btn-lg.offer,.btn-primary', 'background', 'buttons_background_color'); ?>
        <?php self::generate_css('a.more-link,', 'color', 'headers_color'); ?>
    <?php self::generate_css('nav#menu .active a,nav#menu a:hover', 'background', 'menu_background_hover'); ?>
    </style>
  <?php
    }
    public static function live_preview()
    {
        wp_enqueue_script(
           'mytheme-themecustomizer',
              get_template_directory_uri().'/assets/customizer/live.js',
           array(  'jquery', 'customize-preview' ),
           '',
           true
      );
    }
    public static function generate_css($selector, $style, $mod_name, $prefix='', $postfix='', $echo=true)
    {
        $return = '';
        $mod = get_theme_mod($mod_name);
        if (! empty($mod)) {
            $return = sprintf(
             '%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
            if ($echo) {
                echo $return;
            }
        }
        return $return;
    }
}
add_action('customize_register', array( 'Automotive_Customize' , 'register' ));
add_action('wp_head', array( 'Automotive_Customize' , 'header_output' ));
add_action('customize_preview_init', array( 'Automotive_Customize' , 'live_preview' ));
function extend_customizer($wp_customize)
{
    $wp_customize->add_section('find_by_section', array(
    'title'       => __('Find By Vehicle Type', 'automotive'),
    'priority'    => 15,
    'panel' => 'panel2',
    'description' => 'Upload a to replace the default site name and description in the header',
));
    $wp_customize->add_setting('image_one');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_one', array(
    'label'    => __('Image 1', 'automotive'),
    'section'  => 'find_by_section',
    'settings' => 'image_one',
)));
    $wp_customize->add_setting('car_link_one', array(
  'default' => 'Add vehicle type name here',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('car_link_one', array(
  'type' => 'text',
  'section' => 'find_by_section',
  'label' => __('Name'),
  'description' => __('Vehicle Type'),
));
    $wp_customize->add_setting('image_two');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_two', array(
    'label'    => __('Image 2', 'automotive'),
    'section'  => 'find_by_section',
    'settings' => 'image_two',
)));
    $wp_customize->add_setting('car_link_two', array(
  'default' => 'Add vehicle type name here',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('car_link_two', array(
  'type' => 'text',
  'section' => 'find_by_section',
  'label' => __('Name'),
  'description' => __('Vehicle Type'),
));
    $wp_customize->add_setting('image_three');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_three', array(
    'label'    => __('Image 3', 'automotive'),
    'section'  => 'find_by_section',
    'settings' => 'image_three',
)));
    $wp_customize->add_setting('car_link_three', array(
  'default' => 'Add vehicle type name here',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('car_link_three', array(
  'type' => 'text',
  'section' => 'find_by_section',
  'label' => __('Name'),
  'description' => __('Vehicle Type'),
));
    $wp_customize->add_setting('image_four');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_four', array(
    'label'    => __('Image 4', 'automotive'),
    'section'  => 'find_by_section',
    'settings' => 'image_four',
)));
    $wp_customize->add_setting('car_link_four', array(
  'default' => 'Add vehicle type name here',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('car_link_four', array(
  'type' => 'text',
  'section' => 'find_by_section',
  'label' => __('Name'),
  'description' => __('Vehicle Type'),
));
    $wp_customize->add_setting('image_five');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_five', array(
    'label'    => __('Image 5', 'automotive'),
    'section'  => 'find_by_section',
    'settings' => 'image_five',
)));
    $wp_customize->add_setting('car_link_five', array(
  'default' => 'Add vehicle type name here',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('car_link_five', array(
  'type' => 'text',
  'section' => 'find_by_section',
  'label' => __('Name'),
  'description' => __('Vehicle Type'),
));
    $wp_customize->add_setting('image_six');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_six', array(
    'label'    => __('Image 6', 'automotive'),
    'section'  => 'find_by_section',
    'settings' => 'image_six',
)));
    $wp_customize->add_setting('car_link_six', array(
  'default' => 'Add vehicle type name here',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('car_link_six', array(
  'type' => 'text',
  'section' => 'find_by_section',
  'label' => __('Name'),
  'description' => __('Vehicle Type'),
));
$wp_customize->add_setting('image_seven');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_seven', array(
'label'    => __('Image 7', 'automotive'),
'section'  => 'find_by_section',
'settings' => 'image_seven',
)));
$wp_customize->add_setting('car_link_seven', array(
'default' => 'Add vehicle type name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_link_seven', array(
'type' => 'text',
'section' => 'find_by_section',
'label' => __('Name'),
'description' => __('Vehicle Type'),
));
$wp_customize->add_setting('image_eight');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_eight', array(
'label'    => __('Image 8', 'automotive'),
'section'  => 'find_by_section',
'settings' => 'image_eight',
)));
$wp_customize->add_setting('car_link_eight', array(
'default' => 'Add vehicle type name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_link_eight', array(
'type' => 'text',
'section' => 'find_by_section',
'label' => __('Name'),
'description' => __('Vehicle Type'),
));
$wp_customize->add_setting('image_nine');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_nine', array(
'label'    => __('Image 9', 'automotive'),
'section'  => 'find_by_section',
'settings' => 'image_nine',
)));
$wp_customize->add_setting('car_link_nine', array(
'default' => 'Add vehicle type name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_link_nine', array(
'type' => 'text',
'section' => 'find_by_section',
'label' => __('Name'),
'description' => __('Vehicle Type'),
));
$wp_customize->add_setting('image_ten');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_ten', array(
'label'    => __('Image 10', 'automotive'),
'section'  => 'find_by_section',
'settings' => 'image_ten',
)));
$wp_customize->add_setting('car_link_ten', array(
'default' => 'Add vehicle type name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_link_ten', array(
'type' => 'text',
'section' => 'find_by_section',
'label' => __('Name'),
'description' => __('Vehicle Type'),
));
$wp_customize->add_setting('image_eleven');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_eleven', array(
'label'    => __('Image 11', 'automotive'),
'section'  => 'find_by_section',
'settings' => 'image_eleven',
)));
$wp_customize->add_setting('car_link_eleven', array(
'default' => 'Add vehicle type name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_link_eleven', array(
'type' => 'text',
'section' => 'find_by_section',
'label' => __('Name'),
'description' => __('Vehicle Type'),
));
$wp_customize->add_setting('image_twelve');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_twelve', array(
'label'    => __('Image 12', 'automotive'),
'section'  => 'find_by_section',
'settings' => 'image_twelve',
)));
$wp_customize->add_setting('car_link_twelve', array(
'default' => 'Add vehicle type name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_link_twelve', array(
'type' => 'text',
'section' => 'find_by_section',
'label' => __('Name'),
'description' => __('Vehicle Type'),
));



$wp_customize->add_section('find_by_make_section', array(
  'title'       => __('Find By Make', 'automotive'),
  'priority'    => 15,
  'panel' => 'panel2',
  'description' => 'Upload Car manufacturer logos',
));
$wp_customize->add_setting('image_make_one');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_make_one', array(
  'label'    => __('Image 1', 'automotive'),
  'section'  => 'find_by_make_section',
  'settings' => 'image_make_one',
)));
$wp_customize->add_setting('car_make_one', array(
'default' => 'Add car manufacturer name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_make_one', array(
'type' => 'text',
'section' => 'find_by_make_section',
'label' => __('Name'),
'description' => __('Car manufacturer name'),
));
$wp_customize->add_setting('image_make_two');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_make_two', array(
'label'    => __('Image 2', 'automotive'),
'section'  => 'find_by_make_section',
'settings' => 'image_make_two',
)));
$wp_customize->add_setting('car_make_two', array(
'default' => 'Add car manufacturer name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_make_two', array(
'type' => 'text',
'section' => 'find_by_make_section',
'label' => __('Name'),
'description' => __('Car manufacturer name'),
));
$wp_customize->add_setting('image_make_three');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_make_three', array(
'label'    => __('Image 3', 'automotive'),
'section'  => 'find_by_make_section',
'settings' => 'image_make_three',
)));
$wp_customize->add_setting('car_make_three', array(
'default' => 'Add car manufacturer name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_make_three', array(
'type' => 'text',
'section' => 'find_by_make_section',
'label' => __('Name'),
'description' => __('Car manufacturer name'),
));
$wp_customize->add_setting('image_make_four');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_make_four', array(
'label'    => __('Image 4', 'automotive'),
'section'  => 'find_by_make_section',
'settings' => 'image_make_four',
)));
$wp_customize->add_setting('car_make_four', array(
'default' => 'Add car manufacturer name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_make_four', array(
'type' => 'text',
'section' => 'find_by_make_section',
'label' => __('Name'),
'description' => __('Car manufacturer name'),
));
$wp_customize->add_setting('image_make_five');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_make_five', array(
'label'    => __('Image 5', 'automotive'),
'section'  => 'find_by_make_section',
'settings' => 'image_make_five',
)));
$wp_customize->add_setting('car_make_five', array(
'default' => 'Add car manufacturer name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_make_five', array(
'type' => 'text',
'section' => 'find_by_make_section',
'label' => __('Name'),
'description' => __('Car manufacturer name'),
));
$wp_customize->add_setting('image_make_six');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_make_six', array(
'label'    => __('Image 6', 'automotive'),
'section'  => 'find_by_make_section',
'settings' => 'image_make_six',
)));
$wp_customize->add_setting('car_make_six', array(
'default' => 'Add car manufacturer name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_make_six', array(
'type' => 'text',
'section' => 'find_by_make_section',
'label' => __('Name'),
'description' => __('Car manufacturer name'),
));
$wp_customize->add_setting('image_make_seven');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_make_seven', array(
'label'    => __('Image 7', 'automotive'),
'section'  => 'find_by_make_section',
'settings' => 'image_make_seven',
)));
$wp_customize->add_setting('car_make_seven', array(
'default' => 'Add car manufacturer name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_make_seven', array(
'type' => 'text',
'section' => 'find_by_make_section',
'label' => __('Name'),
'description' => __('Car manufacturer name'),
));
$wp_customize->add_setting('image_make_eight');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_make_eight', array(
'label'    => __('Image 8', 'automotive'),
'section'  => 'find_by_make_section',
'settings' => 'image_make_eight',
)));
$wp_customize->add_setting('car_make_eight', array(
'default' => 'Add car manufacturer name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_make_eight', array(
'type' => 'text',
'section' => 'find_by_make_section',
'label' => __('Name'),
'description' => __('Car manufacturer name'),
));
$wp_customize->add_setting('image_make_nine');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_make_nine', array(
'label'    => __('Image 9', 'automotive'),
'section'  => 'find_by_make_section',
'settings' => 'image_make_nine',
)));
$wp_customize->add_setting('car_make_nine', array(
'default' => 'Add car manufacturer name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_make_nine', array(
'type' => 'text',
'section' => 'find_by_make_section',
'label' => __('Name'),
'description' => __('Car manufacturer name'),
));
$wp_customize->add_setting('image_make_ten');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_make_ten', array(
'label'    => __('Image 10', 'automotive'),
'section'  => 'find_by_make_section',
'settings' => 'image_make_ten',
)));
$wp_customize->add_setting('car_make_ten', array(
'default' => 'Add car manufacturer name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_make_ten', array(
'type' => 'text',
'section' => 'find_by_make_section',
'label' => __('Name'),
'description' => __('Car manufacturer name'),
));
$wp_customize->add_setting('image_make_eleven');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_make_eleven', array(
'label'    => __('Image 11', 'automotive'),
'section'  => 'find_by_make_section',
'settings' => 'image_make_eleven',
)));
$wp_customize->add_setting('car_make_eleven', array(
'default' => 'Add car manufacturer name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_make_eleven', array(
'type' => 'text',
'section' => 'find_by_make_section',
'label' => __('Name'),
'description' => __('Car manufacturer name'),
));
$wp_customize->add_setting('image_make_twelve');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_make_twelve', array(
'label'    => __('Image 12', 'automotive'),
'section'  => 'find_by_make_section',
'settings' => 'image_make_twelve',
)));
$wp_customize->add_setting('car_make_twelve', array(
'default' => 'Add car manufacturer name here',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('car_make_twelve', array(
'type' => 'text',
'section' => 'find_by_make_section',
'label' => __('Name'),
'description' => __('Car manufacturer name'),
));

    $wp_customize->add_panel('panel1', array(
    'title'=>'Automotive Window Sticker',
    'description'=> 'Theme Customzation',
    'priority'=> 62,
));

    $wp_customize->add_section('section1', array(
    'title'=>'Financing text',
    'priority'=>10,
    'panel'=>'panel1',
));

    $wp_customize->add_setting('text1', array(
  'default' => 'Add financing text here',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('text1', array(
  'type' => 'text',
  'section' => 'section1',
  'label' => __('Financing tagline'),

));
    $wp_customize->add_section('sthours', array(
    'title'=>'Store Hours',
    'priority'=>10,
    'panel'=>'panel1',
));
    $wp_customize->add_setting('day1_time', array(
  'default' => '9:00am - 5:00pm',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('day1_time', array(
  'type' => 'text',
  'section' => 'sthours',
  'label' => __('Monday'),

));
    $wp_customize->add_setting('day2_time', array(
  'default' => '9:00am - 5:00pm',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('day2_time', array(
  'type' => 'text',
  'section' => 'sthours',
  'label' => __('Tuesday'),

));
    $wp_customize->add_setting('day3__time', array(
  'default' => '9:00am - 5:00pm',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('day3_time', array(
  'type' => 'text',
  'section' => 'sthours',
  'label' => __('Wednesday'),

));
    $wp_customize->add_setting('day4_time', array(
  'default' => '9:00am - 5:00pm',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('day4_time', array(
  'type' => 'text',
  'section' => 'sthours',
  'label' => __('Thursday'),

));
    $wp_customize->add_setting('day5_time', array(
  'default' => '9:00am - 5:00pm',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('day5_time', array(
  'type' => 'text',
  'section' => 'sthours',
  'label' => __('Friday'),

));
    $wp_customize->add_setting('day6_time', array(
  'default' => '10:00am - 2:00pm',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('day6_time', array(
  'type' => 'text',
  'section' => 'sthours',
  'label' => __('Saturday'),

));
    $wp_customize->add_setting('day7_time', array(
  'default' => 'Closed',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('day7_time', array(
  'type' => 'text',
  'section' => 'sthours',
  'label' => __('Sunday'),

));
    // $wp_customize->add_setting( 'line-control', array() );
//
    // $wp_customize->add_control( new Prefix_Separator_Control( $wp_customize, 'line-control', array(
    //  'section' => 'section1',
//
    // ) ) );
    $wp_customize->add_section('stwebsite', array(
        'title'=>'Website Address',
        'priority'=>10,
        'panel'=>'panel1',
    ));
        $wp_customize->add_setting('stwebsite_text', array(
      'default' => 'www.gorillathemes.com',
      'sanitize_callback' => 'sanitize_text_field',
    ));
        $wp_customize->add_control('stwebsite_text', array(
      'type' => 'text',
      'section' => 'stwebsite',
      'label' => __('Website Address'),
    
    ));
    $wp_customize->add_section('baddress', array(
    'title'=>'Dealership Address',
    'priority'=>10,
    'panel'=>'panel1',
));
    $wp_customize->add_setting('baddress_text', array(
  'default' => '601 Biscayne Blvd, Miami, FL 10001',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('baddress_text', array(
  'type' => 'text',
  'section' => 'baddress',
  'label' => __('Address'),

));



    $wp_customize->add_section('cwsphone', array(
    'title'=>'Phone Number',
    'priority'=>10,
    'panel'=>'panel1',
));
    $wp_customize->add_setting('cwsphone_text', array(
  'default' => '1800-888-0000',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('cwsphone_text', array(
  'type' => 'text',
  'section' => 'cwsphone',
  'label' => __('Phone number'),

));

    $wp_customize->add_section('cwsfootnote', array(
    'title'=>'Legal (footnotes)',
    'priority'=>10,
    'panel'=>'panel1',
));
    $wp_customize->add_setting('cwsfootnotes_text', array(
  'default' => '**Values displayed are estimates for illustrative purposes only and do not constitute a request for specific credit terms or an offer of credit. Pre-qualification application is to determine estimated credit terms on the vehicle you select and is subject to credit approval and availability. Tax, title, and tags vary by state and will be calculated at the time of purchase. APRs and terms used in estimates may not be applicable based on vehicle and state of purchase.',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('cwsfootnotes_text', array(
  'type' => 'textarea',
  'section' => 'cwsfootnote',
  'label' => __('Legal'),

));


    $wp_customize->add_panel('panel2', array(
    'title'=>'Automotive General Setup',
    'description'=> 'Theme Customization',
    'priority'=> 11,
));

    $wp_customize->add_section('gapi', array(
    'title'=>'Google Maps API Key',
    'priority'=>11,
    'panel'=>'panel2',
));
    $wp_customize->add_setting('gapi_text', array(
  'default' => 'Enter API key here.',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('gapi_text', array(
  'type' => 'text',
  'section' => 'gapi',
  'label' => __('API Key'),

));
$wp_customize->add_section('calculator', array(
'title'=>'Payment Calculator',
'priority'=>11,
'panel'=>'panel2',
));
$wp_customize->add_setting('interest_rate', array(
'default' => '2.5',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('interest_rate', array(
'type' => 'text',
'section' => 'calculator',
'label' => __('Interest Rate (%)'),
));
$wp_customize->add_setting('loan_term', array(
'default' => '5',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('loan_term', array(
'type' => 'text',
'section' => 'calculator',
'label' => __('Term (years)'),
));
$wp_customize->add_setting('purchase_price_text', array(
'default' => 'Purchase price text',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('purchase_price_text', array(
'type' => 'text',
'section' => 'calculator',
'label' => __('Purchase Price'),
));
$wp_customize->add_setting('down_payment_text', array(
'default' => 'Down payment text',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('down_payment_text', array(
'type' => 'text',
'section' => 'calculator',
'label' => __('Down Payment'),
));
$wp_customize->add_setting('interest_rate_text', array(
'default' => 'Interest rate text',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('interest_rate_text', array(
'type' => 'text',
'section' => 'calculator',
'label' => __('Interest Rate'),
));
$wp_customize->add_setting('loan_term_text', array(
'default' => 'Loan term text',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('loan_term_text', array(
'type' => 'text',
'section' => 'calculator',
'label' => __('Loan Term'),
));
$wp_customize->add_setting('monthly_payment_text', array(
'default' => 'Monthly payment text',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('monthly_payment_text', array(
'type' => 'text',
'section' => 'calculator',
'label' => __('Monthly Payment'),
));
$wp_customize->add_section('currency_metrics', array(
'title'=>'Currency & Metrics',
'priority'=>12,
'panel'=>'panel2',
));
$wp_customize->add_section('price_range', array(
'title'=>'Price Range',
'priority'=>12,
'panel'=>'panel2',
));
$wp_customize->add_setting('price_range_text', array(
  'default' => 10000,
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('price_range_text', array(
  'type' => 'text',
  'section' => 'price_range',
  'label' => __('Enter Price Range for Search Module without currency symbol.'),

));
$wp_customize->add_section('year_range', array(
'title'=>'Year Range',
'priority'=>12,
'panel'=>'panel2',
));
    $wp_customize->add_setting('year_range_text', array(
  'default' => 1990,
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('year_range_text', array(
  'type' => 'text',
  'section' => 'year_range',
  'label' => __('Enter starting year search module year range search.'),

));
    $wp_customize->add_setting('currency_symbol', array(
  'default' => '$',
  'sanitize_callback' => 'sanitize_text_field',
));
    $wp_customize->add_control('currency_symbol', array(
  'type' => 'text',
  'section' => 'currency_metrics',
  'label' => __('Enter the currency for you country'),

));

    $wp_customize->add_setting(
    'currency_placement',
    array(
        'default' => 'left',
    )
);

    $wp_customize->add_control(
    'currency_placement',
    array(
        'type' => 'radio',
        'label' => 'Currency symbol placement',
        'section' => 'currency_metrics',
        'choices' => array(
          'left' =>  'Left',
          'right' => 'Right',
        ),
    )
);


    function sanitize_currency_placement($input)
    {
        $valid = array(
      'left' =>  'Left',
      'right' => 'Right',
    );

        if (array_key_exists($input, $valid)) {
            return $input;
        } else {
            return '';
        }
    }
    $wp_customize->add_setting(
    'decimal_separator',
    array(
        'default' => 'comma',
    )
);

    $wp_customize->add_control(
    'decimal_separator',
    array(
        'type' => 'radio',
        'label' => 'Decimal Separator',
        'section' => 'currency_metrics',
        'choices' => array(
          'comma' =>  'Comma',
          'dot' => 'Dot',
        ),
    )
);


    function sanitize_decimal_separator($input)
    {
        $valid = array(
      'comma' =>  'Comma',
      'dot' => 'Dot',
    );

        if (array_key_exists($input, $valid)) {
            return $input;
        } else {
            return '';
        }
    }





//
    // $wp_customize->add_setting(
//     'currency_position'
    // );
    // $wp_customize->add_control(
//     'currency_position',
//     array(
//         'type' => 'checkbox',
//         'label' => 'Swtich currency position',
//         'section' => 'currency_metrics',
//     )
    // );

    // $wp_customize->add_section('vehicle_type_list',array(
//     'title'=>'Vehicle Type List',
//     'priority'=>11,
//     'panel'=>'panel2',
    // ));
//
    // $wp_customize->add_setting( 'vehicle_type_list', array(
//    'sanitize_callback' => 'vehicle_type_list_sanitize'
    // ));
    // $wp_customize->add_control( new Customizer_Repeater( $wp_customize, 'vehicle_type_list', array(
    // 'label'   => esc_html__('Enter Vehicle Type','automotive'),
    // 'section' => 'vehicle_type_list',
    // 'priority' => 1,
//     // 'customizer_repeater_title_control' => true,
    // 'vehicle_type_list_text_control' => true,
//
    // ) ) );

    $wp_customize->add_section('vehicle_type_list', array(
    'title'=>'Vehicle Type List',
    'priority'=>11,
    'panel'=>'panel2',
 ));


    $wp_customize->add_setting('vtype_repeater', array(
        'sanitize_callback' => 'customizer_repeater_sanitize'
     ));

    $wp_customize->add_control(new Customizer_Repeater($wp_customize, 'vtype_repeater', array(
  'label'   => esc_html__('Enter Vehicle Type', 'automotive'),
 'section' => 'vehicle_type_list',
 'priority' => 2,
 'customizer_repeater_text_control' => true,
)));


$wp_customize->add_section('transmission_list', array(
'title'=>'Transmission List',
'priority'=>11,
'panel'=>'panel2',
));


$wp_customize->add_setting('transmission_repeater', array(
    'sanitize_callback' => 'customizer_repeater_sanitize'
 ));

$wp_customize->add_control(new Customizer_Repeater($wp_customize, 'transmission_repeater', array(
'label'   => esc_html__('Enter Transmission', 'automotive'),
'section' => 'transmission_list',
'priority' => 2,
'customizer_repeater_text_control' => true,
)));



    // Translation




    $wp_customize->add_panel('panel4', array(
    'title'=>'Automotive Theme Translation',
    'description'=> 'Translate to your automotive.',
    'priority'=> 10,
));


$wp_customize->add_section('stt', array(
'title'       => __('Sell-Trade Form Translation', 'automotive'),
'priority'    => 30,
'description' => 'Translate sell and trade your car forms',
'panel' => 'panel4',
));


$wp_customize->add_setting('sform_enter_vehicle_information', array(
'default' => 'Enter Vehicle Information &raquo;',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_vehicle_information', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter Vehicle Information &raquo;"'),
));



$wp_customize->add_setting('sform_enter_listing_title', array(
'default' => 'Your listing title',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_listing_title', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter listing title."'),
));

$wp_customize->add_setting('sform_enter_listing_title', array(
'default' => 'Your listing title',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_listing_title', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter listing title."'),
));


$wp_customize->add_setting('sform_state', array(
'default' => 'Your State',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_state', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Your State"'),
));


$wp_customize->add_setting('sform_city', array(
'default' => 'City',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_city', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "City"'),
));


$wp_customize->add_setting('sform_state_first', array(
'default' => 'Select state first',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_state_first', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Select state first"'),
));



$wp_customize->add_setting('sform_make', array(
'default' => 'Make',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_make', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Make"'),
));


$wp_customize->add_setting('sform_select_make_first', array(
'default' => 'Select make first',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_select_make_first', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Select make first"'),
));


$wp_customize->add_setting('sform_year', array(
'default' => 'Year',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_year', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Year"'),
));


$wp_customize->add_setting('sform_enter_vehicle_price', array(
'default' => 'Enter vehicle price',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_vehicle_price', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter vehicle price"'),
));



$wp_customize->add_setting('sform_enter_vehicle_miles', array(
'default' => 'Enter miles',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_vehicle_miles', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter miles"'),
));
$wp_customize->add_setting('sform_enter_vin', array(
'default' => 'Enter vehicle identification number',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_vin', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter vehicle identification number"'),
));


$wp_customize->add_setting('sform_enter_exterior_color', array(
'default' => 'Enter exterior color',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_exterior_color', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter exterior color"'),
));

$wp_customize->add_setting('sform_enter_interior_color', array(
'default' => 'Enter interior color',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_interior_color', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter interior color"'),
));

$wp_customize->add_setting('sform_enter_vehicle_drive', array(
'default' => 'Enter vehicle drive',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_vehicle_drive', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter vehicle drive"'),
));

$wp_customize->add_setting('sform_features_comma', array(
'default' => 'Separate with commas (feature1, feature2, etc',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_features_comma', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Separate with commas (feature1, feature2, etc"'),
));

$wp_customize->add_setting('sform_transmission', array(
'default' => 'Transmission',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_transmission', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Transmission"'),
));


$wp_customize->add_setting('sform_vehicle_type', array(
'default' => 'Vehicle Type',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_vehicle_type', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Vehicle Type"'),
));

$wp_customize->add_setting('sform_text_area_default', array(
'default' => 'Enter vehicle listing description.',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_text_area_default', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter vehicle listing description."'),
));

$wp_customize->add_setting('sform_photos', array(
'default' => 'Upload Photos',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_photos', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Upload Photos"'),
));


$wp_customize->add_setting('sform_photos_instructions', array(
'default' => 'Images will be automatically resized to fit the listing layout. We recommend that you upload photos in full resolution for better results.',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_photos_instructions', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Images will be automatically resized to fit the listing layout. We recommend that you upload photos in full resolution for better results."'),
));

$wp_customize->add_setting('sform_photos_instructions_cont', array(
'default' => 'You may upload up to 12 images and each image may be no larger than 5MB',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_photos_instructions_cont', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "You may upload up to 12 images and each image may be no larger than 5MB"'),
));

$wp_customize->add_setting('sform_preview', array(
'default' => 'Preview',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_preview', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Preview"'),
));



$wp_customize->add_setting('sform_name', array(
'default' => 'Name',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_name', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Name"'),
));



$wp_customize->add_setting('sform_size', array(
'default' => 'Size',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_size', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Size"'),
));



$wp_customize->add_setting('sform_status', array(
'default' => 'Status',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_status', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Status"'),
));


$wp_customize->add_setting('sform_personal_information', array(
'default' => 'Personal Information',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_personal_information', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Personal Information"'),
));


$wp_customize->add_setting('sform_enter_first_name', array(
'default' => 'Enter First Name',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_first_name', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter First Name"'),
));

$wp_customize->add_setting('sform_enter_last_name', array(
'default' => 'Enter Last Name',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_last_name', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter Last Name"'),
));

$wp_customize->add_setting('sform_enter_email', array(
'default' => 'Enter e-mail address',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_email', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter e-mail address"'),
));


$wp_customize->add_setting('sform_enter_phone', array(
'default' => 'Enter Phone',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_phone', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter Phone"'),
));

$wp_customize->add_setting('sform_enter_security_code', array(
'default' => 'Enter Security Code',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_enter_security_code', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Enter Security Code"'),
));

$wp_customize->add_setting('sform_submit_pay', array(
'default' => 'Submit & pay for your listing',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('sform_submit_pay', array(
'type' => 'text',
'section' => 'stt',
'label' => __('Translate "Submit & pay for your listing"'),
));






    $wp_customize->add_section('smt', array(
    'title'       => __('Search Module Translation', 'automotive'),
    'priority'    => 30,
    'description' => 'Translate search module dropdown widget',
    'panel' => 'panel4',
));


$wp_customize->add_setting('state_text', array(
'default' => 'State',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('state_text', array(
'type' => 'text',
'section' => 'smt',
'label' => __('Translate "Select State"'),
));
$wp_customize->add_setting('city_text', array(
'default' => 'City',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('city_text', array(
'type' => 'text',
'section' => 'smt',
'label' => __('Translate "City (Select State First)"'),
));

$wp_customize->add_setting('make_text', array(
'default' => 'Select Make',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('make_text', array(
'type' => 'text',
'section' => 'smt',
'label' => __('Translate "Select Make"'),

));
$wp_customize->add_setting('model_text', array(
'default' => 'Model (Select make First)',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('model_text', array(
'type' => 'text',
'section' => 'smt',
'label' => __('Translate "Model (Select make First)"'),

));

$wp_customize->add_setting('min_price_text', array(
'default' => 'Min Price',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('min_price_text', array(
'type' => 'text',
'section' => 'smt',
'label' => __('Translate "Min Price"'),

));

$wp_customize->add_setting('max_price_text', array(
'default' => 'Max Price',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('max_price_text', array(
'type' => 'text',
'section' => 'smt',
'label' => __('Translate "Max Price"'),

));


$wp_customize->add_setting('from_year_text', array(
'default' => 'From: Year',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('from_year_text', array(
'type' => 'text',
'section' => 'smt',
'label' => __('Transalte "From: Year"'),

));

$wp_customize->add_setting('to_year_text', array(
'default' => 'To: Year',
'sanitize_callback' => 'sanitize_text_field',
));
$wp_customize->add_control('to_year_text', array(
'type' => 'text',
'section' => 'smt',
'label' => __('Translate "To: Year"'),

));



    $wp_customize->add_setting('vehicle_type_text', array(
   'default' => 'Vehicle Type',
   'sanitize_callback' => 'sanitize_text_field',
 ));
    $wp_customize->add_control('vehicle_type_text', array(
   'type' => 'text',
'section' => 'smt',
   'label' => __(' Translate Vechicle Type'),

 ));


 $wp_customize->add_setting('search_button_text', array(
'default' => 'Search',
'sanitize_callback' => 'sanitize_text_field',
));
 $wp_customize->add_control('search_button_text', array(
'type' => 'text',
'section' => 'smt',
'label' => __(' Translate "Search" Buttton'),

));

// Search Theme Setup

$wp_customize->add_panel('panel5', array(
'title'=>'Automotive Search Module Setup',
'description'=> 'Hide/Show Search Items.',
'priority'=> 10,
));

$wp_customize->add_section('search_module', array(
'title'       => __('Automotive Search Module Setup', 'automotive'),
'priority'    => 30,
'description' => 'Click "Publish" to view changes',

));


// Sate/City hide
$wp_customize->add_setting(
'hide_in_search_state',
array(
    'default' => 'off',
)
);
$wp_customize->add_control(
'hide_in_search_state',
array(
    'type' => 'radio',
    'label' => 'State & City',
    'section' => 'search_module',
    'description' => 'Select to hide-show in search module',
    'choices' => array(
      'off' =>  'Show',
      'on' => 'Hide',
    ),
)
);
function sanitize_hide_in_search_state($input)
{
    $valid = array(
      'off' =>  'Show',
      'on' => 'Hide',
);

    if (array_key_exists($input, $valid)) {
        return $input;
    } else {
        return '';
    }
}

// Make & Model hide
$wp_customize->add_setting(
'hide_in_search_make',
array(
    'default' => 'on',
)
);
$wp_customize->add_control(
'hide_in_search_make',
array(
    'type' => 'radio',
    'label' => 'Make & Model',
    'description' => 'Select to hide-show in search module',
    'section' => 'search_module',
    'choices' => array(
      'off' =>  'Show',
      'on' => 'Hide',
    ),
)
);
function sanitize_hide_in_search_make($input)
{
    $valid = array(
      'off' =>  'Show',
      'on' => 'Hide',
);

    if (array_key_exists($input, $valid)) {
        return $input;
    } else {
        return '';
    }
}


// Price hide
$wp_customize->add_setting(
'hide_in_search_price',
array(
    'default' => 'off',
)
);
$wp_customize->add_control(
'hide_in_search_price',
array(
    'type' => 'radio',
    'label' => 'Price',
    'description' => 'Select to hide-show in search module',
    'section' => 'search_module',
    'choices' => array(
      'off' =>  'Show',
      'on' => 'Hide',
    ),
)
);
function sanitize_hide_in_search_price($input)
{
    $valid = array(
      'off' =>  'Show',
      'on' => 'Hide',
);

    if (array_key_exists($input, $valid)) {
        return $input;
    } else {
        return '';
    }
}


// Year hide
$wp_customize->add_setting(
'hide_in_search_year',
array(
    'default' => 'off',
)
);
$wp_customize->add_control(
'hide_in_search_year',
array(
    'type' => 'radio',
    'label' => 'Year',
    'description' => 'Select to hide-show in search module',
    'section' => 'search_module',
    'choices' => array(
      'off' =>  'Show',
      'on' => 'Hide',
    ),
)
);
function sanitize_hide_in_search_year($input)
{
    $valid = array(
      'off' =>  'Show',
      'on' => 'Hide',
);

    if (array_key_exists($input, $valid)) {
        return $input;
    } else {
        return '';
    }
}

// Type hide
$wp_customize->add_setting(
'hide_in_search_vehicle_type',
array(
    'default' => 'on',
)
);
$wp_customize->add_control(
'hide_in_search_vehicle_type',
array(
    'type' => 'radio',
    'label' => 'Vehicle Type',
    'description' => 'Select to hide-show in search module',
    'section' => 'search_module',
    'choices' => array(
      'off' =>  'Show',
      'on' => 'Hide',
    ),
)
);
function sanitize_hide_in_search_vehicle_type($input)
{
    $valid = array(
      'off' =>  'Show',
      'on' => 'Hide',
);

    if (array_key_exists($input, $valid)) {
        return $input;
    } else {
        return '';
    }
}



$wp_customize->add_setting(
'hide_in_search_transmission',
array(
    'default' => 'off',
)
);
$wp_customize->add_control(
'hide_in_search_transmission',
array(
    'type' => 'radio',
    'label' => 'Transmission',
    'description' => 'Select to hide-show in search module',
    'section' => 'search_module',
    'choices' => array(
      'off' =>  'Show',
      'on' => 'Hide',
    ),
)
);
function sanitize_hide_in_search_transmission($input)
{
    $valid = array(
      'off' =>  'Show',
      'on' => 'Hide',
);

    if (array_key_exists($input, $valid)) {
        return $input;
    } else {
        return '';
    }
}














// Vehice  Specificatons

      $wp_customize->add_section('vst', array(
      'title'       => __('Vehicle Specifications Translation', 'automotive'),
      'priority'    => 30,
      'description' => 'Translate all vehicle specifications',
      'panel' => 'panel4',
      ));


      $wp_customize->add_setting('condition_text', array(
    'default' => 'Condition',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('condition_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Condition"'),

  ));


      $wp_customize->add_setting('featured_text', array(
    'default' => 'Featured',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('featured_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Featured"'),
  ));
      $wp_customize->add_setting('top_deal_text', array(
    'default' => 'Top Deal?',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('top_deal_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Top Deal?"'),

  ));

      $wp_customize->add_setting('drive_text', array(
    'default' => 'Drive',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('drive_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Drive"'),

  ));


      $wp_customize->add_setting('epa_mileage_text', array(
    'default' => 'EPA Mileage',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('epa_mileage_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "EPA Mileage"'),

  ));
      $wp_customize->add_setting('transmission_text', array(
    'default' => 'Transmission',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('transmission_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Transmission"'),

  ));


      $wp_customize->add_setting('stock_text', array(
    'default' => 'Stock',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('stock_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Stock"'),

  ));

      $wp_customize->add_setting('citympg_text', array(
    'default' => 'City MPG',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('citympg_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "City MPG"'),

  ));

      $wp_customize->add_setting('highwaympg_text', array(
    'default' => 'Highway MPG',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('highwaympg_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Highway MPG"'),

  ));

      $wp_customize->add_setting('interior_text', array(
    'default' => 'Interior',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('interior_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Interior"'),

  ));


      $wp_customize->add_setting('exterior_text', array(
    'default' => 'Exterior',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('exterior_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Exterior"'),

  ));


      $wp_customize->add_setting('description_text', array(
    'default' => 'Description',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('description_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Description"'),

  ));


      $wp_customize->add_setting('torque_text', array(
    'default' => 'Torque',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('torque_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Torque"'),

  ));


      $wp_customize->add_setting('price_text', array(
    'default' => 'Price',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('price_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Price"'),

  ));



      $wp_customize->add_setting('miles_text', array(
    'default' => 'Miles',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('miles_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Miles"'),

  ));



      $wp_customize->add_setting('year_text', array(
    'default' => 'Year',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('year_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Year"'),

  ));



      $wp_customize->add_setting('make_model_text', array(
    'default' => 'Make & Model',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('make_model_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Make & Model"'),

  ));



      $wp_customize->add_setting('features_text', array(
    'default' => 'Features',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('features_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Features"'),

  ));


      $wp_customize->add_setting('engine_size_text', array(
    'default' => 'Engine Size',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('engine_size_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Engine Size"'),

  ));

      $wp_customize->add_setting('cylinders_text', array(
    'default' => 'Cylinders',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('cylinders_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Cylinders"'),

  ));
      $wp_customize->add_setting('horsepower_text', array(
    'default' => 'Horsepower',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('horsepower_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Horsepower"'),

  ));


      $wp_customize->add_setting('compression_ratio_text', array(
    'default' => 'Compression Ratio',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('compression_ratio_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Compression Ratio'),

  ));




      $wp_customize->add_setting('camshaft_text', array(
    'default' => 'Camshaft',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('camshaft_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Camshaft"'),

  ));



      $wp_customize->add_setting('engine_type_text', array(
    'default' => 'Engine Type',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('engine_type_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Engine Type"'),

  ));



      $wp_customize->add_setting('bore_text', array(
    'default' => 'Bore',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('bore_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Bore"'),

  ));



      $wp_customize->add_setting('stroke_text', array(
    'default' => 'Stroke',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('stroke_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Stroke"'),


    ));


      $wp_customize->add_setting('valves_per_cylinder_text', array(
      'default' => 'Valves per Cylinder',
      'sanitize_callback' => 'sanitize_text_field',
    ));
      $wp_customize->add_control('valves_per_cylinder_text', array(
      'type' => 'text',
      'section' => 'vst',
      'label' => __('Translate "Valves per Cylinder"'),


      ));

      $wp_customize->add_setting('fuel_capacity_text', array(
          'default' => 'Fuel Capacity',
          'sanitize_callback' => 'sanitize_text_field',
        ));
      $wp_customize->add_control('fuel_capacity_text', array(
          'type' => 'text',
          'section' => 'vst',
          'label' => __('Translate "Fuel Capacity"'),


          ));




      $wp_customize->add_setting('wheelbase_text', array(
            'default' => 'Wheelbase',
            'sanitize_callback' => 'sanitize_text_field',
          ));
      $wp_customize->add_control('wheelbase_text', array(
            'type' => 'text',
            'section' => 'vst',
            'label' => __('Translate "Wheelbase"'),


            ));


      $wp_customize->add_setting('overall_length_text', array(
                      'default' => 'Overall Length',
                      'sanitize_callback' => 'sanitize_text_field',
                    ));
      $wp_customize->add_control('overall_length_text', array(
                      'type' => 'text',
                      'section' => 'vst',
                      'label' => __('Translate "Overall Length"'),


                      ));


      $wp_customize->add_setting('width_text', array(
                        'default' => 'Width',
                        'sanitize_callback' => 'sanitize_text_field',
                      ));
      $wp_customize->add_control('width_text', array(
                        'type' => 'text',
                        'section' => 'vst',
                        'label' => __('Translate "Width"'),


                        ));




      $wp_customize->add_setting('curb_weight_text', array(
    'default' => 'Curb Weight',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('curb_weight_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Translate "Curb Weight"'),


    ));




        $wp_customize->add_setting('leg_room_text', array(
      'default' => 'Leg Room',
      'sanitize_callback' => 'sanitize_text_field',
    ));
        $wp_customize->add_control('leg_room_text', array(
      'type' => 'text',
      'section' => 'vst',
      'label' => __('Translate "Leg Room"'),


      ));




      $wp_customize->add_setting('head_room_text', array(
    'default' => 'Head Room',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('head_room_text', array(
    'type' => 'text',
    'section' => 'vst',
    'label' => __('Head Room'),


    ));


        $wp_customize->add_setting('seating_capacity_text', array(
      'default' => 'Seating Capacity (Std)',
      'sanitize_callback' => 'sanitize_text_field',
    ));
        $wp_customize->add_control('seating_capacity_text', array(
      'type' => 'text',
      'section' => 'vst',
      'label' => __('Translate "Seating Capacity (Std)"'),


      ));


          $wp_customize->add_setting('tires_text', array(
        'default' => 'Tires',
        'sanitize_callback' => 'sanitize_text_field',
      ));
          $wp_customize->add_control('tires_text', array(
        'type' => 'text',
        'section' => 'vst',
        'label' => __('Translate "Tires"'),


        ));





// Inventory Management Translations

      $wp_customize->add_section('invt', array(
      'title'       => __('Inventory Management Translation', 'automotive'),
      'priority'    => 30,
      'description' => 'Translate Inventory Management',
      'panel' => 'panel4',
      ));


      $wp_customize->add_setting('sort_by_text', array(
    'default' => 'Sort By',
    'sanitize_callback' => 'sanitize_text_field',
  ));
      $wp_customize->add_control('sort_by_text', array(
    'type' => 'text',
    'section' => 'invt',
    'label' => __('Translate "Sort By"'),
    ));


        $wp_customize->add_setting('back_to_top_text', array(
        'default' => 'BACK TOP TOP',
        'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('back_to_top_text', array(
        'type' => 'text',
        'section' => 'invt',
        'label' => __('Translate "BACK TOP TOP"'),
            ));



            $wp_customize->add_setting('view_details_text', array(
            'default' => 'View Details',
            'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('view_details_text', array(
            'type' => 'text',
            'section' => 'invt',
            'label' => __('Translate "View Details"'),
                ));

                $wp_customize->add_setting('request_information_text', array(
                'default' => 'REQUEST INFORMATION',
                'sanitize_callback' => 'sanitize_text_field',
                ));
                $wp_customize->add_control('request_information_text', array(
                'type' => 'text',
                'section' => 'invt',
                'label' => __('Translate "REQUEST INFORMATION"'),
                    ));



}



add_action('customize_register', 'extend_customizer');



if (! class_exists('Prefix_Separator_Control')) {
    return null;
}
/**
 * Class Prefix_Separator_Control
 *
 * Custom control to display separator
 */
  class Prefix_Separator_Control extends WP_Customize_Control
  {
      public function render_content()
      {
          ?>
        <label>
            <hr>
            <br> </label>
        <?php
      }
  }

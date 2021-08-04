<?php
add_action( 'widgets_init', 'sidebars_and_widgets' );

function sidebars_and_widgets()
{
	register_widget( 'GTCD_Widget' );
	register_widget( 'Carousel' );
	register_widget('Phone_Header_Widget');
	register_widget('Full_Specs');
	register_widget('Feat_Widget');
	register_widget('Top_Deals');
	register_widget('Find_By_Type');
	register_widget('Footer1_Widget');
	register_widget('Footer2_Widget');
	register_widget('Footer3_Widget');
	register_widget('Footer4_Widget');
	register_widget('Loan_Calculator');
	register_widget('Homepage_Vehicles');


	$sidebars = array(
		'sidebar' => array(
							'id'            => 'sidebar',
							'name'          => __( 'Sidebar', 'automotive' ),
							'description'   => __( 'Left Sidebar', 'automotive' ),
							'before_title'  => '<h3 >',
							'after_title'   => '</h3>',
							'before_widget' => '<div class="side-widget">',
							'after_widget'  => '</div>',
				),
		'homepage' => array(
				'id'            => 'homepage',
				'name'          => __( 'Homepage Listings', 'automotive' ),
				'description'   => __( 'Add new listings grid on home page.', 'automotive' ),
	),
		'search'  => array(
							'id'            => 'search',
							'name'          => __( 'Automotive Sidebar', 'automotive' ),
							'description'   => __( 'Add all Automotive widgets here', 'automotive' ),
							'before_title'  => '<h3 class="search-title">',
							'after_title'   => '</h3>',
							'before_widget' => '<div class="side-widget">',
							'after_widget'  => '</div>',
				),
		'carousel' => array(
							'id'            => 'carousel',
							'name'          => __( 'Automotive Carousel', 'automotive' ),
							'description'   => __( 'Homepage Slideshow', 'automotive' ),
				),
		'phone' => array(
							'id'            => 'phone',
							'name'          => __( 'Header Phone Number', 'automotive' ),
							'description'   => __( 'Business phone number in header', 'automotive' ),
				),
		'specs' =>  array(
							'id'            => 'specs',
							'name'          => __( 'Vehicle Specifications', 'automotive' ),
							'description'   => __( 'Accordion widget in listing page ', 'automotive' ),
							'before_title'  => '<h3>',
							'after_title'   => '</h3>',
				),
		'featured' =>  array(
							'id'            => 'featured',
							'name'          => __( 'Featured Vehicles', 'automotive' ),
							'description'   => __( 'Featured vehicles widget', 'automotive' ),
				),
		'find_by_type' => array(
									'id'            => 'find_by_type',
									'name'          => __( 'Find Cars', 'automotive' ),
									'description'   => __( 'Find by Type & Make', 'automotive' ),
						),
		'footer' => array(
							'id'            => 'footer',
							'name'          => __( 'Footer', 'automotive' ),
							'description'   => __( 'Footer widgets', 'automotive' ),
				),
	);
	foreach($sidebars as $sidebar):
		register_sidebar($sidebar);
	endforeach;
	$active_widgets = get_option( 'sidebars_widgets' );
	if(
		!empty($active_widgets['search' ]) ||
		!empty($active_widgets['carousel'] ) ||
		!empty($active_widgets['phone'] )||
		!empty($active_widgets['specs'] )||
	  !empty($active_widgets['carfax'] )||
		!empty($active_widgets['featured'] )||
		!empty($active_widgets['footer'] )

	) return;
	$counter = 1;

	$active_widgets['find_by_type'][0] = 'find_by_type_gt-' . $counter;

	$find_text[ $counter ] = array (
		'title'         => 'Find By Type',
		'title2'        => 'Find By Make',
	);
	update_option( 'widget_find_by_type_gt', $find_text );
	$active_widgets['search'][0] = 'gtcd_widget_gt-' . $counter;
	$search_title[ $counter ] = array ( 'title' => 'Search' );
	update_option( 'widget_gtcd_widget_gt', $search_title );
	$active_widgets['carousel'][0] = 'create_carousel_gt-' . $counter;
	$number_listings[ $counter ] = array ( 'title' => '5' );
	update_option( 'widget_create_carousel_gt', $number_listings );
	$active_widgets['phone'][0] = 'phone_widget_gt-' . $counter;
	$phone_number[ $counter ] = array ( 'title' => '1800.80000.888' );
	update_option( 'widget_phone_widget_gt', $phone_number );

	$active_widgets['specs'][0] = 'full_specs_gt-' . $counter;
	$specs_text[ $counter ] = array (
		'title'         => 'Full Specifications',
		'title2'        => 'Warranty',
		'title3'        => 'Financing',
		'title4'        => 'Trade-In',
		'text2'			=> '5-Day Money-Back Guarantee At Car Dealer, we know that not every car is perfect for every person, so all used Car Dealer cars come with our 5-Day Money-Back Guarantee. You can return any car for any reason within a 5-day period. Simply bring it back in the condition in which it was purchased, and you will get a full refund.',
		'text3'			=> 'Affordable solutions
Car Dealer offers some of the most competitive terms in the industry with solutions for a wide range of credit profiles.

Speed
Fill out our quick credit application and get decisions in a matter of minutes.

Trust
We only use respected and reputable finance sources, and we always protect our customers information.

Integrity
Straightforward, honest business practices are the standard at Car Dealer, and our financing is no exception. If you find a more competitive offer elsewhere, you have three business days to change your mind.',
		'text4'			=> 'Sell your current car and buy a new one at the same place!
You can even apply your written offer towards the purchase of a new car.',
	);
	update_option( 'widget_full_specs_gt', $specs_text );
	$active_widgets['homepage'][0] = 'homepage_gt-' . $counter;
	$feat_text[ $counter ] = array (
		'title'         => 'Home Page Listings',
		'number'        => '12',
	);
	update_option( 'widget_homepage_gt', $feat_text );
	$active_widgets['search'][3] = 'create_calc_gt-' . $counter;
	$feat_text[ $counter ] = array (
		'title'         => 'Payment Calculator',
	);
	update_option( 'widget_create_calc_gt', $feat_text );
	$active_widgets['featured'][0] = 'feat_widget_gt-' . $counter;
	$feat_text[ $counter ] = array (
		'title'         => 'Featured Vehicles',
		'number'        => '8',
);
	update_option( 'widget_feat_widget_gt', $feat_text );
	$active_widgets['footer'][0] = 'footer_1_gt-' . $counter;
	$foot1_text[ $counter ] = array (
		'title'         => __('Sell your Car','automotive'),
		'pagelink'			=> get_bloginfo('url').'/'.__('sell-your-car','automotive'),
		'text'			=>  __('Thinking about selling your current vehicle?

Bring your car for an appraisal, and get a free written offer good for 7 days.

Submit your vehicle information now.','automotive'),
	);
	update_option( 'widget_footer_1_gt', $foot1_text );
	$active_widgets['footer'][1] = 'footer_2_gt-' . $counter;
	$foot2_text[ $counter ] = array ( 'title' => __('News','automotive') );
	update_option( 'widget_footer_2_gt', $foot2_text );
$active_widgets['footer'][2] = 'footer_3_gt-' . $counter;
	$foot3_text[ $counter ] = array (
		'title'         => __('Office','automotive'),
		'text'			=>  __('<p>601 Biscayne Blvd<br/>Miami, FL 33132</p>

<p>Tel: 1800-888-0000</p>

<p>info@gorillathemesauto.com</p>','automotive'),
	);
	update_option( 'widget_footer_3_gt', $foot3_text );
	$active_widgets['footer'][3] = 'footer_4_gt-' . $counter;
	$foot3_text[ $counter ] = array (
		'title'         => __('Directions','automotive'),
		'address'			=>  __('601 Biscayne Blvd, Miami FL 33132','automotive'),
	);
	update_option( 'widget_footer_4_gt', $foot3_text );
	$active_widgets['search'][1] = 'top-deals_gt-' . $counter;
	$deals[ $counter ] = array (
		'deals_title'         => __('Deal of the Week','automotive'),
		'num_deals'			=>  '3',
	);
	update_option( 'widget_top-deals_gt', $deals );
	$counter++;
	update_option( 'sidebars_widgets', $active_widgets );

}
class Loan_Calculator extends WP_Widget {


		public function __construct() {
			parent::__construct(
				'create_calc_gt',
				__( '. Loan Calculator', 'automotive' ),
				array(
					'description' => __( 'Car Payment Caluclator', 'automotive' ),
					'classname'   => 'side-widget',
				)
			);
		}
	public function widget( $args, $instance ) {

		   extract($args);

		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		?>
		<script language="JavaScript">
function checkForZero(field){
    if (field.value == 0 || field.value.length == 0) {
        alert ("This field can't be 0!");
        field.focus(); }
    else
        calculatePayment(field.form);
		}
		function cmdCalc_Click(form)
		{
    if (form.price.value == 0 || form.price.value.length == 0) {
        alert ("The Price field can't be 0!");
        form.price.focus(); }
    else if (form.ir.value == 0 || form.ir.value.length == 0) {
        alert ("The Interest Rate field can't be 0!");
        form.ir.focus(); }
    else if (form.term.value == 0 || form.term.value.length == 0) {
        alert ("The Term field can't be 0!");
        form.term.focus(); }
    else
        calculatePayment(form);
		}
	function calculatePayment(form)
		{
    princ = form.price.value - form.dp.value;
    intRate = (form.ir.value/100) / 12;
    months = form.term.value * 12;
    form.pmt.value = Math.floor((princ*intRate)/(1-Math.pow(1+intRate,(-1*months)))*100)/100;
    form.principle.value = princ;
    form.payments.value = months;
		}
	</script>
<script language="JavaScript">
	function checkForZero(field)
	{
    if (field.value == 0 || field.value.length == 0) {

        }
    else
        calculatePayment(field.form);
	}
	function cmdCalc_Click(form)
	{
    if (form.price.value == 0 || form.price.value.length == 0) {
        // alert ("The Price field can't be 0!");
        form.price.focus(); }
    else if (form.ir.value == 0 || form.ir.value.length == 0) {
        alert ("The Interest Rate field can't be 0!");
        form.ir.focus(); }
    else if (form.term.value == 0 || form.term.value.length == 0) {
        alert ("The Term field can't be 0!");
        form.term.focus(); }
    else
        calculatePayment(form);
	}
	function calculatePayment(form)
	{
    princ = form.price.value - form.dp.value;
    intRate = (form.ir.value/100) / 12;
    months = form.term.value * 12;
    form.pmt.value = Math.floor((princ*intRate)/(1-Math.pow(1+intRate,(-1*months)))*100)/100;
    form.principle.value = princ;
    form.payments.value = months;
	}
	</script>
	<?php
	global $wp_query;
	$postid = $wp_query->post->ID;
	// $options = my_get_theme_options();

	$fields = get_post_meta($postid, 'mod1', true);wp_reset_query();?>
    <h3><?php echo $title;?></h3>
    <form name="Loan Calculator" class="calculate-form">
	    <div class="calc-container">
      <span class="calc-label">
        <label class="loan-title" for="l-amount">
          <?php echo get_theme_mod('purchase_price_text','Purchase Price');echo ' '. get_theme_mod('currency_symbol',' $');?>
        </label>
      </span>
			<span class="calc-input">
		<input type="text" size="14" name="price" value="<?php if (isset($fields['price']) && !empty($fields['price'])) { echo $fields['price'];} else { echo '0'; } ?>"  class="l-inputbar" id="l-amount" onBlur="checkForZero(this)" onChange="checkForZero(this)">
	</span>
	</div>
	     <div class="calc-container">
           <span class="calc-label">
        <label class="loan-title" for="l-down">
          <?php echo get_theme_mod('down_payment_text','Down Payment');echo ' '. get_theme_mod('currency_symbol',' $');?>
        </label>
      </span>
          <span class="calc-input">
        <input type="text" size="14" name="dp" id="l-down"   class="l-inputbar" value="0"  onChange="calculatePayment(this.form)">
      </span>
	     </div>
	      <div class="calc-container">
           <span class="calc-label">
        <label class="loan-title" for="l-interest">
          <?php echo get_theme_mod('interest_rate_text','Interest');echo ' %';?>
        </label>
      </span>
            <span class="calc-input">
        <input type="text" size="14"  name="ir" value="<?php echo get_theme_mod('interest_rate','2.5')?>" class="l-inputbar" onBlur="checkForZero(this)" onChange="checkForZero(this)">
      </span>
	      </div>
	       <div class="calc-container">
           <span class="calc-label">
        <label class="loan-title" for="l-years">
            <?php echo get_theme_mod('loan_term_text','Years');?>
        </label>
      </span>
           <span class="calc-input">
        <input type="text" size="14"  name="term" value="<?php echo get_theme_mod('loan_term','5')?>" class="l-inputbar"  onBlur="checkForZero(this)" onChange="checkForZero(this)">
      </span>
	       </div>
	        <div class="calc-container results">
           <span class="calc-label">
        <label class="loan-title-results" for="l-payment">
          <?php echo get_theme_mod('monthly_payment_text','Monthly Payment')?>
        </label>
           </span>
             <span class="calc-input results"><?php echo '<span class="currency-color"> '.  get_theme_mod('currency_symbol',' $');?>
			 <input type="label" size="42"  class="l-result" value="0.00"  name="pmt">
        </span>
     </div>
		 <div align="center" style="display: none;">
		                     <input
		                     type="button" id="calcbutton" name="cmdCalc"
		                     value="Calculate"
		                     onClick="cmdCalc_Click(this.form)">
		                       </div>
		     </form>
		    <script type="text/javascript">
		 document.getElementById("calcbutton").click();
		 </script>

     <div style="clear:both"></div>
  	<?php echo $after_widget;
	}
	public	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', ) );
		$title = strip_tags($instance['title']);
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title: ","automotive");?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
	return $instance;
	}
}
class Find_By_Type extends WP_Widget
{

	public	function __construct() {
		parent::__construct(
			'find_by_type_gt',
			__( '. Find by Type & Make', 'automotive' ),
			array(
				'description' => __( 'Find Vehicles by type & make', 'automotive' ),
			)
		);
	}
	function widget($args, $instance) {
		$title  = ( !empty( $instance['title']  ) ) ? $instance['title'] : '';
		$title2 = ( !empty( $instance['title2'] ) ) ?  $instance['title2'] : '';

?>
<div id="footer">
<div class="outer-find">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#findtype"><?php echo $title;?></a></li>
		<li><a data-toggle="tab" href="#findmake"><?php echo $title2;?></a></li>
	</ul>
<div class="container-fluid">
<div class="col-sm-12 hidden-xs">
	<div class="full-width find-wrapper">
		<div id="cars-container">
			<div class="tab-content">
		    <div id="findtype" class="tab-pane fade in active">
			<ul class="cars-list list-one">
				<div class="col-sm-2">
					<li>
						<?php $url = str_replace(" ", "+", get_theme_mod('car_link_one','Convertible')); ?>
							<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_one','Convertible')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_one', get_bloginfo('template_url').'/assets/images/product-images/convertible.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_link_one','Convertible')); ?>'>
							</a>
							<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_one')); ?>' rel='home'><?php echo get_theme_mod('car_link_one','Convertible')?></a>
					</li>
			 </div>
			 <div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_link_two','Coupe')); ?>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_two')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_two',get_bloginfo('template_url').'/assets/images/product-images/sportscars.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_link_two','Coupe')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_two')); ?>' rel='home'><?php echo  get_theme_mod('car_link_two','Coupe')?></a>
				</li>
			</div>
		  <div class="col-sm-2">
	<li>
		<?php $url2 = str_replace(" ", "+", get_theme_mod('car_link_three','Minivan')); ?>
			<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_three','Minivan')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_three',get_bloginfo('template_url').'/assets/images/product-images/minivans.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_link_three','Minivan')); ?>'>
			</a>
			<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_three','Minivan')); ?>' rel='home'><?php echo get_theme_mod('car_link_three','Minivan')?></a>
	</li>
</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_link_four','Pickup')); ?>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_four','Pickup')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_four',get_bloginfo('template_url').'/assets/images/product-images/pickuptrucks.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_link_four','Pickup')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_four','Pickup')); ?>' rel='home'><?php echo get_theme_mod('car_link_four','Pickup')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_link_five','Sedan')); ?>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_five','Sedan')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_five',get_bloginfo('template_url').'/assets/images/product-images/sedanscoupes.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_link_five','Sedan')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_five','Sedan')); ?>' rel='home'><?php echo get_theme_mod('car_link_five','Sedan')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_link_six','Sport Utility')); ?>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_six','Sport Utility')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_six',get_bloginfo('template_url').'/assets/images/product-images/4WD-AWD.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_link_six','Sport Utility')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_six','Sport Utility')); ?>' rel='home'><?php echo get_theme_mod('car_link_six','Sport Utility')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_link_seven','Crossover')); ?>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_seven','Crossover')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_seven',get_bloginfo('template_url').'/assets/images/product-images/crossover.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_link_seven','Crossover')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_seven','Crossover')); ?>' rel='home'><?php echo get_theme_mod('car_link_seven','Crossover');?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_link_eight','Diesel')); ?>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_eight','Diesel')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_eight',get_bloginfo('template_url').'/assets/images/product-images/diesel.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_link_eight','Diesel')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_eight','Diesel')); ?>' rel='home'><?php echo get_theme_mod('car_link_eight','Diesel')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_link_nine','Hybrid')); ?>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_nine','Hybrid')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_nine',get_bloginfo('template_url').'/assets/images/product-images/hybrid.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_link_nine','Hybrid')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_nine','Hybrid')); ?>' rel='home'><?php echo get_theme_mod('car_link_nine','Hybrid')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_link_ten','Luxury')); ?>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_ten','Luxury')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_ten',get_bloginfo('template_url').'/assets/images/product-images/luxury.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_link_ten','Luxury')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_ten','Luxury')); ?>' rel='home'><?php echo get_theme_mod('car_link_ten','Luxury')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_link_eleven','Wagons')); ?>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_eleven','Wagons')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_eleven',get_bloginfo('template_url').'/assets/images/product-images/wagons.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_link_eleven','Wagons')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_eleven','Wagons')); ?>' rel='home'><?php echo get_theme_mod('car_link_eleven','Wagons')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_link_twelve','4WD-AWD')); ?>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_twelve','4WD-AWD')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_twelve',get_bloginfo('template_url').'/assets/images/product-images/sportutilities.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_link_twelve','4WD-AWD')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_link_twelve','4WD-AWD')); ?>' rel='home'><?php echo get_theme_mod('car_link_twelve','4WD-AWD')?></a>
				</li>
			</div>
			</ul>
		</div>

		<div id="findmake" class="tab-pane fade">
			<ul class="cars-list list-one logos">
				<div class="col-sm-2">
					<li>
						<?php $url = str_replace(" ", "+", get_theme_mod('car_make_one','Audi')); ?>
							<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_one','Audi')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_make_one', get_bloginfo('template_url').'/assets/images/product-logos/audi.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_make_one','Audi')); ?>'>
							</a>
							<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_one','Audi')); ?>' rel='home'><?php echo get_theme_mod('car_make_one','Audi')?></a>
					</li>
			 </div>
			 <div class="col-sm-2">
				 <li>
					 <?php $url = str_replace(" ", "+", get_theme_mod('car_make_two','BMW')); ?>
						 <a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_two','BMW')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_make_two', get_bloginfo('template_url').'/assets/images/product-logos/bmw.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_make_two','BMW')); ?>'>
						 </a>
						 <a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_two','BMW')); ?>' rel='home'><?php echo get_theme_mod('car_make_two','BMW')?></a>
				 </li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url = str_replace(" ", "+", get_theme_mod('car_make_three','Cadillac')); ?>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_three','Cadillac')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_make_three', get_bloginfo('template_url').'/assets/images/product-logos/cadillac.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_make_three','Cadillac')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_three','Cadillac')); ?>' rel='home'><?php echo get_theme_mod('car_make_three','Cadillac')?></a>
				</li>
		 </div>
		 <div class="col-sm-2">
			 <li>
				 <?php $url = str_replace(" ", "+", get_theme_mod('car_make_five','Chevrolet')); ?>
					 <a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_five','Chevrolet')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_make_four', get_bloginfo('template_url').'/assets/images/product-logos/chevrolet.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_make_five','Chevrolet')); ?>'>
					 </a>
					 <a href='<?php echo esc_url(home_url('/#search/vehicletype-')).  $url.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_five','Chevrolet')); ?>' rel='home'><?php echo get_theme_mod('car_make_five','Chevrolet')?></a>
			 </li>
		</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_make_five','Dodge')); ?>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_five','Dodge')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_make_five',get_bloginfo('template_url').'/assets/images/product-logos/dodge.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_make_five','Dodge')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_five','Dodge')); ?>' rel='home'><?php echo get_theme_mod('car_make_five','Dodge')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_make_six','Ford')); ?>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_six','Ford')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_make_six',get_bloginfo('template_url').'/assets/images/product-logos/ford.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_make_six','Ford')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_six','Ford')); ?>' rel='home'><?php echo get_theme_mod('car_make_six','Ford')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_make_seven','Honda')); ?>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_seven','Honda')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_make_seven',get_bloginfo('template_url').'/assets/images/product-logos/honda.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_make_seven','Honda')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_seven','Honda')); ?>' rel='home'><?php echo get_theme_mod('car_make_seven','Honda')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_make_eight','Jeep')); ?>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_eight','Honda')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_make_eight',get_bloginfo('template_url').'/assets/images/product-logos/jeep.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_make_eight','Jeep')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_eight','Honda')); ?>' rel='home'><?php echo get_theme_mod('car_make_eight','Honda')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_make_nine','Mercedes Benz')); ?>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_nine','Mercedes Benz')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_make_nine',get_bloginfo('template_url').'/assets/images/product-logos/mercedes.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_make_nine','Mercedes Benz')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_nine','Mercedes Benz')); ?>' rel='home'><?php echo get_theme_mod('car_make_nine','Mercedes Benz')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_make_ten','Nissan')); ?>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_ten','Nissan')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_make_ten',get_bloginfo('template_url').'/assets/images/product-logos/nissan.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_make_ten','Nissan')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_ten','Nissan')); ?>' rel='home'><?php echo get_theme_mod('car_make_ten','Nissan')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_make_eleven','Toyota')); ?>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_eleven','Toyota')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_make_eleven',get_bloginfo('template_url').'/assets/images/product-logos/toyota.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_make_eleven','Toyota')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_eleven','Toyota')); ?>' rel='home'><?php echo get_theme_mod('car_make_eleven','Toyota')?></a>
				</li>
			</div>
			<div class="col-sm-2">
				<li>
					<?php $url2 = str_replace(" ", "+", get_theme_mod('car_make_twelve','Volkswagen')); ?>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_twelve','Volkswagen')); ?>' rel='home'><img src='<?php echo esc_url(get_theme_mod('image_make_twelve',get_bloginfo('template_url').'/assets/images/product-logos/volkswagen.png')); ?>' alt='<?php echo esc_attr(get_theme_mod('car_make_twelve','Volkswagen')); ?>'>
						</a>
						<a href='<?php echo esc_url(home_url('/#search/makemodel-')).  $url2.'/'; ?>' title='<?php echo esc_attr(get_theme_mod('car_make_twelve','Volkswagen')); ?>' rel='home'><?php echo get_theme_mod('car_make_twelve','Volkswagen')?></a>
				</li>
			</div>
			</ul>
    </div>

		</div>
	</div>
</div>

</div>
</div>
</div>
<?php


		$after_widget;
	}

	function form($instance) {


			$instance = wp_parse_args( (array) $instance, array(
				'title' => '',
				'title2' => '',
			) );
			$title = !empty( $instance['title'] ) ? $instance['title'] : '';
			$title2 = !empty( $instance['title2'] ) ? $instance['title2'] : '';
	?>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">
    	<?php _e("First Tab Title: ","language");?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	</label>
 	</p>
	<p>
	<label for="<?php echo $this->get_field_id('title2'); ?>">
			<?php _e("Second Tab Title: ","language");?>
		<input class="widefat" id="<?php echo $this->get_field_id('title2'); ?>" name="<?php echo $this->get_field_name('title2'); ?>" type="text" value="<?php echo esc_attr($title2); ?>" />
	</label>
	</p>


 	<?php
 	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = !empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['title2'] = !empty( $new_instance['title2'] ) ? strip_tags( $new_instance['title2'] ) : '';

		return $instance;

	}
}

// Top_Deals Widget
class Top_Deals extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'top-deals_gt',
			__( '. Top Deals', 'automotive' ),
			array(
				'description' => __( 'Top Deals Widget in Sidebar', 'automotive' ),
				'classname'   => 'side-widget',
			)
		);
	}
	public function widget( $args, $instance ) {
		global $post;
		$dealstitle = ( ! empty( $instance['deals_title'] ) ) ? $instance['deals_title'] : '';
		$numdeals = ( ! empty( $instance['num_deals'] ) ) ? $instance['num_deals'] : '';
		echo $args['before_widget'];
		echo $args['before_title'];
		echo  __($dealstitle,'automotive');
		echo $args['after_title'];
		wp_reset_query();
		$query = new WP_Query(array(
							'post_type' => array('gtcd'),
							'meta_key' => '_topdeal',
							'meta_value' => 'Yes',
							'posts_per_page' => $numdeals,
							));
	if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();?>
     <div class="deals">
	   <a href="<?php the_permalink($post->ID);?>" >
          <?php gorilla_img ($post->ID,'medium'); ?>
            <span class="top-deals">
	      <span class="top-deals-title">
   <?php if ( isset( $fields[ 'year' ] ) ) {
			echo $fields['year'];
		}




		else { echo '';		}?>  <?php get_template_part( 'assets/template-parts/makemodel' ); ?>

		<span class="top-deals-price">
 			<?php get_template_part( 'assets/template-parts/currencyprice' ); ?>
		</span>
			</span>
	     </span>
	   </a>
        </div>
		<div clear="both"></div>
      <?php endwhile; else: ?>
			<img class="img-responsive" src="https://via.placeholder.com/300x224.png/444444/DDDDDD?text=PLACEHOLDER">
	      <?php endif;
		echo $args['after_widget'];
	}
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'deals_title' => '',
			'num_deals' => '',
		) );
		$dealstitle = !empty( $instance['deals_title'] ) ? $instance['deals_title'] : '';
		$numdeals = !empty( $instance['num_deals'] ) ? $instance['num_deals'] : '';
		echo '<p>';
		echo '	<label for="' . $this->get_field_id( 'deals_title' ) . '" >' . __( 'Title', 'automotive' ) . '</label>';
		echo '	<input type="text" id="' . $this->get_field_id( 'deals_title' ) . '" name="' . $this->get_field_name( 'deals_title' ) . '" class="widefat" placeholder="' . esc_attr__( '', 'automotive' ) . '" value="' . esc_attr( $dealstitle ) . '">';
		echo '	<span class="description">' . __( 'Widget title.', 'automotive' ) . '</span>';
		echo '</p>';
		echo '<p>';
		echo '	<label for="' . $this->get_field_id( 'num_deals' ) . '" >' . __( 'Number', 'automotive' ) . '</label>';
		echo '	<input type="text" id="' . $this->get_field_id( 'num_deals' ) . '" name="' . $this->get_field_name( 'num_deals' ) . '" class="widefat" placeholder="' . esc_attr__( '', 'automotive' ) . '" value="' . esc_attr( $numdeals ) . '">';
		echo '	<span class="description">' . __( 'Number of vehicles.', 'automotive' ) . '</span>';
		echo '</p>';
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['deals_title'] = !empty( $new_instance['deals_title'] ) ? strip_tags( $new_instance['deals_title'] ) : '';
		$instance['num_deals'] = !empty( $new_instance['num_deals'] ) ? strip_tags( $new_instance['num_deals'] ) : '';
		return $instance;
	}

}
function deals_register_widgets() {
	register_widget( 'Top_Deals' );
}
add_action( 'widgets_init', 'deals_register_widgets' );

class Footer3_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'footer_3_gt',
			__( '. Footer 3', 'automotive' ),
			array(
				'description' => __( 'Footer widget', 'automotive' ),
				'classname'   => 'side-widget',
			)
		);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$text = empty($instance['text']) ? ' ' : apply_filters('widget_text', $instance['text']); ?>
<div class="col-sm-3">
    <h3><?php echo __($title,'automotive');?></h3>
  <p><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?> </p></div>
<?php
		}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
		}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = $instance['text']; ?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e("Title: ","automotive");?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<textarea id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" rows="10" cols="30" ><?php echo $text; ?></textarea>
<p>
  <input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />
  &nbsp;
  <label for="<?php echo $this->get_field_id('filter'); ?>">
    <?php _e('Automatically add paragraphs','automotive'); ?>
  </label>
</p>
<?php

	}
}
class Footer4_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'footer_4_gt',
			__( '. Footer 4', 'automotive' ),
			array(
				'description' => __( 'Footer widget', 'automotive' ),
				'classname'   => 'side-widget',
			)
		);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$address = empty($instance['address']) ? ' ' : apply_filters('widget_title', $instance['address']);?>
<div class="col-sm-3">
  <h3><?php echo __($title,'automotive');?></h3>
 <single-address><?php echo $address;?></single-address>
                        <script type="text/javascript">
	$(document).ready(function(){
   $("single-address").each(function(){
      var embed ="<div class='map'><iframe frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://maps.google.com/maps?f=q&amp;z=15&amp;source=s_q&amp;hl=en&amp;geocode=&amp;iwloc=near&amp;q="+ encodeURIComponent( $(this).text() ) +";&amp;output=embed'></iframe></div>";
      $(this).html(embed);
   });
});
	</script>
</div>
<?php
		}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['address'] = strip_tags($new_instance['address']);
		return $instance;
		}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '','address' => '') );
		$title = strip_tags($instance['title']);
		$address = strip_tags($instance['address']);
		?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e("Title: ","automotive");?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
      </label>
   <label for="<?php echo $this->get_field_id('address'); ?>">
    <?php _e("Address: ","automotive");?>
    <input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo esc_attr($address); ?>" />
  </label>
</p>
<?php }

}
class Footer2_Widget extends WP_Widget {


	public function __construct() {
		parent::__construct(
			'footer_2_gt',
			__( '. Footer 2', 'automotive' ),
			array(
				'description' => __( 'Footer widget', 'automotive' ),
				'classname'   => 'side-widget',
			)
		);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);?>
<div class="col-sm-3">
    <h3><?php echo __($title,'automotive');?></h3>
  <ul class="news">
    <?php $query = new WP_Query(array(
					'post_type' => array('post'),
					'posts_per_page' => 4
					));
						if ( $query->have_posts() ) while ( $query->have_posts() ) : $query->the_post();
					?>
    <p><li><a href="<?php the_permalink();?>">
      <?php the_title();?>
      </a></li></p>
    <?php endwhile; wp_reset_query(); ?>
  </ul>
</div>
<?php }
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
		$text = $instance['text'];
		?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e("Title: ","automotive");?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<?php
	}
}
class Footer1_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'footer_1_gt',
			__( '. Footer 1', 'automotive' ),
			array(
				'description' => __( 'Footer widget', 'automotive' ),
				'classname'   => 'side-widget',
			)
		);
	}
	public function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$text = empty($instance['text']) ? ' ' : apply_filters('widget_text', $instance['text']);
		$pagelink = empty($instance['pagelink']) ? ' ' : apply_filters('widget_pagelink', $instance['pagelink']);
		$blogurl = get_bloginfo('template_url');
		?>
<div class="col-sm-3">
  <h3><?php echo __($title,'automotive');?></h3>
  <p><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></p>
  <p><a class="learn-more" href='<?php echo $pagelink; ?>'> <i class="fa fa-arrow-circle-o-right"></i> <?php _e('Learn more','automotive');?></a><div style="clear:both"></div></p>
</div>
<?php }
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['pagelink'] = strip_tags($new_instance['pagelink']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) );
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
		}
		function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '','pagelink' => '' ) );
		$title = strip_tags($instance['title']);
		$text = $instance['text'];
		$pagelink = strip_tags($instance['pagelink']);
		?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e("Title: ","automotive");?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('pagelink'); ?>">
    <?php _e("URL for full page : ","automotive");?>
    <input class="widefat" id="<?php echo $this->get_field_id('pagelink'); ?>" name="<?php echo $this->get_field_name('pagelink'); ?>" type="text" value="<?php echo esc_attr($pagelink); ?>" />
  </label>
</p>
<textarea id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" rows="10" cols="30" ><?php echo $text; ?></textarea>
<p>
  <input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />
  &nbsp;
  <label for="<?php echo $this->get_field_id('filter'); ?>">
    <?php _e('Automatically add paragraphs','automotive'); ?>
  </label>
</p>
<?php
	}
}


class Feat_Widget extends WP_Widget {


	public function __construct() {
		parent::__construct(
			'feat_widget_gt',
			__( '. Featured Vehicles', 'automotive' ),
			array(
				'description' => __( 'Featured cars in single page', 'automotive' ),
				'classname'   => 'side-widget',
			)
		);
	}
	         public function widget( $args, $instance ) {
			$title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
			$number = isset( $instance['number'] ) ? apply_filters( 'widget_number', $instance['number'] ) : '';
		if ( ! empty( $title ) )
		  ?>
		  <div class="hideOnSearch featured-bottom">
			  <?php  echo $args['before_title'] .'<h3>'.__($title ,'automotive').'</h3>'. $args['after_title'];?>
		<div class="product-list-wrapper">
			<div class="tricol-product-list">
				<div class="row row-no-gutter">
				<?php $query = new WP_Query(array(
					'post_type' => 'gtcd',
					'posts_per_page' => '4',
					'meta_key' => '_featured',
					'meta_value' => 'Yes',
					));
						if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); global $post; $fields = get_post_meta($post->ID, 'mod1', true); $fields3 = get_post_meta($post->ID, 'mod3', true); $fields2 = get_post_meta($post->ID, 'mod2', true);

						// $options = my_get_theme_options();

						?>
				<div class="col-sm-3">
				<div class="item-container">
				<a class="arrivals-link" href="<?php the_permalink();?>">
					<div class="image-container">
							<div class="status-tag <?php echo $fields['statustag'];?>"><?php echo $fields['statustag'];?></div>

											<?php	gorilla_img ($post->ID,'medium');?>
					</div></a>
                    <div class="arrivals-details">
					<p class="title"><?php get_template_part('assets/template-parts/makemodel'); ?></p>
					<div class="price-style"><?php  if (is_numeric( $fields['price'])){ echo $options['currency_text']; echo number_format($fields['price']);} else {  echo $fields['price']; } ?> </div>

					<div class="meta-style"><?php if ( $fields['year']){ echo $fields['year'].' | ';} else {  echo ''; } ?> <?php	 if ( $fields['miles']){ echo $fields['miles'].' '.get_theme_mod('miles_text','Miles');} elseif ($fields['miles'] == '0' ){ echo _e('0','automotive').' '.get_theme_mod('miles_text','Miles');} else {echo '';}  ?></div>
						<?php  echo '<p class="strong grid-location">';?>
						<?php get_template_part('assets/template-parts/location'); ?>
					<div style="clear: both"></div>






					<div class="single_gtcd_save"><?php

								if (class_exists('S2F_Comparing_Public')) { ?>
									<div class="col-sm-6 button"><p></p></div>

								       <div class="col-sm-3 button">
								        <?php echo do_action('auto_del_child_after_result_buttons', $post->ID); ?>
											</div>




								        <?php
								                        } else {
								                            ?><a class="detail-btn" href="<?php the_permalink(); ?>"><?php _e(get_theme_mod('view_details_text','View Details'), 'automotive'); ?></a><?php
								                        } ?>
				</div>










                     </div>
				</div></div>
			<?php endwhile; wp_reset_query(); ?> </div>
            	<?php else: ?>
			<?php endif; ?>
		</div>
	</div>
</div>
		<?php
		echo $args['after_widget'];
	}
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Title', 'automotive' );
		}
		if ( isset( $instance[ 'number' ] ) ) {
			$number = $instance[ 'number' ];
		}
		else {
			$number = __( 'Number of vehicles', 'automotive' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ,'automotive'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of Vehicles:','automotive' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">
		</p>
		<?php
	}
		public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
		return $instance;
	}
}
class Phone_Header_Widget extends WP_Widget
{	public	function __construct() {
	parent::__construct(
		'phone_widget_gt',
		__( '. Header Phone Number', 'automotive' ),
		array(
			'description' => __( 'Add phphone number to header', 'automotive' ),
		)
	);
}
	function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$link = empty($instance['link']) ? ' ' : apply_filters('widget_link', $instance['link']);?>
	<div class="call-us">
		<a class="font" href="tel:<?php echo $title;?>">
			<?php echo $title;?>
		</a>
		<a class="phone"><i class="fa fa-phone-square fa-3x "></i></a>
	</div>
	<?php
	}
	function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['link'] = strip_tags($new_instance['link']);
			return $instance;
	}
	function form($instance) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'link' => '' ) );
			$title = strip_tags($instance['title']);
			$link = strip_tags($instance['link']);?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Phone Number: ","automotive");?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
	}
}
class GTCD_Widget extends WP_Widget
{

	public	function __construct() {
		parent::__construct(
			'gtcd_widget_gt',
			__( '. Search Module', 'automotive' ),
			array(
				'description' => __( 'Add search widget to sidebar', 'automotive' ),
			)
		);
	}
	function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$blogurl = get_bloginfo('template_url')	;
			echo '<span class="hidden-xs">'.$before_widget;
			echo '<h3 class="search-title hidden-xs">'.__($title,'automotive').'</h3>';
			echo $after_title;
			?>
    <div class="collapse navbar-collapse  navbar-search" role="navigation">
	   	<?php cps_search_form();?>
    </div>
	<?php
		echo $after_widget.'</span>';
	}
	function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
	}
	function form($instance) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'profile_id' => '' ) );
			$title = strip_tags($instance['title']);
	?>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">
    	<?php _e("Title: ","automotive");?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	</label>
 	</p>
 	<?php
 	}
}
class Carousel extends WP_Widget
{



	public function __construct() {
		parent::__construct(
			'create_carousel_gt',
			__( '. Homepage Slider', 'automotive' ),
			array(
				'description' => __( 'Featured Cars Carousel', 'automotive' ),
			)
		);
	}
	function widget($args, $instance) {
?>
				<div id="myCarousel" class="carousel slide  hideOnSearch home col-sm-12" data-interval="18000" data-ride="carousel">
					<?php $number_slides = 0;
						// WP_Query arguments
						$args = array (
						'post_type' => array('post','gtcd'),
						'meta_key' =>'_featured',
						'meta_value' =>  'Yes',
						'orderby' => 'date',
						'order' => 'DESC' ,
						'posts_per_page' => 5,);
						// The Query
						$query = new WP_Query( $args );
						if(have_posts()); ?>
						<ol class="carousel-indicators">
							<?php while( $query->have_posts()): $query->the_post(); ?>
								<li data-target="#myCarousel" data-slide-to="<?php echo $number_slides++; ?>"></li>
							<?php endwhile; ?>
  						</ol>
  						<div class="carousel-inner"> <!-- Start Carousel Inner -->
  							<?php $i=1;
	  							$the_query = new WP_Query(array(
	  							'post_type' => array('post','gtcd'),
	  							'meta_key' =>'_featured',
	  							'meta_value' => 'Yes',
	  							'orderby' => 'date',
	  							'order' => 'DESC' ,
								'posts_per_page' => 5,
	  							));
	  							if ($the_query->have_posts()) : while ( $the_query->have_posts() ) : $the_query->the_post();
	  							global $post; $fields = get_post_meta($post->ID, 'mod1', true); $fields3 = get_post_meta($post->ID, 'mod3', true); $fields2 = get_post_meta($post->ID, 'mod2', true);
									  // $options = my_get_theme_options();
	  							if($i == 1){ ?>
	  							<div class="item active">
	  								<a href="<?php the_permalink();?>"><?php gorilla_img ($post->ID,'large'); ?></a>
	  							<div class="carousel-caption"><!-- Start Carousel Caption  -->
										<h2>
										<?php
				$content = get_the_content();
				$content = preg_replace("/<img[^>]+\>/i", " ", $content);
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]>', $content);
				?><?php if ( $fields['year']){ echo $fields['year'];}else {  echo ''; }?></span>


<?php get_template_part( 'assets/template-parts/makemodel' ); ?>


		  								<span class="price-style">
											 <?php get_template_part( 'assets/template-parts/currencyprice' ); ?>
		  								</span>
		  							</h2>
								</div><!-- End Carousel Caption  -->
								</div><!-- End Item Active -->
							<?php } else { ?>
								<div class="item"><!-- Start Item -->
									<a href="<?php the_permalink();?>"><?php gorilla_img ($post->ID,'large'); ?></a>
								<div class="carousel-caption"><!-- Start Carousel Caption  -->
									<h2>
										<?php
				$content = get_the_content();
				$content = preg_replace("/<img[^>]+\>/i", " ", $content);
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]>', $content);
				?><?php if ( $fields['year']){ echo $fields['year'];}else {  echo ''; }?></span>

					<?php get_template_part( 'assets/template-parts/makemodel' ); ?>
						  								<span class="price-style">
															 <?php get_template_part( 'assets/template-parts/currencyprice' ); ?>
						  								</span>
									</h2>
								</div><!-- End Carousel Caption  -->
								</div><!-- End Item  -->
							<?php } $i++; endwhile; else : ?>
									<?php require_once(AUTODEALER_INCLUDES.'/init/carousel.php'); ?>
<?php endif; ?>
						</div>
						<a class="left carousel-control" href="#myCarousel" data-slide="prev">
						<i class="fa fa-angle-left fa-2x"></i></a>
						<a class="right carousel-control" href="#myCarousel" data-slide="next">
						<i class="fa fa-angle-right fa-2x"></i></a>
						<!-- End Carousel-Nav -->
				</div> <!-- End #myCarousel  -->
				<div style="clear:both"></div>

			<?php wp_reset_postdata();?>
				<div style="clear:both"></div>

<?php
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'profile_id' => '' ) );
		$title = strip_tags($instance['title']);
?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e("Number of listings: ","automotive");?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<?php
	}
}
class Full_Specs extends WP_Widget{

	public	function __construct() {
		parent::__construct(
			'full_specs_gt',
			__( '. Vehicle Specifications', 'automotive' ),
			array(
				'description' => __( 'Vehicle pecifications widget', 'automotive' ),
			)
		);
	}

		function widget($args, $instance) {
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$title2 = empty($instance['title2']) ? ' ' : apply_filters('widget_title', $instance['title2']);
		$text2  = apply_filters( 'widget_textarea', empty( $instance['text2'] ) ? '' : $instance['text2'], $instance );
		$title3 = empty($instance['title3']) ? ' ' : apply_filters('widget_title', $instance['title3']);
		$text3  = apply_filters( 'widget_textarea', empty( $instance['text3'] ) ? '' : $instance['text3'], $instance );
		$title4 = empty($instance['title4']) ? ' ' : apply_filters('widget_title', $instance['title4']);
		$text4  = apply_filters( 'widget_textarea', empty( $instance['text4'] ) ? '' : $instance['text4'], $instance );
		?>
<div class="specs side-lift-block" >
  <ul class="refine-nav">
    <?php if(empty($instance['title'])){echo '';} else { ?>
    <li class="first"> <span><?php echo __($title ,'automotive');?></span>
      <?php
			  	global $post, $fields, $fields2, $fields3;
			  	$fields = get_post_meta($post->ID, 'mod1', true);
			  	$fields2 = get_post_meta($post->ID, 'mod2', true);
			  	$fields3 = get_post_meta($post->ID, 'mod3', true);
			  	// $options = my_get_theme_options(); ?>
            <ul>


          <?php if (!empty( $fields2['AdaptiveCruiseControl'])){ echo  '<li><strong>'.get_theme_mod('AdaptiveCruiseControl_text','Cruise Control').': </strong>'.$fields2['AdaptiveCruiseControl'].'</li>';}

        if (!empty( $fields2['AirBagLocCurtain'])){ echo  '<li><strong>'.get_theme_mod('AirBagLocCurtain_text','Airbag Curtain').': </strong>'.$fields2['AirBagLocCurtain'].'</li>';}

          if (!empty( $fields2['AirBagLocFront'])){  echo  '<li><strong>'.get_theme_mod('AirBagLocFront_text','Airbag Curtain').': </strong>'.$fields2['AirBagLocFront'].'</li>';}

					 if (!empty( $fields2['AirBagLocSide'])){  echo  '<li><strong>'.get_theme_mod('AirBagLocSide_text','Airbag Side').': </strong>'.$fields2['AirBagLocSide'].'</li>';}

					   if (!empty( $fields2['BrakeSystemDesc'])){  echo  '<li><strong>'.get_theme_mod('BrakeSystemDesc_text','Brake System').': </strong>'.$fields2['BrakeSystemDesc'].'</li>';}

						 if (!empty( $fields2['BrakeSystemType'])){  echo  '<li><strong>'.get_theme_mod('BrakeSystemType_text','Brake Type').': </strong>'.$fields2['BrakeSystemType'].'</li>';}

					 if (!empty( $fields2['CurbWeightLB'])){  echo  '<li><strong>'.get_theme_mod('CurbWeightLB_text','Curb Weight').': </strong>'.$fields2['CurbWeightLB'].'</li>';}

					 if (!empty( $fields2['Doors'])){  echo  '<li><strong>'.get_theme_mod('Doors_text','Doors').': </strong>'.$fields2['Doors'].'</li>';}

						 if (!empty( $fields2['EngineCycles'])){  echo  '<li><strong>'.get_theme_mod('EngineCycles_text','Engine Cycles').': </strong>'.$fields2['EngineCycles'].'</li>';}


						 if (!empty( $fields2['EngineCylinders'])){  echo  '<li><strong>'.get_theme_mod('EngineCylinders_text','Engine Cylinders Curtain').': </strong>'.$fields2['EngineCylinders'].'</li>';}

			 if (!empty( $fields2['EngineModel'])){  echo  '<li><strong>'.get_theme_mod('EngineModel_text','Engine Model').': </strong>'.$fields2['EngineModel'].'</li>';}


					if (!empty( $fields2['EntertainmentSystem'])){  echo  '<li><strong>'.get_theme_mod('EntertainmentSystem_text','Entertainment System').': </strong>'.$fields2['EntertainmentSystem'].'</li>';}


						 if (!empty( $fields2['EquipmentType'])){  echo  '<li><strong>'.get_theme_mod('EquipmentType_text','Equipment Type').': </strong>'.$fields2['EquipmentType'].'</li>';}

						 if (!empty( $fields2['FuelTypePrimary'])){  echo  '<li><strong>'.get_theme_mod('FuelTypePrimary_text','Fuel Type').': </strong>'.$fields2['FuelTypePrimary'].'</li>';}

						 if (!empty( $fields2['Manufacturer'])){  echo  '<li><strong>'.get_theme_mod('Manufacturer_text','Manufacturer').': </strong>'.$fields2['Manufacturer'].'</li>';}

							 if (!empty( $fields2['RearVisibilityCamera'])){  echo  '<li><strong>'.get_theme_mod('RearVisibilityCamera_text','Rear Visibility Camera').': </strong>'.$fields2['RearVisibilityCamera'].'</li>';}

		if (!empty( $fields2['SeatBeltsAll'])){  echo  '<li><strong>'.get_theme_mod('SeatBeltsAll_text','Seatbelts').': </strong>'.$fields2['SeatBeltsAll'].'</li>';}


			 if (!empty( $fields2['Seats'])){  echo  '<li><strong>'.get_theme_mod('Seats_text','Seats').': </strong>'.$fields2['Seats'].'</li>';}

			if (!empty( $fields2['Trim'])){  echo  '<li><strong>'.get_theme_mod('Trim_text','Trim').': </strong>'.$fields2['Trim'].'</li>';}


          if (!empty( $fields2['Windows'])){  echo  '<li><strong>'.get_theme_mod('Windows_text','Windows').': </strong>'.$fields2['Windows'].'</li>';}

						?>


  </ul>
    </li>
    <?php } ?>
    <?php if(empty($instance['title2'])){echo '';}else{?>
    <li class="second"> <span><?php echo __($title2 ,'automotive'); ?></span>
      <ul>
        <li><?php echo wpautop( $text2 ) ; ?></li>
      </ul>
    </li>
    <?php } ?>
    <?php if(empty($instance['title3'])){echo '';}else{?>
    <li class="third"> <span><?php echo __($title3 ,'automotive'); ?></span>
      <ul>
        <?php echo wpautop ($text3); ?>
      </ul>
    </li>
    <?php } ?>
    <?php if(empty($instance['title4'])){echo '';}else{?>
    <li class="fourth"> <span><?php echo __($title4 ,'automotive'); ?></span>
      <ul>
        <?php echo $text4; ?>
      </ul>
    </li>
    <?php } ?>
  </ul>
</div>
<?php }
		function form($instance) {
			$title = $instance['title'];
			$title2 = $instance['title2'];
			$title3 = $instance['title3'];
			$title4 = $instance['title4'];
			$text2 = $instance['text2'];
			$text3 = $instance['text3'];
			$text4 = $instance['text4'];
			?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e("<strong>Enter Vehicle Specifications title:</strong> <br/>(leave empty to hide) ","automotive");?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('title2'); ?>">
    <?php _e("<strong>Enter title for second module:</strong> <br/>(leave empty to hide)","automotive");?>
    <input class="widefat" id="<?php echo $this->get_field_id('title2'); ?>" name="<?php echo $this->get_field_name('title2'); ?>" type="text" value="<?php echo esc_attr($title2); ?>" />
  </label>
</p>
<textarea id="<?php echo $this->get_field_id('text2'); ?>" name="<?php echo $this->get_field_name('text2'); ?>" rows="10" cols="33" ><?php echo wpautop( $text2 ); ?></textarea>
<p>
  <label for="<?php echo $this->get_field_id('title3'); ?>">
    <?php _e("Enter title for third module:</strong> <br/>(leave empty to hide)","automotive");?>
    <input class="widefat" id="<?php echo $this->get_field_id('title3'); ?>" name="<?php echo $this->get_field_name('title3'); ?>" type="text" value="<?php echo esc_attr($title3); ?>" />
  </label>
</p>
<textarea id="<?php echo $this->get_field_id('text3'); ?>" name="<?php echo $this->get_field_name('text3'); ?>" rows="10" cols="33" ><?php  echo wpautop( $text3 ); ?></textarea>
<p>
  <label for="<?php echo $this->get_field_id('title4'); ?>">
    <?php _e("<strong>Enter title for fourth module:</strong> <br/>(leave empty to hide)","automotive");?>
    <input class="widefat" id="<?php echo $this->get_field_id('title4'); ?>" name="<?php echo $this->get_field_name('title4'); ?>" type="text" value="<?php echo esc_attr($title4); ?>" />
  </label>
</p>
<textarea id="<?php echo $this->get_field_id('text4'); ?>" name="<?php echo $this->get_field_name('text4'); ?>" rows="10" cols="33" ><?php echo wpautop( $text4 );?></textarea>
<?php
	}
	function update($new_instance, $old_instance) {	return $new_instance; }
}
class Homepage_Vehicles extends WP_Widget {

	public	function __construct() {
		parent::__construct(
			'homepage_gt',
			__( '. Homepage Listings', 'automotive' ),
			array(
				'description' => __( 'Add listings to your homepage', 'automotive' ),
			)
		);
	}

	function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			$number = empty($instance['number']) ? ' ' : apply_filters('widget_number', $instance['number']);
			?>
			<div class="hideOnSearch">
					<div class="product-list-wrapper">
						<div class="tricol-product-list">

								<div class="col-sm-12">
									<h2 class="visible-xs"><?php _e('New Arrivals', 'automotive');?></h2>
								</div>
							<?php $query = new WP_Query(array(
			                    'post_type' => array('gtcd','user_listing'),
			                    'posts_per_page' => $number,
			                    ));
			                        if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); global $post; $fields = get_post_meta($post->ID, 'mod1', true); $fields3 = get_post_meta($post->ID, 'mod3', true); $fields2 = get_post_meta($post->ID, 'mod2', true) ;

															// $options = my_get_theme_options();

															?>
									<div class="col-sm-4">
									<div class="item-container">
									<div class="image-container">
										 <div class="status-tag <?php echo $fields['statustag'];?>"><?php echo $fields['statustag'];?></div>
											<?php if ('user_listing' == get_post_type($post->ID)) {
			                            $args = array(
			                                        'order'          => 'ASC',
			                                        'orderby'        => 'menu_order',
			                                        'post_type'      => 'attachment',
			                                        'post_parent'    => $post->ID,
			                                        'post_mime_type' => 'image',
			                                        'post_status'    => null,
			                                        'numberposts'    => 1,
			                                        );
			                            $attachments = get_posts($args);
			                            if ($attachments) {
			                                foreach ($attachments as $attachment) {
			                                    arrivals_img($post->ID, 'medium');
			                                }
			                            }
			                        } elseif ('gtcd' == get_post_type($post->ID)) {
			                            ?><a href="<?php the_permalink(); ?>" ><?php gorilla_img($post->ID, 'medium'); ?></a><?php
			                        }?>
											</div>
											<div class="arrivals-details">
											<p class="vehicle-name"><span class="mini-hide"><?php if ($fields['year']) {
			                            echo $fields['year'];
			                        } else {
			                            echo '';
			                        }?>
											<?php get_template_part('assets/template-parts/makemodel'); ?>
											</p>
											<div class="price-style">
												<?php  if (is_numeric($fields['price'])){  get_template_part( 'assets/template-parts/currencyprice' );} else { echo $fields['price'];} ?>
											</div>
											<div class="meta-style">
												<?php if ($fields['miles']) {
			                            echo $fields['miles'].' '.get_theme_mod('miles_text','Miles');
			                        } elseif ($fields['miles'] == '0') {
			                            echo _e('0', 'automotive').' '.get_theme_mod('miles_text','Miles');
			                        } else {
			                            echo '';
			                        }  ?>
											</div>
											<div class="meta-style">
												<?php if ($fields['stock']) {
			                            echo get_theme_mod('stock_text','Stock').'#: '.$fields['stock'];
			                        } else {
			                            echo '';
			                        }  ?>
											</div>
											<?php echo '<p class="strong grid-location">';?>


															<?php get_template_part('assets/template-parts/location'); ?>


														</p>
															<div style="clear: both"></div>
														<div class="homepage_save"><?php

			if (class_exists('S2F_Comparing_Public')) {
			                            ?>
								<div class="col-sm-6 button"><p></p></div>

			       <div class="col-lg-3 col-sm-4  button">
			        <?php  echo do_action('auto_del_child_after_result_buttons', $post->ID); ?>

							</div>





			        <?php
			                        } else {
			                            ?> <a class="detail-btn standalone" href="<?php the_permalink(); ?>"><?php _e(get_theme_mod('view_details_text','View Details'), 'automotive'); ?></a><?php
			                        } ?>
			                     					</div>	</div>

											</div>
										</div>
									<?php endwhile;?>
								<?php wp_reset_query(); ?>
							<?php else: ?>
							<?php require_once(AUTODEALER_INCLUDES.'/init/arrivals.php'); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
<?php

			}
	function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['number'] = strip_tags($new_instance['number']);
			return $instance;
	}
	function form($instance) {

			$instance = wp_parse_args( (array) $instance, array( 'number' => '' ) );
			$number = strip_tags($instance['number']);


			?>
<p>
  <label for="<?php echo $this->get_field_id('number'); ?>">
    <?php _e("Enter Number of Vehicles","automotive");?>
    <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
  </label>
</p>
<?php
}
}

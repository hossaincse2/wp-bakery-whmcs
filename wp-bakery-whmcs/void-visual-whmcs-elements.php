<?php
/**
 * Plugin Name: Void WPBakery WHMCS Elements
 * Description: Adds Verious Widgets such as Live Domain Searcher, Pricing Table, Knowledge Base in Elementor for being used with your WHMCS or WHMCS Bridge Plugin for Hosting Website.
 * Version:     1.0.4
 * Author:      VOID CODERS
 * Author URI:  http://voidcoders.com
 * Plugin URI:  http://voidcoders.com/product/elementor-whmcs-elements/
 * Text Domain: void_wbwhmcse
 */
/* This loads the plugin.php file which is the main one */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'VOID_WBWHMCSE_ELEMENTS_FILE_', __FILE__ );

define( 'VOID_WBWHMCSE_PLUGIN_NAME', 'Void WPBakery WHMCS Elements' );

/**
 *
 * Load the plugin after Elementor (and other plugins) are loaded.
 *
 * @since 1.0.0
 */
function void_wbwhmcse_load_elements() {
  // Load localization file
  load_plugin_textdomain( 'void_wbwhmcse' ); 

  void_wbwhmcse_widget_register();
  

  // Notice if the Elementor is not active
  if ( ! did_action( 'js_composer/loaded' ) ) {
    add_action( 'admin_notices', 'void_wbwhmcse_fail_load' );
    return;
  }

    
  // Require the main plugin file
   require( __DIR__ . '/helper/helper.php' ); // load helper functions
}
add_action( 'plugins_loaded', 'void_wbwhmcse_load_elements' );   //notiung but checking and notice
 

function void_wbwhmcse_widget_register(){
  // echo __DIR__ . '/templates/domainSearch.php';
  // require( __DIR__ . '/widgets/section-domain-search.php' ); 
   includes();
   if (class_exists('Section_Domain_Search')) {
   $obj_inits = new Section_Domain_Search;
  }
   if (class_exists('Section_Pricing')) {
   $obj_inits = new Section_Pricing;
  }
   if (class_exists('Section_knowledgebase')) {
   $obj_inits = new Section_knowledgebase;
  }
}

function includes() {
   $void_widgets= array_map('basename', glob(dirname( __FILE__ ) . '/widgets/*.php'));
  foreach($void_widgets as $key => $value){
        require ( __DIR__ . '/widgets/'.$value );
  }
}
 
function void_wbwhmcse_fail_load_out_of_date() {  // if plungin is outdated
  if ( ! current_user_can( 'update_plugins' ) ) {
    return;
  }
  $message = '<p>' . sprintf(__('<strong>%s</strong> Needs <a href="%s">WPBakery Page Builder</a> version higher than the one you have! Please update your <strong>WPBakery Page Builder</strong> plugin.','void_wbwhmcse'), 'https://wpbakery.com',VOID_WBWHMCSE_PLUGIN_NAME ) . '</p>';

  echo '<div class="error">' . $message . '</div>';
}

function void_wbwhmcse_fail_load() {  // if plungin is not isntalled
  if ( ! current_user_can( 'update_plugins' ) ) {
    return;
  }
  $message = '<p>' . sprintf(__('<a href="%s">WPBakery Page Builder</a> must be installed for <strong>%s</strong> plugin to work! Please Install it first','void_wbwhmcse'), 'https://wpbakery.com',VOID_WBWHMCSE_PLUGIN_NAME ) . '</p>';
 
  echo '<div class="error">' . $message . '</div>';
}

// add css frontend
 function WB_whmcs_add_scripts(){
  wp_register_script( 'domain-search', plugins_url( '/assets/js/domain-search.js', __FILE__), [ 'jquery' ], true, true );
    
  $our_script_array = array(	'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'button_available' => esc_html__( 'Buy Now' ),
                'button_unavailable' => esc_html__( 'Not Available' ),
                'button_info' => esc_html__( 'Search Again' ),
                'domain_available' => esc_html__( 'Congratulations! The domain is available.' ),
                'domain_unavailable' => esc_html__( 'Sorry! The Domain is already taken! Search Another one.'));
   wp_localize_script( 'domain-search', 'domainjs_texts', $our_script_array ); 
   wp_enqueue_style( 'void-whmcse', plugins_url( '/assets/css/style.css' , __FILE__ )); 

}
add_action( 'init', 'WB_whmcs_add_scripts' );


//add admin css
function void_wbwhmcse_admin_css(){
    global $pagenow;
    if( $pagenow == 'index.php' || ( !empty( $_GET['page'] ) && $_GET['page']=='void_whcms_pro')){
        wp_enqueue_style( 'void-cf7-admin', plugins_url( 'assets/css/void-cf7-admin.css', __FILE__ ) );
    }
}
add_action( 'admin_enqueue_scripts', 'void_wbwhmcse_admin_css' );


// add plugin activation time

function void_wbwhmcse_activation_time(){
    $get_installation_time = strtotime("now");
    add_option('void_wbwhmcse_elementor_activation_time', $get_installation_time ); 
}
register_activation_hook( __FILE__, 'void_wbwhmcse_activation_time' );

//check if review notice should be shown or not

function void_wbwhmcse_check_installation_time() {

    $spare_me = get_option('void_wbwhmcse_spare_me');
    if( !$spare_me ){
        $install_date = get_option( 'void_wbwhmcse_elementor_activation_time' );
        $past_date = strtotime( '-7 days' );
     
        if ( $past_date >= $install_date ) {
     
            add_action( 'admin_notices', 'void_wbwhmcse_display_admin_notice' );
     
        }
    }
}
add_action( 'admin_init', 'void_wbwhmcse_check_installation_time' );
 
/**
* Display Admin Notice, asking for a review
**/
function void_wbwhmcse_display_admin_notice() {
    // wordpress global variable 
    global $pagenow;
    if( $pagenow == 'index.php' ){
 
        $dont_disturb = esc_url( get_admin_url() . '?spare_me_ewhmcse=1' );
        $plugin_info = get_plugin_data( __FILE__ , true, true );       
        $reviewurl = esc_url( 'https://wordpress.org/support/plugin/void-visual-whmcs-elements/reviews/#new-post' );
        $void_url = esc_url( 'https://voidcoders.com' );
     
        printf(__('<div class="void-cf7-review wrap">You have been using <b> %s </b> for a while. We hope you liked it ! Please give us a quick rating, it works as a boost for us to keep working on the plugin ! Also you can visit our <a href="%s" target="_blank">site</a> to get more themes & Plugins<div class="void-cf7-review-btn"><a href="%s" class="button button-primary" target=
            "_blank">Rate Now!</a><a href="%s" class="void-cf7-review-done"> Already Done !</a></div></div>', $plugin_info['TextDomain']), $plugin_info['Name'], $void_url, $reviewurl, $dont_disturb );
    }
}
// remove the notice for the user if review already done or if the user does not want to
function void_wbwhmcse_spare_me(){    
    if( isset( $_GET['spare_me_ewhmcse'] ) && !empty( $_GET['spare_me_ewhmcse'] ) ){
        $spare_me = $_GET['spare_me_ewhmcse'];

        if( $spare_me == 1 ){
            add_option( 'void_wbwhmcse_spare_me' , TRUE );
            update_option( 'void_wbwhmcse_spare_me' , TRUE );
        }
    }
}
add_action( 'admin_init', 'void_wbwhmcse_spare_me', 5 );



// Plugin Menu
function void_wbwhmcse_custom_menu_page(){
    add_menu_page( 
        __( 'VOID WHMCS', 'void_wbwhmcse' ),
        'WHMCS WPBkary',
        'manage_options',
        'void_whmcs_page',
        'void_wbwhmcse_func',
        '',
        6
    ); 
}
add_action( 'admin_menu', 'void_wbwhmcse_custom_menu_page' );
  

/**
 * Display a custom menu page
 */
function void_wbwhmcse_func(){ ?>

<div class="wrap about-wrap">
  
  <div class="about-text" style=" margin: 15px 2px; ">
    <?php _e('<h4 style=" display: inline; ">Shaping the void~</h4> <a href="http://voidcoders.com" target="_blank">voidcoders</a><br><br>We are voidcoders and we create WordPress goods & WEB Apps & <span style=" color: #2196F3; font-weight: 600; ">Custom Script! </span>','void_wbwhmcse' ); ?>
  </div>
  
  <h4><?php _e( 'Void Visual WHMCS Elements Preview' ,'void_wbwhmcse'); ?></h4>

  <?php echo wp_oembed_get('https://www.youtube.com/watch?v=IFHOMMMowbA',array('width'=>'700')); ?>

  
  <div class="changelog">
  <br>
    <div class="feature-section images-stagger-right">
      <h4><?php _e( 'Check Our Exciting Products & Offeres Bellow' ,'void_wbwhmcse'); ?></h4>
    </div>

        <object type="text/html" data="//voidcoders.com/promo-products" width:="" style=" height: -webkit-fill-available; width: -webkit-fill-available; "> </object>

  </div>

</div>

<?php 
}

function void_wbwhmcse_go_pro(){

  add_submenu_page( 'void_whmcs_page', 'Go Pro', '<span class="dashicons dashicons-star-filled" style="color: #4cb696; font-size: 17px"></span>Go Pro', 'manage_options', 'void_whcms_pro', 'void_wbwhmcse_goPro' );

}

add_action( 'admin_menu', 'void_wbwhmcse_go_pro' );

function void_wbwhmcse_goPro(){ ?>

<div class="void-ewhmcse-table">
    <div class="table">
    <div class="table-cell">VOID<img style="width: 60px;" src="<?php plugins_url( '/assets//logovoid.png', __FILE__ ); ?>">CODERS</div>
    <div class="table-cell plattform">
      <h3><?php esc_html_e('Free','void_wbwhmcse') ?></h3>
    </div>
    <div class="table-cell enterprise">
      <h3><?php esc_html_e('Pro ( 14$ (Lifetime*))','void_wbwhmcse') ?></h3>
      <a href="<?php echo esc_url('https://voidcoders.com/product/elementor-whmcs-elements-pro/') ?>" class="btn" target="_blank">Get Now</a>
    </div>
    <div class="table-cell cell-feature"><?php esc_html_e('Domain Search WHMCS','void_wbwhmcse') ?></div>
    <div class="table-cell">
      <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
    <div class="table-cell">
      <svg class="enterprise-check" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
    <div class="table-cell cell-feature"><?php esc_html_e('Live Ajax Domain Search','void_wbwhmcse') ?></div>
    <div class="table-cell">
      <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
    <div class="table-cell">
      <svg class="enterprise-check" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
    <div class="table-cell cell-feature"><?php esc_html_e('Knowledge Base form for WHMCS','void_wbwhmcse') ?></div>
    <div class="table-cell">
      <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
    <div class="table-cell">
      <svg class="enterprise-check" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
    <div class="table-cell cell-feature"><?php esc_html_e('1 Style Live pricing table from WHMCS','void_wbwhmcse') ?></div>
    <div class="table-cell">
      <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
    <div class="table-cell">
      <svg class="enterprise-check" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
    <div class="table-cell cell-feature"><?php esc_html_e('General Pricing table','void_wbwhmcse') ?></div>
    <div class="table-cell">
      <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
    <div class="table-cell">
      <svg class="enterprise-check" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen"/>
      </svg>
    </div>
    <div class="table-cell cell-feature"><?php esc_html_e('6+ Style Live pricing table from WHMCS','void_wbwhmcse') ?></div>
    <div class="table-cell"></div>
    <div class="table-cell">
      <svg class="enterprise-check" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
    <div class="table-cell cell-feature"><?php esc_html_e('Domain TLD pricing table from WHMCS','void_wbwhmcse') ?></div>
    <div class="table-cell"></div>
    <div class="table-cell">
      <svg class="enterprise-check" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
    <div class="table-cell cell-feature"><?php esc_html_e('WHMCS login form','void_wbwhmcse') ?></div>
    <div class="table-cell"></div>
    <div class="table-cell">
      <svg class="enterprise-check" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
    <div class="table-cell cell-feature"><?php esc_html_e('Dedicated Support','void_wbwhmcse') ?></div>
    <div class="table-cell"></div>
    <div class="table-cell">
      <svg class="enterprise-check" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>

    <div class="table-cell cell-feature"><?php esc_html_e('More Features Update','void_wbwhmcse') ?></div>
    <div class="table-cell"></div>
    <div class="table-cell">
      <svg class="enterprise-check" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <title>check_blue</title>
        <path d="M6.116 14.884c.488.488 1.28.488 1.768 0l10-10c.488-.488.488-1.28 0-1.768s-1.28-.488-1.768 0l-9.08 9.15-4.152-4.15c-.488-.488-1.28-.488-1.768 0s-.488 1.28 0 1.768l5 5z" fill="limegreen" fill-rule="evenodd"/>
      </svg>
    </div>
  </div>
</div>
<div style="text-align: center;">

<h3 style="color: green;">**Get Our Featured Hosting WordPress Theme with WHMCS Elements Pro For Free**</h3>
<a href="https://voidcoders.com/product/hostdaddy-responsive-whmcs-hosting-wordpress-theme/" target="_blank">
<img src="<?php plugins_url( '/assets//01_preview.png', __FILE__ ); ?>"></a>
</div>

<?php }
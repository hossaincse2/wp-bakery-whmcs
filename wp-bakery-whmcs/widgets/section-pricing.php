<?php
   
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Visual Style for header
 *
 *
 * @since 1.0.0
 */

  
class Section_Pricing {


    /**
     * Get things started
     */
    function __construct() {

        add_action('init', array($this, 'void_wbwhmcse_register_price_controls'));
        add_shortcode('void_wbwhmcse_laouts_price', array($this, 'void_wbwhmcse_laouts_price_rendering'));
	}
	  
    function void_wbwhmcse_register_price_controls() {
        if (function_exists("vc_map")) { 
            //Register "section" section element.
            vc_map(array(
                "name" => __("WHMCS Pricing Table", "void_wbwhmcse"),
                "base" => "void_wbwhmcse_laouts_price",
                "category" => esc_html__( 'VOID ELEMENTS', 'void_wbwhmcse' ),
                "content_element" => true,
                "icon" => 'icon-wpb-row',
                "params" => array(
			                	
								array(
									"type" => "checkbox",
									"class" => "",
									"heading" => __("Get Packedge Title Directly","void_wbwhmcse"),
									"param_name" => "auto_title",
									"value" => "Basic Plan",
									"description" => __("If turned on the packedge name is featched automatically from your whmcs url defined above. Give the ID of your product of WHMCS Product in the Product ID field so that the data can be fatched","void_wbwhmcse"),
 								),
								array(
									"type" => "textfield",
									"class" => "",
									"heading" => __("Packedge Title","void_wbwhmcse"),
									"param_name" => "table_title",
									"value" => "Basic Plan",
  								),
								array(
									"type" => "attach_image",
									"class" => "",
									"heading" => __("Packedge Image","void_wbwhmcse"),
									"param_name" => "package_image",
									"description" => __("Please Upload Image Or Icon","void_wbwhmcse"),
								 ),
								   
								 array(
									"type" => "textarea_html",
									"class" => "",
									"heading" => __("Price Content","void_wbwhmcse"),
									"param_name" => "content",
									"value" => "<ul class='pt-features'>
													<li class='feature-item'>Your Content Here</li>
													<li class='feature-item'>Your Content Here</li>
													<li class='feature-item'>Your Content Here</li>
													<li class='feature-item'>Your Content Here</li>
													<li class='feature-item'>Your Content Here</li>
												</ul>",
									"description" => "",
									"group"         => "Content",
								),
								 
								array(
									"type" => "checkbox",
									"class" => "",
									"heading" => __("Get Monthly Packedge Price Directly","void_wbwhmcse"),
									"param_name" => "auto_price",
									"description" => "If turned on the packedge price is featched automatically from your whmcs url defined above. Give the ID of your product of WHMCS Product so that the data can be fatched in product id filed",
								 ),
								 array(
									"type" => "textfield",
									"class" => "",
									"heading" =>  __( 'Packedge ID from WHMCS', 'void_wbwhmcse' ),
									"param_name" => "packedge_id",
									"value" => "1",
									"dependency" => array('element' => 'auto_price', 'value' => 'true'),
									"description" => __('Provide the Packedge ID number of your product so the system can get the details of product via the ID from your defined WHMCS url in above. The Featched data will be visible to page after you hit save & check the page', 'void_wbwhmcse'),
 								  ),
								 array(
									"type" => "textfield",
									"class" => "",
									"heading" => __("Currency Number","void_wbwhmcse"),
									"param_name" => "currency_number",
									"value" =>'1',
									"dependency" => array('element' => 'auto_price', 'value' => 'true'),
									"description" => __("The currency number from your WHMCS. Generally the default currency is numbered - 1", "void_wbwhmcse"),
								 ), 
								 array(
							        "type" => "dropdown",
							        "class" => "",
							        "heading" => __("Billing Cycle","void_wbwhmcse"),
									"param_name" => "billingcycle",
									"dependency" => array('element' => 'auto_price', 'value' => 'true'),
							        "value" => array(
										'monthly'  => esc_html__( 'monthly', 'void_wbwhmcse' ),
										'quarterly'  => esc_html__( 'quarterly', 'void_wbwhmcse' ),
 										'semiannually'  => esc_html__( 'semiannually', 'void_wbwhmcse' ),
										'annually'  => esc_html__( 'annually', 'void_wbwhmcse' ),
										'biennially'  => esc_html__( 'biennially', 'void_wbwhmcse' ),
										'triennially'  => esc_html__( 'triennially', 'void_wbwhmcse' ),
							        ),
									'save_always' => true,
								 ),
								array(
									"type" => "textfield",
									"class" => "",
									"heading" => __("Auto Price After Text","void_wbwhmcse"),
									"param_name" => "billingafter",
									"value" => "/Mo",
									"dependency" => array('element' => 'auto_price', 'value' => 'true'),
 								 ), 
								array(
									"type" => "textfield",
									"class" => "",
									"heading" => __("Use Old Price","void_wbwhmcse"),
									"param_name" => "oldprice",
									"value" => "$60",
									"description" => __( 'Show old packedge price like was-5$ now discounted. Leave empty to disable.', 'void_wbwhmcse' ),
								  ),
								  array(
									"type" => "textfield",
									"class" => "",
									"heading" => __("Packedge Price","void_wbwhmcse"),
									"param_name" => "price",
									"value" => "$229.00/Mo",
  								 ), 
								  array(
									"type" => "textfield",
									"class" => "",
									"heading" => __("WHMCS URL","void_wbwhmcse"),
									"param_name" => "whmcs_url",
									"value" => "https://voidcoders.com/voidwhmcs",
  								 ), 
								  
								array(
									"type" => "dropdown",
									"class" => "",
									"heading" => __("Show Button","void_wbwhmcse"),
									"param_name" => "table_show_button",
									"value" => array(
										"Yes" => "yes",
										"No" => "no"
									),
									'save_always' => true,
									"group"         => "Button",
								),
					            array(
					                "type" => "textfield",
					                "class" => "",
					                "heading" => __( 'Button Text', 'void_wbwhmcse' ),
					                "param_name" => "button_text",
					                "value" => "Buy Now",
					                "description" => __("Default Label is Buy Now","void_wbwhmcse"),
					                "dependency" => array('element' => 'table_show_button', 'value' => 'yes'),
					                "group"         => "Button",
					            ),
								array(
									"type" => "textfield",
									"class" => "",
									"heading" => __( 'Button Url', 'void_wbwhmcse' ),
									"param_name" => "website_link",
									"value" => "http://voidcoders.com",
									"dependency" => array('element' => 'table_show_button', 'value' => 'yes'),
									"group"         => "Button",
								),
								array(
									"type" => "dropdown",
									"class" => "",
									"heading" => __("Button Target","void_wbwhmcse"),
									"param_name" => "table_target",
									"value" => array(
										"" => "",
										"Self" => "_self",
										"Blank" => "_blank",	
										"Parent" => "_parent"
									),
									"dependency" => array('element' => 'table_show_button', 'value' => 'yes'),
									"group"         => "Button",
								),
								array(
									"type" => "checkbox",
									"class" => "",
									"heading" => __( 'Make Featured', 'void_wbwhmcse' ),
									"param_name" => "make_featured",
									"value" => "",
 									"group"         => "Featured",
								),
								array(
									"type" => "textfield",
									"class" => "",
									"heading" => __( 'Featured Text', 'void_wbwhmcse' ),
									"param_name" => "featured_title",
									"value" => "Best Deal",
 									"group"         => "Featured",
								),
					             
								array(
									"type" => "dropdown",
									"class" => "",
									"heading"  => __( 'Select Style', 'void_wbwhmcse' ),
									"param_name" => "table_style",
									"value" => array(
										'void-price-0'  => esc_html__( 'void-price-0', 'void_wbwhmcse' ), 
										'void-price-1'  => esc_html__( 'void-price-1', 'void_wbwhmcse' ), 
									),
									"dependency" => array('element' => 'table_show_button', 'value' => 'yes'),
									"group"         => "Style",
								),
								array(
									"type" => "colorpicker",
									"class" => "",
									"heading" => __( 'Button Text Color', 'void_wbwhmcse' ),
									"param_name" => "button_text_color",
									"value" => "",
 									"group" => "Style",
								  ),
								array(
									"type" => "css_editor",
									"class" => "",
									"heading" => __( 'Button Css', 'void_wbwhmcse' ),
									"param_name" => "buy_btn_css",
									"value" => "",
 									"group" => "Style",
								  ),
								  array(
									"type" => "colorpicker",
									"class" => "",
									"heading" => __( 'Button Text Hover Color', 'void_wbwhmcse' ),
									"param_name" => "button_text_hover_color",
									"value" => "",
 									"group" => "Style",
								  ),
								array(
									"type" => "css_editor",
									"class" => "",
									"heading" => __( 'Button Hover Css', 'void_wbwhmcse' ),
									"param_name" => "buy_btn_css_hover",
									"value" => "",
 									"group" => "Style",
								  ),
								  array(
									"type" => "dropdown",
									"class" => "",
									"heading"  => __( 'Pricing Style', 'void_wbwhmcse' ),
									"param_name" => "pricing_style",
									"value" => array(
										'void-price-normal'  => esc_html__( 'Default', 'void_wbwhmcse' ),
			     						'void-price-rounded'  => esc_html__( 'Rounded', 'void_wbwhmcse' ),
									),
									"dependency" => array('element' => 'table_show_button', 'value' => 'yes'),
									"group"         => "Style",
								), 
								array(
									"type" => "html",
									"heading" => __("<h3 style='padding: 10px;background: #2b4b80;color: #fff;'>Limited Offer : 60% Discount on Release</h3>
													<a target='_blank' href='https://voidcoders.com/wpbakery-visual-composer-whmcs-elements-pro-subscription/' >Subscribe to get pro version when released</a>", "void_wbwhmcse" ),
									"param_name" => "pro_feature",
									"group" => "Pro Features"
								),

								
					)
            ));


        }
    }

    function void_wbwhmcse_laouts_price_rendering($atts, $content = null, $tag) {

		global $whmcs_bridge_enabled;
	
		extract(shortcode_atts(array(
			'auto_title' => '',
			'table_title' => 'Entry Server',
			'package_image' => '',
			'currency_number' => '1',
			'billingcycle' => 'monthly',
			'table_style' => '', 
			'pricing_style' => 'void-price-normal', 
			'oldprice' => '$60',
			'auto_price' => '',
			'billingafter' => '/Mo',
			'price' => '$229.00/Mo',
			'packedge_id' => '1',
			'make_featured' => 'yes',
			'featured_title' => 'Best Deal',
  			'button_text_color' => '#fff',
			'button_text_hover_color' => '#fff',
			'button_text_size' => '',
			'buy_btn_css' => '',
			'buy_btn_css_hover' => '',
			'target' => '',
			'button_text' => 'Buy Now',
			'website_link' => 'https://voidcoders.com/',
			'whmcs_url' => 'https://voidcoders.com/voidwhmcs',
			'active' => 'yes',
			'active_text' => '', 

		), $atts)); 
 			$buy_btn_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $buy_btn_css, ' ' ), $this->settings['base'], $atts );
			$buy_btn_css_hover = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $buy_btn_css_hover, ' ' ), $this->settings['base'], $atts );
  			ob_start();  
			?>
		<?php if($table_style == 'void-price-1' ) : ?>

<div class="void-pricing-3 pt-type6">
	<div class="pt-header">
	<?php $images = wp_get_attachment_image_src( $package_image, 'pricing_image' ); ?>
    <?php if($images[0]){ ?><img src="<?php echo $images[0];  ?>" alt="<?php echo $table_title; ?> "> <?php } ?>  

		<h3 class="plan-title">
			<?php if($auto_title && $whmcs_url!='' && $packedge_id){ echo'<script language="javascript" src="'.$whmcs_url.'/feeds/productsinfo.php?pid='. $packedge_id .'&get=name"></script>'; } else{  echo $table_title; } ; ?>
  		</h3>
		<h4 class="plan-price">
			<?php if($oldprice!=''){echo '<span class="old-price-span">'.$oldprice.'</span>'; } ?> 
			<?php if( $auto_price && $whmcs_url!='' && $packedge_id ) { echo'<script language="javascript" src="'. esc_url($whmcs_url.'/feeds/productsinfo.php?pid='. $packedge_id .'&get=price&billingcycle='. $billingcycle .'&currency='.$currency_number).'"></script>'. $billingafter; } else{echo $price; } ?>
 		</h4>
	</div> 	
	<?php echo $content; ?> 
	<div class="pt-footer">
		<?php if( $make_featured ): ?>
		<div class="sale-box">
			<span class="on_sale title_shop"><?php echo $featured_title; ?></span>
		</div>
		<?php endif; ?>
		<?php echo '<a class="magicmore pb-get hvr-bs '.esc_attr($buy_btn_css).' '.esc_attr($button_text_color).'" href="' . esc_url($website_link) . '" ' . esc_attr($target) .'>'. $button_text.'</a>'; ?>
	</div>
</div>

<?php else: echo $table_style; ?>
		
<div class="<?php echo $table_style.' '.$pricing_style;  ?>">
	<div class="pricing-box">
		<div class="pricing-box-head">
			<?php $images = wp_get_attachment_image_src( $package_image, 'pricing_image' ); ?>
			<?php if($images[0]){ ?><img src="<?php echo $images[0];  ?>" alt="<?php echo $table_title; ?> "> <?php } ?>  
			<span class="on_sale title_shop"><?php if($auto_title && $whmcs_url!='' && $packedge_id){ echo'<script language="javascript" src="'. $whmcs_url.'/feeds/productsinfo.php?pid='. $packedge_id .'&get=name"></script>'; } else{  echo $table_title; } ; ?></span>

		<?php if( $make_featured ): ?>
			<div class="sale-box">
			<span class="on_sale title_shop"><?php echo $featured_title; ?></span>
 			</div>
			<?php endif; ?>
		</div>

		<div class="pb-list">
			<div class="price">
				<div class="original-price">
					<div class="dispay-price">
						<?php if($oldprice!=''){echo '<span class="old-price-span">'.$oldprice.'</span>'; } ?> 
						<?php if( $auto_price && $whmcs_url!='' && $packedge_id ) { echo'<script language="javascript" src="'. esc_url($whmcs_url.'/feeds/productsinfo.php?pid='. $packedge_id .'&get=price&billingcycle='. $billingcycle .'&currency='.$currency_number).'"></script>'. $billingafter; } else{echo $price; } ?>
					</div>
				</div>
			</div>
		 
		<?php echo $content; ?> 
		</div>
 		<?php echo '<a style="color:'. esc_attr($button_text_color) .'" class="pb-get hvr-bs '. esc_attr($buy_btn_css) .'" href="' . esc_url($website_link) . '" ' . esc_attr($target) .'>'. $button_text.'</a>'; ?>
	</div>
</div>

<?php endif; ?>

	<?php		
	$output = ob_get_clean();

			return $output; 
	} 

}
 
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_void_wbwhmcse_laouts_price extends WPBakeryShortCode {
    }
}
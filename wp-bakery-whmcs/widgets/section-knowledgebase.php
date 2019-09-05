<?php
   
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Visual Style for header
 *
 *
 * @since 1.0.0
 */

  
class Section_knowledgebase { 

    /**
     * Get things started
     */
    function __construct() {

        add_action('init', array($this, 'void_wbwhmcse_register_knowledgebase_controls'));
        add_shortcode('void_wbwhmcse_laouts_knowledgebase', array($this, 'void_wbwhmcse_laouts_knowledgebase_rendering'));
	}
	 
    function void_wbwhmcse_register_knowledgebase_controls() {
        if (function_exists("vc_map")) { 
            //Register "section" section element.
            vc_map(array(
                "name" => __("Knowledgebase Section", "void_wbwhmcse"),
                "base" => "void_wbwhmcse_laouts_knowledgebase",
                "category" => esc_html__( 'VOID ELEMENTS', 'void_wbwhmcse' ),
                "content_element" => true,
                "icon" => "vc_icon-vc-gitem-post-excerpt",
                "params" => array(
			                	
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Title","void_wbwhmcse"),
						"param_name" => "input_title",
						"value" => "Knowledgebase Search",
						"group"         => "Typography",
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Input Placeholder","void_wbwhmcse"),
						"param_name" => "input_placeholder",
						"value" => "Search Knowledgebase",
						"group"         => "Typography",
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Whmcs Url","void_wbwhmcse"),
						"param_name" => "whmcs_url",
						"value" => "https://voidcoders.com/voidwhmcs",
						"description" =>  __( 'Used when you do not have WHMCS Bridge Plugin installed to get/send data. Do not add (/). Just input direct url of your whmcs area (not admin url). ex: https://testsite/whmcs', 'void_wbwhmcse' ),
						"group"         => "Typography",
					),
					 
					 
					
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Show Button","void_wbwhmcse"),
						"param_name" => "input_show_button",
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
						"heading" => __("Button Text","void_wbwhmcse"),
						"param_name" => "input_button_text",
						"description" => "Default label is Search Domain",
						"dependency" => array('element' => 'input_show_button', 'value' => 'yes'),
						"group"         => "Button",
					), 
					array(
						"type" => "colorpicker",
						"class" => "",
						"heading" => __( "Button Color", "void_wbwhmcse" ),
						"param_name" => "button_color",
						"value" => '#1e73be', 
						"description" => __( "Choose Color", "void_wbwhmcse" ),
						"group"         => "Button",
					),
					array(
						"type" => "colorpicker",
						"class" => "",
						"heading" => __( "Button Text Color", "void_wbwhmcse" ),
						"param_name" => "button_text_color",
						"value" => '#fff', 
						"description" => __( "Choose Text Color", "void_wbwhmcse" ),
						"group"         => "Button",
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Button Text Size", "void_wbwhmcse" ),
						"param_name" => "button_text_size",
						"value" => '', 
						"description" => __( "Type Text Size", "void_wbwhmcse" ),
						"group"         => "Button",
					),
					
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Search Input Border", "void_wbwhmcse" ),
						"param_name" => "search_input_border",
						"value" => '1px solid gray', 
						"description" => __( "Search Input Border", "void_wbwhmcse" ),
						"group"         => "Button",
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

  
    function void_wbwhmcse_laouts_knowledgebase_rendering($atts, $content = null, $tag) {
 			global $whmcs_bridge_enabled;
	
			extract(shortcode_atts(array(
				'direct_search' => 'no',
				'input_title' => 'Domain Search',
				'input_placeholder' => 'Enter your knowledge',
				'input_show_button' => 'yes',
				'input_button_text' => 'Search Knowledgebase',
				'search_input_border' => '1px solid gray',
				'button_color' => '#1e73be',
				'button_text_color' => '#fff',
				'button_text_size' => '',
				'whmcs_url' => 'https://voidcoders.com/voidwhmcs',
				'active' => 'yes',
				'active_text' => '', 
	
			), $atts)); 
 				ob_start();  
				?>
			 <div class="search-knowledgebase">
				<form method="post" action="<?php if($whmcs_bridge_enabled==1){ echo esc_url(void_wbwhmcse_whmcs_bridge_url() .'?ccce=knowledgebase&action=search'); } else{ echo esc_url($whmcs_url.'/index.php/knowledgebase/search'); }  ?>">
					<input type="text" id="inputKnowledgebaseSearch" name="search"  placeholder="<?php echo $input_placeholder; ?>">
					<input type="submit" value="<?php echo $input_button_text; ?>">
				</form>
			</div>
		<?php		
		$output = ob_get_clean();
	
				return $output; 
		} 

}
 
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_void_wbwhmcse_laouts_knowledgebase extends WPBakeryShortCode {
    }
}
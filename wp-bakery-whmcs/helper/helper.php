<?php 

global $whmcs_bridge_enabled;

if( function_exists('cc_whmcs_bridge_home')){
    $whmcs_bridge_enabled = true;
}

/**
 *
 * WHMCS Bridge Page URL
 *
 */
if(!function_exists('void_wbwhmcse_whmcs_bridge_url')){
function void_wbwhmcse_whmcs_bridge_url() {
  return cc_whmcs_bridge_home($home,$pid);
}
}


//Metod 1
// function void_ewhmcse_ajax_domain_function(){  
//     $json = file_get_contents('http://api.bulkwhoisapi.com/whoisAPI.php?domain='.$_POST["domain"].'&type=whois&token=7d3f08b98ab9f69ae15060a5b58ef1ee');
//     //$json = json_decode($json,true);
//     $json = json_decode($json);
//     $json = json_encode( $json->response_code );
//     echo $json;
//     wp_die(); 
// }

//Metod 2
function void_wbwhmcse_ajax_domain_function(){  
    $json = wp_remote_get('http://whoiz.herokuapp.com/lookup.json?url='.$_POST['domain']);
    $json = json_decode(json_encode($json),true);
    echo $json;
    wp_die(); 
}
add_action( 'wp_ajax_void_wbwhmcse_ajax_domain_function', 'void_wbwhmcse_ajax_domain_function' );
add_action( 'wp_ajax_nopriv_void_wbwhmcse_ajax_domain_function', 'void_wbwhmcse_ajax_domain_function' );

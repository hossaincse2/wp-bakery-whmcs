
( function( $ ) {
    var WidgetDomainSearchHandler = function( $scope, $ ) {
        
		$(".iddomainname").on("change keyup paste", function(){
				var selector = $(this);
				var domainname = selector.val();
				//console.log( domainname );
				if (domainname.indexOf('.') !== -1){
						$.ajax({
								    method: "POST",
								    url: domainjs_texts.ajaxurl,
								    data: { 'action': 'void_ewhmcse_ajax_domain_function', 'domain': domainname }
						})

						.done(function( data ) {
							var data = JSON.parse(data);
							
							//console.log('Successful AJAX Call! /// Return Data: ' + data['registered?']);
							//console.log('saka karap');
						   	if(data['registered?']){  
						   		selector.closest('.sda-form-area').find( '#find' ).val(domainjs_texts.button_unavailable).removeClass('btn-available btn-info').addClass('btn-unavailable').prop('disabled', true);
						   		selector.closest('.sda-form-area').find('#results').html('<span class="domain-unavailable">'+ domainjs_texts.domain_unavailable +'</span>');
						   	}	
						   	else if(data['available?']){  
						   		selector.closest('.sda-form-area').find( '#find' ).val(domainjs_texts.button_available).removeClass('btn-unavailable btn-info').addClass('btn-available').prop('disabled', false);
						   		selector.closest('.sda-form-area').find('#results').html('<span class="domain-available">'+ domainjs_texts.domain_available +'</span>');
						   	}
						   	else{
						   		selector.closest('.sda-form-area').find( '#find' ).val(domainjs_texts.button_info).removeClass('btn-unavailable btn-available').addClass('btn-info').prop('disabled', false);
						   		selector.closest('.sda-form-area').find('#results').html('<span class="domain-info">'+ data['error'] +'</span>');
						   	}

						})

						.fail(function( data ) {
							   // document.getElementById("results").innerHTML = 'Ajax Failed'; 
						});
				}
					
			});

    };
    
	
    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/section-domain-search.default', WidgetDomainSearchHandler );
    } );
} )( jQuery );

jQuery(document).ready(function($) {
	function close_accordion_section() {
		$('.easy-payment-accordion .easy-payment-accordion-section-title').removeClass('active');
		$('.easy-payment-accordion .easy-payment-accordion-section-content').slideUp(300).removeClass('open');
	}
	$('.easy-payment-accordion-section-title').click(function(e) {           
		var currentAttrValue = jQuery(this).attr('href');
		if($(e.target).is('.active')) {
			close_accordion_section();
		}else {
			close_accordion_section();			
			$(this).addClass('active');		
			$('.easy-payment-accordion ' + currentAttrValue).slideDown(300).addClass('open'); 
		}
		e.preventDefault();
	});
});


$('document').ready(function(){
	$('.logout').click(function(){
		mask_width = $(window).width();
		mask_height = $(window).height();
		var path = $('.paths').val();
		$('.logout_form').show();
		$('.site_mask').css('width',mask_width+'px');
		$('.site_mask').css('height',mask_height+'px');
		
		$.ajax({				
			url: path+'wedgits/user_logout/logout_ajax.php', 				
			cache: false,  				
			success: function(html){ 

					$('.ajax_msgs').html(html);

					//setTimeout("$('.ajax_msgs').hide(); $('.site_mask').css('width','0'); $('.site_mask').css('height','0'); $('.ajax_msgs').html(''); $('.logout_form').hide(); $('.login_nav').show(); $('.form_table').show(); document.location='"+path+"index.php';", 2000);
					setTimeout("$('.ajax_msgs').hide(); $('.site_mask').css('width','0'); $('.site_mask').css('height','0'); $('.ajax_msgs').html(''); $('.logout_form').hide(); $('.login_nav').show(); $('.form_table').show(); document.location.reload();", 2000);
					
								
			}  			
		});	
	});

});
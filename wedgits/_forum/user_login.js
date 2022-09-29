function submitMemForm(ajax_label,ajax_suc,ajax_fail){
	var pattern=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i ;	
	var status = 'go';	
	//path = $('.path').val();
	var path = $('.path').attr('value');
	
	var pass = $('.pass').val();
	var username = $('.username').val();
	
	var mask_width = $(window).width();
	var mask_height = $(window).height();
		
	$('.required').each(function(){
		var req_val = $.trim($(this).val());
		if(req_val==''){
			$(this).css('border','1px dotted #ecaa01');
			status = 'stop';
		}else{
			status = 'go';
			$(this).css('border','1px solid #9d9d9d');
		}
	});
	
	
	

	if(status == 'go'){		
		
		$('.ajax_loader').show();
		$('.ajax_msg').show();
		$('.form_table').hide();
		$('.login_nav').hide();


		$('.required').css('border','1px solid #9d9d9d');	
		$('.required').attr('value','');	
			
		$.ajax({				
			url: path+'wedgits/user_login/login_ajax.php?pass='+pass+'&username='+username, 				
			cache: false,  				
			success: function(html){ 
				$('.ajax_msg').css('padding-top','50px');
				if(html==1){
					$('.ajax_msg').html(ajax_suc);
					$('.ajax_loader').hide();
					//setTimeout("$('.ajax_msg').hide(); $('.ajax_msg').css('padding-top','0'); $('.ajax_msg').html('"+ajax_label+"'); $('.login_form').hide(); $('.login_nav').show(); $('.form_table').show(); document.location='"+path+"view/forum/viewAllCat.php';", 3000);
					setTimeout("$('.ajax_msg').hide(); $('.ajax_msg').css('padding-top','0'); $('.ajax_msg').html('"+ajax_label+"'); $('.login_form').hide(); $('.login_nav').show(); $('.form_table').show(); document.location.reload();", 3000);
					
				}else if(html==2){
					$('.ajax_msg').html(ajax_fail);
					$('.ajax_loader').hide();
					setTimeout("$('.ajax_msg').hide();  $('.site_mask').css('width','0'); $('.site_mask').css('height','0'); $('.ajax_msg').css('padding-top','0'); $('.ajax_msg').html('"+ajax_label+"'); $('.login_nav').show(); $('.form_table').show();", 3000);
				}
				
				  						
								
			}  			
		});	
	}
}


$('document').ready(function(){
	$('.show_m_form').click(function(){
		mask_width = $(window).width();
		mask_height = $(window).height();
		$('.login_form').fadeIn('fast');
		$('.site_mask').css('width',mask_width+'px');
		$('.site_mask').css('height',mask_height+'px');
	});
	
	
	$('.close_form').click(function(){
		
	
		$('.pass').attr('value','');
		$('.username').attr('value','');
		mask_width = $(window).width();
		mask_height = $(window).height();
		$('.login_form').fadeOut('fast');
		$('.site_mask').css('width','0');
		$('.site_mask').css('height','0');
	});
});
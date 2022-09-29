function submitMemForm(label,path,ajax_label){	
	var pattern=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i ;	
	status = true;	
	email = $('#email').val();	
	if((email == '' || email == label) || (!pattern.test($('#email').val())) ){		
		$('#email').css('border','1px dotted #007dc2');		
		status = false;	
	}
	
	message_name = '#inner_success_window1';
	if(path!=''){
		message_name = '#inner_success_window2';
	}
	if(status == true){		
		$(message_name).html(ajax_label);
		$('#email').css('border','1px solid #bababa');	  		
		$('#email').attr('value','');	
		$(message_name).show();  			
		$.ajax({				
			url: path+'modules/mailing_list/subscribe.php?email='+email, 				
			cache: false,  				
			success: function(html){ 
				$(message_name).html(html);  	
				  						
				setTimeout("$('"+message_name+"').fadeOut(); $('#email').attr('value','"+label+"');", 5000);				
			}  			
		});	
	}
}
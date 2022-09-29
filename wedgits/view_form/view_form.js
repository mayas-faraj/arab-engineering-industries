function validate_form(form_id,req_label,email_label){
	var return_value=true;
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

	


	var path = $('.path').val();

	$('.required'+form_id).each(function(){
		if($(this).val()==''){
			//$(this).css('background','url('+path+'css/text_hover.png) top left no-repeat');
			$(this).css('border-top','1px solid #ffbe00');
			$(this).css('border-bottom','1px solid #ffbe00');
			$(this).css('border-right','1px solid #ffbe00');
			$(this).css('border-left','1px solid #ffbe00');	
			$(this).parent().parent().children('.errorMsg').html(req_label);
			return_value=false;
		}else{
			/*$(this).css('background','url('+path+'css/text.png) top left no-repeat');*/
			$(this).css('border-top','1px solid #d1d1d1');
			$(this).css('border-bottom','1px solid #d1d1d1');
			$(this).css('border-right','1px solid #d1d1d1');
			$(this).css('border-left','1px solid #d1d1d1');
			$(this).parent().parent().children('.errorMsg').html('');
		}
	})
	$('.required_area'+form_id).each(function(){
		if($(this).val()==''){
			/*$(this).css('border','1px solid #253b83');*/
			$(this).css('border-top','1px solid #ffbe00');
			$(this).css('border-bottom','1px solid #ffbe00');
			$(this).css('border-right','1px solid #ffbe00');
			$(this).css('border-left','1px solid #ffbe00');	
			$(this).parent().parent().children('.errorMsg').html(req_label);
			return_value=false;
		}else{
			/*$(this).css('border','1px solid white');*/
			$(this).css('border-top','1px solid #d1d1d1');
			$(this).css('border-bottom','1px solid #d1d1d1');
			$(this).css('border-right','1px solid #d1d1d1');
			$(this).css('border-left','1px solid #d1d1d1');
			$(this).parent().parent().children('.errorMsg').html('');
		}
	})
	
	
	$('.email'+form_id).each(function(){
		if(!pattern.test($(this).val())){
			/*$(this).css('background','url('+path+'css/text_hover.png) top left no-repeat');*/
			$(this).css('border-top','1px solid #ffbe00');
			$(this).css('border-bottom','1px solid #ffbe00');
			$(this).css('border-right','1px solid #ffbe00');
			$(this).css('border-left','1px solid #ffbe00');	
			$(this).parent().parent().children('.errorMsg').html(email_label);
			return_value=false;
		}else{
			/*$(this).css('background','url('+path+'css/text.png) top left no-repeat');*/
			$(this).css('border-top','1px solid #d1d1d1');
			$(this).css('border-bottom','1px solid #d1d1d1');
			$(this).css('border-right','1px solid #d1d1d1');
			$(this).css('border-left','1px solid #d1d1d1');
			$(this).parent().parent().children('.errorMsg').html('');
		}
	})

	if(return_value){
		
		document.subForm.submit();
	}else{return false;}
}



/*

function validate_form1(){
	file_type = $('.com_files_type').val();
	var return_value=true;
	if (file_type!=null ){
		
		var file_type_arr = file_type.split(',');
		$('.file').each(function(){
			if($(this).val()!=''){

				var file_ext = $(this).val().split('.').pop().toLowerCase();
				

				if((jQuery.inArray(file_ext, file_type_arr)== -1 && file_ext != '')){		
					$(this).css('border','1px solid #ffbe00');
					return_value=false;
				}else{
					$(this).css('border','1px solid #d1d1d1');
				}
			}
			
			

			
		});
	}
	
	
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

	var path = $('.path').val();

	
	
	$('.required1').each(function(){
		if($(this).val()==''){
			$(this).css('border','1px solid #ffbe00');
			return_value=false;
		}else{
			$(this).css('border','1px solid #d1d1d1');
		}
	})
	$('.required_area1').each(function(){
		if($(this).val()==''){
			$(this).css('border','1px solid #ffbe00');
			return_value=false;
		}else{
			$(this).css('border','1px solid #d1d1d1');
		}
	})
	
	
	$('.email1').each(function(){
		if(!pattern.test($(this).val())){
			$(this).css('border','1px solid #ffbe00');
			return_value=false;
		}else{
			$(this).css('border','1px solid #d1d1d1');
		}
	})

	
	if(return_value){
		document.subForm.submit();
	}else{return false;}
}

function getFile(){
	return '';
}

$(function (){
	$("a.checkb").click(function(){
		var url = this.href;
		var obj=   $(this);
		var fv = obj.children().attr('fv');
		$.get(url,{'fv':fv},function(result){
			if(result==1) sres="0"; else sres="1";
			obj.html('<img src="../../images/icons/_'+result+'_.png" border="0" fv="'+sres+'">');
		});
		return false;
	});
	$('.delete').jConfirmAction();
});*/
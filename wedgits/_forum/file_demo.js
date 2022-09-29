(function($) {
	
$.fn.ajaxSubmit.debug = true;

$(document).ajaxError(function(ev,xhr,o,err) {
   // alert(err);
    if (window.console && window.console.log) console.log(err);
});

$(function() {
	
	$('.submit_it').click(function(){
		
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
		
		$('.required1').each(function(){
			if($(this).val()==''){
				$(this).css('border','1px solid #ffbe00');
				return_value=false;
			}else{
				$(this).css('border','1px solid #d1d1d1');
			}
		});
		
		if(return_value == true){
			$('#uploadForm').ajaxForm({
		
				beforeSubmit: function(a,f,o) {

					o.dataType = $('#uploadResponseType')[0].value;
					$('#uploadOutput').html('Submitting...');
				},
				success: function(data) {
					var $out = $('#uploadOutput');

					
					$out.append('<div><pre>'+data+'</pre></div>');
					$out.hide();
					
					//$("document").ready(function(){$("#uploadOutput").html(""); });
				
				}
			});
		}else{
			return false;
		}
		
	});


});

})(jQuery);


function refresh(url){
	var referLink = document.createElement('a');
	referLink.href = url;
	document.body.appendChild(referLink);
	referLink.click();
}
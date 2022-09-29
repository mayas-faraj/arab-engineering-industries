
jQuery(function(){
	page_lang = $('.pageLang').val();
	
	$.ajax({  
		url: 'wedgits/calender/calendar.php?pl='+page_lang,  
		cache: false,  
		success: function(html){  
		$('#calendar').html(html);  
		}  
	}); 
});

function getNextTime(time){
	page_lang = $('.pageLang').val();
	$.ajax({  
		url: 'wedgits/calender/calendar.php?pl='+page_lang+'&time='+time,  
		cache: false,  
		success: function(html){  
		$('#calendar').html(html);  
		}  
	}); 
}

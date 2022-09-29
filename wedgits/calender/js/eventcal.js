
jQuery(function(){
	$.ajax({  
		url: '../../wedgits/eventcal/calendar.php?pl=en',  
		cache: false,  
		success: function(html){  
		$('.events_calender').html(html);  
		}  
	}); 
});

function getNextTime(time){
	$.ajax({  
		url: '../../wedgits/eventcal/calendar.php?pl=en&time='+time,  
		cache: false,  
		success: function(html){  
		$('.events_calender').html(html);  
		}  
	}); 
}

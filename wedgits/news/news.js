
function next_news(max_sections,item_clicked){
	clearTimeout(timer_news);
	
	next = 0;
	if(item_clicked){
		next = item_clicked;
	}else{
		current = $('.curr_high').attr('num');
		next = (parseInt(current)%max_sections)+1;
		}
		
	
	
	if(current != null)
	{
		
		$('.bt').removeClass("curr_high");
		$('#news_block'+current).fadeOut(2000);
		$('.news_block').hide();
		$('#bt'+next).addClass('curr_high');
		$('#news_block'+next).fadeIn(2000);
	}
	else
	{
		//alert('nul');
		current = 1;
	}
	timer_news = setTimeout('next_news(' + max_sections +',"")',7000);
}
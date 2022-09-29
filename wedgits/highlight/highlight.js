
function switch_highlight(max_sections,operation){
	clearTimeout(timer_news);
	current = parseInt($('.current').val());
	max_sections = parseInt(max_sections);

	curr_count--;

	if(curr_count==0){
		curr_count=total_count;
		
		$('.nav_buttons').css('top',-count+73+'px');
	}
	if(operation=='next'){
		next_item = current+1;

		move_amount = 73;

		if(next_item > max_sections){
			next_item = 1;
		}
		
		$(".nav_buttons").animate({"top": "-="+move_amount}, "slow");
		
		$('.bt'+current).removeClass("highlight_bt_active");
		$('.bt'+next_item).removeClass("highlight_bt");
		$('.bt'+current).addClass("highlight_bt");
		$('.bt'+next_item).addClass("highlight_bt_active");
		$('.bt'+next_item).addClass("highlight_bt_active");
		
		$('.current').attr("value",next_item);
		$('.curr_high').html(next_item);

	}else if(operation=='prev'){
		next_item = current-1;
		move_amount = 73;
		move_amount_fix = 146;

		if(next_item==0){
			next_item=max_sections;
		}
		
		$(".nav_buttons").animate({"top": "+="+move_amount}, "slow");
		
		$('.bt'+current).removeClass("highlight_bt_active");
		$('.bt'+next_item).removeClass("highlight_bt");
		$('.bt'+current).addClass("highlight_bt");
		$('.bt'+next_item).addClass("highlight_bt_active");
		$('.current').attr("value",next_item);
		$('.curr_high').html(next_item);
	}
	
	$('.highlight_desc').fadeOut();
	$('.desc'+next_item).fadeIn();
	timer_news = setTimeout('switch_highlight('+max_sections+',"next")',7000);
	
}









function switch_highlights(max_sections,operation){
	
	clearTimeout(timer_news);
	current = parseInt($('.current').val());
	max_sections = parseInt(max_sections);
	
	if(operation=='next'){
		next_item = current+1;

		move_amount = 73;
		
		if(next_item > max_sections){
			next_item = 1;
			$(".nav_buttons").animate({"top": "+="+move_amount}, "slow");
		}else{
			$(".nav_buttons").animate({"top": "-="+move_amount}, "slow");
		}

		$('.bt'+current).removeClass("highlight_bt_active");
		$('.bt'+next_item).removeClass("highlight_bt");
		$('.bt'+current).addClass("highlight_bt");
		$('.bt'+next_item).addClass("highlight_bt_active");
		$('.bt'+next_item).addClass("highlight_bt_active");
		
		$('.current').attr("value",next_item);
		$('.curr_high').html(next_item);
		
	}else if(operation=='prev'){
		
		next_item = current-1;
		move_amount = 73;
		

		if(next_item==0){
			next_item=max_sections;
			$(".nav_buttons").animate({"top": "-="+move_amount}, "slow");
		}else{
			$(".nav_buttons").animate({"top": "+="+move_amount}, "slow");
		}

		$('.bt'+current).removeClass("highlight_bt_active");
		$('.bt'+next_item).removeClass("highlight_bt");
		$('.bt'+current).addClass("highlight_bt");
		$('.bt'+next_item).addClass("highlight_bt_active");
		$('.current').attr("value",next_item);
		$('.curr_high').html(next_item);

	}
	
	$('.highlight_desc').fadeOut();
	$('.desc'+next_item).fadeIn();
	timer_news = setTimeout('switch_highlights('+max_sections+',"next")',7000);
	
}
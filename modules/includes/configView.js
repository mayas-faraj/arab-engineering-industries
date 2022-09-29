$(document).ready(function(){
/***************************Intialize validate form***************************/
	jQuery(function(){
		jQuery('ul.sf-menu').superfish();
	});
	$("form[name='subForm']").validate({
		submitHandler: function(form) {
			$("form[name='subForm']").ajaxSubmit({target:'#output1'}); 
		}
	});
function jqCheckAll2( id, name ){
 $("input[name='" + name + "[]'][type='checkbox']").attr('checked', $('#' + id).is(':checked'));
}
/**********************change row color on rollover***************************/
 $("#list tbody tr").hover(
      function() {
		  $(this).addClass('trover');
	  },
      function() {
		  $(this).removeClass('trover');
	  }
  );
});

/*****************************popup config*****************************/
$(function (){
	$('a.popup').click(function() {
		var url = this.href;
		var dialog = $('<div style="display:hidden;overflow:auto"></div>').appendTo('body');
		// load remote content
		dialog.load(
			url, 
			{},
			function (responseText, textStatus, XMLHttpRequest) {
				dialog.dialog({
					autoOpen: true, 
					height: 400, 
					width: 600, 
					modal: true, 
					overlay: { 
						opacity: 0.5, 
						background: "black" 
					},
					buttons: {
						"Close": function() { 
							$(this).dialog("close"); 
							location.reload();
						}
					}
				});
			}
		);
		//prevent the browser to follow the link
		return false;
	});
});

/***************************popup config with iframe***************************/
// using for Enter new record, edit, delete
// or any file contain form
$(function (){
	$('a.dialog-form').click(function() {
		var url = this.href;
		var dialog = $('<div style="display:hidden;overflow:auto"></div>').appendTo('body');
		// load remote content
		dialog.load(
			url, 
			{},
			function (responseText, textStatus, XMLHttpRequest) {
				dialog.dialog({
					autoOpen: true, 
					width: 600,
					height: 400, 
					modal: true, 
					overlay: { 
						opacity: 0.5, 
						background: "black" 
					},
					open:function() {						
						$('.dateF').datepicker({
							showTime: false,
							dateFormat: 'yy-mm-dd',
							showButtonPanel: true,
							minDate: $('.dateF').attr('minDate'),
							maxDate: ($('.dateF').attr('maxDate')) ? ($('.dateF').attr('maxDate')) :'+3M'
						});
					},
					buttons: {
						"Close": function() {
							$(this).dialog("close"); 
							location.reload();
						},
 				        'Save': function() {
							button = $(this).find("button:contains('Save')");
							button.unbind();
							button.addClass('ui-state-disabled');
							$("form").validate({
								submitHandler: function(form) {
									$("form").ajaxSubmit({target:'#output1',  clearForm: true}); 
								}
							});
							$('form').submit();
							$(this).dialog("close"); 
							location.reload();
						}
					}
				});
			}
		);
		//prevent the browser to follow the link
		return false;
	});
});

///------------By Ahmad
//  Show or Hide div by ID
function SH(id){
	if(document.getElementById(id).style.display=="block"){
		document.getElementById(id).style.display="none"	
	}else{
		document.getElementById(id).style.display="block"
	}
}
// nav('nav1^link1|nav2^link2|nav3^')
function nav(nav){
	var str="";
	var n = new Array();
	n = nav.split('|');
	str+='<table border="0" cellspacing="0" cellpadding="3"><tr>';
	for(s=0;s<n.length;s++){
		link1=n[s].split('^');
		if(link1[1]!=""){
			l1='<b><a href="'+link1[1]+'">'+link1[0]+'</b></a>';
		}else{
			l1=link1[0];
		}
		str+='<td height="5" >'+l1+'</td>';
		if(s<n.length-1){
			str+='<td height="5"  > > </td>';
		}
	}
	str+='</tr></table>';
	document.getElementById("nav").innerHTML=str;
}
/**
 * Show message box function 
 * @author Ahmad Hajjar
 * @param msg String the message to show.
 * */
function showMessageBox(msg)
{
	$('.messageBox').html(msg+"<br/><br/><br/><input type='button' value='OK' class='__messageBoxOK' />");
	
	$('.__messageBoxOK').live(
			'click',
			function(){
				$('.messageBox').hide();
				$('.lockedPage').hide();
			}
	);
	$('.__messageBoxOK').focus();
	$('.messageBox').show();
	$('.lockedPage').show();
}

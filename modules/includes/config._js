$(document).ready(function(){
/***************************Intialize validate form***************************/
	$('.delete').jConfirmAction();
	$("form[name='subForm']").validate({
		submitHandler: function(form) {
			tinyMCE.triggerSave();
			$("form[name='subForm']").ajaxSubmit({target:'#output1'}); 
		}
	});
/**********************change row color on rollover***************************/
 $("#list tbody tr").hover(
      function() {
		  $(this).addClass('trover');
	  },
      function() {
		  $(this).removeClass('trover');
	  }
  );
 /********************** help tips *****************************/
 	$("#help img[title]").tooltip().dynamic({ bottom: { direction: 'down', bounce: false } });
	
	$('.group').slideUp();
	$('.group_label').click(function(){
		var group_id = $(this).attr('id');
		var child_status = $('.'+group_id).attr('id');
		if(child_status == 'opened'){
			$('#'+group_id+' img').attr('src','../../images/images/icons/start.gif');
			$('.'+group_id).attr('id','closed');
			$('.'+group_id).slideUp();
		}else{
			$('.group_label img.status_img').attr('src','../../images/images/icons/start2.gif');
			$('.'+group_id).attr('id','opened');
			$('.'+group_id).slideDown();
		}
	});
});

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
		var title = ($(this).attr('title')) ? $(this).attr('title') : 'External Site';
		var width = ($(this).attr('width')) ? $(this).attr('width') : 800;
		var height = ($(this).attr('height')) ? $(this).attr('height') : 450;
		var dialog = $('<div style="display:hidden;overflow:auto" id="openDialog"></div>').appendTo('body');
		// load remote content
		dialog.load(
			url, 
			{},
			function (responseText, textStatus, XMLHttpRequest) {
				dialog.dialog({
					title: title, 
					autoOpen: true, 
					width: width,
					height: height, 
					modal: true, 
					overlay: { 
						opacity: 0.5, 
						background: "black" 
					},
					open: function() {
						initEditor();
						$('.dateF').datepicker({
							showTime: false,
							dateFormat: 'yy-mm-dd',
							showButtonPanel: true,
							minDate: $('.dateF').attr('minDate'),
							maxDate: ($('.dateF').attr('maxDate')) ? ($('.dateF').attr('maxDate')) :'+3M'
						});
						$('.datetime').datepicker({
							showTime: true,
							dateFormat: 'yy-mm-dd',
							showButtonPanel: true,
							stepMinutes: 5,  
							stepHours: 1, 
							time24h: true
						 });
					},
					buttons: {
						"Close": function() {
							$(this).dialog("close"); 
							location.reload();
						},
				        'Save': function() {
							$("#widgets").val('');
							$('#sortable2').children().each(function() {
							  var elm = $(this).attr('rel');
							  $("#widgets").val($("#widgets").val()+','+elm);
							});
							//alert($("#widgets").val());
							$("form[name='seoForm']").validate({
								submitHandler: function(form) {
									tinyMCE.triggerSave();
									$("form[name='seoForm']").ajaxSubmit({target:'#output',  clearForm: true}); 
								}
							});
							$("form[name='seoForm']").submit();

							button = $(this).find("button:contains('Save')");
							button.unbind();
							button.addClass('ui-state-disabled');
						}
					}
				});
			}
		);
		//prevent the browser to follow the link
		return false;
	});
});

/***************************Date Picker Config***************************/
$(function() {
	$('.dateF').datepicker({
		showTime: false,
		dateFormat: 'yy-mm-dd',
		showButtonPanel: true,
		minDate: $('.dateF').attr('minDate'),
		maxDate: ($('.dateF').attr('maxDate')) ? ($('.dateF').attr('maxDate')) :'+3M'
	});
	$('.datetime').datepicker({
		showTime: true,
		dateFormat: 'yy-mm-dd',
		showButtonPanel: true,
		stepMinutes: 5,  
		stepHours: 1, 
		time24h: true
	 });
});

function initEditor(){
tinyMCE.init({
		// General options
		mode : "specific_textareas",
		theme : "advanced",
		editor_selector : "fullEditor",
		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager",
		// Theme options
		theme_advanced_buttons1 : "cut,copy,paste,pastetext,pasteword,cleanup,|,search,replace,|,undo,redo,|,bullist,numlist,|,outdent,indent,blockquote,|,ltr,rtl,|,justifyleft,justifycenter,justifyright,justifyfull,", 
		theme_advanced_buttons2 : ",bold,italic,underline,strikethrough,|,sub,sup,|,styleselect,formatselect,fontselect,fontsizeselect|,forecolor,backcolor,|,removeformat,", 
		theme_advanced_buttons3 : "link,unlink,anchor,image,insertimage,media,emotions,charmap,|,insertdate,inserttime,|,hr,|,tablecontrols,", 
		theme_advanced_buttons4 :"insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage|,fullscreen,attribs,preview,code,", 
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "js/template_list.js",
		external_link_list_url : "js/link_list.js",
		external_image_list_url : "js/image_list.js",
		media_external_list_url : "js/media_list.js",
		content_css : "../includes/editor.css",
		// Replace values for the template plugin
		template_replace_values : {
			username : "demo",
			staffid : "demo"
		}
});



tinyMCE.init({
		// General options
		mode : "specific_textareas",
		theme : "advanced",
		editor_selector : "mceEditor",
		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager",
		// Theme options
		theme_advanced_buttons1 : "pasteword,cleanup,search,|,bullist,numlist,|,outdent,indent,blockquote,|,ltr,rtl,|,justifyleft,justifycenter,justifyright,justifyfull,|,bold,italic,underline,strikethrough,|,link,unlink,anchor", 
		theme_advanced_buttons2 : "image,insertimage,|,sub,sup,charmap,styleselect,formatselect,fontsizeselect|,forecolor,backcolor,|,removeformat,|hr,|,table,|styleprops,|,blockquote,pagebreak,|,insertfile,insertimage|,fullscreen,preview,code,", 
		theme_advanced_buttons3 : "", 
		theme_advanced_buttons4 :"", 
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "js/template_list.js",
		external_link_list_url : "js/link_list.js",
		external_image_list_url : "js/image_list.js",
		media_external_list_url : "js/media_list.js",
		content_css : "../includes/editor.css",
		width : "740",
		height : "680",
		// Replace values for the template plugin
		template_replace_values : {
			username : "demo",
			staffid : "demo"
		}
});

tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager",
        //plugins : "table,inlinepopups",
		editor_selector : "simpleEditor",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,link,unlink,,anchor|,table",
    
		theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
		// Drop lists for link/image/media/template dialogs
		//template_external_list_url : "js/template_list.js",
		external_link_list_url : "js/link_list.js",
		external_image_list_url : "js/image_list.js",
		media_external_list_url : "js/media_list.js",
		content_css : "../includes/editor.css",
		width : "250",
		height : "150",
		// Replace values for the template plugin
		template_replace_values : {
			username : "demo",
			staffid : "demo"
		}
		});
		
}

function correctMessage(msg){
	$("#dialog").dialog("destroy");
	$.blockUI({
		message: '<h5><img src="/4m/images/icons/_1_.png">'+msg+'</h5>', 
		css: {
			border: 'none',
			padding: '15px',
			backgroundColor: '#000',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: .5,
			color: '#fff'
		}
	});
	setTimeout(function() {
		$.unblockUI({
			onUnblock: function(){ history.go(-1); }
		});
	}, 2000);

}

function correctMessageWithoutBack(msg){
	$("#dialog").dialog("destroy");
	$.blockUI({
		message: '<h5><img src="/4m/images/icons/_1_.png">'+msg+'</h5>', 
		css: {
			border: 'none',
			padding: '15px',
			backgroundColor: '#000',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: .5,
			color: '#fff'
		},
		onUnblock: function(){ $("#openDialog").dialog("close"); },
		timeout: 2000
	});
}

function errorMessage(msg){
	$.blockUI({
		message: '<h5><img src="/4m/images/icons/_0_.png">'+msg+'</h5>', 
		css: {
			border: 'none',
			padding: '15px',
			backgroundColor: '#000',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: .5,
			color: '#fff'
		},
		timeout: 2000
	});
}
function winopen(url,w,h){
	window.open(url,"",'width='+ w +',height='+ h +',resizable=yes, scrollbars=no ,status=1 ,toolbar=no ,menubar=no');
}

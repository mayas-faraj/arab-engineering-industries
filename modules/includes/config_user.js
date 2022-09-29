
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
		height : "300",
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
        theme_advanced_buttons1 : "",
    
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
		width : "200",
		height : "150",
		// Replace values for the template plugin
		template_replace_values : {
			username : "demo",
			staffid : "demo"
		}
		});
		
}





	
	








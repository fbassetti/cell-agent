$(document).bind("pageinit", function(){
	$.mobile.ajaxEnabled = false;
	$('.navigation > li').live('mouseover',function(){$('.navigation > li > ul').hide().stop(); $(this).children('ul').show().stop();});
	$('.navigation > li > ul').live('mouseout',function(){$(this).delay(1000).stop().hide('slow');});
	$('[data-legend]').each(function(){
		$(this).addClass('ui-legend').css('position','relative').append('<span class="uileg">'+$(this).attr('data-legend')+'</span>');
	});
});
$('.ui-legend').live('mouseover',function(){
	$(this).children('.uileg')
		.css({ opacity:'1', top:'-20px', left: parseInt((1-$(this).children('.uileg').css('width').replace('px','')/2)+$(this).css('width').replace('px','')/2) });
}).live('mouseout',function(){
	$(this).children('.uileg').css({ opacity:'0', top:'-10px',left: '-9999px'});
});
$('#nav').live('mouseout',function(){
	$('.navigation > li > ul:visible').stop().hide('fast');
});
$('.imprimir,.exportar,.excel').live('click',function(){
	var action = '';
	var nodo = '#block-b';
	if($(nodo).length == 0){
		nodo = '#content';
	}

	if($(this).hasClass('exportar')){
		action = 'exportar';
	}
	else if($(this).hasClass('excel')){
		action = 'excel';
		nodo += ' table';
	}
	if($('#printform').length == 1){ $('#printform').submit(); }

	$('<form />').attr({
			'method':'post','action':'/web/imprimir/'+action,
			'target':'_blank','style':'display:none;','id':'#printform'})
		.append($('<textarea />').attr('name','body').append(encodeURIComponent($(nodo).html())))
		.appendTo('body')
		.submit();
});

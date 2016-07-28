$('.navigation > li').live('mouseover',function(){ $('.navigation > li > ul').hide().stop(); $(this).children('ul').show().stop();});
$('.navigation > li > ul').live('mouseout',function(){$(this).delay(1000).hide('slow');});

$('.imprimir,.exportar,.excel').live('click',function(){
	var action = '';
	var nodo = '.container fieldset';
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

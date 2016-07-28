$(function() {
	var dates = $( "#from, #to" ).datepicker({
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 2,
		dateFormat : 'dd/mm/yy',
		maxDate: 0, minDate: new Date(2009,0,1),
		showButtonPanel : true,
		onSelect: function( selectedDate ) {
			var option = this.id == "from" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate( instance.settings.dateFormat ||	$.datepicker._defaults.dateFormat,
			selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});
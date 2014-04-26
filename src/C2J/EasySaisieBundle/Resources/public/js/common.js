$(document).ready(function() {
	/**
	*	Handle the alert on button delete click
	**/
	$('.delete-entry').on('click', function(event) {		
		if (!confirm("Confirmer la suppression ? (irréversible)"))
			event.preventDefault();
	});

	/**
	*	Make rows clickable inside a table
	**/
	$(".clickableRow").click(function() {
     	window.document.location = $(this).attr("href");
	});

	/**
	*	Handle Table Sorter plugin
	**/
	$.extend($.tablesorter.themes.bootstrap, {
			// these classes are added to the table. To see other table classes available,
			// look here: http://twitter.github.com/bootstrap/base-css.html#tables
			table      : 'table table-striped table-bordered table-hover',
			caption    : 'caption',
			header     : 'bootstrap-header', // give the header a gradient background
			footerRow  : '',
			footerCells: '',
			icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
			sortNone   : 'bootstrap-icon-unsorted',
			sortAsc    : 'icon-chevron-up glyphicon glyphicon-chevron-up',     // includes classes for Bootstrap v2 & v3
			sortDesc   : 'icon-chevron-down glyphicon glyphicon-chevron-down', // includes classes for Bootstrap v2 & v3
			active     : '', // applied when column is sorted
			hover      : '', // use custom css here - bootstrap class may not override it
			filterRow  : '', // filter row class
			even       : '', // odd row zebra striping
			odd        : ''  // even row zebra striping
		});

		// call the tablesorter plugin and apply the uitheme widget
		$("table").tablesorter({
			// this will apply the bootstrap theme if "uitheme" widget is included
			// the widgetOptions.uitheme is no longer required to be set
			theme : "bootstrap",

			widthFixed: true,

			headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!

			// widget code contained in the jquery.tablesorter.widgets.js file
			// use the zebra stripe widget if you plan on hiding any rows (filter widget)
			widgets : [ "uitheme", "filter", "zebra" ],

			widgetOptions : {
			// using the default zebra striping class name, so it actually isn't included in the theme variable above
			// this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
			zebra : ["even", "odd"],

			// reset filters button
			filter_reset : ".reset"

			// set the uitheme widget to use the bootstrap theme class names
			// this is no longer required, if theme is set
			// ,uitheme : "bootstrap"
		}
	})
	
	/**
	*	Handle X-Editable plugin
	**/
	var pattern = new RegExp("^[0-9]{1,2}\.?[0-9]{0,2}$");
	$('.mark').editable({
		title : "Entrez une note (entre 0.00 - 20.00)",
		validate: function(value) {
			value = $.trim(value);

			if(value && (!pattern.test(value) || value < 0 || value > 20)) {
				return 'La note doit être comprise entre 0.00 - 20.00';
			}
		},
		ajaxOptions: {
		    type: 'put'
		},
		params: function(params) {
		    params.spid = $(this).data('spid');
		    params.tucsid = $(this).data('tucsid');
		    params.pk = $(this).data('pk');
		    params.session = $(this).data('session');
		    return params;
		},
		success: function(response, newValue) {
	        if(response.status == 'error') 
	        	console.log(response.msg);

	        $(this).data('pk', response.markId);
	        $(this).editable('setValue', newValue); // Needed to update the value in html before calling refreshAvg(), otherwise the update is done last
	        refreshAvg(true);
	    },
		error: function(response, newValue) {
	        console.log(response.responseText);	
		}
	});
});

function displayLoadingWheel(enable) {
	if(enable)
		$('#loadingWheel').show();
	else 
		$('#loadingWheel').fadeOut();
}
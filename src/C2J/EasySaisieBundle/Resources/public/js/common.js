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
			odd        : '',  // even row zebra striping
			placeholder : {search : 'Chercher...'}
		});

		// call the tablesorter plugin and apply the uitheme widget
		$(".table:not('#studentsAvgTable')").tablesorter({
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
});

function displayLoadingWheel(enable) {
	if(enable)
		$('#loadingWheel').show();
	else 
		$('#loadingWheel').fadeOut();
}
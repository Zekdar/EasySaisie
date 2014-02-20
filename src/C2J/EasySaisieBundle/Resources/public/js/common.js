$(document).ready(function() {
	/**
	*	Handle the alert on button delete click
	**/
	$('.delete-entry').on('click', function(event) {		
		if (!confirm("Confirmer la suppression ? (irréversible)"))
			event.preventDefault();
	});
});
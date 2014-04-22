$(document).ready(function() {
	$("#btnExport").click(function(e) {
		window.open('data:application/vnd.ms-excel,' + $('#displayMarks').html());
		e.preventDefault();
	});​
})
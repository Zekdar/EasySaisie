function getMinAvg(marks) {
	return marks[0];
}

function getMaxAvg(marks) {
	return marks[marks.length-1];
}

function getMarks(subject) {
	var marks = [];
	var subjectIndex = $('#marksTable thead th:contains("' + subject + '")').index();

	if(subjectIndex == -1)
		throw 'La matière est inconnue.';

	$('#marksTable tbody tr td:nth-child(' + (subjectIndex + 1) + ') a').each(function() {
		if($(this).text() != 'Empty')
			marks.push(parseFloat($(this).text().trim()));
	});

	return  marks.sort(function(a,b) {return a - b}); // Sort asc
}

function getSubjectsAvg(marks) {	
	var sum = 0.0;
	for(var i = 0; i < marks.length; i++) {
		sum += marks[i];
	}
	if(sum != 0)
		return (sum / marks.length).toFixed(2); // Rounds at 10^-2 decimals
	else
		return 'Empty';
}

function refreshAvg(toggleLoader) {
	if(toggleLoader)
		displayLoadingWheel(true);

	var subjects = $('#marksTable thead .subject .tablesorter-header-inner');
	var avgCells = $('#avgTable tbody tr td.subjectAvg');
	var minSubjectAvgCells = $('#avgTable tbody tr td.minSubjectAvg');
	var maxSubjectAvgCells = $('#avgTable tbody tr td.maxSubjectAvg');

	var avg, minAvg, maxAvg, marks;
	for(var i = 0; i < subjects.length; i++) {
		marks = getMarks($(subjects[i]).text());

		if(marks.length > 0) {
			for(var j in marks) 
				marks[j] = marks[j].toFixed(2); // Rounds every marks at 10^-2 decimals

			avg = getSubjectsAvg(marks);
			minAvg = getMinAvg(marks);
			maxAvg = getMaxAvg(marks);

			$(avgCells[i]).html(avg);
			$(minSubjectAvgCells[i]).html(minAvg);
			$(maxSubjectAvgCells[i]).html(maxAvg);
		} else {
			$(avgCells[i]).html('');
			$(minSubjectAvgCells[i]).html('');
			$(maxSubjectAvgCells[i]).html('');
		}

	}

	if(toggleLoader)
		displayLoadingWheel(false);
}

function refreshAvgTableWidth() {
	var markWidths = $('#marksTable tbody tr:first td');
	var avgWidths = $('#avgTable tbody tr:first td');
	var avgTable = $('#avgTable');
	
	$(avgTable).width($('#marksTable').width());
	$(avgTable).css('margin-left', $(markWidths[0]).outerWidth());

	for(var i = 1; i < avgWidths.length; i++) 
		$(avgWidths[i-1]).width($(markWidths[i]).width());
}

/***** WINDOW INIT *****/
$(document).ready(function() {
	try {
		displayLoadingWheel(true);

		refreshAvg();
		refreshAvgTableWidth();

		displayLoadingWheel(false);
	}
	catch(e) {
		console.log(e);
	}	


	$('#avgTable tr td').on('change', refreshAvgTableWidth());
});
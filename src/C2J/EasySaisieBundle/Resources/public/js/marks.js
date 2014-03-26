$(document).ready(function() {
	try {
		refreshAvg();
	}
	catch(e) {
		console.log(e);
	}	
});

function getSubjectsAvg(subject) {
	var subjectIndex = $('#marksTable thead th:contains("' + subject + '")').index();
	if(subjectIndex == -1)
		throw 'La matière est inconnue.';

	var marks = $('#marksTable tbody tr td:nth-child(' + (subjectIndex + 1) + ') a');
	
	var sum = 0.0;
	for(var i = 0; i < marks.length; i++) {
		var value = $(marks[i]).html();
		if(value != 'Empty') 
			sum += parseFloat(value);
	}
	if(sum != 0)
		return Math.round(sum / marks.length * 100) / 100; // Round at 10^-2 decimals
	else
		return 'Empty';
}

function refreshAvg() {
	displayLoadingWheel(true);

	var subjects = $('#marksTable thead .subject .tablesorter-header-inner');
	var avgCells = $('#avgTable tbody tr td')
	avgCells.splice(0, 2); // Removes the 2 first cells that represent Num. Etudiant and Etudiant lastname

	var avg;
	for(var i = 0; i < subjects.length; i++) {
		avg = getSubjectsAvg($(subjects[i]).text());
		$(avgCells[i]).text(avg);console.log(avg);
	}

	displayLoadingWheel(false);
}
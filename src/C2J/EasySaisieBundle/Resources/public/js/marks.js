function getAvg(marks) {	
	var sum = 0.0;
	for(var i = 0; i < marks.length; i++) {
		sum += marks[i];
	}
	if(sum != 0)
		return (sum / marks.length).toFixed(2); // Rounds at 10^-2 decimals
	else
		return 'Empty';
}

function getMinAvg(marks) {
	return marks[0];
}

function getMaxAvg(marks) {
	return marks[marks.length-1];
}

// function getMarksBySubject(subject) {
// 	var subjectIndex = $('#marksTable thead th:contains("' + subject + '")').index();

// 	if(subjectIndex == -1)
// 		throw 'La matière est inconnue.';

// 	return getMarksByIndex(subjectIndex);
// }

function getMarksByIndex(index) {
	var marks = new Array;

	$('#marksTable tbody tr td:nth-child(' + (index + 2) + ') a').each(function() {
		if($(this).text() != 'Empty')
			marks.push(parseFloat($(this).text().trim()));
	});

	return  marks.sort(function(a,b) {return a - b}); // Sort asc
}

function getMarksByStudent(student) {
	var marksCells = new Array();
	var marks = new Array();

	marksCells = $('#marksTable tbody tr:contains(' + student + ') td');
	marksCells.splice(0, 2);

	$(marksCells).each(function() {
		marks.push($(this).text().trim());
	});

	return marks;	
}

function getStudentsName() {
	var names = new Array();

	$('#marksTable tbody td:nth-child(2)').each(function() {
		names.push($(this).text().trim());
	});

	return names;
}

function refreshAvg(toggleLoader) {
	if(toggleLoader)
		displayLoadingWheel(true);

	var avgCells = $('#avgTable tbody tr:first td').splice(1);
	var minCells = $('#avgTable tbody tr:nth-child(2) td').splice(1);
	var maxCells = $('#avgTable tbody tr:last td').splice(1);
	var marks = new Array();
	var avg, minAvg, maxAvg;

	$(avgCells).each(function() {
		marks = getMarksByIndex($(this).index());
		
		if(marks.length > 0)
			avg = getAvg(marks);
		else 
			avg = '';

		$(this).html(avg);
	});

	$(minCells).each(function() {
		marks = getMarksByIndex($(this).index());
		
		if(marks.length > 0)
			minAvg = getMinAvg(marks).toFixed(2, 0);
		else 
			minAvg = '';

		$(this).html(minAvg);
	});

	$(maxCells).each(function() {
		marks = getMarksByIndex($(this).index());

		if(marks.length > 0)
			maxAvg = getMaxAvg(marks).toFixed(2, 0);
		else 
			maxAvg = '';

		$(this).html(maxAvg);
	});

	// Calculates each teaching unit avg
	var index;
	var tu = $('#marksTable thead tr:nth-child(2) th');
	var subjects = $('#marksTable thead tr:nth-child(3) th');
	subjects.splice(0, 2); // removes the 2 first cells (Num. Etudiant + Etudiant)
	tu.splice(0, 2); // removes the 2 first cells (Num. Etudiant + Etudiant)

	var sum = 0;
	for(var i = 0; i < tu.length; i++) {
		for(var j = 0; j < $(tu).attr('colspan'); j++) {
			sum += subjects[j];
		}
	}

	var students = getStudentsName();
	var studentMarks =  new Array();
	for(var i = 0; i < students.length; i++) {
		studentMarks = getMarksByStudent(students[i]);

		for(var j = 0; j < studentMarks.length; j++) {
			
		}
	}

	$('#marksTable thead tr:nth-child(3) th.tuAvg').each(function() {
		index = $(this).index();		

		$('#marksTable tbody tr td:nth-child(' + (index + 1) + ')').each(function() {
			// $(this).html();
		})
	});

	if(toggleLoader)
		displayLoadingWheel(false);
}

function refreshAvgTableWidth() {
	var markWidths = $('#marksTable tbody tr:first td');
	var avgWidths = $('#avgTable tbody tr:first td');
	var avgTable = $('#avgTable');
	
	$(avgTable).width($('#marksTable').width());
	$(avgTable).css('margin-left', $(markWidths[0]).outerWidth(true));

	for(var i = 1; i < avgWidths.length; i++) 
		$(avgWidths[i-1]).width($(markWidths[i]).width());
}

function createAvgTable() {
	var marksTableFirstRow = $('#marksTable tbody tr:first td').splice(2);
	var row = '';

	row += '<tr><td><b>Moyenne</b></td>';
		$(marksTableFirstRow).each(function() {
			row += '<td></td>';
		});
	row += '</tr>';
	row += '<tr><td><b>Min</b></td>';
		$(marksTableFirstRow).each(function() {
			row += '<td></td>';
		});
	row += '</tr>';
	row += '<tr><td><b>Max</b></td>';
		$(marksTableFirstRow).each(function() {
			row += '<td></td>';
		});
	row += '</tr>';
	$('#avgTable').append(row);
}

/***** WINDOW INIT *****/
$(document).ready(function() {
	try {
		displayLoadingWheel(true);

		createAvgTable();
		refreshAvg();
		refreshAvgTableWidth();

		displayLoadingWheel(false);
	}
	catch(e) {
		console.log(e);
	}

	$('#avgTable tr td').on('change', refreshAvgTableWidth());
});
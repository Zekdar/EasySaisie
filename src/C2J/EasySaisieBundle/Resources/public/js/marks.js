function getAvg(marks) {	
	var sum = 0.0;
	for(var i = 0; i < marks.length; i++) {
		sum += marks[i];
	}
	if(sum != 0)
		return (sum / marks.length).toFixed(2, 0); // Rounds at 10^-2 decimals
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
	var searchPattern = ''; // Necessary to know if we have to search for a <a> inside the <td> ou just the <td> itself

	if($(this).hasClass('tdMark'))
		searchPattern = 'a'

	var content;
	$('#marksTable tbody tr td:nth-child(' + (index + 2) + ') ' + searchPattern).each(function() {
		content = $(this).text().trim();
		if(content != 'Empty' && content != '') 
			marks.push(parseFloat(content));
	});

	return  marks.sort(function(a,b) {return a - b}); // Sort asc
}

function getMarksByStudent(student, includeAvg) {
	var marksCells = new Array();
	var marks = new Array();

	if(includeAvg)
		marksCells = $('#marksTable tbody tr:contains(' + student + ') td');
	else
		marksCells = $('#marksTable tbody tr:contains(' + student + ') td.tdMark');

	marksCells.splice(0, 2);

	$(marksCells).each(function() {
		marks.push($(this).text().trim());
	});

	return marks;	
}

function getTuCodes() {
	var tuCodesCells = $('#marksTable thead tr:nth-child(2)').find('[data-tucode]');
	var tuCodes = new Array();

	$(tuCodesCells).each(function(){
		tuCodes.push($(this).data('tucode'));
	});

	return tuCodes;
}

function getStudentsName() {
	var names = new Array();

	$('#marksTable tbody td.studentName').each(function() {
		names.push($(this).text().trim());
	});

	return names;
}

function refreshAvg(toggleLoader) {
	if(toggleLoader)
		displayLoadingWheel(true);

	// Calculates each teaching unit avg
	var tuCodes = getTuCodes();
	var sum = 0; var avg = 0;
	var studentMarks; 
	var tableAvg;
	var students = getStudentsName();
	var content;

	for(var i = 0; i < students.length; i++) {		
		tableAvg = new Array();

		for(var j = 0; j < tuCodes.length; j++) {
			studentMarks = new Array();
			sum = 0;
			avg = 0;

			$('#marksTable tbody tr:contains("' + students[i] + '") td').find('[data-tucode="' + tuCodes[j] + '"]').each(function() {
				content = $(this).text().trim();

				if(content != 'Empty') {
					studentMarks.push(parseFloat(content));
				}
			});

			for(var k = 0; k < studentMarks.length; k++) {
				sum += studentMarks[k];
			}

			avg = (sum / studentMarks.length).toFixed(2, 0);
			if(avg == 'NaN')
				avg = '';
			tableAvg.push(avg);
		}
		
		var tableTuAvg = $('#marksTable tbody tr:contains("' + students[i] + '") td.tuAvg');
		for(var k = 0; k < tableAvg.length; k++) {
			$(tableTuAvg[k]).text(tableAvg[k]);
		}
	}	

	// Refreshes avegerage table 
	var avgCells = $('#avgTable tbody tr:first td').splice(1);
	var minCells = $('#avgTable tbody tr:nth-child(2) td').splice(1);
	var maxCells = $('#avgTable tbody tr:last td').splice(1);
	var marks = new Array();
	var index;
	var avg, minAvg, maxAvg;

	$(avgCells).each(function() {
		index = $(this).index();
		marks = getMarksByIndex(index);

		if(marks.length > 0)
			avg = getAvg(marks);
		else 
			avg = '';
		if($('#marksTable thead tr:nth-child(' + index + ') th').hasClass('tuAvg'))
		
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

	if(toggleLoader)
		displayLoadingWheel(false);
}

function refreshAvgTableWidth() {console.log('refresh width');
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

	// $('#avgTable tr td').on('change', refreshAvgTableWidth());
});
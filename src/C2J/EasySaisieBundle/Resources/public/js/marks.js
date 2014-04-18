function getAvg(marks, withCoeff) {	
	var sum = 0.0;
	var sumCoeff = 0;
	var coeff;

	if(marks.length == 0) {
		return 'Empty';
	}
	else {
		for(var i = 0; i < marks.length; i++) {
			if(withCoeff) {
				if(marks[i].value != 'Empty') {
					coeff = marks[i].coeff;
					sum += marks[i].value * coeff;
					sumCoeff += coeff;
				}
			}
			else {
				if(marks[i] != 'Empty') {
					coeff = 1;
					sum += marks[i];
					sumCoeff += coeff;
				}
			}
		}
		return parseFloat((sum / sumCoeff).toFixed(2, 0)); // Rounds at 10^-2 decimals
	}
}

function getMinAvg(marks) {
	return marks[0];
}

function getMaxAvg(marks) {
	return marks[marks.length - 1];
}

function getMarksByIndex(index, tableId) {
	var marks = [];
	index += 2;

	if(!tableId)
		return [];

	$('#' + tableId + ' tbody tr td:nth-child(' + index + ')').each(function() {
		content = $(this).text().trim();
		if(content != 'Empty' && content != '') 
			marks.push(parseFloat(content));
	});

	return  marks.sort(function(a,b) {return a - b}); // Sort asc
}

function getMarksByStudent(student, includeAvg) {
	var marksCells = [];
	var marks = [];

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
	var tuCodes = [];

	$(tuCodesCells).each(function(){
		tuCodes.push($(this).data('tucode'));
	});

	return tuCodes;
}

function getStudentsName() {
	var names = [];

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
	var studentMarks = []; 
	var tableAvg;
	var students = getStudentsName();
	var content;
	var coeff;

	for(var i = 0; i < students.length; i++) {		
		tableAvg = [];

		for(var j = 0; j < tuCodes.length; j++) {
			studentMarks = [];
			sum = 0;
			avg = 0;

			$('#marksTable tbody tr:contains("' + students[i] + '") td').find('[data-tucode="' + tuCodes[j] + '"]').each(function() {
				content = $(this).text().trim();
				coeff = $(this).data('coeff');

				if(content != 'Empty') {
					studentMarks.push({
						"value"	: 	parseFloat(content),
						"coeff"	: 	coeff
					});
				}
			});

			avg = getAvg(studentMarks, true);
			if(avg == 'Empty')
				avg = '';
			tableAvg.push(avg);
		}

		var tableTuAvg = $('#marksTable tbody tr:contains("' + students[i] + '") td.tuAvg');
		for(var k = 0; k < tableAvg.length; k++) {
			$(tableTuAvg[k]).text(tableAvg[k]);
		}

	}	

	// Refreshes avegerage table 
	var avgCells = $('#avgTable tbody tr:contains(Moyenne) td').splice(1);
	var minCells = $('#avgTable tbody tr:contains(Min) td').splice(1);
	var maxCells = $('#avgTable tbody tr:contains(Max) td').splice(1);
	var marks = [];
	var index;
	var avg, minAvg, maxAvg;

	// Average
	$(avgCells).each(function() {
		index = $(this).index();
		marks = getMarksByIndex(index, 'marksTable');

		if(marks.length > 0) {
			avg = getAvg(marks);
		}
		else 
			avg = '';
		
		$(this).html(avg);
	});

	// Min
	$(minCells).each(function() {
		marks = getMarksByIndex($(this).index(), 'marksTable');
		
		if(marks.length > 0)
			minAvg = getMinAvg(marks).toFixed(2, 0);
		else 
			minAvg = '';

		$(this).html(minAvg);
	});

	// Max
	$(maxCells).each(function() {
		marks = getMarksByIndex($(this).index(), 'marksTable');

		if(marks.length > 0)
			maxAvg = getMaxAvg(marks).toFixed(2, 0);
		else 
			maxAvg = '';

		$(this).html(maxAvg);
	});

	// General averages table
	refreshGeneralAvgs(students);

	if(toggleLoader)
		displayLoadingWheel(false);
}

function refreshGeneralAvgs(students) {
	var studentAvgs = [];
	var tableAvgs = [];
	var content;
	var container;
	var currentContainer;
	var avg;
	var tmp;
	
	for(var i = 0; i < students.length; i++) {
		studentAvgs = {};
		tmp = [];

		var tuAvgsFromMarksTable = $('#marksTable tbody tr:contains("' + students[i] + '") td.tuAvg');
		container = $(tuAvgsFromMarksTable[0]).data('container');

		for(var j = 0; j < tuAvgsFromMarksTable.length; j++) {
			content = $(tuAvgsFromMarksTable[j]).text().trim();
			currentContainer = $(tuAvgsFromMarksTable[j]).data('container');

			if($(tuAvgsFromMarksTable[j]).data('container') == container) {
				if(content != '') 
					tmp.push(parseFloat(content));
			}
			else {
				studentAvgs['' + container] = tmp;
				tmp = [];

				if(content != '')
					tmp.push(parseFloat(content));

				container = $(tuAvgsFromMarksTable[j]).data('container');
			}
		}

		studentAvgs['' + container] = tmp;
		
		var avgsTmp = [];
		for(var j in studentAvgs) {
			avgsTmp.push(getAvg(studentAvgs[j]));
		}
		tableAvgs.push(avgsTmp);
	}
	
	// AVG display
	var studentAvgCells;
	var generalAvgCell;
	for(var i = 0; i < students.length; i++) {
		studentAvgCells = $('#displayContainersAvg tbody tr:contains(' + students[i] + ') td.avg');
		generalAvgCell = $('#displayContainersAvg tbody tr:contains(' + students[i] + ') td.generalAvg');

		for(var j = 0; j < tableAvgs[i].length; j++) {
			if(tableAvgs[i][j] != "Empty") {
				$(studentAvgCells[j]).text(tableAvgs[i][j]);
			}
		}
		
		if(tableAvgs[i].length > 0) {
			// Containers AVG calculation
			$(generalAvgCell).text(getAvg(tableAvgs[i]));
		}
	}

	// Refreshed Students AVG Table
	var avgCells = $('#studentsAvgTable tbody tr:contains(Moyenne) td').splice(1);
	var minCells = $('#studentsAvgTable tbody tr:contains(Min) td').splice(1);
	var maxCells = $('#studentsAvgTable tbody tr:contains(Max) td').splice(1);
	var marks = [];
	var index;
	var avg, minAvg, maxAvg;

	// Average
	$(avgCells).each(function() {
		index = $(this).index();
		marks = getMarksByIndex(index, 'containersAvgTable');

		if(marks.length > 0) {
			avg = getAvg(marks);
		}
		else 
			avg = '';
		
		$(this).html(avg);
	});

	// Min
	$(minCells).each(function() {
		marks = getMarksByIndex($(this).index(), 'containersAvgTable');
		
		if(marks.length > 0)
			minAvg = getMinAvg(marks).toFixed(2, 0);
		else 
			minAvg = '';

		$(this).html(minAvg);
	});

	// Max
	$(maxCells).each(function() {
		marks = getMarksByIndex($(this).index(),'containersAvgTable');

		if(marks.length > 0)
			maxAvg = getMaxAvg(marks).toFixed(2, 0);
		else 
			maxAvg = '';

		$(this).html(maxAvg);
	});
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
	var rows = '';	

	rows += '<tr><td></td>';
		var subjectsList = $('#marksTable thead tr:nth-child(3) th').splice(2);
		var content;

		$(subjectsList).each(function() {
			if($(this).text().trim() == '')
				content = '<img src="/EasySaisie/web/bundles/c2jeasysaisie/img/xbar.png">';
			else 
				content = $(this).text();
			rows += '<td>' + content + '</td>';
		});
	rows += '</tr>';

	var rowTitles = ['Moyenne', 'Min', 'Max'];
	for(var i = 0; i < 3; i++) {
		rows += '<tr><td><b>' + rowTitles[i] + '</b></td>';
			$(marksTableFirstRow).each(function() {

				var index = $(this).index();

				if($('#marksTable tbody tr:nth-child(3) td:nth-child(' + (index + 1) + ')').hasClass('tuAvg'))
					rows += '<td class="tuAvg"></td>';
				else
					rows += '<td></td>';

			});	
		rows += '</tr>';
	}

	$('#avgTable').append(rows);
}

function switchTables(href, e) {	
	if(e)
		e.preventDefault();
	
	if(href == '#displayMarks') {
		$('#displayContainersAvg').fadeOut(function() {
			window.location.hash = '#displayMarks';
			$('#displayMarks').fadeIn();
			$('#switchDisplayMarks').hide(0, function() {
				$('#switchDisplayContainersAvg').show(0);
			});
		});	
	}
	else {
		$('#displayMarks').fadeOut(function() {
			window.location.hash = '#displayContainersAvg';
			$('#displayContainersAvg').fadeIn();
			$('#switchDisplayContainersAvg').hide(0, function() {
				$('#switchDisplayMarks').show(0);
			});
		});	
	}
}

function switchTablesWithHash(hash) {
	switchTables(hash);		
} 

/***** WINDOW INIT *****/
$(document).ready(function() {
	$('#switchDisplayMarks, #switchDisplayContainersAvg').on('click', function(event) {
		switchTables($(this).attr('href'), event);
	});

	// try {
		var startStopWatch = (new Date()).getTime();

		// displayLoadingWheel(true);

		if(window.location.hash == '')
			window.location.hash = '#displayMarks'
		switchTablesWithHash(window.location.hash)

		createAvgTable();
		refreshAvg();
		refreshAvgTableWidth();

		displayLoadingWheel(false);

		var totalTime = (new Date()).getTime() - startStopWatch;
		console.log('Generated in : ' + totalTime + 'ms');
	// }
	// catch(e) {
		// console.error('/!\\ Exception : ' + e.message);
	// }
});
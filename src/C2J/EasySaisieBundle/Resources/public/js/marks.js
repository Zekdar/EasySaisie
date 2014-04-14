function getAvg(marks, withCoeff) {	
	var sum = 0.0;
	var sumCoeff = 0;
	var coeff;

	for(var i = 0; i < marks.length; i++) {
		if(withCoeff) {
			coeff = marks[i].coeff;
			sum += marks[i].value * coeff;
		}
		else {
			coeff = 1;
			sum += marks[i];
		}

		sumCoeff += coeff;
	}
	if(sum != 0)
		return (sum / sumCoeff).toFixed(2, 0); // Rounds at 10^-2 decimals
	else
		return 'Empty';
}

function getMinAvg(marks) {
	return marks[0];
}

function getMaxAvg(marks) {
	return marks[marks.length - 1];
}

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
	var coeff;

	for(var i = 0; i < students.length; i++) {		
		tableAvg = new Array();

		for(var j = 0; j < tuCodes.length; j++) {
			studentMarks = new Array();
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
	var marks = new Array();
	var index;
	var avg, minAvg, maxAvg;

	// Average
	$(avgCells).each(function() {
		index = $(this).index();
		marks = getMarksByIndex(index);

		if(marks.length > 0) {
			avg = getAvg(marks);
		}
		else 
			avg = '';
		
		$(this).html(avg);
	});

	// Min
	$(minCells).each(function() {
		marks = getMarksByIndex($(this).index());
		
		if(marks.length > 0)
			minAvg = getMinAvg(marks).toFixed(2, 0);
		else 
			minAvg = '';

		$(this).html(minAvg);
	});

	// Max
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
		$('#displayContainersAvg').fadeOut(400, function() {
			window.location.hash = '#displayMarks';
			$('#displayMarks').fadeIn(400);
			$('#switchDisplayMarks').hide(0, function() {
				$('#switchDisplayContainersAvg').show(0);
			});
		});	
	}
	else {
		$('#displayMarks').fadeOut(400, function() {
			window.location.hash = '#displayContainersAvg';
			$('#displayContainersAvg').fadeIn(400);
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

	try {
		var startStopWatch = (new Date()).getTime();

		displayLoadingWheel(true);

		if(window.location.hash != '')
			switchTablesWithHash(window.location.hash)

		createAvgTable();
		refreshAvg();
		refreshAvgTableWidth();

		displayLoadingWheel(false);

		var totalTime = (new Date()).getTime() - startStopWatch;
		console.log('Generated in : ' + totalTime + 'ms');
	}
	catch(e) {
		console.log(e);
	}
});
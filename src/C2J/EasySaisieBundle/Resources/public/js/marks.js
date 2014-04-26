var studentMarksTable = {};
var containersInfo = {};
var teachingUnitsInfo = {};

function getAvg(marks, withCoeff) {	
	var sum = 0.0;
	var sumCoeff = 0;
	var coeff;
	var containsSomething = false;

	if(marks.length == 0) {
		return 'Empty';
	}
	else {
		for(var i = 0; i < marks.length; i++) {
			if(withCoeff) {
				if(marks[i].value != 'Empty') {
					containsSomething = true;
					coeff = marks[i].coeff;
					sum += marks[i].value * coeff;
					sumCoeff += coeff;
				}
			}
			else {
				if(marks[i] != 'Empty') {
					containsSomething = true;
					coeff = 1;
					sum += marks[i];
					sumCoeff += coeff;
				}
			}
		}

		if(containsSomething)
			return parseFloat((sum / sumCoeff).toFixed(3, 0)); // Rounds at 10^-2 decimals
		else
			return 'Empty';
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
		if($(this).hasClass('tdMark'))
			content = $(this).find('a:first').text().trim();
		else
			content = $(this).text().trim();

		if(content != 'Empty' && content != 'Toutes les notes n\'ont pas encore été remplies.' && content != '') {
			marks.push(parseFloat(content));
		}
	});

	return  marks.sort(function(a,b) {return a - b}); // Sort asc
}

function getMarksByStudent(student, withCoeff) {
	var marks = [];
	var content;
	var coeff;	
	var marksCells = $('#marksTable tbody tr:contains(' + student + ')').find('td.tdMark a');

	$(marksCells).each(function() {
		content = $(this).text().trim();
		coeff = $(this).data('coeff');

		if(withCoeff)
			if(content != 'Empty' && coeff != '')
				marks.push({
					'value' : parseFloat(content),
					'coeff' : parseFloat(coeff)
				});
			else
				marks.push({
					'value' : content,
					'coeff' : coeff
				});
		else
			marks.push(content);
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

function getNotationSystemRules() {
	// Containers
	$($('#marksTable thead tr:first th').splice(2)).each(function() {
		var container = {};
		
		containersInfo[$(this).text().trim()] = {
			areTusCompensable : $(this).data('aretuscompensable'),
			minMark : $(this).data('minmark'),
			minAvg : $(this).data('minavg')			
		}
	});

	// Teaching Units
	$($('#marksTable thead tr:nth-child(2) th').splice(2)).each(function() {
		var tu = {};
		teachingUnitsInfo[$(this).data('tucode')] = {
			isCompensable : $(this).data('iscompensable')
		}
	});
}

function refreshAvg(toggleLoader) {
	if(toggleLoader)
		displayLoadingWheel(true);

	// Calculates each teaching unit avg
	var tuCodes = getTuCodes();
	var sum = 0; var avg = {};
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
			avg = {};

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

			avg.value = getAvg(studentMarks, true);
			if(avg.value == 'Empty'){
				avg.value = '';
				avg.tuCode = tuCodes[j];
				tableAvg.push(avg);
			}
			else {
				avg.value = avg.value.toFixed(3, 0);
				avg.tuCode = tuCodes[j];
				tableAvg.push(avg);	
			}
		}

		var tableTuAvg = $('#marksTable tbody tr:contains("' + students[i] + '") td.tuAvg');
		for(var k = 0; k < tableAvg.length; k++) {
			$(tableTuAvg[k]).text(tableAvg[k].value);
			$(tableTuAvg[k]).data('tuCode', tableAvg[k].tuCode);
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
			avg = getAvg(marks).toFixed(3, 0);
		}
		else 
			avg = '';
		
		$(this).html(avg);
	});

	// Min
	$(minCells).each(function() {
		marks = getMarksByIndex($(this).index(), 'marksTable');
		
		if(marks.length > 0)
			minAvg = getMinAvg(marks).toFixed(3, 0);
		else 
			minAvg = '';

		$(this).html(minAvg);
	});

	// Max
	$(maxCells).each(function() {
		marks = getMarksByIndex($(this).index(), 'marksTable');

		if(marks.length > 0)
			maxAvg = getMaxAvg(marks).toFixed(3, 0);
		else 
			maxAvg = '';

		$(this).html(maxAvg);
	});

	// General averages table
	refreshGeneralAvgs(students);
	
	// Checks if there are new students going to session 2
	refreshStudentsGoingToSession2();

	if(toggleLoader)
		displayLoadingWheel(false);
}

function refreshGeneralAvgs(students) {
	var studentAvgs = [];
	var tableAvgs = [];
	var content;
	var coeff
	var container;
	var currentContainer;
	var avg;
	var tmp;
	
	for(var i = 0; i < students.length; i++) {
		studentAvgs = {};
		tmp = [];

		var tuAvgsFromMarksTable = $('#marksTable tbody tr:contains("' + students[i] + '") td.tuAvg');
		container = $(tuAvgsFromMarksTable[0]).data('containername');

		for(var j = 0; j < tuAvgsFromMarksTable.length; j++) {
			content = $(tuAvgsFromMarksTable[j]).text().trim();
			coeff = $(tuAvgsFromMarksTable[j]).data('coeff');
			currentContainer = $(tuAvgsFromMarksTable[j]).data('containername');

			if($(tuAvgsFromMarksTable[j]).data('containername') == container) {
				if(content != '') 
					tmp.push({
						"value"	: 	parseFloat(content),
						"coeff"	: 	coeff
					});
			}
			else {
				studentAvgs['' + container] = tmp;
				tmp = [];

				if(content != '')
					tmp.push({
						"value"	: 	parseFloat(content),
						"coeff"	: 	coeff
					});

				container = $(tuAvgsFromMarksTable[j]).data('containername');
			}
		}

		studentAvgs['' + container] = tmp;
		
		var avgsTmp = [];
		for(var j in studentAvgs) {
			avgsTmp.push(getAvg(studentAvgs[j], true));
		}
		tableAvgs.push(avgsTmp);
	}
	
	// AVG display
	var studentAvgCells;
	var generalAvgCell;
	for(var i = 0; i < students.length; i++) {
		studentAvgCells = $('#displayContainersAvg tbody tr:contains(' + students[i] + ') td.avg');
		generalAvgCell = $('#displayContainersAvg tbody tr:contains(' + students[i] + ') td.generalAvg');

		// Displays Containers AVG
		for(var j = 0; j < tableAvgs[i].length; j++) {
			if(tableAvgs[i][j] != "Empty") {
				$(studentAvgCells[j]).text(tableAvgs[i][j]);
			}
		}
		
		// Displays General AVG
		var studentMarks = getMarksByStudent(students[i], true);
		var missingMark = false;
		for(var j = 0; j < studentMarks.length && !missingMark; j++) {
			if(studentMarks[j].value == 'Empty') 
				missingMark = true;
		}

		if(!missingMark) {
			var avg = getAvg(studentMarks, true);
			if(avg != 'Empty')
				$(generalAvgCell).text(avg);			
		}
		else {
			$(generalAvgCell).text('Toutes les notes n\'ont pas encore été remplies.');
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
			avg = getAvg(marks).toFixed(3, 0);
		}
		else 
			avg = '';
		
		$(this).html(avg);
	});

	// Min
	$(minCells).each(function() {
		marks = getMarksByIndex($(this).index(), 'containersAvgTable');
		
		if(marks.length > 0)
			minAvg = getMinAvg(marks).toFixed(3, 0);
		else 
			minAvg = '';

		$(this).html(minAvg);
	});

	// Max
	$(maxCells).each(function() {
		marks = getMarksByIndex($(this).index(),'containersAvgTable');

		if(marks.length > 0)
			maxAvg = getMaxAvg(marks).toFixed(3, 0);
		else 
			maxAvg = '';

		$(this).html(maxAvg);
	});
}

function refreshStudentsGoingToSession2() {
	var studentsNumbers = [];
	var goToSession2 = [];
	var currentStudent;
	var content;
	var missingMark;

	// Gets students number
	$('#marksTable tbody tr td:nth-child(1)').each(function() {
		studentsNumbers.push($(this).text().trim());
	});

	// Gets students marks by their number
	var stop = false;
	for(var i = 0; i < studentsNumbers.length && !stop; i++) {
		currentStudent = $('#marksTable tbody tr:contains(' + studentsNumbers[i] + ')');

		// Rule minMark
		missingMark = false;
		$(currentStudent).find('td.tdMark a').each(function() {
			content = $(this).text().trim();

			if(!$.isEmptyObject(containersInfo) && !$.isEmptyObject(teachingUnitsInfo)) {
				if(content != 'Empty' && content < containersInfo[$(this).data('containername')].minMark) {
					goToSession2.push(studentsNumbers[i]);
					return false;
				}
				if(content == 'Empty') {
					missingMark = true;
				}
			}
			else {
				alert('Il y a un problème de paramétrages au niveau des règles de validation. \nMerci de contacter l\'administrateur d\'EasySaisie en lui donnant cette erreur : \n"containersInfo == [] || teachingUnitsInfo == []"');
				stop = true;
				return false;
			}
		});
		
		// Checks for missing marks for each container
		var containers = {};
		for(var j in containersInfo) {
			containers[j] = {
				isFullyFilled : true
			}

			// Search marks by containers
			$(currentStudent).find('td.tdMark a[data-containername="' + j + '"]').each(function() {
				content = $(this).text().trim();

				if(content == 'Empty') {
					containers[j] = {
						isFullyFilled : false
					}
					return false; // break the loop
				}
			});			
		}
		
		for(var j in containers) {
			// If alls marks are filled in this container, let's check the minAvgToValidate
			if(containers[j].isFullyFilled) {
				var marks = [];

				$('#containersAvgTable tbody tr:contains(' + studentsNumbers[i] + ')').find('td.avg[data-containername="' + j + '"]').each(function() {
					content = $(this).text().trim();

					if(content != '' && content < containersInfo[j].minAvg && goToSession2.indexOf(studentsNumbers[i]) == -1) {
						if(containersInfo[j].areTusCompensable) // TODO
							goToSession2.push(studentsNumbers[i]);
					}
				});
			}
		}
	}
	console.log(goToSession2);
	return goToSession2;
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

var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()

/***** WINDOW INIT *****/
$(document).ready(function() {
	$('#switchDisplayMarks, #switchDisplayContainersAvg').on('click', function(event) {
		switchTables($(this).attr('href'), event);
	});
	
	$('#btnExport').on('click', function(event) {
		event.preventDefault();
		var id = $('.exportable:visible').attr('id');
		tableToExcel(id, 'export');		
	});
	
	// try {
		var startStopWatch = (new Date()).getTime();

		displayLoadingWheel(true);

		if(window.location.hash == '')
			window.location.hash = '#displayMarks';
		switchTablesWithHash(window.location.hash);

		createAvgTable();
		getNotationSystemRules();
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
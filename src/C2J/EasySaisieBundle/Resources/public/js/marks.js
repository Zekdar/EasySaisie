var studentMarksTable = {};
var containersInfo = {};
var teachingUnitsInfo = {};
// var promotion = {};

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

function getStudentsNumber() {
	var numbers = [];

	$('#marksTable tbody td.studentNumber').each(function() {
		numbers.push($(this).text().trim());
	});

	return numbers;
}

function getNotationSystemRules() {
	// Containers
	$($('#marksTable thead tr:first th').splice(2)).each(function() {
		var container = {};
		
		containersInfo[$(this).text().trim()] = {
			isCompensable : $(this).data('iscompensable'),
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
	var students = getStudentsNumber();
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

function getStudentsGoingToSession2() {
	var studentsNumbers = [];
	var goToSession2 = [];
	var currentStudent;
	var content;
	var missingMark;

	if(!$.isEmptyObject(containersInfo) && !$.isEmptyObject(teachingUnitsInfo)) {
		// Gets students number
		$('#marksTable tbody tr td:nth-child(1)').each(function() {
			studentsNumbers.push($(this).text().trim());
		});

		// Gets students marks by their number
		for(var i = 0; i < studentsNumbers.length; i++) {
			var stop = false; 

			currentStudent = $('#marksTable tbody tr:contains(' + studentsNumbers[i] + ')');

			// Checks for missing marks for each container
			var containersFullyFilled = true;
			for(var j in containersInfo) {
				// Search marks by containers
				$(currentStudent).find('td.tdMark a').each(function() {
					content = $(this).text().trim();

					if(content == 'Empty') {
						containersFullyFilled = false;
						return false; // break the loop
					}
				});			
			}
			
			if(containersFullyFilled) {
				for(var j in containersInfo) {
					// foreach container marks
					var containerMarks = $(currentStudent).find('td.tdMark a[data-containername="' + j + '"]').each(function() {
						content = $(this).text().trim();
			
						if(content != 'Empty' && content < containersInfo[$(this).data('containername')].minMark && goToSession2.indexOf(studentsNumbers[i]) == -1) {
							goToSession2.push(studentsNumbers[i]);
							stop = true;
							return false; // stop looping because this student has already an eliminatory mark 
						}
					});
				}
			
			
				// !stop means that this student doesn't have any eliminatory mark
				if(!stop) {
					var generalAvg = $($('#containersAvgTable tbody tr:contains(' + studentsNumbers[i] + ')').find('td.generalAvg')[0]).text().trim();
					if(generalAvg != '' && generalAvg != 'Toutes les notes n\'ont pas encore été remplies.') {
						for(var j in containersInfo) {
							var containerAvg = $($('#containersAvgTable tbody tr:contains(' + studentsNumbers[i] + ')').find('td.avg[data-containername="' + j + '"]')[0]).text().trim();

							if(!containersInfo[j].isCompensable && containerAvg != '' && containerAvg < containersInfo[j].minAvg && goToSession2.indexOf(studentsNumbers[i]) == -1) {
								goToSession2.push(studentsNumbers[i]);
								stop = true;
							}
						}
					}
				}

				if(!stop) {
					var containername;
					for(var j in containersInfo) {
						$(currentStudent).find('td.tuAvg[data-containername="' + j + '"]').each(function() {
							content = $(this).text().trim();
							isCompensable = $(this).data('iscompensable');

							if(content != '' && containername != '' && !isCompensable && content < containersInfo[j].minAvg && goToSession2.indexOf(studentsNumbers[i]) == -1) {
								goToSession2.push(studentsNumbers[i]);
							}
						});
					}
				}
			}
		}
		return goToSession2;
	}

	else {
		alert('Il y a un problème de paramétrages au niveau des règles de validation. \nMerci de contacter l\'administrateur d\'EasySaisie en lui donnant cette erreur : \n"containersInfo == [] || teachingUnitsInfo == []"');
		stop = true;
		return false;
	}
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

	$('#btnExport').on('click', function(event) {
		var excelFile = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>";
		excelFile += "<head>";
		excelFile += "<!--[if gte mso 9]>";
		excelFile += "<xml>";
		excelFile += "<x:ExcelWorkbook>";
		excelFile += "<x:ExcelWorksheets>";
		excelFile += "<x:ExcelWorksheet>";
		excelFile += "<x:Name>";
		excelFile += "{worksheet}";
		excelFile += "</x:Name>";
		excelFile += "<x:WorksheetOptions>";
		excelFile += "<x:DisplayGridlines/>";
		excelFile += "</x:WorksheetOptions>";
		excelFile += "</x:ExcelWorksheet>";
		excelFile += "</x:ExcelWorksheets>";
		excelFile += "</x:ExcelWorkbook>";
		excelFile += "</xml>";
		excelFile += "<![endif]-->";
		excelFile += "</head>";
		excelFile += "<body>";
		excelFile += "<table>";
		excelFile += $('.exportable').html().replace(/"/g, '\'').replace(/<a.+Empty<\/a>/g, '').replace(/<img.+xbar.png'>/g, '');
		excelFile += "</table>";
		excelFile += "</body>";
		excelFile += "</html>";

		window.open('data:application/vnd.ms-excel,' + decodeURIComponent(encodeURIComponent(escape(excelFile))));
		//window.open('data:application/vnd.ms-excel;charset=utf-8;filename=coucou;' + base64data);
		event.preventDefault();
		//var id = $('.exportable:visible').attr('id');
		//tableToExcel(id);
	});

	// Handles the active class for the session buttons
	$('#btns_session').find('a.sessionPicker').each(function() {
		// get the session from the url
		var url = window.location.pathname.split('/');
		
		if(url != '')
			var sessionParam = url[url.length-1]

		if(sessionParam != '') {
			if(sessionParam == 1) {
				$('#btn_session1').addClass('active');
				$('#btn_session2').removeClass('active');
				$('#btn_pvFinal').removeClass('active');
			}
			else if(sessionParam == 2) {
				$('#btn_session2').addClass('active');
				$('#btn_session1').removeClass('active');
				$('#btn_pvFinal').removeClass('active');	
			}
			else {
				$('#btn_pvFinal').addClass('active');		
				$('#btn_session1').removeClass('active');
				$('#btn_session2').removeClass('active');
				$('#btn_session2').attr('disabled', true);
			}
		}
	});

	$('#btns_session').find('a.sessionPicker').on('click', function(event) {
		event.preventDefault();
		
		var url = window.location.pathname;
		var href = $(this).attr('href');
		var hrefToCompareWith = href;
		var stop = false;

		var studentsNumberToTransmit = []; // used if btn_session2 is clicked
		if($(this).attr('id') == 'btn_session2') {
			var studentsSession2 = getStudentsGoingToSession2();
			var content;
			if(studentsSession2.length > 0) {
				for(var i = 0; i < studentsSession2.length; i++) {
					studentsNumberToTransmit.push(studentsSession2[i]);
				}
				href += '?studentsList=' + JSON.stringify(studentsNumberToTransmit); // passes the studentsList array to the controller
			}
			else {
				stop = true;
				alert('Aucun élève n\'est encore aux rattrapages.');
			}
		}		
		
		if(!stop && href != '' && url != '' && url != hrefToCompareWith)
			window.location = href;
	});

	/**
	*	Handle X-Editable plugin
	**/
	var pattern = new RegExp("^[0-9]{1,2}\.?[0-9]{0,2}$");
	$('.mark').editable({
		title : "Entrez une note (entre 0.00 - 20.00)",
		validate: function(value) {
			value = $.trim(value);

			if(value && (!pattern.test(value) || value < 0 || value > 20)) {
				return 'La note doit être comprise entre 0.00 - 20.00';
			}
		},
		ajaxOptions: {
		    type: 'put'
		},
		emptyclass : 'emptyClass',
		params: function(params) {
		    params.spid = $(this).data('spid');
		    params.tucsid = $(this).data('tucsid');
		    params.pk = $(this).data('pk');
		    params.session = session;

		    return params;
		},
		success: function(response, newValue) {
	        if(response.status == 'error') 
	        	console.log(response.msg);

	        $(this).data('pk', response.markId);
	        $(this).editable('setValue', newValue); // Needed to update the value in html before calling refreshAvg(), otherwise the update is done last
	        refreshAvg(true);
	    },
		error: function(response, newValue) {
	        console.log(response.responseText);	
		}
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
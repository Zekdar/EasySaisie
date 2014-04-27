$(document).ready(function() {
	var student = $('#c2j_userbundle_user_student_control_group');
	var teacher = $('#c2j_userbundle_user_teacher_control_group');
	var role = $('#c2j_userbundle_user_myRoles');

	if($(role).val() != 'ROLE_STUD') {
		$(student).hide();
	}
	if($(role).val() != 'ROLE_PROF') {
		$(teacher).hide();
	}
	

	$(role).on('change',function() {console.log('bite');
		if($(this).val() == 'ROLE_STUD') {
			$('#c2j_userbundle_user_teacher').val('');
			$(teacher).hide();
			$(student).show();
		}
		else if($(this).val() == 'ROLE_PROF') {
			$('#c2j_userbundle_user_student').val('');
			$(student).hide();
			$(teacher).show();
		}
		else {
			$('#c2j_userbundle_user_student').val('');
			$('#c2j_userbundle_user_teacher').val('');
			$(student).hide();
			$(teacher).hide();
		}
	});
	
});
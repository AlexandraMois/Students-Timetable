function saveStudent(studentId) {

	var modal = $('#myModal-' + studentId);

	modal.find('.errors').html('').removeClass('eroare-edit');

	$.post( "/students/update", 
		$("#form-update-student-" + studentId).serialize() 
	)
	  .done(function( data ) {
	  	response = JSON.parse(data);
	  	if (response.status == 'success') {
	  		modal.removeClass('fade').modal("hide");
			$('#status-update-student').removeClass('hidden').addClass('reusit').html('Studentul a fost salvat cu succes!');
			
	  	} else {
	  		var str = "";
	  		for(x in response.errors){
	  			str = str.concat(response.errors[x], "<br>");
	  		}
	  		modal.find('.errors').removeClass('hidden').addClass('eroare-edit').html(str);
  		}
  	});
	 
}

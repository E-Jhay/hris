var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

	  $("#pim_list").addClass("active_tab");
	  $('.drawer').hide();
	  $('.drawer').on('click',function(){
	   $('.navnavnav').slideToggle();
	  });

		$('#statusdd').on('change',function(){
			var statusdd = $('#statusdd').val();
			$('#tbl_employee').DataTable().destroy();
			loademployee(statusdd);
		});

		$('#formModal').on('submit', function (e) {
    		e.preventDefault();
    		confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
      	});


	});

	function save_callback(){
		var formData = new FormData($("#formModal")[0]);
		$.ajax({
			url:"controller/controller.employee.php?updateEmployeeMasterfile",
			method:"POST",
			data: formData,
			processData: false,
			contentType: false,
			beforeSend: function(){
				$("#updateEmployeeBtn").text('Loading....')
				$("#updateEmployeeBtn").attr('disabled', true)
			},
			complete: function(){
				$("#updateEmployeeBtn").text('Upload')
				$("#updateEmployeeBtn").attr('disabled', false)
			},
			success:function(data){
				const b = $.parseJSON(data)
				if(b.type === 'error')
					$.Toast(b.message, errorToast)
				else {
					$.Toast(b.message, successToast)
					$('#tbl_employee').DataTable().destroy();
					loademployee('Active');
				}
				$('#update_modal').modal('hide');
				$('#forformModalm').trigger("reset");
			}
		});
	}

	// function lb(){

	// 		 $.ajax({
	// 			url:"controller/controller.leavebalance.php?leave_credits_load",
	// 			method:"POST",
	// 			data:{
	// 				id:""
	// 			},success:function(){

	// 			}
	// 		});
			 
	// }
	// lb();

	function loademployee(statusdd){
    
    $('#tbl_employee').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "pageLength":10,
			  "scrollX": true,
              "ajax" : "controller/controller.employee.php?loademployee&statusdd="+statusdd,
              "columns" : [

                    { "data" : "pic"},
                    { "data" : "employeeno"},
                    { "data" : "lastname"},
                    { "data" : "firstname"},
                    { "data" : "middlename"},
                    { "data" : "job_title"},
                    { "data" : "employment_status"},
                    { "data" : "company"},
                    { "data" : "action"},

                ],
         });
  }
  var statusdd = "Active";
  loademployee(statusdd);

  function editemp(employeeno){
  	window.location.href="dashboard.php?employeeno="+employeeno;
  }
  function deleteemp(employeeno){
  	confirmed("delete",deleteemp_callback, "Do you really want to delete this?", "Yes", "No",employeeno);
  }

  function deleteemp_callback(employeeno){
  		$.ajax({
	  		url:"controller/controller.employee.php?deleteemployee",
	  		method:"POST",
	  		data:{
	  			employeeno:employeeno
	  		},success:function(){
	  			$.Toast("Successfully Deleted", successToast);
	  			$('#myModal').modal('hide');
		      $('#tbl_employee').DataTable().destroy();
		      loademployee("Active");
			  $('#statusdd').val('Active')
	  		}
	  	});
  }

  function backmodule(){
  	window.location.href="module.php";
  }

  function goto(linkk){
		window.location.href=linkk;
  }

//   function count_leaveapp(){

// 	var employeenoo = $('#employeeno').val();
// 	$.ajax({
// 		url:"controller/controller.leave_app.php?count_leaveapp",
// 		method:"POST",
// 		data:{
// 			employeenoo:employeenoo
// 		},success:function(data){
// 			var b = $.parseJSON(data);
			
// 			if(b.count > 0){
// 				$('#leave_app_number').show();
// 				$('#leave_app_number').html(b.count);
// 			}else{
// 				$('#leave_app_number').hide();
// 			}
// 		}
// 	});
// }
// count_leaveapp();

// function count_otapp(){

// 	var employeenoo = $('#employeeno').val();
// 	$.ajax({
// 		url:"controller/controller.leave_app.php?count_otapp",
// 		method:"POST",
// 		data:{
// 			employeenoo:employeenoo
// 		},success:function(data){
// 			var b = $.parseJSON(data);
			
// 			if(b.count > 0){
// 				$('#ot_app_number').show();
// 				$('#ot_app_number').html(b.count);
// 			}else{
// 				$('#ot_app_number').hide();
// 			}
// 		}
// 	});
// }
// count_otapp();

// function count_payslip(){

// 	var employeenoo = $('#employeeno').val();
// 	$.ajax({
// 		url:"controller/controller.leave_app.php?count_payslip",
// 		method:"POST",
// 		data:{
// 			employeenoo:employeenoo
// 		},success:function(data){
// 			var b = $.parseJSON(data);
			
// 			if(b.count > 0){
// 				$('#payslip_number').show();
// 				$('#payslip_number').html(b.count);
// 			}else{
// 				$('#payslip_number').hide();
// 			}
// 		}
// 	});
// }
// count_payslip();

// function count_reimbursement(){

// 	var employeenoo = $('#employeeno').val();
// 	$.ajax({
// 		url:"controller/controller.leave_app.php?count_reimbursement",
// 		method:"POST",
// 		data:{
// 			employeenoo:employeenoo
// 		},success:function(data){
// 			var b = $.parseJSON(data);
// 			if(b.count > 0){
// 				$('#reim_app_number').show();
// 				$('#reim_app_number').html(b.count);
// 			}else{
// 				$('#reim_app_number').hide();
// 			}
// 		}
// 	});
// }
// count_reimbursement();

function updateEmployees(){
	$('#update_modal').modal('show');
}
function exportEmployees(){
	window.location.href="tcpdf/examples/masterFileList.php"
}
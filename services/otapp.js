var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    $("#ess_overtimereports").addClass("active_tab");
    $('.drawer').hide();
    $('.drawer').on('click',function(){
       $('.navnavnav').slideToggle();
    });

		var notif_number = $('#notif_number').html();
		if(notif_number > 0){
			$('#notif_number').show();
		}else{
			$('#notif_number').hide();
		}
		var employeenoo = $('#employeeno').val();
		$('#filter_status').on('change',function(){
			const filter_status = $('#filter_status').val();
			$('#tbl_myot').DataTable().destroy();
			loadallot(filter_status);
		});
    $('#lleave').addClass("active");
	});

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

function btnotlist(){
  $('#lleave').addClass("active");
  $('#lreports').removeClass("active");
  $('#div_otlist').show();
  $('#div_reports').hide();
}
function btnreports(){
  $('#lleave').removeClass("active");
  $('#lreports').addClass("active");
  $('#div_otlist').hide();
  $('#div_reports').show();
}

  function open_ot(id,firstname,lastname,job_title,reasons,date_filed,ot_from,ot_to,no_of_hrs,ot_date,statuss,remarks, employeeno){
  	$('#overtimedetail_modal').modal('show');

  	$('#ot_id').val(id);
	$('#ot_emp_name').html(firstname+' '+lastname);
	$('#ot_position').html(job_title);
	$('#ot_reasons').html(reasons);
	$('#ot_date_filed').html(date_filed);
	$('#ot_from').html(ot_from);
	$('#ot_to').html(ot_to);
	$('#ot_no_of_hrs').html(no_of_hrs);
	$('#ot_date').html(ot_date);
	$('#ot_remarks').val(remarks);
	$('#ot_status').text(statuss);
	$('#ot_employeeno').val(employeeno);
	if(statuss=="Pending"){
		$('#btnapprove').show();
		$('#btndisapprove').show();
		$('#btncancelapprove').hide();
	}else{
		$('#btnapprove').hide();
		$('#btndisapprove').hide();
		$('#btncancelapprove').show();
	}



  }

  function approve(){
  	confirmed("save",approve_callback, "Do you really want to approve this?", "Yes", "No");
  }

  function approve_callback(){
  	var ot_id = $('#ot_id').val();
  	var ot_remarks = $('#ot_remarks').val();
  	var statuss = "Approved";
  	var employeeno = $('#employeeno').val();
  	var ot_employeeno = $('#ot_employeeno').val();

  		$.ajax({
  			url:"controller/controller.otapp.php?approveot",
  			method:"POST",
  			data:{
  				ot_id: ot_id,
				ot_remarks: ot_remarks,
				statuss: statuss,
				employeeno: employeeno,
				ot_employeeno: ot_employeeno,
  			},
			  beforeSend: function(){
				  $("#btnapprove").text('Loading....')
				  $("#btnapprove").attr('disabled', true)
				  $("#btndisapprove").text('Loading....')
				  $("#btndisapprove").attr('disabled', true)
				  $("#btncancelapprove").text('Loading....')
				  $("#btncancelapprove").attr('disabled', true)
			  },
			  complete: function(){
				  $("#btnapprove").text('Approved')
				  $("#btnapprove").attr('disabled', false)
				  $("#btndisapprove").text('Disapproved')
				  $("#btndisapprove").attr('disabled', false)
				  $("#btncancelapprove").text('Cancel')
				  $("#btncancelapprove").attr('disabled', false)
			  },
			  success:function(data){
				const b = $.parseJSON(data)
				if(b.type === 'error')
					$.Toast(b.message, errorToast)
				else {
					$.Toast(b.message, successToast)
					$('#overtimedetail_modal').modal('hide');
					$('#filter_status').val('Pending');
					$('#tbl_myot').DataTable().destroy();
					loadallot('Pending');
				}
  			}
  		});
  }
  function disapproved(){
  	confirmed("delete",disapproved_callback, "Do you really want to disapprove this?", "Yes", "No");
  }

  function disapproved_callback(){
  	var ot_id = $('#ot_id').val();
  	var ot_remarks = $('#ot_remarks').val();
  	var statuss = "Disapproved";
  	var employeeno = $('#employeeno').val();
  	var ot_employeeno = $('#ot_employeeno').val();

  		$.ajax({
  			url:"controller/controller.otapp.php?approveot",
  			method:"POST",
  			data:{
  				ot_id: ot_id,
				ot_remarks: ot_remarks,
				statuss: statuss,
				employeeno: employeeno,
				ot_employeeno: ot_employeeno,
  			},
			  beforeSend: function(){
				  $("#btnapprove").text('Loading....')
				  $("#btnapprove").attr('disabled', true)
				  $("#btndisapprove").text('Loading....')
				  $("#btndisapprove").attr('disabled', true)
				  $("#btncancelapprove").text('Loading....')
				  $("#btncancelapprove").attr('disabled', true)
			  },
			  complete: function(){
				  $("#btnapprove").text('Approved')
				  $("#btnapprove").attr('disabled', false)
				  $("#btndisapprove").text('Disapproved')
				  $("#btndisapprove").attr('disabled', false)
				  $("#btncancelapprove").text('Cancel')
				  $("#btncancelapprove").attr('disabled', false)
			  },
			  success:function(data){
				const b = $.parseJSON(data)
				if(b.type === 'error')
					$.Toast(b.message, errorToast)
				else {
					$.Toast(b.message, successToast)
					$('#overtimedetail_modal').modal('hide');
					$('#filter_status').val('Pending');
					$('#tbl_myot').DataTable().destroy();
					loadallot('Pending');
				}
  			}
  		});
  }

  function cancelapprove(){
  	confirmed("delete",cancelapprove_callback, "Do you really want to cancel this?", "Yes", "No");
  }

  function cancelapprove_callback(){
  	var ot_id = $('#ot_id').val();
  	var ot_remarks = "";
  	var statuss = "Cancelled";
  	var employeeno = $('#employeeno').val();
  	var ot_employeeno = $('#ot_employeeno').val();
  		$.ajax({
  			url:"controller/controller.otapp.php?approveot",
  			method:"POST",
  			data:{
  				ot_id: ot_id,
				ot_remarks: ot_remarks,
				statuss: statuss,
				employeeno: employeeno,
				ot_employeeno: ot_employeeno,
  			},
			beforeSend: function(){
				$("#btnapprove").text('Loading....')
				$("#btnapprove").attr('disabled', true)
				$("#btndisapprove").text('Loading....')
				$("#btndisapprove").attr('disabled', true)
				$("#btncancelapprove").text('Loading....')
				$("#btncancelapprove").attr('disabled', true)
			},
			complete: function(){
				$("#btnapprove").text('Approved')
				$("#btnapprove").attr('disabled', false)
				$("#btndisapprove").text('Disapproved')
				$("#btndisapprove").attr('disabled', false)
				$("#btncancelapprove").text('Cancel')
				$("#btncancelapprove").attr('disabled', false)
			},
			success:function(data){
				const b = $.parseJSON(data)
				if(b.type === 'error')
					$.Toast(b.message, errorToast)
				else {
					$.Toast(b.message, successToast)
					$('#overtimedetail_modal').modal('hide');
					$('#filter_status').val('Pending');
					$('#tbl_myot').DataTable().destroy();
					loadallot('Pending');
				}
  			}
  		});
  }

  function loadallot(filter_status){
    $('#tbl_myot').DataTable({  
		createdRow: function (row, data, index) {
			if ($('td', row).eq(5)[0].innerText == 'Disapproved') {
				$('td', row).eq(5).addClass('reject')
				// console.log($('td', row).eq(5)[0].innerText)
			} else if($('td', row).eq(5)[0].innerText == 'Approved') {
				$('td', row).eq(5).addClass('acknowledged')
				// console.log($('td', row).eq(9)[0].innerText)
			}
		},
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
			  "scrollX": true,
              "ajax" : "controller/controller.otapp.php?loadallot&filter_status="+filter_status,
              "columns" : [
        
                    { "data" : "employeeno"},
                    { "data" : "ot_from"},
                    { "data" : "ot_to"},
                    { "data" : "no_of_hrs"},
                    { "data" : "ot_date"},
                    { "data" : "status"},
                    { "data" : "overtime_form"},
                    { "data" : "action"}


                ],
         });
  }
  var filter_status = $("#filter_status").val();
  loadallot(filter_status);

  function loadallot_list(filter_status_report,filter_from,filter_to){
    $('#tbl_otlist').DataTable({  
			createdRow: function (row, data, index) {
				if ($('td', row).eq(5)[0].innerText == 'Disapproved') {
					$('td', row).eq(5).addClass('reject')
					// console.log($('td', row).eq(5)[0].innerText)
				} else if($('td', row).eq(5)[0].innerText == 'Approved') {
					$('td', row).eq(5).addClass('acknowledged')
					// console.log($('td', row).eq(9)[0].innerText)
				}
			},
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
			  "scrollX": true,
              "ajax" : "controller/controller.otapp.php?loadallot2&filter_status="+filter_status_report+"&filter_from="+filter_from+"&filter_to="+filter_to,
              "columns" : [
        
                    { "data" : "employeeno"},
                    { "data" : "ot_from"},
                    { "data" : "ot_to"},
                    { "data" : "no_of_hrs"},
                    { "data" : "ot_date"},
                    { "data" : "status"}


                ],
         });
  }
  var filter_status_report = $("#filter_status_report").val();
  var filter_from = $('#filter_from').val();
  var filter_to = $('#filter_to').val();
  loadallot_list(filter_status_report,filter_from,filter_to);

  function filterotapp(){

    var filter_status_report = $("#filter_status_report").val();
    var filter_from = $('#filter_from').val();
    var filter_to = $('#filter_to').val();
    $('#tbl_otlist').DataTable().destroy();
    loadallot_list(filter_status_report,filter_from,filter_to);

  }

  function exportotapp(){
    var filter_status_report = $("#filter_status_report").val();
    var filter_from = $('#filter_from').val();
    var filter_to = $('#filter_to').val();

    window.location.href="tcpdf/examples/ot_app.php?filter_status="+filter_status_report+"&filter_from="+filter_from+"&filter_to="+filter_to
  }

  function goto(linkk){
	
	if(linkk=="notification.php"){
		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.otapp.php?readleave",
			method:"POST",
			data:{
				employeeno:employeeno
			},success:function(){
				window.location.href=linkk;
			}
		});
	}else if(linkk=="ess_payslip.php"){

		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.otapp.php?readpayslip",
			method:"POST",
			data:{
				employeeno:employeeno
			},success:function(){
				window.location.href=linkk;
			}
		});

	}else{
		window.location.href=linkk;
	}

  }

  function viewOvertimeForm(filename, employeeno){
    var link = "static/overtime_form/" + employeeno + '/' + filename;
    window.open(link);
  }


//   function count_leaveapp(){

//   	var employeenoo = $('#employeeno').val();
//   	$.ajax({
//   		url:"controller/controller.otapp.php?count_leaveapp",
//   		method:"POST",
//   		data:{
//   			employeenoo:employeenoo
//   		},success:function(data){
//   			var b = $.parseJSON(data);
  			
// 			if(b.count > 0){
// 				$('#leave_app_number').show();
// 				$('#leave_app_number').html(b.count);
// 			}else{
// 				$('#leave_app_number').hide();
// 			}

//   		}
//   	});
//   }
//   count_leaveapp();


//   function count_otapp(){

//   	var employeenoo = $('#employeeno').val();
//   	$.ajax({
//   		url:"controller/controller.otapp.php?count_otapp",
//   		method:"POST",
//   		data:{
//   			employeenoo:employeenoo
//   		},success:function(data){
//   			var b = $.parseJSON(data);
  			
// 			if(b.count > 0){
// 				$('#ot_app_number').show();
// 				$('#ot_app_number').html(b.count);
// 			}else{
// 				$('#ot_app_number').hide();
// 			}

//   		}
//   	});
//   }
//   count_otapp();

//   function count_payslip(){

//   	var employeenoo = $('#employeeno').val();
//   	$.ajax({
//   		url:"controller/controller.otapp.php?count_payslip",
//   		method:"POST",
//   		data:{
//   			employeenoo:employeenoo
//   		},success:function(data){
//   			var b = $.parseJSON(data);
  			
// 			if(b.count > 0){
// 				$('#payslip_number').show();
// 				$('#payslip_number').html(b.count);
// 			}else{
// 				$('#payslip_number').hide();
// 			}
//   		}
//   	});
//   }
//   count_payslip();

//   function count_reimbursement(){

//   	var employeenoo = $('#employeeno').val();
//   	$.ajax({
//   		url:"controller/controller.otapp.php?count_reimbursement",
//   		method:"POST",
//   		data:{
//   			employeenoo:employeenoo
//   		},success:function(data){
//   			var b = $.parseJSON(data);
// 			if(b.count > 0){
// 				$('#reim_app_number').show();
// 				$('#reim_app_number').html(b.count);
// 			}else{
// 				$('#reim_app_number').hide();
// 			}

//   		}
//   	});
//   }
//   count_reimbursement();
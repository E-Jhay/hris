var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		$("#ess_omnibus_report").addClass("active_tab");
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
		$('#employeeddown').load('controller/controller.reimburse_report.php?employeelistadmin&employeenoo='+employeenoo);
		$("#lemployee").addClass("active");
		$("#lapply").addClass("active");

		$('#filter_reimbursement').on('change',function(){
			var statuss = $('#filter_reimbursement').val();
			$('#tbl_reimburse_all').DataTable().destroy();
			load_reimburse_all(statuss);
		});

		var balance = $('#balance').val();
		if(balance <=0){
			$.Toast("Insufficient balance", errorToast);
		}


		$('#employeeddown').on('change',function(){
			var employeeddown = $('#employeeddown').val();
			$.ajax({
				url:"controller/controller.reimburse_report.php?check_reim_bal",
				method:"POST",
				data:{
					employeeno: employeeddown
				},success:function(data){
					var b = $.parseJSON(data);
					$('#rem_bal2').html(b.balance);
					$('#reimbursement_bal_apply').val(b.balance);
				}
			});
		});

	});

function export_emp_reim(){
	window.location.href="tcpdf/examples/reimbursement.php";
}
	
 function btnemployee(){
 	$('#div_employee').show();
	$('#div_apply_employee').hide();
	$('#div_reports').hide();
	$('#lemployee').addClass("active");
	$('#l_apply_employee').removeClass("active");
	$('#l_reports').removeClass("active");
 }

 function btnapplyemployee(){
 	$('#div_employee').hide();
	$('#div_apply_employee').show();
	$('#div_reports').hide();
	$('#lemployee').removeClass("active");
	$('#l_apply_employee').addClass("active");
	$('#l_reports').removeClass("active");
 }

function btnreports(){
	$('#div_employee').hide();
	$('#div_apply_employee').hide();
	$('#div_reports').show();
	$('#lemployee').removeClass("active");
	$('#l_apply_employee').removeClass("active");
	$('#l_reports').addClass("active");
}

	function reset_credit(){
		confirmed("delete",reset_credit_callback, "Do you really want to reset all the credits?", "Yes", "No");
	}

	function reset_credit_callback(){
		$.ajax({
		  	url:"controller/controller.reimburse_report.php?reset_credit",
		  	method:"POST",
		  	data:{
		  		id:""
		  	},success:function(){
		  		$.Toast("Successfully Resetted", errorToast);
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

	function approved(){
		confirmed("save",approved_callback, "Do you really want to approve this?", "Yes", "No");
	}

	function approved_callback(){
		var rem_id = $('#rem_id').val();
		var amount_modal = $('#amount_modal').val();
		var remarks = $('#remarks').val();
		var statuss = "Approved";
		var employeeno = $('#employeeno_modal').val();
		var credits_modal = $('#credits_modal').val();
		$.ajax({
			url:"controller/controller.reimburse_report.php?approve_reimbursement",
			method:"POST",
			data:{
				rem_id: rem_id,
				amount_modal: amount_modal,
				remarks: remarks,
				statuss: statuss,
				employeeno: employeeno,
				credits_modal: credits_modal
			},success:function(){
				$.Toast("Successfully Approved", successToast);
				$('#reimbursement_modal').modal('hide');
				$('#tbl_reimburse_all').DataTable().destroy();
				load_reimburse_all("Pending");
				count_reimbursement();
				$('#filter_reimbursement').val("Pending");
			}
		});
	}

	function disapproved(){
		confirmed("delete",disapproved_callback, "Do you really want to disapprove this?", "Yes", "No");
	}
	function disapproved_callback(){
		var rem_id = $('#rem_id').val();
		var amount_modal = $('#amount_modal').val();
		var remarks = $('#remarks').val();
		var statuss = "Disapproved";
		var employeeno = $('#employeeno_modal').val();
		var credits_modal = $('#credits_modal').val();
		$.ajax({
			url:"controller/controller.reimburse_report.php?approve_reimbursement",
			method:"POST",
			data:{
				rem_id: rem_id,
				amount_modal: amount_modal,
				remarks: remarks,
				statuss: statuss,
				employeeno: employeeno,
				credits_modal: credits_modal
			},success:function(){
				$.Toast("Successfully Disapproved", errorToast);
				$('#reimbursement_modal').modal('hide');
				$('#tbl_reimburse_all').DataTable().destroy();
				load_reimburse_all("Pending");
				count_reimbursement();
				$('#filter_reimbursement').val("Pending");
			}
		});
	}

	function undo(){
		confirmed("delete",undo_callback, "Do you really want to cancel this?", "Yes", "No");
	}

	function undo_callback(){
		var rem_id = $('#rem_id').val();
		var amount_modal = $('#orig_amount_modal').val();
		var remarks = "";
		var statuss = "Pending";
		var employeeno = $('#employeeno_modal').val();
		var credits_modal = $('#credits_modal').val();
		$.ajax({
			url:"controller/controller.reimburse_report.php?approve_reimbursement",
			method:"POST",
			data:{
				rem_id: rem_id,
				amount_modal: amount_modal,
				remarks: remarks,
				statuss: statuss,
				employeeno: employeeno,
				credits_modal: credits_modal
			},success:function(){
				$.Toast("Successfully Cancelled", errorToast);
				$('#reimbursement_modal').modal('hide');
				$('#tbl_reimburse_all').DataTable().destroy();
				load_reimburse_all("Pending");
				count_reimbursement();
				$('#filter_reimbursement').val("Pending");
			}
		});
	}

	function dl_file(file_name,employeeno){
		window.open("reimbursement/"+employeeno+"/"+file_name);
	}

	function view_file(id,employeeno,description,nature,datee,amount,file_name,remarks,orig_amount,statuss,lastname,firstname,reimbursement_bal){
		$('#reimbursement_modal').modal('show');
		$('#rem_id').val(id);
		$('#employeeno_modal').val(employeeno);
		$('#description_modal').val(description);
		$('#nature_modal').val(nature);
		$('#datee_modal').val(datee);
		$('#amount_modal').val(amount);
		$('#orig_amount_modal').val(orig_amount);
		$('#remarks').val(remarks);
		$('#employeename_modal').val(firstname+" "+lastname);
		$('#credits_modal').val(reimbursement_bal);
		if(statuss=="Approved" || statuss=="Disapproved"){
			$('#undo_btn').show();
			$('#approved_btn').hide();
			$('#disapproved_btn').hide();
			$('#amount_modal').prop("disabled",true);
			$('#remarks').prop("disabled",true);
		}else{
			$('#undo_btn').hide();
			$('#approved_btn').show();
			$('#disapproved_btn').show();
			$('#amount_modal').prop("disabled",false);
			$('#remarks').prop("disabled",false);
		}
	}

	function myFunction(item, index) {
	  alert(item);
	}

  function goto(linkk){
	
	if(linkk=="notification.php"){

		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.reimburse_report.php?readleave",
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
			url:"controller/controller.reimburse_report.php?readpayslip",
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

  function load_reimburse_all(statuss){
  	var type = "all";
	var employeeno = $('#employeeno').val();
  	$('#tbl_reimburse_all').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.reimburse_report.php?load_myreimburse&type="+type+"&employeeno="+employeeno+"&statuss="+statuss,
              "columns" : [
                    
                    { "data" : "employee_name"},
                    { "data" : "description"},
                    { "data" : "nature"},
                    { "data" : "amount"},
                    { "data" : "datee"},
                    { "data" : "statuss"},
                    { "data" : "action"}

                ],
         });

  }
  var statuss = $('#filter_reimbursement').val();
  load_reimburse_all(statuss);

  function count_leaveapp(){

  	var employeenoo = $('#employeeno').val();
  	$.ajax({
  		url:"controller/controller.reimburse_report.php?count_leaveapp",
  		method:"POST",
  		data:{
  			employeenoo:employeenoo
  		},success:function(data){
  			var b = $.parseJSON(data);
  			
			if(b.count > 0){
				$('#leave_app_number').show();
				$('#leave_app_number').html(b.count);
			}else{
				$('#leave_app_number').hide();
			}

  		}
  	});
  }
  count_leaveapp();

  function count_otapp(){

  	var employeenoo = $('#employeeno').val();
  	$.ajax({
  		url:"controller/controller.reimburse_report.php?count_otapp",
  		method:"POST",
  		data:{
  			employeenoo:employeenoo
  		},success:function(data){
  			var b = $.parseJSON(data);
  			
			if(b.count > 0){
				$('#ot_app_number').show();
				$('#ot_app_number').html(b.count);
			}else{
				$('#ot_app_number').hide();
			}

  		}
  	});
  }
  count_otapp();


  function count_reimbursement(){

  	var employeenoo = $('#employeeno').val();
  	$.ajax({
  		url:"controller/controller.reimburse_report.php?count_reimbursement",
  		method:"POST",
  		data:{
  			employeenoo:employeenoo
  		},success:function(data){
  			var b = $.parseJSON(data);
			if(b.count > 0){
				$('#reim_app_number').show();
				$('#reim_app_number').html(b.count);
			}else{
				$('#reim_app_number').hide();
			}

  		}
  	});
  }
  count_reimbursement();


  function count_payslip(){

  	var employeenoo = $('#employeeno').val();
  	$.ajax({
  		url:"controller/controller.reimburse_report.php?count_payslip",
  		method:"POST",
  		data:{
  			employeenoo:employeenoo
  		},success:function(data){
  			var b = $.parseJSON(data);
  			
			if(b.count > 0){
				$('#payslip_number').show();
				$('#payslip_number').html(b.count);
			}else{
				$('#payslip_number').hide();
			}

  		}
  	});
  }
  count_payslip();
var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

		$("#ess_leaveapp").addClass("active_tab");
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
		$('#employeeddown').load('controller/controller.leave.php?employeelistadmin&employeenoo='+employeenoo);
		$('#leave_type').load('controller/controller.leave.php?leave_typelist');

		$('#timeto').on('change',function(){
			var halfdate = $('#halfdate').val();
			var timefrom = $('#timefrom').val();
			var timeto = $('#timeto').val();
			var date1 = new Date(halfdate+' '+timefrom);
			var date2 = new Date(halfdate+' '+timeto);
			
			var diff = Math.abs(date1-date2);

		   var seconds = Math.floor(diff / 1000);
		   var minute = Math.floor(seconds / 60);
		   var seconds = seconds % 60;
		   var hour = Math.floor(minute / 60);
		   var minute = minute % 60;
		   var day = Math.floor(hour / 24);
		   var hour = hour % 24;
		   
		   if(hour >= 5){
		   	hour = hour - 1;
		   }
		   var points_todeduct = 0.125;


			$('#no_days').val(hour * points_todeduct);
		});


		$('#leave_type').on('change',function(){
			var leave_type = $('#leave_type').val();
			var employeeno = $('#employeeno').val();
			var application_type = $('#application_type').val();
			$.ajax({
				url:"controller/controller.leave.php?get_leavebal",
				method:"POST",
				data:{
					leave_type: leave_type,
					employeeno: employeeno
				},success:function(data){
					var b = $.parseJSON(data);
					if(b.bal=="wala"){
						$.Toast("This leave is not available", errorToast);
						$('#leave_type').val("");
						$('#leave_bal').val("");
						$('#points_todeduct').val("");
						$('#no_days').val("");
					}else{
						if(b.bal <= 0){
							$('#pay_leave').val("Without Pay");
						}else{
							$('#pay_leave').val("With Pay");
						}
						$('#leave_bal').val(b.bal);
						$('#points_todeduct').val(b.points);
						if(application_type=="Half Day"){
						}
					}
					
				}
			});
		});

		$('#amchoice').on('change',function(){
			var amchoice = $('#amchoice').val();
			$('#no_days').val(amchoice);
		});

		$('#pmchoice').on('change',function(){
			var pmchoice = $('#pmchoice').val();
			if(pmchoice=="sixpm"){
				$('#no_days').val("0.63");
			}else if(pmchoice=="twopm"){
				$('#no_days').val("0.5");
			}else if(pmchoice=="fivepm"){
				$('#no_days').val("0.5");
			}
			
		});


		$('#employeeddown').on('change',function(){
			var employeeno = $('#employeeddown').val();
			$.ajax({
				url:"controller/controller.leave.php?searchleavebalance",
				method:"POST",
				data:{
					employeeno:employeeno
				},success:function(data){
					var b = $.parseJSON(data);
					$('#assignremaininglb').val(b.leave_balance);

					  $("#bal_pertype_parent").empty();

					 

						$.ajax({
							url:"controller/controller.leave.php?fetch_leave",
							method:"POST",
							data:{
								employeeno: employeeno
							},success:function(datass){
								
							}
						});

				}
			});

		});

		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.leave.php?searchleavebalance",
			method:"POST",
			data:{
				employeeno:employeeno
			},success:function(data){
				var b = $.parseJSON(data);
				$('#leave_value').html(b.leave_balance);
			}
		});

		$('#datefrom').on('change',function(){
			var datefrom = $('#datefrom').val();
			
		});

		$('#dateto').on('change',function(){
			var dateto = $('#dateto').val();
			var datefrom = $('#datefrom').val();
			const date1 = new Date(dateto);
			const date2 = new Date(datefrom);
			const diffTime = Math.abs(date2 - date1);
			const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
			var points_todeduct = $('#points_todeduct').val();
			if(datefrom > dateto){
				$.Toast("Invalid date range", errorToast);
				$('#dateto').val("0000-00-00");
				$('#no_days').val("");
			}else{
				var dayss = diffDays+1;
				var deduct = dayss * points_todeduct;
				$('#no_days').val(deduct);
			}
			
		});


		$('#application_type').on('change',function(){
			var application_type = $('#application_type').val();
			$('#leave_type').val("");
			$('#leave_bal').val("");
			$('#no_days').val("");
			$('#comment').val("");
			$('#halfdate').val("");
			$('#datefrom').val("");
			$('#dateto').val("");
			$('#timefrom').val("15:00");
			$('#timeto').val("15:00");
			$('#amchoice').val("");
			$('#pmchoice').val("");
			if(application_type=="Whole Day"){
				$('#datefrom_column').show();
				$('#dateto_column').show();
				$('#date_column').hide();
				$('#timefrom_column').hide();
				$('#timeto_column').hide();
				$('#ampm_column').hide();
			}else if(application_type=="Half Day"){
				$('#datefrom_column').hide();
				$('#dateto_column').hide();
				$('#date_column').show();
				$('#timefrom_column').hide();
				$('#timeto_column').hide();
				$('#ampm_column').show();
			}else if(application_type=="Under Time"){
				$('#datefrom_column').hide();
				$('#dateto_column').hide();
				$('#date_column').show();
				$('#timefrom_column').show();
				$('#timeto_column').show();
				$('#ampm_column').hide();
			}
		});

		var status_module =  window.localStorage.getItem("status");
		
		if(status_module == "success"){
			$.Toast("Successfully Sent", successToast);
			localStorage.clear();
		}

		// leaveForm();
		// uploadLeaveForm();

		
	});


	function myFunction(item, index) {
	  alert(item);
	}


	function exportleaveapp(){
		var filter_type = $('#filter_type').val();
		var filter_from = $('#filter_from').val();
		var filter_to = $('#filter_to').val();

		window.location.href="tcpdf/examples/leave_app.php?filter_type="+filter_type+"&filter_from="+filter_from+"&filter_to="+filter_to
	}

	function compute_rate(){
		var fivepm = $('#fivepm').val();
		var sixpm = $('#sixpm').val();
		var emp_days = $('#emp_days').val();
		var sum = parseInt(fivepm) + parseInt(sixpm);

		if(sum > emp_days){
			alert("Too much no. of days");
			$('#fivepm').val("");
			$('#sixpm').val("");
			$('#fivepm').focus();
		}else if(sum < emp_days){
			alert("Insufficient no. of days");
			$('#fivepm').focus();
			$('#fivepm').val("");
			$('#sixpm').val("");
		}else{
			var first_n = parseInt(fivepm) * 1;
			var second_n = parseFloat(sixpm) * 1.13;
			var sumoftwo = parseInt(first_n) + parseFloat(second_n);
			// $('#emp_nodays').html(sumoftwo);

			var emp_days = $('#emp_days').val();
			var emp_rate = $('#emp_rate').val();
			var emp_id = $('#emp_id').val();
			var new_deduct = sumoftwo;
			$.ajax({
				url:"controller/controller.leave.php?update_deductleave",
				method:"POST",
				data:{
					emp_id: emp_id,
					new_deduct: new_deduct,
					emp_rate: emp_rate,
					fivepm: fivepm,
					sixpm: sixpm
				},success:function(){
					$('#emp_nodays').html(new_deduct);


					$('#tbl_myleave').DataTable().destroy();
					var employeeno = $('#employeeno').val();
	  				loadmyleave(employeeno);
					$('#tbl_leavelist').DataTable().destroy();
					loadleavelist();

				}
			});
		}
	}

	
	function upt(){
		var emp_days = $('#emp_days').val();
		var emp_rate = $('#emp_rate').val();
		var emp_id = $('#emp_id').val();
		var new_deduct = emp_days * emp_rate;
		$.ajax({
			url:"controller/controller.leave.php?update_deductleave",
			method:"POST",
			data:{
				emp_id: emp_id,
				new_deduct: new_deduct,
				emp_rate: emp_rate
			},success:function(){
				$('#emp_nodays').html(new_deduct);


				$('#tbl_myleave').DataTable().destroy();
				var employeeno = $('#employeeno').val();
  				loadmyleave(employeeno);
				$('#tbl_leavelist').DataTable().destroy();
				loadleavelist();

			}
		});
	}


	function ampm(){
		var leaveampm = $("input[name='leaveampm']:checked").val();
		if(leaveampm=="AM"){
			$('#amchoice').val("");
			$('#amchoice').show();
			$('#pmchoice').hide();
			$('#no_days').val("");
		}else if(leaveampm=="PM"){
			$('#amchoice').hide();
			$('#pmchoice').show();
			$('#pmchoice').val("");
			$('#no_days').val("");
		}else{
			alert("E");
		}
	}


	function cancelapprove(){
		var emp_id = $('#emp_id').val();
		var remarks = $('#remarks').val();
		var status = "Cancelled";	
		var emp_number = $('#emp_number').html();
		var emp_leavetype = $('#emp_leavetype').html();
		var emp_nodays = $('#emp_nodays').html();
		$.ajax({
			url:"controller/controller.leave.php?approveleave",
			method:"POST",
			data:{
				emp_id:emp_id,
				status:status,
				remarks:remarks,
				emp_number:emp_number,
				emp_leavetype:emp_leavetype,
				emp_nodays:emp_nodays
			},success:function(){
				alert(status);
				window.location.href="leave.php";
			}
		});
	}

	function approve(){
		var emp_id = $('#emp_id').val();
		var remarks = $('#remarks').val();
		var status = "Approved";	
		var emp_number = $('#emp_number').html();
		var emp_leavetype = $('#emp_leavetype').html();
		var emp_nodays = $('#emp_nodays').html();
		$.ajax({
			url:"controller/controller.leave.php?approveleave",
			method:"POST",
			data:{
				emp_id:emp_id,
				status:status,
				remarks:remarks,
				emp_number:emp_number,
				emp_leavetype:emp_leavetype,
				emp_nodays:emp_nodays
			},success:function(){
				alert(status);
				window.location.href="leave.php";
			}
		});
	}

  	function disapproved(){
  		var emp_id = $('#emp_id').val();
  		var remarks = $('#remarks').val();
  		var status = "Disapproved";
  		var emp_number = $('#emp_number').html();
  		var emp_leavetype = $('#emp_leavetype').html();
		var emp_nodays = $('#emp_nodays').html();
  		$.ajax({
			url:"controller/controller.leave.php?approveleave",
			method:"POST",
			data:{
				emp_id:emp_id,
				status:status,
				remarks:remarks,
				emp_number:emp_number,
				emp_leavetype:emp_leavetype,
				emp_nodays:emp_nodays
			},success:function(){
				alert(status);
				window.location.href="leave.php";
			}
		});
  	}

	function submitleave(){
		confirmed("save",submitleave_callback, "Do you really want to submit this?", "Yes", "No");
	}




	///////////////////////////////////////////////////////////////////

	function submitleave_callback(){

		var application_type = $('#application_type').val();
		// var leave_value = $('#leave_value').html();
		var leave_bal = $('#leave_bal').val();
		var leave_type = $('#leave_type').val();
		var datefrom = $('#datefrom').val();
		var dateto = $('#dateto').val();
		var comment = $('#comment').val();
		var stat = "Pending";
		var employeeno = $('#employeeno').val();
		var date_applied = $('#datenow').val();
		var no_days = $('#no_days').val();
		var timefrom = $('#timefrom').val();
		var timeto = $('#timeto').val();
		var points_todeduct = $('#points_todeduct').val();
		var halfdate = $('#halfdate').val();
		var pay_leave = $('#pay_leave').val();

		const date1 = new Date(dateto);
		const date2 = new Date(datefrom);
		const diffTime = Math.abs(date2 - date1);
		const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
		var dayss = diffDays+1;

		if(leave_bal=="" || leave_bal==null){
			$.Toast("No available leave credits", errorToast);
		}
		else if(no_days=="" || no_days==null){
			$.Toast("Invalid transaction", errorToast);
		}else if(comment=="" || comment==null){
			$.Toast("Please input the reason of your leave.", errorToast);
		}else{

			// var updatedbalance = leave_bal - no_days;

			if(application_type=="Under Time"){
				datefrom = timefrom;
				dateto = timeto;
				points_todeduct = no_days;
				dayss = 0

				if(datefrom >= dateto) {
					$.Toast("Invalid time", errorToast);
				}
			}
			if(application_type=="Half Day"){

				var leaveampm = $("input[name='leaveampm']:checked").val();
				dayss = 0
				if(leaveampm=="AM"){
					// datefrom = "AM";
					var amchoice = $('#amchoice').val();
					if(amchoice=="0.5"){
						dateto = "8:00 AM - 12:00 PM";
						points_todeduct = no_days;
					}else{
						dateto = "8:00 AM - 2:00 PM";
						points_todeduct = no_days;
					}
				}
				else{
					// datefrom = "PM";
					var pmchoice = $('#pmchoice').val();
					if(pmchoice=="sixpm"){
						dateto = "12:00 PM - 6:00 PM";
						points_todeduct = no_days;
					}else if(pmchoice=="twopm"){
						dateto = "2:00 PM - 6:00 PM";
						points_todeduct = no_days;
					}else if(pmchoice=="fivepm"){
						dateto = "12:00 PM - 5:00 PM";
						points_todeduct = no_days;
					}
				}
				
			}

			// var updatedbalance = leave_value - no_days;
			var form_data = new FormData();
			var leaveForm = $("#leaveForm").prop("files")[0];
			form_data.append("leaveForm", leaveForm)
			form_data.append("leave_type", leave_type)
			form_data.append("datefrom", datefrom)
			form_data.append("dateto", dateto)
			form_data.append("comment", comment)
			form_data.append("stat", stat)
			form_data.append("employeeno", employeeno)
			form_data.append("date_applied", date_applied)
			form_data.append("no_days", no_days)
			// form_data.append("updatedbalance", updatedbalance)
			form_data.append("application_type", application_type)
			form_data.append("points_todeduct", points_todeduct)
			form_data.append("dayss", dayss)
			form_data.append("date_from", halfdate)
			form_data.append("leave_bal", leave_bal)
			form_data.append("pay_leave", pay_leave)
			$.ajax({
				url:"controller/controller.leave.php?addleave",
				method:"POST",
				data: form_data,
				processData: false,
				contentType: false,
				success:function(){
					$.Toast("Successfully Saved", successToast);
					setTimeout(() => {	
						window.location.href="leave.php";
					}, 1000)
					// window.location.href="leave.php";
				}
			});
		}

	}

	// function leaveUploadBtn() {
	// 	$('#uploadform').modal('show');
	// }

	// function leaveForm() {
	// 	$('.image-area').on('click', function() {
	// 		var dataTarget = $(this).data('target');
	// 		$('#'+dataTarget).trigger('click');
	// 	});
	// }

	// function uploadLeaveForm() {
	// 	$('#leaveUploadForm').on('submit', function(e){
	// 		e.preventDefault();
	// 		var formData = new FormData(this);

	// 		$.ajax({
	// 			type: "POST",
	// 			url: 'controller/controller.leave.php?uploadLeaveForm',
	// 			data: formData,
	// 			cache: false,
	// 			contentType: false,
	// 			processData: false,
	// 			success:function(data){
	// 				alert(data);
	// 			}
	// 		});
	// 	});
	// }

	// function findImage(name) {
	// 	$.ajax({
	// 		url:'http://localhost/hris/static/leave_form/'+name,
	// 		type:'HEAD',
	// 		error: function()
	// 		{
	// 			$('#prev').attr("src","static/default-placeholder.png");
	// 			//file does not exist
	// 		},
	// 		success: function()
	// 		{
	// 			$('#prev').attr("src","http://localhost/hris/static/leave_form/"+name);
	// 			//file exists do something here
	// 		}
	// 	});
	// }

	// function previewImage(){
	// 	prev.src=URL.createObjectURL(event.target.files[0]);
	// 	return
	// }

	///////////////////////////////////////////////////////////////////



	function btnapply(){
		$("#lapply").addClass("active");
		$("#lmyapply").removeClass("active");
		$("#lleave").removeClass("active");
		$("#lassign").removeClass("active");
		$("#lreports").removeClass("active");

		$("#div_apply").show();
		$("#div_myleave").hide();
		$("#div_leavelist").hide();
		$("#div_assignleave").hide();
		$("#div_reports").hide();
	}
	function btnmyleave(){
		$("#lapply").removeClass("active");
		$("#lmyapply").addClass("active");
		$("#lleave").removeClass("active");
		$("#lassign").removeClass("active");
		$("#lreports").removeClass("active");

		$("#div_apply").hide();
		$("#div_myleave").show();
		$("#div_leavelist").hide();
		$("#div_assignleave").hide();
		$("#div_reports").hide();
	}
	

	function goto(linkk){
		
		if(linkk=="notification.php"){

			var employeeno = $('#employeeno').val();
			$.ajax({
				url:"controller/controller.leave.php?readleave",
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
				url:"controller/controller.leave.php?readpayslip",
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

	function delete_leave(id){
		confirmed("delete",delete_leave_callback, "Do you really want to delete this?", "Yes", "No", id);	
	}

	function delete_leave_callback(id){
		$.ajax({
			url:"controller/controller.leave.php?delete_myleave",
			method:"POST",
			data:{
				id:id
			},success:function(){
				$.Toast("Successfully Deleted", successToast);
				$('#tbl_myleave').DataTable().destroy();
				var employeeno = $('#employeeno').val();
				loadmyleave(employeeno);
			}
		});
	}

  	function edit_leave(id,fname,employeeno,leave_type,date_applied,leave_balance,datefrom,dateto,no_days,status,comment,remarks,application_type,deduct_rate,fivepm,sixpm,balanse){

		const date1 = new Date(dateto);
		const date2 = new Date(datefrom);
		const diffTime = Math.abs(date2 - date1);
		const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
		var dayss = diffDays+1;
		$('#emp_days').val(dayss);

		$('#fivepm').val(fivepm);
		$('#sixpm').val(sixpm);

		$('#emp_leavebalancetype').html(balanse);
		$('#emp_id').val(id);
		$('#emp_number').html(employeeno);
		$('#emp_fname').html(fname);
		$('#emp_leavetype').html(leave_type);
		$('#emp_dateapplied').html(date_applied);
		$('#emp_leavebalance').html(leave_balance);
		$('#emp_datefrom').html(datefrom);
		$('#emp_dateto').html(dateto);

		$('#emp_ampm').html(datefrom);
		$('#emp_time').html(dateto);

		$('#emp_nodays').html(no_days);
		$('#emp_status').html(status);
		$('#emp_comment').html(comment);
		$('#remarks').val(remarks);
		$('#emp_application_type').html(application_type);
		$('#emp_rate').val(deduct_rate);

		if(status=="Disapproved"){
			$('#btnapprove').hide();
			$('#btndisapprove').hide();
			$('#btncancelapprove').show();
		}else if(status=="Approved"){
			$('#btnapprove').hide();
			$('#btndisapprove').hide();
			$('#btncancelapprove').show();
		}else{
			$('#btnapprove').show();
			$('#btndisapprove').show();
			$('#btncancelapprove').hide();
		}

		if(application_type=="Half Day"){
			$('#no_days_column').hide();
			$('#rate_column').hide();
			$('#dfrom_column').hide();
			$('#dto_column').hide();
			$('#ap_column').show();
			$('#time_column').show();
			$('#fivepm_column').hide();
			$('#sixpm_column').hide();
		}else if(application_type=="Whole Day"){
			$('#no_days_column').show();
			$('#rate_column').hide();
			$('#dfrom_column').show();
			$('#dto_column').show();
			$('#ap_column').hide();
			$('#time_column').hide();
			$('#fivepm_column').show();
			$('#sixpm_column').show();
		}else{
			$('#no_days_column').hide();
			$('#rate_column').hide();
			$('#dfrom_column').show();
			$('#dto_column').show();
			$('#ap_column').hide();
			$('#time_column').hide();
			$('#fivepm_column').hide();
			$('#sixpm_column').hide();
		}

		$('#leavemodal').modal('show');
	}

	function loadmyleave(employeeno){
							
		$('#tbl_myleave').DataTable({  
			"aaSorting": [],
			"bSearching": true,
			"bFilter": true,
			"bInfo": true,
			"bPaginate": true,
			"bLengthChange": true,
			"pagination": true,
			"ajax" : "controller/controller.leave.php?loadmyleave&employeeno="+employeeno,
			"columns" : [
					
				{ "data" : "employeeno"},
				{ "data" : "date"},
				{ "data" : "leavetype"},
				{ "data" : "leavebalance"},
				{ "data" : "numberofdays"},
				{ "data" : "active_status"},
				{ "data" : "action"}

			],
		});
	}
	var employeeno = $('#employeeno').val();
	loadmyleave(employeeno);


	function loadleavelist(){
		
		var employeenoo = $('#employeeno').val();
		$('#tbl_leavelist').DataTable({  
			"aaSorting": [],
			"bSearching": true,
			"bFilter": true,
			"bInfo": true,
			"bPaginate": true,
			"bLengthChange": true,
			"pagination": true,
			"ajax" : "controller/controller.leave.php?loadleavelist&employeenoo="+employeenoo,
			"columns" : [
				
				{ "data" : "employeeno"},
				{ "data" : "date"},
				{ "data" : "leavetype"},
				{ "data" : "leavebalance"},
				{ "data" : "numberofdays"},
				{ "data" : "active_status"},
				{ "data" : "action"}

			],
		});
	}
	loadleavelist();


	function count_leaveapp(){

		var employeenoo = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.leave.php?count_leaveapp",
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
			url:"controller/controller.leave.php?count_otapp",
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


	function count_payslip(){

		var employeenoo = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.leave.php?count_payslip",
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

	function count_reimbursement(){

		var employeenoo = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.leave.php?count_reimbursement",
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

	
	function lb(){

		$.ajax({
		 url:"controller/controller.leavebalance.php?leave_credits_load",
		 method:"POST",
		 data:{
		   id:""
		 },success:function(){
 
		 }
	   });
		
   }
   lb();
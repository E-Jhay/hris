var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		$("#ess_leavereports").addClass("active_tab");
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
		$('#employeeddown').load('controller/controller.leave_app.php?employeelistadmin&employeenoo='+employeenoo);
		$('#assignlt').load('controller/controller.leave_app.php?leave_typelist');

		$('#assign_date_column').hide()
		$('#assign_ampm_column').hide()
		$('#assign_timefrom_column').hide()
		$('#assign_timeto_column').hide()
		$('#assign_datefrom_column').hide()
		$('#assign_dateto_column').hide()

		$('#assignlt').on('change',function(){
			var leave_type = $('#assignlt').val();
			var employeeno = $('#employeeddown').val();
			// var application_type = $('#application_type').val();
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
						$('#assignlt').val("");
						$('#assignleavebal').val("");
						$('#assign_points_todeduct').val("");
						$('#assigno_days').val("");
					}else{
						// if(b.bal <= 0){
						// 	$('#pay_leave').val("Without Pay");
						// 	$('#withPay').prop('disabled', true);
						// }else{
						// 	$('#pay_leave').val("With Pay");
						// }
						$('#assignleavebal').val(b.bal);
						// if(application_type=="Half Day"){
						// }
					}
					
				}
			});
		});	

		///////////////////////////////

		// $('#assign_timeto').on('change',function(){
		// 	var halfdate = $('#assign_halfdate').val();
		// 	var timefrom = $('#assign_timefrom').val();
		// 	var timeto = $('#assign_timeto').val();
		// 	var date1 = new Date(halfdate+' '+timefrom);
		// 	var date2 = new Date(halfdate+' '+timeto);
			
		// 	var diff = Math.abs(date1-date2);

		// 	var seconds = Math.floor(diff / 1000);
		// 	var minute = Math.floor(seconds / 60);
		// 	var seconds = seconds % 60;
		// 	var hour = Math.floor(minute / 60);
		// 	var minute = minute % 60;
		// 	var day = Math.floor(hour / 24);
		// 	var hour = hour % 24;
			
		// 	if(hour >= 5){
		// 		hour = hour - 1;
		// 	}
		//    	var points_todeduct = 0.125;

		// 	$('#assigno_days').val(hour * points_todeduct);
		// });

		// $('#assignlt').on('change',function(){
		// 	var leave_type = $('#assignlt').val();
		// 	var employeeno = $('#employeeddown').val();
		// 	var assign_application_type = $('#assign_application_type').val();
		// 	$.ajax({
		// 		url:"controller/controller.leave_app.php?get_leavebal",
		// 		method:"POST",
		// 		data:{
		// 			leave_type: leave_type,
		// 			employeeno: employeeno
		// 		},success:function(data){
		// 			var b = $.parseJSON(data);
		// 			if(b.bal=="wala"){
		// 				$.Toast("Insufficient leave credits", errorToast);
		// 				$('#assignlt').val("");
		// 				$('#assignleavebal').val("");
		// 				$('#assign_points_todeduct').val("");
		// 				$('#assigno_days').val("");
		// 			}else{

		// 				if(b.bal <= 0){
		// 					$('#pay_leave').val("Without Pay");
		// 				}else{
		// 					$('#pay_leave').val("With Pay");
		// 				}
						
		// 				$('#assignleavebal').val(b.bal);

		// 				$('#assign_points_todeduct').val(b.points);
		// 				if(assign_application_type=="Half Day"){
		// 				}
		// 			}
					
		// 		}
		// 	});


		// });
		
		// $('#assign_amchoice').on('change',function(){
		// 	var amchoice = $('#assign_amchoice').val();
		// 	$('#assigno_days').val(amchoice);
		// });

		// $('#assign_pmchoice').on('change',function(){
		// 	var pmchoice = $('#assign_pmchoice').val();
		// 	var pmchoice = $('#assign_pmchoice').val();
		// 	if(pmchoice=="sixpm"){
		// 		$('#assigno_days').val("0.63");
		// 	}else if(pmchoice=="twopm"){
		// 		$('#assigno_days').val("0.5");
		// 	}else if(pmchoice=="fivepm"){
		// 		$('#assigno_days').val("0.5");
		// 	}

		// });

		// $('#employeeddown').on('change',function(){
		// 	var employeeno = $('#employeeddown').val();
		// 	$.ajax({
		// 		url:"controller/controller.leave_app.php?searchleavebalance",
		// 		method:"POST",
		// 		data:{
		// 			employeeno:employeeno
		// 		},success:function(data){
		// 			var b = $.parseJSON(data);
		// 			$('#assignremaininglb').val(b.leave_balance);

		// 			$("#bal_pertype_parent").empty();

		// 			$.ajax({
		// 				url:"controller/controller.leave_app.php?fetch_leave",
		// 				method:"POST",
		// 				data:{
		// 					employeeno: employeeno
		// 				},success:function(datass){

		// 				}
		// 			});

		// 		}
		// 	});

		// });

		// var employeeno = $('#employeeno').val();
		// $.ajax({
		// 	url:"controller/controller.leave_app.php?searchleavebalance",
		// 	method:"POST",
		// 	data:{
		// 		employeeno:employeeno
		// 	},success:function(data){
		// 		var b = $.parseJSON(data);
		// 		$('#leave_value').html(b.leave_balance);
		// 	}
		// });

		// $('#asssigntodate').on('change',function(){
		// 	var asssigntodate = $('#asssigntodate').val();
		// 	var asssignfromdate = $('#asssignfromdate').val();
		// 	const date1 = new Date(asssigntodate);
		// 	const date2 = new Date(asssignfromdate);
		// 	const diffTime = Math.abs(date2 - date1);
		// 	const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
		// 	var assign_points_todeduct = $('#assign_points_todeduct').val();
		// 	if(asssignfromdate > asssigntodate){
		// 		alert("Invalid date range");
		// 		$('#asssigntodate').val("0000-00-00");
		// 		$('#assigno_days').val("");
		// 	}else{

		// 		var dayss = diffDays+1;
		// 		var deduct = dayss * assign_points_todeduct;
		// 		$('#assigno_days').val(deduct);
		// 	}
		// });

		function getBusinessDatesCount(startDate, endDate) {
			let count = 0;
			const curDate = new Date(startDate.getTime());
			while (curDate <= endDate) {
				const dayOfWeek = curDate.getDay();
				if(dayOfWeek !== 0 && dayOfWeek !== 6) count++;
				curDate.setDate(curDate.getDate() + 1);
			}
			return count;
		}

		$('#assign_application_type').on('change',function(){
			var application_type = $('#assign_application_type').val();

			$('#assignlt').val("");
			$('#assignleavebal').val("");
			$('#assign_halfdate').val("");
			$('#asssignfromdate').val("");
			$('#asssigntodate').val("");
			$('#assigno_days').val("");
			$('#assigncomment').val("");
			if(application_type=="Whole Day"){
				
				$('#assign_date_column').hide()
				$('#assign_ampm_column').hide()
				$('#assign_timefrom_column').hide()
				$('#assign_timeto_column').hide()
				$('#assign_datefrom_column').show()
				$('#assign_dateto_column').show()
				$('#assign_points_todeduct').val(1);
				$('#assignfromdate').on('change',function(){
					const dateto = $('#assigntodate').val();
					const datefrom = $('#assignfromdate').val();
					const date1 = new Date(datefrom);
					const date2 = new Date(dateto);
					const points_todeduct = $('#assign_points_todeduct').val();
					if(dateto) {
						$('#date1').val(date1.toISOString().substring(0, 10))
						$('#date2').val(date2.toISOString().substring(0, 10))
						// const diffTime = Math.abs(date2 - date1);
						// const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
						// const points_todeduct = $('#assign_points_todeduct').val();
						if(datefrom > dateto){
							$.Toast("Invalid date range", errorToast);
							$('#assigntodate').val("0000-00-00");
							$('#assigno_days').val("");
						}else{
							// var dayss = diffDays+1;
							// const deduct = (diffDays + 1) * points_todeduct;
							// $('#assigno_days').val(deduct);
							const deduct = getBusinessDatesCount(date1, date2) * points_todeduct;
							$('#assigno_days').val(deduct);
						}
					}
					
				});
				$('#assigntodate').on('change',function(){
					const dateto = $('#assigntodate').val();
					const datefrom = $('#assignfromdate').val();
					const date1 = new Date(datefrom);
					const date2 = new Date(dateto);
					// if(dateto) {
					// 	$('#date1').val(date1.toISOString().substring(0, 10))
					// 	$('#date2').val(date2.toISOString().substring(0, 10))
					// 	const diffTime = Math.abs(date2 - date1);
					// 	const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
					// 	const points_todeduct = $('#assign_points_todeduct').val();
					// 	if(datefrom > dateto){
					// 		$.Toast("Invalid date range", errorToast);
					// 		$('#assigntodate').val("0000-00-00");
					// 		$('#assigno_days').val("");
					// 	}else{
					// 		// var dayss = diffDays+1;
					// 		const deduct = (diffDays + 1) * points_todeduct;
					// 		$('#assigno_days').val(deduct);
					// 	}
					// }
					const points_todeduct = $('#assign_points_todeduct').val();
					if(dateto) {
						$('#date1').val(date1.toISOString().substring(0, 10))
						$('#date2').val(date2.toISOString().substring(0, 10))
						// const diffTime = Math.abs(date2 - date1);
						// const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
						// const points_todeduct = $('#assign_points_todeduct').val();
						if(datefrom > dateto){
							$.Toast("Invalid date range", errorToast);
							$('#assigntodate').val("0000-00-00");
							$('#assigno_days').val("");
						}else{
							// var dayss = diffDays+1;
							// const deduct = (diffDays + 1) * points_todeduct;
							// $('#assigno_days').val(deduct);
							const deduct = getBusinessDatesCount(date1, date2) * points_todeduct;
							$('#assigno_days').val(deduct);
						}
					}
					
				});
			}else if(application_type=="Half Day"){
				
				$('#assign_date_column').show()
				$('#assign_ampm_column').show()
				$('#assign_timefrom_column').hide()
				$('#assign_timeto_column').hide()
				$('#assign_datefrom_column').hide()
				$('#assign_dateto_column').hide()
				$('#assign_points_todeduct').val(.5);
				$('#assign_halfdate').on('change',function(){
					let date = $('#assign_halfdate').val() ? $('#assign_halfdate').val() : new Date().toJSON().slice(0, 10)
					if($('.assign_leaveampm:checked').val() === 'AM') {
						$('#date1').val(`${date} 08:00 AM`)
						$('#date2').val(`${date} 12:00 PM`)
					} else {
						$('#date1').val(`${date} 01:00 PM`)
						$('#date2').val(`${date} 05:PM PM`)
					}
				})
				$('.assign_leaveampm').on('change',function(){
					let date = $('#assign_halfdate').val() ? $('#assign_halfdate').val() : new Date().toJSON().slice(0, 10)
					if($('.assign_leaveampm:checked').val() === 'AM') {
						$('#date1').val(`${date} 08:00 AM`)
						$('#date2').val(`${date} 12:00 PM`)
					} else {
						$('#date1').val(`${date} 01:00 PM`)
						$('#date2').val(`${date} 05:PM PM`)
					}
				})
				
					const deduct = 0.5;
					$('#assigno_days').val(deduct);
			}else if(application_type=="Under Time"){
				
				$('#assign_date_column').show()
				$('#assign_ampm_column').hide()
				$('#assign_timefrom_column').show()
				$('#assign_timeto_column').show()
				$('#assign_datefrom_column').hide()
				$('#assign_dateto_column').hide()
				$('#assign_points_todeduct').val(.125);
				$('#assign_timefrom').on('change',function(){
					const timeFrom = $('#assign_timefrom').val();
					const timeTo = $('#assign_timeto').val();
					let date = $('#assign_halfdate').val() ? $('#assign_halfdate').val() : new Date().toJSON().slice(0, 10)
					const date1 = date + " " + timeFrom;
					const date2 = date + " " + timeTo;
					$('#date1').val(date1)
					$('#date2').val(date2)
					const points_todeduct = $('#assign_points_todeduct').val();
					let difference = new Date(date2) - new Date(date1);             
		
					difference = difference / 60 / 60 / 1000;
					const deduct = difference * points_todeduct;
					$('#assigno_days').val(deduct);
				});
				$('#assign_timeto').on('change',function(){
					const timeFrom = $('#assign_timefrom').val();
					const timeTo = $('#assign_timeto').val();
					let date = $('#assign_halfdate').val() ? $('#assign_halfdate').val() : new Date().toJSON().slice(0, 10)
					const date1 = date + " " + timeFrom;
					const date2 = date + " " + timeTo;
					$('#date1').val(date1)
					$('#date2').val(date2)
					const points_todeduct = $('#assign_points_todeduct').val();
					let difference = new Date(date2) - new Date(date1);             
		
					difference = difference / 60 / 60 / 1000;
					const deduct = difference * points_todeduct;
					$('#assigno_days').val(deduct);
				});
				$('#assign_halfdate').on('change',function(){
					const timeFrom = $('#assign_timefrom').val();
					const timeTo = $('#assign_timeto').val();
					let date = $('#halfdate').val() ? $('#assign_halfdate').val() : new Date().toJSON().slice(0, 10)
					const date1 = date + " " + timeFrom;
					const date2 = date + " " + timeTo;
					$('#date1').val(date1)
					$('#date2').val(date2)
					const points_todeduct = $('#assign_points_todeduct').val();
					let difference = new Date(date2) - new Date(date1);             
		
					difference = difference / 60 / 60 / 1000;
					const deduct = difference * points_todeduct;
					$('#assigno_days').val(deduct);
				});
			}
		});

		// $('#assign_application_type').on('change',function(){
		// 	var assign_application_type = $('#assign_application_type').val();

		// 	$('#assignlt').val("");
		// 	$('#assignleavebal').val("");
		// 	$('#assign_halfdate').val("");
		// 	$('#assign_timefrom').val("15:00");
		// 	$('#assign_timeto').val("15:00");
		// 	$('#asssignfromdate').val("");
		// 	$('#asssigntodate').val("");
		// 	$('#assigno_days').val("");
		// 	$('#assigncomment').val("");
		// 	$('#assign_amchoice').val("");
		// 	$('#assign_pmchoice').val("");

		// 	if(assign_application_type=="Whole Day"){
		// 		$('#assign_date_column').hide();
		// 		$('#assign_timefrom_column').hide();
		// 		$('#assign_timeto_column').hide();
		// 		$('#assign_datefrom_column').show();
		// 		$('#assign_dateto_column').show();
		// 		$('#assign_ampm_column').hide();
		// 	}else if(assign_application_type=="Half Day"){
		// 		$('#assign_date_column').show();
		// 		$('#assign_timefrom_column').hide();
		// 		$('#assign_timeto_column').hide();
		// 		$('#assign_datefrom_column').hide();
		// 		$('#assign_dateto_column').hide();
		// 		$('#assign_ampm_column').show();
		// 	}else if(assign_application_type=="Under Time"){
		// 		$('#assign_date_column').show();
		// 		$('#assign_timefrom_column').show();
		// 		$('#assign_timeto_column').show();
		// 		$('#assign_datefrom_column').hide();
		// 		$('#assign_dateto_column').hide();
		// 		$('#assign_ampm_column').hide();
		// 	}
		// });


		// var status_module =  window.localStorage.getItem("status");
		
		// if(status_module == "success"){
		// 	$.Toast("Successfully Sent", successToast);
		// 	localStorage.clear();
		// }

	});


	function myFunction(item, index) {
	  alert(item);
	}


	function filter_stat(){
		var filter_status = $('#filter_status').val();

		$('#tbl_leavelist').DataTable().destroy();
		loadleavelist(filter_status);

	}

	function filterleaveapp(){
		var filter_type = $('#filter_type').val();
		var filter_from = $('#filter_from').val();
		var filter_to = $('#filter_to').val();

		$('#tbl_leavelist_report').DataTable().destroy();
		loadleavelistreport(filter_type,filter_from,filter_to);

	}

	function exportleaveapp(){

		var filter_type = $('#filter_type').val();
		var filter_from = $('#filter_from').val();
		var filter_to = $('#filter_to').val();

		window.location.href="tcpdf/examples/leave_app.php?filter_type="+filter_type+"&filter_from="+filter_from+"&filter_to="+filter_to
	}


	/////////////////////////////////////////////////////////////////////

	// function compute_rate(){
	// 	var fivepm = $('#fivepm').val();
	// 	var sixpm = $('#sixpm').val();
	// 	var emp_days = $('#emp_days').val();
	// 	var sum = parseInt(fivepm) + parseInt(sixpm);

	// 	if(sum > emp_days){
	// 		alert("Too much no. of days");
	// 		$('#fivepm').val("");
	// 		$('#sixpm').val("");
	// 		$('#fivepm').focus();
	// 	}else if(sum < emp_days){
	// 		alert("Insufficient no. of days");
	// 		$('#fivepm').focus();
	// 		$('#fivepm').val("");
	// 		$('#sixpm').val("");
	// 	}else{
	// 		var first_n = parseInt(fivepm) * 1;
	// 		var second_n = parseFloat(sixpm) * 1.13;
	// 		var sumoftwo = parseInt(first_n) + parseFloat(second_n);
	// 		var emp_days = $('#emp_days').val();
	// 		var emp_rate = $('#emp_rate').val();
	// 		var emp_id = $('#emp_id').val();
	// 		var new_deduct = sumoftwo;
	// 		$.ajax({
	// 			url:"controller/controller.leave_app.php?update_deductleave",
	// 			method:"POST",
	// 			data:{
	// 				emp_id: emp_id,
	// 				new_deduct: new_deduct,
	// 				emp_rate: emp_rate,
	// 				fivepm: fivepm,
	// 				sixpm: sixpm
	// 			},success:function(){
	// 				$('#emp_nodays').html(new_deduct);

	// 				$('#tbl_myleave').DataTable().destroy();
	// 				var employeeno = $('#employeeno').val();
	//   				loadmyleave(employeeno);
	// 				$('#tbl_leavelist').DataTable().destroy();
	// 				var stat = "Pending";
	// 				loadleavelist(stat);

	// 			}
	// 		});
	// 	}
		
	// }

	/////////////////////////////////////////////////////////////////////
	
	// function upt(){
	// 	var emp_days = $('#emp_days').val();
	// 	var emp_rate = $('#emp_rate').val();
	// 	var emp_id = $('#emp_id').val();
	// 	var new_deduct = emp_days * emp_rate;
	// 	$.ajax({
	// 		url:"controller/controller.leave_app.php?update_deductleave",
	// 		method:"POST",
	// 		data:{
	// 			emp_id: emp_id,
	// 			new_deduct: new_deduct,
	// 			emp_rate: emp_rate
	// 		},success:function(){
	// 			$('#emp_nodays').html(new_deduct);


	// 			$('#tbl_myleave').DataTable().destroy();
	// 			var employeeno = $('#employeeno').val();
  	// 			loadmyleave(employeeno);
	// 			$('#tbl_leavelist').DataTable().destroy();
	// 			var stat = "Pending";
	// 			loadleavelist(stat);

	// 		}
	// 	});
	// }

	// function assign_ampm(){
	// 	var leaveampm = $("input[name='assign_leaveampm']:checked").val();
	// 	if(leaveampm=="AM"){
	// 		$('#assign_amchoice').val("");
	// 		$('#assign_amchoice').show();
	// 		$('#assign_pmchoice').hide();
	// 		$('#assigno_days').val("");
	// 	}else if(leaveampm=="PM"){
	// 		$('#assign_amchoice').hide();
	// 		$('#assign_pmchoice').show();
	// 		$('#assign_pmchoice').val("");
	// 		$('#assigno_days').val("");
	// 	}else{
	// 		alert("E");
	// 	}
	// }


	function cancelapprove(){
		confirmed("save",cancelapprove_callback, "Do you really want to undo this?", "Yes", "No");
	}

	function cancelapprove_callback(){
		var leave_id = $('#leave_id').val();
		var remarks = $('#remarks').val();
		var status = "Cancelled";	
		var emp_number = $('#emp_number').html();
		var emp_leavetype = $('#emp_leavetype').html();
		var emp_nodays = $('#emp_nodays').html();
		var emp_status = $('#emp_status').html();
		$.ajax({
			url:"controller/controller.leave_app.php?approveleave",
			method:"POST",
			data:{
				leave_id:leave_id,
				status:status,
				remarks:remarks,
				emp_number:emp_number,
				emp_leavetype:emp_leavetype,
				emp_nodays:emp_nodays,
				emp_status:emp_status
			},
			beforeSend: function(){
				$("#btncancelapprove").text('Loading....')
				$("#btncancelapprove").attr('disabled', true)
			},
			complete: function(){
				$("#btncancelapprove").text('Undo')
				$("#btncancelapprove").attr('disabled', false)
			},
			success:function(data){
				const b = $.parseJSON(data)
				if(b.type === 'error')
					$.Toast(b.message, errorToast)
				else {
					$.Toast(b.message, successToast);
					$('#tbl_leavelist').DataTable().destroy();
					var stat = "Pending";
					$('#filter_status').val(stat)
					loadleavelist(stat);
					$('#leavemodal').modal('hide')
				}
			}
		});
	}

	function approve(){
		confirmed("save",approve_callback, "Do you really want to approve this?", "Yes", "No");
	}

	function approve_callback(){
		var leave_id = $('#leave_id').val();
		var remarks = $('#remarks').val();
		var status = "Approved";	
		var emp_number = $('#emp_number').html();
		var emp_leavetype = $('#emp_leavetype').html();
		var emp_nodays = $('#emp_nodays').html();
		var emp_status = $('#emp_status').html();
		$.ajax({
			url:"controller/controller.leave_app.php?approveleave",
			method:"POST",
			data:{
				leave_id:leave_id,
				status:status,
				remarks:remarks,
				emp_number:emp_number,
				emp_leavetype:emp_leavetype,
				emp_nodays:emp_nodays,
				emp_status:emp_status
			},
			beforeSend: function(){
				$("#btndisapprove").text('Loading....')
				$("#btndisapprove").attr('disabled', true)
				$("#btnapprove").text('Loading....')
				$("#btnapprove").attr('disabled', true)
			},
			complete: function(){
				$("#btndisapprove").text('Disapprove')
				$("#btndisapprove").attr('disabled', false)
				$("#btnapprove").text('Approve')
				$("#btnapprove").attr('disabled', false)
			},
			success:function(data){
				const b = $.parseJSON(data)
				if(b.type === 'error')
					$.Toast(b.message, errorToast)
				else {
					$.Toast(b.message, successToast)
					$('#tbl_leavelist').DataTable().destroy();
					var stat = "Pending";
					$('#filter_status').val(stat)
					loadleavelist(stat);
					$('#leavemodal').modal('hide')
				}
			}
		});
	}

  	function disapproved(){
  		confirmed("delete",disapproved_callback, "Do you really want to disapproved this?", "Yes", "No");
  	}

  	function disapproved_callback(){
  		var leave_id = $('#leave_id').val();
	  	var remarks = $('#remarks').val();
	  	var status = "Disapproved";
	  	var emp_number = $('#emp_number').html();
	  	var emp_leavetype = $('#emp_leavetype').html();
		var emp_nodays = $('#emp_nodays').html();
		var emp_status = $('#emp_status').html();
	  	$.ajax({
			url:"controller/controller.leave_app.php?approveleave",
			method:"POST",
			data:{
				leave_id:leave_id,
				status:status,
				remarks:remarks,
				emp_number:emp_number,
				emp_leavetype:emp_leavetype,
				emp_nodays:emp_nodays,
				emp_status:emp_status
			},
			beforeSend: function(){
				$("#btndisapprove").text('Loading....')
				$("#btndisapprove").attr('disabled', true)
				$("#btnapprove").text('Loading....')
				$("#btnapprove").attr('disabled', true)
			},
			complete: function(){
				$("#btndisapprove").text('Disapprove')
				$("#btndisapprove").attr('disabled', false)
				$("#btnapprove").text('Approve')
				$("#btnapprove").attr('disabled', false)
			},
			success:function(data){
				const b = $.parseJSON(data)
				if(b.type === 'error')
					$.Toast(b.message, errorToast)
				else {
					$.Toast(b.message, successToast)
					$('#tbl_leavelist').DataTable().destroy();
					var stat = "Pending";
					$('#filter_status').val(stat)
					loadleavelist(stat);
					$('#leavemodal').modal('hide')
				}
			}
		});
  	}

	function submitassignleave(){
		confirmed("save",submitassignleave_callback, "Do you really want to save this?", "Yes", "No");	
	}

	function submitassignleave_callback(){

		var application_type = $('#assign_application_type').val();
		// var leave_value = $('#assignremaininglb').val();
		var leave_bal = $('#assignleavebal').val();
		var leave_type = $('#assignlt').val();
		var datefrom = $('#date1').val();
		var dateto = $('#date2').val();
		var comment = $('#assigncomment').val();
		var stat = "Pending";
		var employeeno = $('#employeeddown').val();
		var date_applied = $('#datenow').val();
		var no_days = $('#assigno_days').val();
		// var timefrom = $('#assign_timefrom').val();
		// var timeto = $('#assign_timeto').val();
		var points_todeduct = $('#assign_points_todeduct').val();
		var halfdate = $('#assign_halfdate').val();
		var pay_leave = $('#pay_leave').val();
		var leaveForm = $("#leaveForm").prop("files")[0];
		// var leaveForm = $('#leaveForm').prop('files');

		// const date1 = new Date(dateto);
		// const date2 = new Date(datefrom);
		// const diffTime = Math.abs(date2 - date1);
		// const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
		// var dayss = diffDays+1;
		// if(leave_bal=="" || leave_bal==null){
		// 	$.Toast("No available leave credits", errorToast);
		// }
		if(no_days=="" || no_days==null){
			$.Toast("Invalid transaction", errorToast);
		}else if(comment=="" || comment==null){
			$.Toast("Please input the reason of your leave.", errorToast);
		}else if(leaveForm=="" || leaveForm==null){
			$.Toast("Please input the hardcopy of your leave form.", errorToast);
		}else{
			// var updatedbalance = leave_value - no_days;
			var form_data = new FormData();
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
			// form_data.append("dayss", dayss)
			form_data.append("date_from", halfdate)
			form_data.append("leave_bal", leave_bal)
			form_data.append("pay_leave", pay_leave)
			// console.log(form_data)
			// for (var pair of form_data.entries()) {
			// 	console.log(pair[0]+ ', ' + pair[1]); 
			// }
			$.ajax({
				url:"controller/controller.leave_app.php?addleave",
				method:"POST",
				data: form_data,
				processData: false,
				contentType: false,
				beforeSend: function(){
					$("#btndisapprove").text('Loading....')
					$("#btndisapprove").attr('disabled', true)
					$("#btnapprove").text('Loading....')
					$("#btnapprove").attr('disabled', true)
				},
				complete: function(){
					$("#btndisapprove").text('Disapprove')
					$("#btndisapprove").attr('disabled', false)
					$("#btnapprove").text('Approve')
					$("#btnapprove").attr('disabled', false)
				},
				success:function(data){
					const b = $.parseJSON(data)
					if(b.type === 'error')
						$.Toast(b.message, errorToast)
					else {
						$.Toast(b.message, successToast)
						$('#tbl_leavelist').DataTable().destroy();
						// var stat = "Pending";
						// $('#filter_status').val(stat)
						loadleavelist('Pending');
						$('#leavemodal').modal('hide')
						$('#form').trigger("reset");
					}
				}
			});

		}

	}


	function btnleavelist(){
		$("#lapply").removeClass("active");
		$("#lmyapply").removeClass("active");
		$("#lleave").addClass("active");
		$("#lassign").removeClass("active");
		$("#lreports").removeClass("active");

		$("#div_apply").hide();
		$("#div_myleave").hide();
		$("#div_leavelist").show();
		$("#div_assignleave").hide();
		$("#div_reports").hide();
	}
	function btnassignleave(){
		$("#lapply").removeClass("active");
		$("#lmyapply").removeClass("active");
		$("#lleave").removeClass("active");
		$("#lassign").addClass("active");
		$("#lreports").removeClass("active");

		$("#div_apply").hide();
		$("#div_myleave").hide();
		$("#div_leavelist").hide();
		$("#div_assignleave").show();
		$("#div_reports").hide();
	}
	function btnreports(){
		$("#lapply").removeClass("active");
		$("#lmyapply").removeClass("active");
		$("#lleave").removeClass("active");
		$("#lassign").removeClass("active");
		$("#lreports").addClass("active");

		$("#div_apply").hide();
		$("#div_myleave").hide();
		$("#div_leavelist").hide();
		$("#div_assignleave").hide();
		$("#div_reports").show();
	}


	function goto(linkk){
		
		if(linkk=="notification.php"){
			var employeeno = $('#employeeno').val();
			$.ajax({
				url:"controller/controller.leave_app.php?readleave",
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
				url:"controller/controller.leave_app.php?readpayslip",
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


	function edit_leave(id,fname,employeeno,leave_type,date_applied,leave_balance,datefrom,dateto,no_days,status,comment,remarks,application_type,deduct_rate,fivepm,sixpm,balanse,pay_leave, leaveForm){               

		const date1 = new Date(dateto);
		const date2 = new Date(datefrom);
		const diffTime = Math.abs(date2 - date1);
		const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
		// let dayss = 1
		// if(application_type === 'Whole Day'){
		// 	dayss = diffDays+1;
		// }
		
		$('#emp_days').html(no_days);

		$('#fivepm').val(fivepm);
		$('#sixpm').val(sixpm);

		$('#emp_leavebalancetype').html(balanse);
		$('#leave_id').val(id);
		$('#emp_number').html(employeeno);
		$('#emp_fname').html(fname);
		$('#emp_leavetype').html(leave_type);
		$('#emp_dateapplied').html(date_applied);
		// $('#emp_leavebalance').html(leave_balance);
		$('#emp_datefrom').html(datefrom);
		$('#emp_dateto').html(dateto);

		// $('#emp_ampm').html(datefrom);
		// $('#emp_time').html(dateto);

		$('#emp_nodays').html(no_days);
		$('#emp_status').html(status);
		$('#emp_comment').html(comment);
		$('#remarks').val(remarks);
		$('#emp_application_type').html(application_type);
		// $('#emp_rate').val(deduct_rate);
		// $('#pay_leave_span').html(pay_leave);
		$('#pay_leave_span').html(pay_leave);
		// $('#leaveFormButton').on(leaveForm);
		// $('#leaveFormButton').on('click', () => {
		// 	viewLeaveForm(leaveForm)
		// });

		if(status=="Disapproved"){
			$('#btnapprove').hide();
			$('#btndisapprove').hide();
			$('#btncancelapprove').show();
			$('#compute_btn').hide();
			$( "#remarks" ).prop( "disabled", true);
			// $( "#fivepm" ).prop( "disabled", true);
			// $( "#sixpm" ).prop( "disabled", true);
			

		}else if(status=="Approved"){
			$('#btnapprove').hide();
			$('#btndisapprove').hide();
			$('#btncancelapprove').show();
			$('#compute_btn').hide();
			$( "#remarks" ).prop( "disabled", true);
			// $( "#fivepm" ).prop( "disabled", true);
			// $( "#sixpm" ).prop( "disabled", true);
		}else{
			$('#btnapprove').show();
			$('#btndisapprove').show();
			$('#btncancelapprove').hide();
			$('#compute_btn').show();
			$( "#remarks" ).prop( "disabled", false);
			// $( "#fivepm" ).prop( "disabled", false);
			// $( "#sixpm" ).prop( "disabled", false);
		}

		if(application_type=="Half Day"){
			$('#no_days_column').hide();
			$('#rate_column').hide();
			$('#dfrom_column').hide();
			$('#dto_column').hide();
			$('#ap_column').show();
			$('#time_column').show();
			// $('#fivepm_column').hide();
			// $('#sixpm_column').hide();
		}else if(application_type=="Whole Day"){
			$('#no_days_column').show();
			$('#rate_column').hide();
			$('#dfrom_column').show();
			$('#dto_column').show();
			$('#ap_column').hide();
			$('#time_column').hide();
			// $('#fivepm_column').show();
			// $('#sixpm_column').show();
		}else{
			$('#no_days_column').hide();
			$('#rate_column').hide();
			$('#dfrom_column').show();
			$('#dto_column').show();
			$('#ap_column').hide();
			$('#time_column').hide();
			// $('#fivepm_column').hide();
			// $('#sixpm_column').hide();
		}

		if(pay_leave=="Without Pay"){
			$('#emp_nodays').html(0);
			$('#no_days_column').hide();
			// $('#fivepm_column').hide();
			// $('#sixpm_column').hide();
		}else{
			$('#no_days_column').show();
			// $('#fivepm_column').show();
			// $('#sixpm_column').show();
		}

		$('#leavemodal').modal('show');
	}

	// function loadmyleave(employeeno){
							
	// 	$('#tbl_myleave').DataTable({  
	// 			"aaSorting": [],
	// 			"bSearching": true,
	// 			"bFilter": true,
	// 			"bInfo": true,
	// 			"bPaginate": true,
	// 			"bLengthChange": true,
	// 			"pagination": true,
	// 			"ajax" : "controller/controller.leave_app.php?loadmyleave&employeeno="+employeeno,
	// 			"columns" : [
					
	// 				{ "data" : "employeeno"},
	// 				{ "data" : "date"},
	// 				{ "data" : "leavetype"},
	// 				{ "data" : "leavebalance"},
	// 				{ "data" : "numberofdays"},
	// 				{ "data" : "active_status"},
	// 				{ "data" : "action"}

	// 			],
	// 		});
	// }
	// var employeeno = $('#employeeno').val();
	// loadmyleave(employeeno);


	function loadleavelist(stat){
		
		var employeenoo = $('#employeeno').val();
		$('#tbl_leavelist').DataTable({  
			createdRow: function (row, data, index) {
				if ($('td', row).eq(6)[0].innerText == 'Disapproved') {
					$('td', row).eq(6).addClass('reject')
				} else if($('td', row).eq(6)[0].innerText == 'Approved') {
					$('td', row).eq(6).addClass('acknowledged')
				}
			},
			"aaSorting": [],
			"bSearching": true,
			"bFilter": true,
			"bInfo": true,
			"bPaginate": true,
			"bLengthChange": true,
			"pagination": true,
			"ajax" : "controller/controller.leave_app.php?loadleavelist&employeenoo="+employeenoo+"&stat="+stat,
			"columns" : [
					
				{ "data" : "employeeno"},
				{ "data" : "date"},
				{ "data" : "leavetype"},
				{ "data" : "application_type"},
				{ "data" : "leavebalance"},
				{ "data" : "numberofdays"},
				{ "data" : "active_status"},
				{ "data" : "leave_form"},
				{ "data" : "action"},

			],
		});
	}
	var stat = "Pending";
	loadleavelist(stat);

	// function count_leaveapp(){

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


	function loadleavelistreport(filter_type,filter_from,filter_to){
		
		$('#tbl_leavelist_report').DataTable({  
				createdRow: function (row, data, index) {
					if ($('td', row).eq(7)[0].innerText == 'Disapproved') {
						$('td', row).eq(7).addClass('reject')
					} else if($('td', row).eq(7)[0].innerText == 'Approved') {
						$('td', row).eq(7).addClass('acknowledged')
					}
				},
				"aaSorting": [],
				"bSearching": true,
				"bFilter": true,
				"bInfo": true,
				"bPaginate": true,
				"bLengthChange": true,
				"pagination": true,
				"ajax" : "controller/controller.leave_app.php?loadleavelistreport&filter_type="+filter_type+"&filter_from="+filter_from+"&filter_to="+filter_to,
				"columns" : [
						
					{ "data" : "employeeno"},
					{ "data" : "date_from"},
					{ "data" : "date_to"},
					{ "data" : "leavetype"},
					{ "data" : "application_type"},
					{ "data" : "leavebalance"},
					{ "data" : "numberofdays"},
					{ "data" : "active_status"}

				],
			});
	}

	var filter_type = $('#filter_type').val();
	var filter_from = $('#filter_from').val();
	var filter_to = $('#filter_to').val();
  loadleavelistreport(filter_type,filter_from,filter_to);

  function viewLeaveForm(filename, employeeno){
    var link = "static/leave_form/" + employeeno + '/' + filename;
    window.open(link);
  }

  
	// function lb(){

	// 	$.ajax({
	// 		url:"controller/controller.leavebalance.php?leave_credits_load",
	// 		method:"POST",
	// 		data:{
	// 		id:""
	// 		},success:function(){

	// 		}
	// 	});
		
	// }
	// lb();
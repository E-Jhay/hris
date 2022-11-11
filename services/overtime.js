var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

		$("#ess_overtime").addClass("active_tab");
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
		

		$("#lapply").addClass("active");

		$('#ot_to').on('change',function(){
			var ot_from = $('#ot_from').val();
			var ot_to = $('#ot_to').val();
			console.log(ot_from, ot_to)
			
			var hours = ( new Date("1970-1-1 " + ot_to) - new Date("1970-1-1 " + ot_from) ) / 1000 / 60 / 60;
			
			if(hours < 0){

				hours = 24 + hours;
			} 

			$('#no_of_hrs').val(hours);
		});

		$('#ot_from').on('change',function(){
			var ot_from = $('#ot_from').val();
			var ot_to = $('#ot_to').val();
			console.log(ot_from, ot_to)
			var hours = ( new Date("1970-1-1 " + ot_to) - new Date("1970-1-1 " + ot_from) ) / 1000 / 60 / 60;
			
			if(hours < 0){

				hours = 24 + hours;
			} 

			$('#no_of_hrs').val(hours);
		});

	});

	function submitot(){
		confirmed("save",submitot_callback, "Do you really want to submit this?", "Yes", "No");
	}

	function submitot_callback(){

			var employeeno = $('#employeeno').val();
			var reasons = $('#reasons').val();
			var date_filed = $('#date_filed').val();
			var ot_from = $('#ot_from').val();
			var ot_to = $('#ot_to').val();
			var no_of_hrs = $('#no_of_hrs').val();
			var ot_date = $('#ot_date').val();
			var ot_date_to = $('#ot_date_to').val();

			if(reasons=="" || reasons==null){
				$.Toast("Please input the reason of your Overtime.", errorToast);
			}else if(no_of_hrs=="" || no_of_hrs==null){
				$.Toast("Invalid Transaction", errorToast);
			}else{
				$.ajax({
					url:"controller/controller.overtime.php?apply_overtime",
					method:"POST",
					data:{
						employeeno: employeeno,
						reasons: reasons,
						date_filed: date_filed,
						ot_from: ot_from,
						ot_to: ot_to,
						no_of_hrs: no_of_hrs,
						ot_date: ot_date,
						ot_date_to: ot_date_to
					},success:function(){
						window.location.href="overtime.php";
					}
				});
			}
			// console.log(employeeno, reasons, date_filed, ot_from, ot_to, no_of_hrs, ot_date, ot_date_to)
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


		function myFunction(item, index) {
		  alert(item);
		}




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
			url:"controller/controller.overtime.php?readleave",
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
			url:"controller/controller.overtime.php?readpayslip",
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

  function delete_myot(id){
  	confirmed("delete",delete_myot_callback, "Do you really want to delete this?", "Yes", "No", id);
  }

  function delete_myot_callback(id){
  	
  		$.ajax({
  			url:"controller/controller.overtime.php?delete_otapply",
  			method:"POST",
  			data:{
  				id:id
  			},success:function(){
  				$.Toast("Successfully Deleted", errorToast);
  				$('#tbl_myot').DataTable().destroy();
  				var employeeno = $('#employeeno').val();
  				loadmyot(employeeno);
  			}
  		});
  }

  function loadmyot(employeeno){
                          
    $('#tbl_myot').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.overtime.php?loadmyot&employeeno="+employeeno,
              "columns" : [
        
                    { "data" : "employeeno"},
                    { "data" : "position"},
                    { "data" : "reasons"},
                    { "data" : "date_filed"},
                    { "data" : "ot_from"},
                    { "data" : "ot_to"},
                    { "data" : "no_of_hrs"},
                    { "data" : "ot_date"},
                    { "data" : "ot_date_to"},
                    { "data" : "status"},
                    { "data" : "remarks"},
                    { "data" : "action"}


                ],
         });
  }
  var employeeno = $('#employeeno').val();
  loadmyot(employeeno);


  function count_leaveapp(){

  	var employeenoo = $('#employeeno').val();
  	$.ajax({
  		url:"controller/controller.overtime.php?count_leaveapp",
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
  		url:"controller/controller.overtime.php?count_otapp",
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
  		url:"controller/controller.overtime.php?count_payslip",
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
  		url:"controller/controller.overtime.php?count_reimbursement",
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
var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

		$("#ess_overtime").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});
		var employeenoo = $('#employeeno').val();
		

		$("#lapply").addClass("active");

		$('#ot_to').on('change',function(){
			var ot_from = $('#ot_from').val();
			var ot_to = $('#ot_to').val();
			
			var hours = ( new Date("1970-1-1 " + ot_to) - new Date("1970-1-1 " + ot_from) ) / 1000 / 60 / 60;
			
			if(hours < 0){

				hours = 24 + hours;
			} 

			$('#no_of_hrs').val(hours);
		});

		$('#ot_from').on('change',function(){
			var ot_from = $('#ot_from').val();
			var ot_to = $('#ot_to').val();
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

		if(reasons=="" || reasons==null) return $.Toast("Please input the reason of your Overtime.", errorToast)
		if(no_of_hrs=="" || no_of_hrs==null) return $.Toast("Invalid Transaction", errorToast);
		if(ot_date=="" || ot_date==null) return $.Toast("Overtime date should not be empty", errorToast);
		if(ot_date_to=="" || ot_date_to==null) return $.Toast("Overtime date To should not be empty", errorToast);
		if(ot_date > ot_date_to) return $.Toast("Invalid dates, please check the dates", errorToast);
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
			},
			beforeSend: function(){
				$("#btn_submit").text('Loading....')
				$("#btn_submit").attr('disabled', true)
			},
			complete: function(){
				$("#btn_submit").text('Submit')
				$("#btn_submit").attr('disabled', false)
			},
			success:function(data){
				const b = $.parseJSON(data)
				if(b.type === 'error')
					$.Toast(b.message, errorToast)
				else {
					$.Toast(b.message, successToast)
					clearFields()
					$('#tbl_myot').DataTable().destroy();
					var employeeno = $('#employeeno').val();
					loadmyot('Pending');
				}
			}
		});
	}

	function clearFields() {
		$('#reasons').val('');
		$('#date_filed').val('');
		$('#ot_from').val('');
		$('#ot_to').val('');
		$('#no_of_hrs').val('');
		$('#ot_date').val('');
		$('#ot_date_to').val('');
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
  				$.Toast("Successfully Deleted", successToast);
  				$('#tbl_myot').DataTable().destroy();
  				var employeeno = $('#employeeno').val();
  				loadmyot(employeeno);
  			}
  		});
  }

  function loadmyot(status){
	const employeeno = $('#currentUser').val();
                          
    $('#tbl_myot').DataTable({  
				createdRow: function (row, data, index) {
					if ($('td', row).eq(9)[0].innerText == 'Disapproved') {
						$('td', row).eq(9).addClass('reject')
						console.log($('td', row).eq(9)[0].innerText)
					} else if($('td', row).eq(9)[0].innerText == 'Approved') {
						$('td', row).eq(9).addClass('acknowledged')
						console.log($('td', row).eq(9)[0].innerText)
					}
				},
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.overtime.php?loadmyot&employeeno="+employeeno+"&status="+status,
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
  loadmyot('Pending');

  $('#filter_ot').on('change', () => {
	$('#tbl_myot').DataTable().destroy();
	loadmyot($('#filter_ot').val());
})

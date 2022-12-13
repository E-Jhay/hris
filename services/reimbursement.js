var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		$("#ess_omnibus").addClass("active_tab");
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

		var balance = $('#balance').val();
		if(balance <=0){
			$.Toast("Insufficient balance", errorToast);
		}

		$('#form').on('submit', (e) => {
			e.preventDefault()
			const emp_no = $('#emp_no').val()
			const reimbursement_bal = $('#reimbursement_bal').val()
			const description = $('#description').val()
			const nature = $('#nature').val()
			const amount = $('#amount').val()
			const empfile = $("#empfile").prop("files")[0]
			if (parseInt(reimbursement_bal) <= 0) return $.Toast('No available balance', errorToast)
			if (parseInt(reimbursement_bal) < parseInt(amount)) return $.Toast('Insufficient balance', errorToast)
			const formData = new FormData()
			formData.append('emp_no', emp_no)
			formData.append('reimbursement_bal', reimbursement_bal)
			formData.append('description', description)
			formData.append('nature', nature)
			formData.append('amount', amount)
			formData.append('empfile', empfile)
			$.ajax({
				url:"controller/controller.reimburse.php?uploadreimbursement",
				method:"POST",
				data: formData,
				processData: false,
				contentType: false,
				success:function(data){
					const b = $.parseJSON(data)
					if(b.type === 'error')
						$.Toast(b.message, errorToast);
					else{
						$.Toast(b.message, successToast)
						$('#form')[0].reset()
						$('#tbl_reimburse').DataTable().destroy();
						load_myreimburse('');
					}
				}
			});
		 })

});

function get_reimbal(){
	var employeeno = $('#employeeno').val();
	$.ajax({
		url:"controller/controller.reimburse.php?get_reimbal",
		method:"POST",
		data:{
			employeeno: employeeno
		},success:function(data){
			var b = $.parseJSON(data);
			var rembal = b.reimbursement_bal;
			if(rembal < 0){
				rembal = 0;
			}
			$('#reimbursement_bal').val(rembal);
			$('#rem_bal').html(rembal);
		}
	});
}
get_reimbal();

// function lb(){

// 	$.ajax({
// 		url:"controller/controller.leavebalance.php?leave_credits_load",
// 		method:"POST",
// 		data:{
// 			id:""
// 		},success:function(){

// 		}
// 	});
			 
// }
// lb();


	function dl_file(file_name,employeeno){
		window.open("reimbursement/"+employeeno+"/"+file_name);
	}
	function delete_file(id,file_name,employeeno){
		var data = [id,file_name,employeeno];
		confirmed("delete",delete_file_callback, "Do you really want to delete this?", "Yes", "No", data);
	}

function delete_file_callback(data){
			var id = data[0];
			var file_name = data[1];
			var employeeno = data[2];
			$.ajax({
				url:"controller/controller.reimburse.php?delete_reimbursement",
				method:"POST",
				data:{
					id: id,
					file_name: file_name,
					employeeno: employeeno
				},success:function(){
					$.Toast("Successfully Deleted", errorToast);
					$('#tbl_reimburse').DataTable().destroy();
					load_myreimburse();
				}
		  });
}

function view_file_personal(id,employeeno,description,nature,datee,amount,file_name,remarks,orig_amount,statuss,lastname,firstname,reimbursement_bal){
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
		$('#amount_modal').prop("disabled",true);
		$('#remarks').prop("disabled",true);
		
}


function myFunction(item, index){
	alert(item);
}

	

  function goto(linkk){
	
	if(linkk=="notification.php"){

		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.reimburse.php?readleave",
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
			url:"controller/controller.reimburse.php?readpayslip",
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

	function btnapply(){
			$("#lapply").addClass("active");
			$("#lmyapply").removeClass("active");

			$("#div_apply").show();
			$("#div_myapply").hide();
	}

	function btnmyapply(){
			$("#lapply").removeClass("active");
			$("#lmyapply").addClass("active");

			$("#div_apply").hide();
			$("#div_myapply").show();
	}


  function load_myreimburse(statuss){
	var type = "personal";
	var employeeno = $('#employeeno').val();
    $('#tbl_reimburse').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.reimburse.php?load_myreimburse&type="+type+"&employeeno="+employeeno+"&statuss="+statuss,
              "columns" : [
                    
                    { "data" : "description"},
                    { "data" : "nature"},
                    { "data" : "amount"},
                    { "data" : "datee"},
                    { "data" : "statuss"},
                    { "data" : "action"}

                ],
         });
  }
  var statuss = "";
  load_myreimburse(statuss);

  function count_leaveapp(){

  	var employeenoo = $('#employeeno').val();
  	$.ajax({
  		url:"controller/controller.reimburse.php?count_leaveapp",
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
  		url:"controller/controller.reimburse.php?count_otapp",
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
  		url:"controller/controller.reimburse.php?count_reimbursement",
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
  		url:"controller/controller.reimburse.php?count_payslip",
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

	// function submitReimbursement(e){
	// 	e.preventDefault()
	// 	confirmed("save",submitReimbursementCallback, "Do you really want to submit this?", "Yes", "No");
	// }

	// function submitReimbursementCallback(){
	// 	var formData = new FormData($("#form")[0]);
	// 	$.ajax({
	// 		url:"controller/controller.reimburse.php?uploadreimbursement",
	// 		method:"POST",
	// 		data: formData,
	// 		processData: false,
	// 		contentType: false,
	// 		success:function(){
	// 			$.Toast("Successfully Saved", successToast);
	// 			setTimeout(() => {
	// 				window.location.href="reimbursement.php";
	// 			}, 1000)
	// 		}
	// 	});
	// 	console.log(formData)
	// }
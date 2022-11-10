var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

		$("#ess_myinfo").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});

		$('#personal_image').css('cursor','pointer');
		$('#personal_image').on('click', function(){
			$('#profile').click();
		});
		$('#dependent_image').css('cursor','pointer');
		$('#dependent_image').on('click', function(){
			$('#dependent').click();
		});
		$('#marriage_contract_image').css('cursor','pointer');
		$('#marriage_contract_image').on('click', function(){
			$('#marriageContract').click();
		});
		$('#additional_id_image').css('cursor','pointer');
		$('#additional_id_image').on('click', function(){
			$('#additionalId').click();
		});
		$('#proofOFBilling_image').css('cursor','pointer');
		$('#proofOFBilling_image').on('click', function(){
			$('#proofOFBilling').click();
		});

		$('#profile').on('change',function(){
				if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#personal_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
			console.log('changed')
        }
		});
		$('#dependent').on('change',function(){
				if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#dependent_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
		});
		$('#marriageContract').on('change',function(){
				if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#marriage_contract_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
		});
		$('#additionalId').on('change',function(){
				if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#additional_id_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
		});
		$('#proofOFBilling').on('change',function(){
				if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#proofOFBilling_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
		});

		$('#removeImage').on('click', (e) => {
			e.preventDefault()
			$('#personal_image').attr('src', $('#personal_pic').attr('src'));
		})

		var notif_number = $('#notif_number').html();
		if(notif_number > 0){
			$('#notif_number').show();
		}else{
			$('#notif_number').hide();
		}
		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.info.php?getmyinfo",
			method:"POST",
			data:{
				employeeno:employeeno
			},success:function(data){
				var b = $.parseJSON(data);
				// document.getElementById("personal_pic").src = "personal_picture/3.jpg";
				document.getElementById("personal_pic").src = "personal_picture/"+b.imagepic;
				document.getElementById("personal_image").src = "personal_picture/"+b.imagepic;
				$('#fname').html(b.firstname);
				$('#mname').html(b.middlename);
				$('#lname').html(b.lastname);
				$('#empno').html(b.employeeno);
				$('#dob').html(b.dateofbirth);
				$('#marital_status').html(b.marital_status);
				$('#genderr').html(b.gender);
				$('#datehired').html(b.date_hired);
				$('#nationality').html(b.nationality);
				$('#username_modal').val(b.username);
				$('#pass_modal').val(b.password);


			}

		});

		// $('#form').on('submit', function (e) {
		// 	e.preventDefault();
		// 	confirmed("save",save_form_callback, "Do you really want to save taaaaahis?", "Yes", "No");
		// })

});

function removeFile(button, image) {
	// $("#removeProfile").on('click', (e) => {
	// 	e.preventDefault()
	// 	$("#removeProfile").attr('src', $("#personal_image").attr('src'));
	// })
	let defaultImage = ""
	if(button === "#removeProfile") {
		// defaultImage = "#personal_pic"
		$(image).attr('src', $("#personal_pic").attr('src'));
	} else {
		$(image).attr('src', "static/card-thumbnail.jpg");
	}
	// $(image).attr('src', $(defaultImage).attr('src'));
	console.log(button, image)
}

// function lb(){

// 			 $.ajax({
// 				url:"controller/controller.leavebalance.php?leave_credits_load",
// 				method:"POST",
// 				data:{
// 					id:""
// 				},success:function(){

// 				}
// 			});	 
// 	}
// 	lb();
	

 function save_pass(){
 	confirmed("save",save_pass_callback, "Do you really want to save this?", "Yes", "No");
 }	
 

 function save_pass_callback(){

 	var pass_modal = $('#pass_modal').val();
	var empno = $('#empno').html();

	$.ajax({
		url:"controller/controller.info.php?changepassword",
		method:"POST",
		data:{
			pass_modal : pass_modal,
			empno : empno
		},success:function(){
			
			window.location.href="myinfo.php";
		}
	});
 }

//  function save_form_callback(){
// 	var formData = new FormData($("#form")[0]);
	
// 	$.ajax({
// 		url:"controller/controller.info.php?addDocuments",
// 		method:"POST",
// 		data: formData,
// 		processData: false,
// 		contentType: false,
// 		success:function(){
// 			console.log(data)
// 		}
// 	});
// }

 function change(){
 	$('#password_modal').modal('show');
 }
 function documentsModal(){
 	$('#documentsModal').modal('show');
 }

  function backmodule(){
  	window.location.href="module.php";
  }

  function goto(linkk){

	if(linkk=="notification.php"){
		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.info.php?readleave",
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
			url:"controller/controller.info.php?readpayslip",
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

  function count_leaveapp(){

  	var employeenoo = $('#employeeno').val();
  	$.ajax({
  		url:"controller/controller.info.php?count_leaveapp",
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
  		url:"controller/controller.info.php?count_otapp",
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
  		url:"controller/controller.info.php?count_payslip",
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
  		url:"controller/controller.info.php?count_reimbursement",
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
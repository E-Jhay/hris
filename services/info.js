var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
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

		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.info.php?getmyinfo",
			method:"POST",
			data:{
				employeeno:employeeno
			},success:function(data){
				var b = $.parseJSON(data);
				if(b.imagepic=="" || b.imagepic==null){
					document.getElementById("personal_pic").src = "usera.png";
					document.getElementById("personal_image").src = "usera.png";
				}else{
					document.getElementById("personal_pic").src = "personal_picture/"+b.employeeno+"/"+b.imagepic;
					document.getElementById("personal_image").src = "personal_picture/"+b.employeeno+"/"+b.imagepic;
					// document.getElementById("personal_image").src = "personal_picture/"+b.imagepic;
				}
				// document.getElementById("personal_pic").src = "personal_picture/3.jpg";
				// document.getElementById("personal_pic").src = "personal_picture/"+b.employeeno+"/"+b.imagepic;
				// document.getElementById("personal_image").src = "personal_picture/"+b.employeeno+"/"+b.imagepic;
				$('#file_name').val(b.imagepic);
				// $('#prevMarriageContract').val(b.marriage_contract);
				// $('#prevDependent').val(b.dependent);
				// $('#prevAdditionalId').val(b.additional_id);
				// $('#prevProofOfBilling').val(b.proof_of_billing);
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
	// console.log(button, image)
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

 $('#form').on('submit', (e) => {
	e.preventDefault()
	const formData = new FormData($("#form")[0]);
	$.ajax({
		url:"controller/controller.info.php?addDocuments",
		method:"POST",
		data: formData,
		processData: false,
		contentType: false,
		success:function(data){
			const b = $.parseJSON(data)
			if(b.type === 'error')
				$.Toast(b.message, errorToast);
			else{
				$.Toast(b.message, successToast);
				$('#documentsModal').modal('hide');
				setTimeout(() => {
					var b = $.parseJSON(data);
					var id = b.id;
					window.location.href="myinfo.php";
				}, 1000)
			}
		}
	});

 })
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
// 	}

 function change(){
 	$('#password_modal').modal('show');
 }
 function documentsModal(){
 	$('#documentsModal').modal('show');
 }

  function backmodule(){
  	window.location.href="module.php";
  }
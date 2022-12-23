var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		$('#personal_image').css('cursor','pointer');
		$('#personal_image').on('click', function(){
			$('#profile').click();
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

		$("#master_other").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});
		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.otherinfo.php?selectotherinfo",
			method:"POST",
			data:{
				employeeno:employeeno
			},success:function(data){
				var b = $.parseJSON(data);
				$('#emp_no').val(b.emp_no);
				$('#f_name').val(b.f_name);
				$('#l_name').val(b.l_name);
				$('#m_name').val(b.m_name);
				$('#rank').val(b.rank);
				$('#statuss').val(b.statuss);
				$('#file_name').val(b.imagepic);

				  var dob = b.dateofbirth;
		          var dobb = new Date(dob);
		          var ageDifMs = Date.now() - dobb.getTime();
		          var ageDate = new Date(ageDifMs); 
		          var age = Math.abs(ageDate.getUTCFullYear() - 1970);


				$('#age').val(age);
				if(dob=="0000-00-00"){
					$('#age').val("");
				}

				$('#emp_statuss').load('controller/controller.otherinfo.php?demp_stat',function(){
					$('#emp_statuss').val(b.emp_statuss);
				});

				$('#company').load('controller/controller.otherinfo.php?dcompany',function(){
					$('#company').val(b.company);
				});
				document.getElementById("personal_image").src = b.imagepic;

				$('#department').load('controller/controller.otherinfo.php?ddepartment',function(){
					$('#department').val(b.department);
				});
				
				$('#nickname').val(b.nickname);
				$('#dateofbirth').val(b.dateofbirth !== '0000-00-00' ? b.dateofbirth : '');
				$('#gender').val(b.gender);
				$('#weight').val(b.weight);
				$('#height').val(b.height);
				$('#marital_status').val(b.marital_status);
				$('#birth_place').val(b.birth_place);
				$('#blood_type').val(b.blood_type);
				$('#contact_name').val(b.contact_name);
				$('#contact_address').val(b.contact_address);
				$('#contact_telno').val(b.contact_telno);
				$('#contact_celno').val(b.contact_celno);
				$('#contact_relation').val(b.contact_relation);
				$('#leave_balance').val(b.leave_balance);
			}
		});

		$('#emp_statuss').on('change',function(){
			var emp_statuss = $('#emp_statuss').val();
			if(emp_statuss=="Resigned" || emp_statuss=="Terminated"){
				$('#statuss').val("Inactive");
			}else{
				$('#statuss').val("Active");
			}
		});

		$('#contact_celno').on('keyup',function(){
			var contact_celno = $('#contact_celno').val();
			var len = contact_celno.length;
			if(len==4){
				
				$('#contact_celno').val(contact_celno+"-");
			}

		});


		$('#contact_telno').on('keyup',function(){
			var contact_telno = $('#contact_telno').val();
			var len = contact_telno.length;
			if(len==4){
				
				$('#contact_telno').val(contact_telno+"-");
			}

		});

	});

	$('form').on('submit', function (e) {

		e.preventDefault();
		confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
		
});

function save_callback(){
	var formData = new FormData($("#form")[0]);
	$.ajax({
		url:"controller/controller.otherinfo.php?editotherinfo",
		method:"POST",
		data: formData,
		processData: false,
		contentType: false,
		success:function(data){
			$.Toast("Successfully Saved", successToast);
			setTimeout(() => {
				var b = $.parseJSON(data);
				var employeeno = b.employeeno;
				window.location.href="otherinfo.php?employeeno="+employeeno;
			}, 1000)
			// console.log(data)
		}
	});
}


// function lb(){

//        $.ajax({
//         url:"controller/controller.leavebalance.php?leave_credits_load",
//         method:"POST",
//         data:{
//           id:""
//         },success:function(){

//         }
//       });
       
//   }
//   lb();
	function editcontact(){
		$('.master_input').addClass('master_input_open');
		$('.master_input').removeClass('master_input');
		$('#btnsave').removeClass('d-none');
		$('#btncancel').removeClass('d-none');
		$('#btnedit').addClass('d-none');
	}

	function canceledit(){
		var employeeno = $('#employeeno').val();
		window.location.href="otherinfo.php?employeeno="+employeeno;
	}

	function goto(linkk){
		var employeeno = $('#employeeno').val();
		var link = linkk+"?employeeno="+employeeno;
		window.location.href=link;
	}
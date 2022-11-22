var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
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
		var emp_id = $('#emp_id').val();
		$.ajax({
			url:"controller/controller.otherinfo.php?selectotherinfo",
			method:"POST",
			data:{
				emp_id:emp_id
			},success:function(data){
				var b = $.parseJSON(data);
				$('#emp_no').val(b.emp_no);
				$('#f_name').val(b.f_name);
				$('#l_name').val(b.l_name);
				$('#m_name').val(b.m_name);
				$('#rank').val(b.rank);
				$('#statuss').val(b.statuss);

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
				if(b.imagepic=="" || b.imagepic==null){
					document.getElementById("personal_image").src = "usera.png";
				}else{
					document.getElementById("personal_image").src = "personal_picture/"+b.imagepic;
				}

				$('#department').load('controller/controller.otherinfo.php?ddepartment',function(){
					$('#department').val(b.department);
				});
				
				$('#nickname').val(b.nickname);
				$('#dateofbirth').val(b.dateofbirth);
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
				var id = b.id;
				window.location.href="otherinfo.php?id="+id;
			}, 1000)
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
		var id = $('#emp_id').val();
		window.location.href="otherinfo.php?id="+id;
	}

	function goto(linkk){
		var id = $('#emp_id').val();
		var link = linkk+"?id="+id;
		window.location.href=link;
	}
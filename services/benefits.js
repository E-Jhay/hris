var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		$("#master_benefits").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});
		var emp_id = $('#emp_id').val();
		$.ajax({
			url:"controller/controller.benefits.php?selectbenefit",
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

				if(b.imagepic=="" || b.imagepic==null){
					document.getElementById("personal_image").src = "usera.png";
				}else{
					document.getElementById("personal_image").src = "personal_picture/"+b.emp_no+"/"+b.imagepic;
					// document.getElementById("personal_image").src = "personal_picture/"+b.imagepic;
				}
				
				$('#emp_statuss').load('controller/controller.benefits.php?demp_stat',function(){
					$('#emp_statuss').val(b.emp_statuss);
				});

				$('#company').load('controller/controller.benefits.php?dcompany',function(){
					$('#company').val(b.company);
				});

				$('#department').load('controller/controller.benefits.php?ddepartment',function(){
					$('#department').val(b.department);
				});

				$('#dependent1').val(b.dependent1);
				$('#age1').val(b.age1);
				$('#sex1').val(b.sex1);
				$('#dependent2').val(b.dependent2);
				$('#age2').val(b.age2);
				$('#sex2').val(b.sex2);
				$('#dependent3').val(b.dependent3);
				$('#age3').val(b.age3);
				$('#sex3').val(b.sex3);
				$('#dependent4').val(b.dependent4);
				$('#age4').val(b.age4);
				$('#sex4').val(b.sex4);
				$('#dependent5').val(b.dependent5);
				$('#age5').val(b.age5);
				$('#sex5').val(b.sex5);
				$('#leave_balance').val(b.leave_balance);
				$('#relation1').val(b.relation1);
				$('#relation2').val(b.relation2);
				$('#relation3').val(b.relation3);
				$('#relation4').val(b.relation4);
				$('#relation5').val(b.relation5);
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

	});


	$('form').on('submit', function (e) {

            e.preventDefault();
            confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
});

function save_callback(){
				$.ajax({
	        	url:"controller/controller.benefits.php?editbenefits",
	        	method:"POST",
	        	data: $('form').serialize(),
	        	success:function(data){
					$.Toast("Successfully Saved", successToast);
					setTimeout(() => {
						var b = $.parseJSON(data);
						var id = b.id;
						window.location.href="benefits.php?id="+id;
					}, 1000)
	        		
	        	}
	        });
}

  // function lb(){

  //      $.ajax({
  //       url:"controller/controller.leavebalance.php?leave_credits_load",
  //       method:"POST",
  //       data:{
  //         id:""
  //       },success:function(){

  //       }
  //     });
       
  // }
  // lb();
  
	function editcontact(){
		$('.master_input').addClass('master_input_open');
		$('.master_input').removeClass('master_input');
		$('#btnsave').removeClass('d-none');
		$('#btncancel').removeClass('d-none');
		$('#btnedit').addClass('d-none');
	}

	function canceledit(){
		var id = $('#emp_id').val();
		window.location.href="benefits.php?id="+id;
	}

	function goto(linkk){
		var id = $('#emp_id').val();
		var link = linkk+"?id="+id;
		window.location.href=link;
	}
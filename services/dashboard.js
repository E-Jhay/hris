var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

		$("#master_contact").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});

		$('#telephoneno').on('keyup',function(){
			var telephoneno = $('#telephoneno').val();
			var len = telephoneno.length;
			if(len==4){
				
				$('#telephoneno').val(telephoneno+"-");
			}

		});

		$('#contactno').on('keyup',function(){
			var contactno = $('#contactno').val();
			var len = contactno.length;
			if(len==4){
				
				$('#contactno').val(contactno+"-");
			}

		});


		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.dashboard.php?selectcontact",
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
				document.getElementById("personal_image").src = b.imagepic;
				
				$('#emp_statuss').load('controller/controller.dashboard.php?demp_stat',function(){
					$('#emp_statuss').val(b.emp_statuss);
				});

				$('#company').load('controller/controller.dashboard.php?dcompany',function(){
					$('#company').val(b.company);
				});


				$('#department').load('controller/controller.dashboard.php?ddepartment',function(){
					$('#department').val(b.department);
				});
				
				$('#nationality').val(b.nationality);
				$('#driver_license').val(b.driver_license);
				$('#driver_expdate').val(b.driver_expdate);
				$('#street').val(b.street);
				$('#municipality').val(b.municipality);
				$('#province').val(b.province);
				$('#telephoneno').val(b.telephoneno);
				$('#contactno').val(b.contactno);
				$('#corp_email').val(b.corp_email);
				$('#personal_email').val(b.personal_email);			
				$('#leave_balance').val(b.leave_balance);
				$('#dept_head_email').val(b.dept_head_email);
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

		$('#li1').addClass("active");
		
	});

	$('form').on('submit', function (e) {

            e.preventDefault();
            confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
            
            

      });

	function save_callback(){
		$.ajax({
	  	url:"controller/controller.dashboard.php?editcontactemp",
	  	method:"POST",
	  	data: $('form').serialize(),
	  	success:function(data){
			$.Toast("Successfully Saved", successToast);
			setTimeout(() => {
				var b = $.parseJSON(data);
				var employeeno = b.employeeno;
				window.location.href="dashboard.php?employeeno="+employeeno;
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
		var employeeno = $('#employeeno').val();
		window.location.href="dashboard.php?employeeno="+employeeno;
	}

	function goto(linkk){
		var employeeno = $('#employeeno').val();
		var link = linkk+"?employeeno="+employeeno;
		window.location.href=link;
	}
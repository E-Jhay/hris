var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		$("#master_contract").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});
		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.contract.php?selectcontract",
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

				if(b.imagepic=="" || b.imagepic==null){
					document.getElementById("personal_image").src = "usera.png";
				}else{
					document.getElementById("personal_image").src = "personal_picture/"+b.emp_no+"/"+b.imagepic;
					// document.getElementById("personal_image").src = "personal_picture/"+b.imagepic;
				}
				
				$('#emp_statuss').load('controller/controller.contract.php?demp_stat',function(){
					$('#emp_statuss').val(b.emp_statuss);
				});

				$('#company').load('controller/controller.contract.php?dcompany',function(){
					$('#company').val(b.company);
				});

				$('#department').load('controller/controller.contract.php?ddepartment',function(){
					$('#department').val(b.department);
				});

				$('#job_title').load('controller/controller.contract.php?d_jobtitle',function(){
					$('#job_title').val(b.job_title);
				});

				$('#job_category').load('controller/controller.contract.php?d_jobcategory',function(){
					$('#job_category').val(b.job_category);
				});

				$('#date_hired').val(b.date_hired !== '0000-00-00' ? b.date_hired : '');
				$('#eoc').val(b.eoc !== '0000-00-00' ? b.eoc : '');
				$('#regularized').val(b.regularized !== '0000-00-00' ? b.regularized : '');
				$('#preterm').val(b.preterm !== '0000-00-00' ? b.preterm : '');
				$('#resigned').val(b.resigned !== '0000-00-00' ? b.resigned : '');
				$('#retired').val(b.retired !== '0000-00-00' ? b.retired : '');
				$('#terminated').val(b.terminated !== '0000-00-00' ? b.terminated : '');
				$('#lastpay').val(b.lastpay !== '0000-00-00' ? b.lastpay : '');
				$('#remarks').val(b.remarks !== '0000-00-00' ? b.remarks : '');
				$('#leave_balance').val(b.leave_balance !== '0000-00-00' ? b.leave_balance : '');
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
	        	url:"controller/controller.contract.php?editcontractemp",
	        	method:"POST",
	        	data: $('form').serialize(),
	        	success:function(data){
					$.Toast("Successfully Saved", successToast);
					setTimeout(() => {
						var b = $.parseJSON(data);
						var employeeno = b.employeeno;
						window.location.href="contractinfo.php?employeeno="+employeeno;
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
		window.location.href="contractinfo.php?employeeno="+employeeno;
	}

	function goto(linkk){
		var employeeno = $('#employeeno').val();
		var link = linkk+"?employeeno="+employeeno;
		window.location.href=link;
	}
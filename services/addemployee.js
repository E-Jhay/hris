var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

		$("#pim_add").addClass("active_tab");
	  $('.drawer').hide();
	  $('.drawer').on('click',function(){
	   $('.navnavnav').slideToggle();
	  });

		$('#contactno').on('keyup',function(){
			var contactno = $('#contactno').val();
			var len = contactno.length;
			if(len==4){
				
				$('#contactno').val(contactno+"-");
			}

		});
		
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

		$('#dateofbirth').on('change',function(){
			var dateofbirth = new Date($('#dateofbirth').val());
			var today = new Date();
			var age = today.getFullYear() - dateofbirth.getFullYear();
			var m = today.getMonth() - dateofbirth.getMonth();
			if (m < 0 || (m === 0 && today.getDate() < dateofbirth.getDate())) {
				age--;
			}
			$('#age').val(age);
		});

		$('#employment_status').load('controller/controller.employee.php?demp_stat');
		$('#company').load('controller/controller.employee.php?dcompany');
		$('#department').load('controller/controller.employee.php?department');
		$('#job_title').load('controller/controller.employee.php?job_title');
		$('#job_category').load('controller/controller.employee.php?job_category');
		$.ajax({
			url:"controller/controller.employee.php?generateEmployeeNumber",
			method:"GET",
			success:function(data){
				$('#employeeno').val(data);
				$('#employeenoProxy').val(data);
				console.log(data)
			}

		});
		

    	$('form').on('submit', function (e) {
    		e.preventDefault();
    		confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
      });
    	var randomstring = Math.random().toString(36).slice(-8);
		$('#password').val(randomstring);

	});
	
	function save_callback(){
		var formData = new FormData($("#form")[0]);
		$.ajax({
			url:"controller/controller.employee.php?addnewemployee",
			method:"POST",
			data: formData,
			processData: false,
			contentType: false,
			success:function(){
				$.Toast("Successfully Saved", successToast);
				setTimeout(() => {
					window.location.href="employee.php";
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


  function backmodule(){
  	window.location.href="module.php";
  }

  function goto(linkk){
	window.location.href=linkk;
  }
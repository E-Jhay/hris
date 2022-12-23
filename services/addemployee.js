var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
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

		$('#tin').on('keyup',function(){
			var tin = $('#tin').val();
			var len = tin.length;
			if(len==3){
				
				$('#tin').val(tin+"-");
			}

			if(len==7){
				
				$('#tin').val(tin+"-");
			}

			if(len==11){
				
				$('#tin').val(tin+"-");
			}

		});

		$('#sss').on('keyup',function(){
			var sss = $('#sss').val();
			var len = sss.length;
			if(len==2){
				
				$('#sss').val(sss+"-");
			}

			if(len==10){
				
				$('#sss').val(sss+"-");
			}

		});

		$('#phic').on('keyup',function(){
			var phic = $('#phic').val();
			var len = phic.length;
			if(len==2){
				
				$('#phic').val(phic+"-");
			}

			if(len==12){
				
				$('#phic').val(phic+"-");
			}

			

		});

		$('#hdmf').on('keyup',function(){
			var hdmf = $('#hdmf').val();
			var len = hdmf.length;
			if(len==4){
				
				$('#hdmf').val(hdmf+"-");
			}

			if(len==9){
				
				$('#hdmf').val(hdmf+"-");
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
				var parseData = $.parseJSON(data);
				$('#employeeno').val(parseData.data.generatedEmployeeId);
				$('#employeenoProxy').val(parseData.data.generatedEmployeeId);
				$('#id_number').val(parseData.data.latestIdNumber);
				// console.log(parseData.data.generatedEmployeeId, parseData.data.latestIdNumber)
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
		const job_title = $('#job_title').val()
		const job_category = $('#job_category').val()
		const department = $('#department').val()
		const employment_status = $('#employment_status').val()
		const company = $('#company').val()
		const date_hired = $('#date_hired').val()

		let errors = []

		if(!job_title) errors.push('Job title')
		if(!job_category) errors.push('Job category')
		if(!department) errors.push('Department')
		if(!employment_status) errors.push('Employment Status')
		if(!company) errors.push('Company')
		if(!date_hired) errors.push('Date hired')
		if(!errors.length <= 0) {
			return $.Toast(errors.join(', ') + ' are required', errorToast)
		}
		var formData = new FormData($("#form")[0]);
		$.ajax({
			url:"controller/controller.employee.php?addnewemployee",
			method:"POST",
			data: formData,
			processData: false,
			contentType: false,
			success:function(data){
				const b = $.parseJSON(data)
				if(b.type === 'error')
					$.Toast(b.message, errorToast)
				else {
					$.Toast(b.message, successToast);
					setTimeout(() => {
						window.location.href="employee.php";
					}, 2000)
				}
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
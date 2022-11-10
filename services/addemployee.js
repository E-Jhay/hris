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

		$('#employment_status').load('controller/controller.employee.php?demp_stat');
		$('#company').load('controller/controller.employee.php?dcompany');

    	$('form').on('submit', function (e) {
    		e.preventDefault();
    		confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
      });
    	var randomstring = Math.random().toString(36).slice(-8);
		$('#password').val(randomstring);

	});
	
	function save_callback(){
					$.ajax({
		        	url:"controller/controller.employee.php?addnewemployee",
		        	method:"POST",
		        	data: $('form').serialize(),
		        	success:function(){
		        		$.Toast("Successfully Saved", successToast);
		        		window.location.href="employee.php";
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
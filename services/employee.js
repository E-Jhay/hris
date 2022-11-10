var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

	  $("#pim_list").addClass("active_tab");
	  $('.drawer').hide();
	  $('.drawer').on('click',function(){
	   $('.navnavnav').slideToggle();
	  });

		$('#statusdd').on('change',function(){
			var statusdd = $('#statusdd').val();
			$('#tbl_employee').DataTable().destroy();
			loademployee(statusdd);
		});


	});

	// function lb(){

	// 		 $.ajax({
	// 			url:"controller/controller.leavebalance.php?leave_credits_load",
	// 			method:"POST",
	// 			data:{
	// 				id:""
	// 			},success:function(){

	// 			}
	// 		});
			 
	// }
	// lb();

	function loademployee(statusdd){
    
    $('#tbl_employee').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "pageLength":50,
              "ajax" : "controller/controller.employee.php?loademployee&statusdd="+statusdd,
              "columns" : [

                    { "data" : "pic"},
                    { "data" : "employeeno"},
                    { "data" : "lastname"},
                    { "data" : "firstname"},
                    { "data" : "middlename"},
                    { "data" : "job_title"},
                    { "data" : "employment_status"},
                    { "data" : "company"},
                    { "data" : "action"}

                ],
         });
  }
  var statusdd = "Active";
  loademployee(statusdd);

  function editemp(id){
  	window.location.href="dashboard.php?id="+id;
  }
  function deleteemp(id){
  	confirmed("delete",deleteemp_callback, "Do you really want to delete this?", "Yes", "No",id);
  }

  function deleteemp_callback(id){
  		$.ajax({
	  		url:"controller/controller.employee.php?deleteemployee",
	  		method:"POST",
	  		data:{
	  			id:id
	  		},success:function(){
	  			$.Toast("Successfully Deleted", errorToast);
	  			$('#myModal').modal('hide');
		      $('#tbl_employee').DataTable().destroy();
		      loademployee("Active");
	  		}
	  	});
  }

  function backmodule(){
  	window.location.href="module.php";
  }

  function goto(linkk){
		window.location.href=linkk;
  }
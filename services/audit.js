var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
       $("#admin_audit").addClass("active_tab");
       $('.drawer').hide();
       $('.drawer').on('click',function(){
        $('.navnavnav').slideToggle();
       });
	});

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

	function load_audit(){
    
    $('#tbl_audit').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "pageLength":50,
              "ajax" : "controller/controller.announcement.php?load_audit",
              "columns" : [
                    
                    { "data" : "audit_date"},
                    { "data" : "action_type"},
                    { "data" : "audit_action"},
                    { "data" : "end_user"}

                ],
         });
  }
  load_audit();
  function backmodule(){
  	window.location.href="module.php";
  }

  function goto(linkk){
	window.location.href=linkk;
  }
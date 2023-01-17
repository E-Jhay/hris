var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		 $("#admin_user").addClass("active_tab");
     $('#usertype').load('controller/controller.admin.php?loadusertype');

     $('#usertype').on('change',function(){
        var usertype = $('#usertype').val();
        if(usertype=="admin"){
          $('#approverr').show();
          $('#1').prop('checked', true)
          $('#2').prop('checked', true)
          $('#3').prop('checked', true)
        }else{
          $('#approverr').hide();
          $('#approverr').val("no");
          $('#1').prop('checked', false)
          $('#2').prop('checked', false)
        }
     });
     $('#div_user_role').hide();
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

  function btnadduserrole(){
    $('#userrole_modal').modal('show');
    $('#modal_userroleid').val("");
    $('#modal_userrole').val("");
    $('#modal_userroletype').val("");

    $('#saveuserrolebtn').show();
    $('#updateuserrolebtn').hide();

  }

  function btn_saveuserrole(){
    var modal_userroleid = $('#modal_userroleid').val();
    var modal_userrole = $('#modal_userrole').val();
    var modal_userroletype = $('#modal_userroletype').val();
    $.ajax({
      url:"controller/controller.admin.php?adduserrole",
      method:"POST",
      data:{
        modal_userroleid: modal_userroleid,
        modal_userrole: modal_userrole,
        modal_userroletype: modal_userroletype
      },success:function(){
        $.Toast("Successfully Saved", successToast);
        $('#tbl_user_role').DataTable().destroy();
        loaduser_role();
        $('#userrole_modal').modal('hide');
      }
    });
    
  }
  function btn_updateuserrole(){
    var modal_userroleid = $('#modal_userroleid').val();
    var modal_userrole = $('#modal_userrole').val();
    var modal_userroletype = $('#modal_userroletype').val();
    $.ajax({
      url:"controller/controller.admin.php?updateuserrole",
      method:"POST",
      data:{
        modal_userroleid: modal_userroleid,
        modal_userrole: modal_userrole,
        modal_userroletype: modal_userroletype
      },success:function(){
        $.Toast("Successfully Saved", successToast);
        $('#tbl_user_role').DataTable().destroy();
        loaduser_role();
        $('#userrole_modal').modal('hide');
      }
    });
    
  }

  function edituser_role(id, usertype, userrole){
      $('#modal_userroleid').val(id);
      $('#modal_userrole').val(userrole);
      $('#modal_userroletype').val(usertype);
      $('#userrole_modal').modal('show');
      $('#saveuserrolebtn').hide();
      $('#updateuserrolebtn').show();
  }
  function deleteuser_role(id){
    confirmed("delete",deleteuser_role_callback, "Do you really want to delete this?", "Yes", "No",id);
  }
  function deleteuser_role_callback(id){
        $.ajax({
          url:"controller/controller.admin.php?deleteuserrole",
          method:"POST",
          data:{
            id:id
          },success:function(){
            $.Toast("Successfully Deleted", errorToast);
            $('#tbl_user_role').DataTable().destroy();
            loaduser_role();
          }
        });
  }

 	function btnuser(){
 		$('#div_user').show();
 		$('#div_user_role').hide();
 		$("#luser").addClass("active");
 		$("#luser_role").removeClass("active");
 	}

	function btnuserrole(){
		$('#div_user').hide();
 		$('#div_user_role').show();
 		$("#luser").removeClass("active");
 		$("#luser_role").addClass("active");
	}


	var a = 0;
	setInterval(function(){
	 var cars = ["violet","mediumseagreen", "dodgerblue", "#ff4d4d"];
	 
	 a++;
	 if(a==4){
	 	a=0;
	 }
	}, 600);

	function loaduser(){
    
    $('#tbl_user').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "pageLength":50,
              "scrollX": true,
              "ajax" : "controller/controller.admin.php?loaduser",
              "columns" : [
                    
                    { "data" : "employeeno"},
                    { "data" : "fullname"},
                    { "data" : "username"},
                    { "data" : "password"},
                    { "data" : "usertype"},
                    { "data" : "active_status"},
                    { "data" : "action"}

                ],
         });
  }
  loaduser();

  function loaduser_role(){
    
    $('#tbl_user_role').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "scrollX": true,
              "ajax" : "controller/controller.admin.php?loaduser_role",
              "columns" : [
                    
                    { "data" : "user_role"},
                    { "data" : "user_role_type"},
                    { "data" : "action"}

                ],
         });
  }
  loaduser_role();
  
  $('#1').on('change', function() { 
      // From the other examples
      if (this.checked) {
        $('#approverr').show();
      } else {
        $('#approverr').hide();
      }
  });
  $('#2').on('change', function() { 
      // From the other examples
      if (this.checked) {
        $('#approverr').show();
      } else {
        $('#approverr').hide();
      }
  });

  function edituser(id,fullname,username,password,empstatus,usertype,userrole,approverr){
    $('#1').prop("checked",false);
    $('#2').prop("checked",false);
    $('#3').prop("checked",false);
    if(userrole !=""){
      var strArray = userrole.split(",");

        for(var i = 0; i < strArray.length; i++){

            $("#"+strArray[i]). prop("checked", true);
        }
    }
    
    if(usertype=="admin"){
      $('#approverr').show();
    }else{
      $('#approverr').hide();
    }


  	$('#usermodal').modal('show');
    $('#approverr').val(approverr);
  	$('#user_id').val(id);
		$('#fullname').val(fullname);
		$('#username').val(username);
		$('#password').val(password);
		$('#usertype').val(usertype);
		$('#active_status').val(empstatus);

  }


  function backmodule(){
  	window.location.href="module.php";
  }

  function updateuser(){

  	var user_id = $('#user_id').val();
	var fullname = $('#fullname').val();
	var username = $('#username').val();
	var password = $('#password').val();
	var usertype = $('#usertype').val();
	var active_status =	$('#active_status').val();
  var approverr = $('#approverr').val();
  var roles = [];

  $.each($("input[name='role']:checked"), function(){
    roles.push($(this).val());
  });
  var userrole = roles.length > 0 ? roles.join(",") : '3';
	$.ajax({
		url:"controller/controller.admin.php?updateuser",
		method:"POST",
		data:{

			user_id : user_id,
			fullname : fullname,
			username : username,
			password : password,
			usertype : usertype,
			active_status : active_status,
      userrole : userrole,
      approverr: approverr

		},
		success:function(){
			$.Toast("Successfully Saved", successToast);
			$('#usermodal').modal('hide');
			$('#tbl_user').DataTable().destroy();
		    loaduser();
		}
	});

  }

  function goto(linkk){
	window.location.href=linkk;
  }
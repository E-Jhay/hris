var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
  $("#ess_notif").addClass("active_tab");
  $('.drawer').hide();
  $('.drawer').on('click',function(){
    $('.navnavnav').slideToggle();
  });

});

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

  function loadnotifleave(employeenum){
                          
    $('#tbl_notif_leave').DataTable({  
        "aaSorting": [],
        "bSearching": false,
        "bFilter": false,
        "bInfo": false,
        "bPaginate": true,
        "bLengthChange": false,
        "pagination": false,
        "ajax" : "controller/controller.notifications.php?loadnotifleave&employeenum="+employeenum,
        "columns" : [
              
              { "data" : "trail"},
              { "data" : "date_time"}

          ],
    });
  }
  var employeenum = $('#employeenum').val();
  loadnotifleave(employeenum);


  function backmodule(){
  	window.location.href="module.php";
  }

  function goto(linkk){ 
	  window.location.href=linkk;

    if(linkk=="ess_payslip.php"){

      var employeeno = $('#employeeno').val();
      $.ajax({
        url:"controller/controller.notifications.php?readpayslip",
        method:"POST",
        data:{
          employeeno:employeeno
        },success:function(){
          window.location.href=linkk;
        }
      });

    }else{
      window.location.href=linkk;
    }

  }

  function count_leaveapp(){

    var employeenoo = $('#employeeno').val();
    $.ajax({
      url:"controller/controller.notifications.php?count_leaveapp",
      method:"POST",
      data:{
        employeenoo : employeenoo
      },success:function(data){
        var b = $.parseJSON(data);
        
        if(b.count > 0){
          $('#leave_app_number').show();
          $('#leave_app_number').html(b.count);
        }else{
          $('#leave_app_number').hide();
        }

      }

    });
  }
  count_leaveapp();

  function count_otapp(){

    var employeenoo = $('#employeeno').val();
    $.ajax({
      url:"controller/controller.notifications.php?count_otapp",
      method:"POST",
      data:{
        employeenoo:employeenoo
      },success:function(data){
        var b = $.parseJSON(data);
        
      if(b.count > 0){
        $('#ot_app_number').show();
        $('#ot_app_number').html(b.count);
      }else{
        $('#ot_app_number').hide();
      }

      }
    });
  }
  count_otapp();

  function count_payslip(){

    var employeenoo = $('#employeeno').val();
    $.ajax({
      url:"controller/controller.notifications.php?count_payslip",
      method:"POST",
      data:{
        employeenoo:employeenoo
      },success:function(data){
        var b = $.parseJSON(data);
        
      if(b.count > 0){
        $('#payslip_number').show();
        $('#payslip_number').html(b.count);
      }else{
        $('#payslip_number').hide();
      }

      }
    });
  }
  count_payslip();

  function count_reimbursement(){

    var employeenoo = $('#employeeno').val();
    $.ajax({
      url:"controller/controller.notifications.php?count_reimbursement",
      method:"POST",
      data:{
        employeenoo:employeenoo
      },success:function(data){
        var b = $.parseJSON(data);
      if(b.count > 0){
        $('#reim_app_number').show();
        $('#reim_app_number').html(b.count);
      }else{
        $('#reim_app_number').hide();
      }

      }
    });
  }
  count_reimbursement();
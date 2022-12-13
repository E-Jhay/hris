var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		  $("#ess_payslip").addClass("active_tab");
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

  function loadpayslip(employeeno){

      $('#tbl_payslip').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "pageLength": 5,
              "ajax" : "controller/controller.payslip.php?loadpayslip_ess&employeeno="+employeeno,
              "columns" : [
                    
                    { "data" : "file_name"},
                    { "data" : "pay_period"},
                    { "data" : "process_date"},
                    { "data" : "action"}

                ],
         });
  }
  var employeeno = $('#employeeno').val();
  loadpayslip(employeeno);


  function backmodule(){
  	window.location.href="module.php";
  }

  function goto(linkk){ 

    	if(linkk=="notification.php"){

        var employeeno = $('#employeeno').val();
        $.ajax({
          url:"controller/controller.payslip.php?readleave",
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
      url:"controller/controller.payslip.php?count_leaveapp",
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
      url:"controller/controller.payslip.php?count_otapp",
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

  function count_reimbursement(){

    var employeenoo = $('#employeeno').val();
    $.ajax({
      url:"controller/controller.payslip.php?count_reimbursement",
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

  function count_payslip(){
    const employeenoo = $('#employeeno').val();
      $.ajax({
          url:"controller/controller.info.php?count_payslip",
          method:"POST",
          data:{
        employeenoo:employeenoo
      },
          success:function(data){
              var b = $.parseJSON(data);
              
            if(b.count > 0){
                $('#payslip_number').show();
                $('#payslip_number').html(b.count);
            }else{
                $('#payslip_number').hide();
            }
          console.log(b.count)
  
          }
      });
  }
  count_payslip();

  function dl_payslip(filename,employeeno){
    var link = "payslips/"+employeeno+"/"+filename;
    window.open(link);
  }
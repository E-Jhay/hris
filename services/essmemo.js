var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
	   
    $("#ess_memo").addClass("active_tab");
    $('.drawer').hide();
    $('.drawer').on('click',function(){
      $('.navnavnav').slideToggle();
    });

     var notif_number = $('#notif_number').html();
    if(notif_number > 0){
      $('#notif_number').show();
    }else{
      $('#notif_number').hide();
    }

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


  function dl_memo(filename,employeeno){
    window.open("memo/"+employeeno+'/'+filename);
  }


  function load_memo(){
      var employeeno = $('#employeeno').val();
      $('#tbl_memo').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.essmemo.php?load_memoess&employeeno="+employeeno,
              "columns" : [
                    
                    { "data" : "employeeno"},
                    { "data" : "memo"},
                    { "data" : "date"},
                    { "data" : "action"}

                ],
         });
  }
  load_memo();
  

  function backmodule(){
    window.location.href="module.php";
  }

  function goto(linkk){

  if(linkk=="notification.php"){
    var employeeno = $('#employeeno').val();
    $.ajax({
      url:"controller/controller.essmemo.php?readleave",
      method:"POST",
      data:{
        employeeno:employeeno
      },success:function(){
        window.location.href=linkk;
      }
    });
  }else if(linkk=="ess_payslip.php"){

    var employeeno = $('#employeeno').val();
    $.ajax({
      url:"controller/controller.essmemo.php?readpayslip",
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
      url:"controller/controller.essmemo.php?count_leaveapp",
      method:"POST",
      data:{
        employeenoo:employeenoo
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
      url:"controller/controller.essmemo.php?count_otapp",
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
      url:"controller/controller.essmemo.php?count_payslip",
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
      url:"controller/controller.essmemo.php?count_reimbursement",
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
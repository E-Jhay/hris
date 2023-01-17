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
      "scrollX": true,
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

function dl_payslip(filename,employeeno){
  var link = "payslips/"+employeeno+"/"+filename;
  window.open(link);
}
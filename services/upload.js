var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    $("#ess_uploadpayslip").addClass("active_tab");
    $('.drawer').hide();
    $('.drawer').on('click',function(){
       $('.navnavnav').slideToggle();
    });

		 $('#employeeddown').load('controller/controller.upload.php?employeelist_surname');

     var notif_number = $('#notif_number').html();
    if(notif_number > 0){
      $('#notif_number').show();
    }else{
      $('#notif_number').hide();
    }

	});

function upload_pslip(){
  $('#userrole_modal').modal('show');
}

$('#formModal').on('submit', (e) => {
  e.preventDefault()
  confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No")
})

function save_callback() {
  const dateTo = $('#dateto').val()
  const dateFrom = $('#datefrom').val()
  if(dateFrom > dateTo) return $.Toast('Error: Invalid dates', errorToast)

  const formData = new FormData($("#formModal")[0])

  $.ajax({
    url:"controller/controller.upload.php?uploadpayslip",
			method:"POST",
			data: formData,
			processData: false,
			contentType: false,
			beforeSend: function(){
				$("#btn_submit").text('Loading....')
				$("#btn_submit").attr('disabled', true)
			},
			complete: function(){
				$("#btn_submit").text('Upload')
				$("#btn_submit").attr('disabled', false)
			},
			success:function(data){
        const b = $.parseJSON(data)
        if(b.type === 'error')
          $.Toast(b.message, errorToast)
        else{
          $.Toast(b.message, successToast)
          $('#userrole_modal').modal('hide');
          $('#formModal').trigger("reset");
          $('#tbl_payslip').DataTable().destroy();
          loadpayslip();
        }
      }
  })

}
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


function dl_payslip(filename,employeeno){
    var link = "payslips/"+employeeno+"/"+filename;
    window.open(link);
  }

function delete_payslip(id,filename,employeeno){
    var data = [id,filename,employeeno];
    confirmed("delete",delete_payslip_callback, "Do you really want to delete this?", "Yes", "No", data);

}

function delete_payslip_callback(data){
    var id = data[0];
    var filename = data[1];
    var employeeno = data[2];
    $.ajax({
        url:"controller/controller.upload.php?deletepayslip",
        method:"POST",
        data:{
          id: id,
          filename: filename,
          employeeno: employeeno
        },success:function(){
          $.Toast("Successfully Deleted", successToast);
          $('#tbl_payslip').DataTable().destroy();
          loadpayslip();
        }
    });
}

  function loadpayslip(){

      $('#tbl_payslip').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "pageLength": 20,
              "ajax" : "controller/controller.upload.php?loadpayslip",
              "columns" : [
                    
                    { "data" : "employeeno"},
                    { "data" : "file_name"},
                    { "data" : "pay_period"},
                    { "data" : "process_date"},
                    { "data" : "action"}

                ],
      });
  }
  loadpayslip();
  

  function backmodule(){
    window.location.href="module.php";
  }

  function goto(linkk){

  if(linkk=="notification.php"){
    var employeeno = $('#employeeno').val();
    $.ajax({
      url:"controller/controller.upload.php?readleave",
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
      url:"controller/controller.upload.php?readpayslip",
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

  // function count_leaveapp(){

  //   var employeenoo = $('#employeeno').val();
  //   $.ajax({
  //     url:"controller/controller.upload.php?count_leaveapp",
  //     method:"POST",
  //     data:{
  //       employeenoo:employeenoo
  //     },success:function(data){
  //       var b = $.parseJSON(data);
        
  //     if(b.count > 0){
  //       $('#leave_app_number').show();
  //       $('#leave_app_number').html(b.count);
  //     }else{
  //       $('#leave_app_number').hide();
  //     }

  //     }
  //   });
  // }
  // count_leaveapp();
  // function count_otapp(){

  //   var employeenoo = $('#employeeno').val();
  //   $.ajax({
  //     url:"controller/controller.upload.php?count_otapp",
  //     method:"POST",
  //     data:{
  //       employeenoo:employeenoo
  //     },success:function(data){
  //       var b = $.parseJSON(data);
        
  //     if(b.count > 0){
  //       $('#ot_app_number').show();
  //       $('#ot_app_number').html(b.count);
  //     }else{
  //       $('#ot_app_number').hide();
  //     }

  //     }
  //   });
  // }
  // count_otapp();

  // function count_payslip(){

  //   var employeenoo = $('#employeeno').val();
  //   $.ajax({
  //     url:"controller/controller.upload.php?count_payslip",
  //     method:"POST",
  //     data:{
  //       employeenoo:employeenoo
  //     },success:function(data){
  //       var b = $.parseJSON(data);
        
  //     if(b.count > 0){
  //       $('#payslip_number').show();
  //       $('#payslip_number').html(b.count);
  //     }else{
  //       $('#payslip_number').hide();
  //     }

  //     }
  //   });
  // }
  // count_payslip();

  // function count_reimbursement(){

  //   var employeenoo = $('#employeeno').val();
  //   $.ajax({
  //     url:"controller/controller.upload.php?count_reimbursement",
  //     method:"POST",
  //     data:{
  //       employeenoo:employeenoo
  //     },success:function(data){
  //       var b = $.parseJSON(data);
  //     if(b.count > 0){
  //       $('#reim_app_number').show();
  //       $('#reim_app_number').html(b.count);
  //     }else{
  //       $('#reim_app_number').hide();
  //     }

  //     }
  //   });
  // }
  // count_reimbursement();
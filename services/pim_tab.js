function count_leaveapp(){

    $.ajax({
        url:"controller/controller.info.php?count_leaveapp",
        method:"POST",
        success:function(data){
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

    $.ajax({
        url:"controller/controller.info.php?count_otapp",
        method:"POST",
        success:function(data){
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

    $.ajax({
        url:"controller/controller.info.php?count_payslip",
        method:"POST",
        success:function(data){
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

    $.ajax({
        url:"controller/controller.info.php?count_reimbursement",
        method:"POST",
        success:function(data){
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
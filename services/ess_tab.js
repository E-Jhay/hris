function count_payslip(){
    const currentUser = $('#currentUser').val();
    $.ajax({
        url:"controller/controller.info.php?count_payslip",
        method:"POST",
        data:{
            currentUser:currentUser
        },success:function(data){
            const b = $.parseJSON(data);
            
          if(b.count > 0){
              $('#notif_number').show();
              $('#payslip_number').html(b.count);
          }else{
              $('#payslip_number').hide();
          }

        }
    });
}
count_payslip();

function count_notifications(){
    const currentUser = $('#currentUser').val();
    $.ajax({
        url:"controller/controller.info.php?count_notifications",
        method:"POST",
        data:{
            currentUser:currentUser
        },success:function(data){
            const b = $.parseJSON(data);
            
          if(b.total > 0){
              $('#notif_number').show();
              $('#notif_number').html(b.total);
          }else{
              $('#notif_number').hide();
          }
          if(b.leave > 0){
            $('#leave_notif_count').show();
            $('#leave_notif_count').html(b.leave);
          }else{
            $('#leave_notif_count').hide();
          }
          if(b.omnibus > 0){
              $('#omnibus_notif_count').show();
              $('#omnibus_notif_count').html(b.omnibus);
          }else{
              $('#omnibus_notif_count').hide();
          }
          if(b.overtime > 0){
              $('#overtime_notif_count').show();
              $('#overtime_notif_count').html(b.overtime);
          }else{
              $('#overtime_notif_count').hide();
          }

        }
    });
}
count_notifications();
// function count_notifications(){
//     const employeenum = $('#currentUser').val();
//     $.ajax({
//         url:"controller/controller.notifications.php?loadnotifleave",
//         method:"POST",
//         data:{
//             employeenum:employeenum
//         },success:function(data){
//         //     const b = $.parseJSON(data);
            
//         //   if(b.count > 0){
//         //       $('#notif_number').show();
//         //       $('#notif_number').html(b.count);
//         //   }else{
//         //       $('#notif_number').hide();
//         //   }
//         console.log(data)

//         }
//     });
// }
// count_notifications();

// function count_reimbursement(){
//     const currentUser = $('#currentUser').val();
//     $.ajax({
//         url:"controller/controller.info.php?count_reimbursement",
//         method:"POST",
//         data:{
//             currentUser:currentUser
//         },success:function(data){
//             const b = $.parseJSON(data);
//           if(b.count > 0){
//               $('#reim_app_number').show();
//               $('#reim_app_number').html(b.count);
//           }else{
//               $('#reim_app_number').hide();
//           }

//         }
//     });
// }
// count_reimbursement();


// const currentUser = $('#currentUser').val();
// console.log(currentUser)

function goto(linkk){ 
  if(linkk=="ess_payslip.php"){
    const currentUser = $('#currentUser').val();
    $.ajax({
      url:"controller/controller.info.php?read_payslips",
      method:"POST",
      data:{
        currentUser:currentUser
      },success:function(){
        window.location.href=linkk;
      }
    });
  }else if(linkk=="notification.php"){
    const currentUser = $('#currentUser').val();
    $.ajax({
      url:"controller/controller.info.php?read_notifications&type=leave",
      method:"POST",
      data:{
        currentUser:currentUser
      },success:function(){
        window.location.href=linkk;
      }
    });
  }else{
    window.location.href=linkk;
  }

}
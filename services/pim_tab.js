function count_leaveapp(){
	const employeenoo = $('#currentUser').val();
	$.ajax({
		url:"controller/controller.info.php?count_leaveapp",
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
	const employeenoo = $('#currentUser').val();
    $.ajax({
        url:"controller/controller.info.php?count_otapp",
        method:"POST",
        data:{
			employeenoo:employeenoo
		},
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

// function count_payslip(){
// 	const employeenoo = $('#currentUser').val();
//     $.ajax({
//         url:"controller/controller.info.php?count_payslip",
//         method:"POST",
//         data:{
// 			employeenoo:employeenoo
// 		},
//         success:function(data){
//             var b = $.parseJSON(data);
            
//           if(b.count > 0){
//               $('#payslip_number').show();
//               $('#payslip_number').html(b.count);
//           }else{
//               $('#payslip_number').hide();
//           }

//         }
//     });
// }
// count_payslip();

function count_reimbursement(){
	var employeenoo = $('#currentUser').val();
    $.ajax({
        url:"controller/controller.info.php?count_reimbursement",
        method:"POST",
        data:{
			employeenoo:employeenoo
		},
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

function count_incident_reports(){

    $.ajax({
        url:"controller/controller.info.php?count_incident_reports",
        method:"POST",
        success:function(data){
            var b = $.parseJSON(data);
            
          if(b.count > 0){
              $('#incident_reports_number').show();
              $('#incident_reports_number').html(b.count);
          }else{
              $('#incident_reports_number').hide();
          }

        }
    });
}
count_incident_reports();
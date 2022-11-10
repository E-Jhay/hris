var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
    $("#admin_leave").addClass("active_tab");
     $('.drawer').hide();
     $('.drawer').on('click',function(){
      $('.navnavnav').slideToggle();
    });
    $('#addleave_type').load('controller/controller.leavemanage.php?leave_typelist');
    $('#div_leavebalance').hide();
    $('#div_leavemonitor').hide();
	 
    $('#addleave_type').on('change',function(){
        var leavetype = $('#addleave_type').val();
        var empno = $('#addempno').val();
        $.ajax({
          url:"controller/controller.leavemanage.php?check_leave",
          method:"POST",
          data:{
            leavetype: leavetype,
            empno: empno
          },success:function(data){
            var b = $.parseJSON(data);
            if(b.counts=="many"){
              $.Toast("Leave type already exists", errorToast);
              $('#addleave_type').val("");
            }else{

            }
          }
        });
    });

  });


  function slconversion(){
    confirmed("save",slconversion_callback, "Do you really want to convert the SL?", "Yes", "No");
  }

  function slconversion_callback(){
    $.ajax({
  
        url:"controller/controller.leavemanage.php?convert_sl",
        method:"GET",
        success:function(){
          $.Toast("Successfully Converted", successToast);
          $('#tbl_leave').DataTable().destroy();
          load_leave();
        }

    });
  }

  function btn_addempleave(){

    var addempno = $('#addempno').val();
    var addleave_type = $('#addleave_type').val();
    var addleave_balance = $('#addleave_balance').val();

    if(addleave_type=="" || addleave_type==null){
      alert("invalid transaction, please select leave type");
    }else{

      $.ajax({
        url:"controller/controller.leavemanage.php?addemployee_leave",
        method:"POST",
        data:{
          addempno: addempno,
          addleave_type: addleave_type,
          addleave_balance: addleave_balance
        },success:function(){
          $.Toast("Successfully Saved", successToast);
          $('#tbl_leave').DataTable().destroy();
          load_leave();
          $('#addleave_modal').modal('hide');

        }
      });

    }
    

  }

  function btnaddleavetype(){
    $('#id_leave').val("");
    $('#leave_type').val("");
    $('#leave_name').val("");
    $('#leave_balances').val("");
    $('#points').val("");
    $('#addtype').show();
    $('#updatetype').hide();
    $('#leavemodal').modal('show');

  }

  function reset_balance(){
    confirmed("save",reset_balance_callback, "Do you really want to reset the leave balance?", "Yes", "No");
  }
  function reset_balance_callback(){
      $.ajax({
        url:"controller/controller.leavemanage.php?reset_balance",
        method:"POST",
        data:{
          id:""
        },success:function(){
            $.Toast("Successfully Reset", successToast);
            $('#tbl_leave').DataTable().destroy();
            load_leave();
        }
     });
  }

  function exportleave_balance(){
    window.location.href="tcpdf/examples/leave_balance.php";
  }

  function editleave_type(id,leave_type,leave_name,leave_stat,points){
    $('#id_leave').val(id);
    $('#leave_type').val(leave_type);
    $('#leave_name').val(leave_name);
    $('#leave_stat').val(leave_stat);
    $('#points').val(points);
    $('#addtype').hide();
    $('#updatetype').show();
    $('#leavemodal').modal('show');
  }

  function addleavetype(){
    var leave_type = $('#leave_type').val();
    var leave_name = $('#leave_name').val();
    var points = $('#points').val();
    var leave_stat = $('#leave_stat').val();

      $.ajax({
        url:"controller/controller.leavemanage.php?addleavetype",
        method:"POST",
        data:{
          leave_type: leave_type,
          leave_name: leave_name,
          leave_stat: leave_stat,
          points: points
        },success:function(){
          $.Toast("Successfully Saved", successToast);
          $('#tbl_leavetype').DataTable().destroy();
          load_tbl_leavetype();
          $('#leavemodal').modal('hide');
        }
      });

  }

  function updateleavetype(){
    var id_leave = $('#id_leave').val();
    var leave_type = $('#leave_type').val();
    var leave_name = $('#leave_name').val();
    var points = $('#points').val();
    var leave_stat = $('#leave_stat').val();

    $.ajax({
        url:"controller/controller.leavemanage.php?updateleavetype",
        method:"POST",
        data:{
          id_leave: id_leave,
          leave_type: leave_type,
          leave_name: leave_name,
          points: points,
          leave_stat: leave_stat
        },success:function(){
          $.Toast("Successfully Saved", successToast);
          $('#tbl_leavetype').DataTable().destroy();
          load_tbl_leavetype();
          $('#leavemodal').modal('hide');
        }
      });

  }

  function deleteleave_type(id){
      confirmed("save",deleteleave_type_callback, "Do you really want to delete this?", "Yes", "No", id);
  }

  function deleteleave_type_callback(id){

      $.ajax({
        url:"controller/controller.leavemanage.php?deleteleavetype",
        method:"POST",
        data:{
          id: id
        },success:function(){
          $.Toast("Successfully Deleted", errorToast);
          $('#tbl_leavetype').DataTable().destroy();
          load_tbl_leavetype();
        }
      });

  }

  function btnltype(){
    $("#ltype").addClass("active");
    $("#lbalance").removeClass("active");
    $('#lmonitor').removeClass("active");
    $('#div_leavetype').show();
    $('#div_leavebalance').hide();
    $('#div_leavemonitor').hide();
  }
  function btnlbalance(){
    $("#ltype").removeClass("active");
    $("#lbalance").addClass("active");
    $('#lmonitor').removeClass("active");
    $('#div_leavetype').hide();
    $('#div_leavebalance').show();
    $('#div_leavemonitor').hide();
  }

  
  function btnmonitor(){
    $("#ltype").removeClass("active");
    $("#lbalance").removeClass("active");
    $('#lmonitor').addClass("active");
    $('#div_leavemonitor').show();
    $('#div_leavebalance').hide();
    $('#div_leavetype').hide();
  }

	function viewleave(id,employeeno,fullname,rank,employment_status,company,leave_balance){
		$('#leave_modal').modal('show');
		$('#employeeno').html(employeeno);
		$('#fullname').html(fullname);
		$('#rank').html(rank);
		$('#employment_status').html(employment_status);
		$('#company').html(company);
		$('#leave_balance').html(leave_balance);

        $('#tbl_leavebalofemp').DataTable().destroy();
        $('#tbl_leavebalofemp').DataTable({  
              "aaSorting": [],
              "bSearching": false,
              "bFilter": false,
              "bInfo": false,
              "bPaginate": false,
              "bLengthChange": false,
              "pagination": false,
              "ajax" : "controller/controller.leavemanage.php?load_leaveemployee&employeeno="+employeeno,
              "columns" : [
                    
                    { "data" : "leave_type"},
                    { "data" : "balance"},
                    { "data" : "action"}

                ],
         });

        


	}

  function updateall(){
    var employeeno = $('#employeeno').html();
    confirmed("save",updateall_callback, "Do you really want to update this?", "Yes", "No", employeeno);
  }

  function updateall_callback(employeeno){
      $.ajax({
            url:"controller/controller.leavemanage.php?checkleave_byemployee",
            method:"POST",
            data:{
              employeeno: employeeno
            },success:function(data){

              var b = $.parseJSON(data);
              b.forEach(myForeach);
              $.Toast("Successfully Saved", successToast);
              $('#tbl_leave').DataTable().destroy();
              load_leave();
              $('#leave_modal').modal('hide');
            }
      });
  }



function myForeach(item) {
  var leave_id = item['id'];
  var id = "emp_leavebal"+item['id'];
  var credits = $("#"+id+"").val();
  var employeeno = $('#employeeno').html();

  $.ajax({
    url:"controller/controller.leavemanage.php?update_leavebal",
    method:"POST",
    data:{
      id: leave_id,
      emp_leavebal: credits,
      employee_no: employeeno
    },success:function(){

    }
  });


}



//   emp_leavebal
  function update_emp_leavebal(id,employee_no){

    var emp_leavebal = $('#emp_leavebal'+id+'').val();
    var data = [id, emp_leavebal, employee_no];
    confirmed("save",update_emp_leavebal_callback, "Do you really want to update this?", "Yes", "No", data);

  }

  function update_emp_leavebal_callback(data){
      var id = data[0];
      var emp_leavebal = data[1];
      var employee_no = data[2];
      $.ajax({
        url:"controller/controller.leavemanage.php?update_leavebal",
        method:"POST",
        data:{
          id: id,
          emp_leavebal: emp_leavebal,
          employee_no: employee_no
        },success:function(){
          $.Toast("Successfully Saved", successToast);
          $('#tbl_leave').DataTable().destroy();
          load_leave();
        }
      });
  }

  function delete_emp_leavebal(id,employee_no){
    var emp_leavebal = $('#emp_leavebal'+id+'').val();
    var data = [id, emp_leavebal, employee_no];
    confirmed("delete",delete_emp_leavebal_callback, "Do you really want to delete this?", "Yes", "No", data);
  }


  function delete_emp_leavebal_callback(data){
    var id = data[0];
    var emp_leavebal = data[1];
    var employee_no = data[2];
    $.ajax({
        url:"controller/controller.leavemanage.php?delete_leavebal",
        method:"POST",
        data:{
          id: id,
          emp_leavebal: emp_leavebal,
          employee_no: employee_no
        },success:function(){
          $.Toast("Successfully Deleted", errorToast);
          $('#tbl_leave').DataTable().destroy();
          load_leave();
          $('#leave_modal').modal('hide');
        }
    });

  }

  // function lb(){

  //      $.ajax({
  //       url:"controller/controller.leavebalance.php?leave_credits_load",
  //       method:"POST",
  //       data:{
  //         id:""
  //       },success:function(data){
  //         var b = $.parseJSON(data);
  //         // alert(b.datee);
  //       }
  //     });
       
  // }
  // lb();

	function load_leave(){
    
    	$('#tbl_leave').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "pageLength":50,
              "ajax" : "controller/controller.leavemanage.php?load_leavebalance",
              "columns" : [
                    
                    { "data" : "employeeno"},
                    { "data" : "fullname"},
                    { "data" : "date_hired"},
                    { "data" : "noofyears"},
                    // { "data" : "totalel"},
                    { "data" : "s_leave"},
                    { "data" : "v_leave"},
                    { "data" : "action"}

                ],
         });
  }
  load_leave();


  function load_leavemonitor(){
    
      $('#tbl_leavemonitor').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.leavemanage.php?load_leavemonitoring",
              "columns" : [
                    
                    { "data" : "tenure"},
                    { "data" : "earned_points"},
                    { "data" : "vacation"},
                    { "data" : "sick"},
                    { "data" : "total"}
                    // { "data" : "action"}

                ],
         });
  }
  load_leavemonitor();


  

  function load_tbl_leavetype(){
    
        $('#tbl_leavetype').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.leavemanage.php?load_leavetype",
              "columns" : [
                    
                    { "data" : "leave_type"},
                    { "data" : "leave_name"},
                    // { "data" : "points"},
                    { "data" : "leave_stat"},
                    { "data" : "action"}

                ],
         });

        
  }
  load_tbl_leavetype();
  
  function backmodule(){
  	window.location.href="module.php";
  }

  function goto(linkk){
	window.location.href=linkk;
  }

  function addempleave(id,employeeno,fullname){
      $('#addleave_type').val("");
      $('#addleave_balance').val("");
      $('#addempno').val(employeeno);
      $('#addempname').val(fullname);
      $('#addleave_modal').modal('show');
  }
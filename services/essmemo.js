var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
	   
    $("#ess_memo").addClass("active_tab");
    $('.drawer').hide();
    $('.drawer').on('click',function(){
      $('.navnavnav').slideToggle();
    });
    $('#div_inter_office_memo').hide();

    $('#action').val('employee')

    load_memo('active', 'active')
      $('#status').on('change', () => {
        $('#tbl_inter_office_memo').DataTable().destroy();
        $('#tbl_memo').DataTable().destroy();
        load_memo($('#status').val(), 'active')
      })

      
      $('#status2').on('change', () => {
        $('#tbl_inter_office_memo').DataTable().destroy();
        $('#tbl_memo').DataTable().destroy();
        load_memo('active', $('#status2').val())
      })

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


  function load_memo(status, status2){
      var employeeno = $('#currentUser').val();
      var department = $('#department').val();
      $('#tbl_memo').DataTable({  
              createdRow: function (row, data, index) {
                if($('td', row).eq(5)[0].innerText == 'Acknowledged') {
                  $('td', row).eq(5).addClass('acknowledged')
                }
              },
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "scrollX": true,
              "ajax" : "controller/controller.essmemo.php?load_memoess&employeeno="+employeeno + "&department=" + department + "&memo=employee&status=" + status,
              "columns" : [
                    
                    { "data" : "employeeno"},
                    { "data" : "memo"},
                    { "data" : "date"},
                    { "data" : "remarks"},
                    { "data" : "notice_to_explain"},
                    { "data" : "status"},
                    { "data" : "action"}

                ],
         });
      $('#tbl_inter_office_memo').DataTable({  
              createdRow: function (row, data, index) {
                if($('td', row).eq(5)[0].innerText == 'Acknowledged') {
                  $('td', row).eq(5).addClass('acknowledged')
                }
              },
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "scrollX": true,
              "ajax" : "controller/controller.essmemo.php?load_memoess&employeeno="+employeeno + "&department=" + department + "&memo=department&status=" + status2,
              "columns" : [
                    
                { "data" : "department"},
                { "data" : "memo"},
                { "data" : "date"},
                { "data" : "remarks"},
                { "data" : "notice_to_explain"},
                { "data" : "status"},
                { "data" : "action"}

                ],
         });
  }
  // load_memo('active', 'active');
  

  function backmodule(){
    window.location.href="module.php";
  }

  // function goto(linkk){

  // if(linkk=="notification.php"){
  //   var employeeno = $('#employeeno').val();
  //   $.ajax({
  //     url:"controller/controller.essmemo.php?readleave",
  //     method:"POST",
  //     data:{
  //       employeeno:employeeno
  //     },success:function(){
  //       window.location.href=linkk;
  //     }
  //   });
  // }else if(linkk=="ess_payslip.php"){

  //   var employeeno = $('#employeeno').val();
  //   $.ajax({
  //     url:"controller/controller.essmemo.php?readpayslip",
  //     method:"POST",
  //     data:{
  //       employeeno:employeeno
  //     },success:function(){
  //       window.location.href=linkk;
  //     }
  //   });

  // }else{
  //   window.location.href=linkk;
  // }

  // }

  function btnPersonalMemo(){
    $('#div_memo').show();
    $('#div_inter_office_memo').hide();
    $("#personal_memo").addClass("active");
    $("#inter_office_memo").removeClass("active");
    $('#action').val('employee')
  }

 function btnInterOfficeMemo(){
   $('#div_memo').hide();
    $('#div_inter_office_memo').show();
    $("#personal_memo").removeClass("active");
    $("#inter_office_memo").addClass("active");
    $('#action').val('department')
 }

 function uploadExplain(id, date, memo_name, remarks, explanation) {
  $('#acknowledge_modal').modal('show');
  $('#memo_id').val(id);
  $('#memo_name').val(memo_name);
  $('#memo_date').val(date);
  $('#remarks').val(remarks);
  $('#explanation').val(explanation);

  // if(statuss=="Pending"){
  //   $('#btnapprove').show();
  //   $('#btndisapprove').show();
  //   $('#btncancelapprove').hide();
  // }else{
  //   $('#btnapprove').hide();
  //   $('#btndisapprove').hide();
  //   $('#btncancelapprove').show();
  // }

}

// function submitFormConfirm(e){
//   e.preventDefault()
//   confirmed("save",submitForm, "Do you really want to approve this?", "Yes", "No");
// }

$('#acknowledge_form').on('submit', (e) => {
  e.preventDefault()
  const form_data = new FormData();
  const file = $("#file").prop("files")[0];
  const memo_id = $("#memo_id").val();
  const employeeno = $("#currentUser").val();
  const department = $("#department").val();
  const explanation = $("#explanation").val();
  const action = $("#action").val();
  form_data.append("file", file)
  form_data.append("memo_id", memo_id)
  form_data.append("employeeno", employeeno)
  form_data.append("department", department)
  form_data.append("action", action)
  form_data.append("explanation", explanation)

  $.ajax({
    url:"controller/controller.essmemo.php?uploadExplanation",
    method:"POST",
    data: form_data,
    processData: false,
    contentType: false,
    beforeSend: function(){
      $("#btn_submit").text('Loading....')
      $("#btn_submit").attr('disabled', true)
    },
    complete: function(){
      $("#btn_submit").text('Submit')
      $("#btn_submit").attr('disabled', false)
    },
    success:function(data){
      const b = $.parseJSON(data)
      if(b.type == 'error') {
        $.Toast(b.message, errorToast);
      } else {
        $.Toast(b.message, successToast);
        $('#acknowledge_modal').modal('hide');
	      $('#tbl_memo').DataTable().destroy();
	      $('#tbl_inter_office_memo').DataTable().destroy();
        load_memo()
      }
    }
  });
  // console.log(form_data)
  // console.log(memo_id)
})

// function submitForm(e) {
//   e.preventDefault()
//   const form_data = new FormData();
//   const file = $("#file").prop("files")[0];
//   const memo_id = $("#memo_id").val();
//   form_data.append("file", file)
//   form_data.append("memo_id", memo_id)

//   $.ajax({
//     url:"controller/controller.essmemo.php?uploadExplanation",
//     method:"POST",
//     data: form_data,
//     processData: false,
//     contentType: false,
//     success:function(data){
//       // $.Toast("Successfully Saved", successToast);
//       // setTimeout(() => {	
//       //   window.location.href="ess_memo.php";
//       // }, 1000)
//       console.log(data)
//     }
//   });
//   // console.log(form_data)
//   // console.log(memo_id)
// }
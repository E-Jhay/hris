var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		 $('#employeeddown').load('controller/controller.memo.php?employeelist');
		 $('#departmentList').load('controller/controller.memo.php?departmentList');

     $("#admin_memo").addClass("active_tab");
     $('.drawer').hide();
     $('.drawer').on('click',function(){
      $('.navnavnav').slideToggle();
     });
     $('#div_inter_office_memo').hide();
     $('#memo_table').hide();
     $('#memo_table_department').hide();
    //  $('#cancelMemoBtn').hide();

});

  $('#addMemoBtn').on('click', () => {
    $("#addMemoBtn").hide()
    $('#cancelMemoBtn').show();
    $('#memo_table').show();
  })
  $('#cancelMemoBtn').on('click', () => {
    $("#addMemoBtn").show()
    $('#cancelMemoBtn').hide();
    $('#memo_table').hide();
  })
  $('#addMemoBtnDepartment').on('click', () => {
    $("#addMemoBtnDepartment").hide()
    $('#cancelMemoBtnDepartment').show();
    $('#memo_table_department').show();
  })
  $('#cancelMemoBtnDepartment').on('click', () => {
    $("#addMemoBtnDepartment").show()
    $('#cancelMemoBtnDepartment').hide();
    $('#memo_table_department').hide();
  })

  $('#form').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
  })
  $('#form2').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",save_callback_form2, "Do you really want to save this?", "Yes", "No");
  })

  function save_callback(){
		var formData = new FormData($("#form")[0]);
		$.ajax({
			url:"controller/controller.memo.php?uploadmemo",
			method:"POST",
			data: formData,
			processData: false,
			contentType: false,
			beforeSend: function(){
				$(".btn_submit").text('Loading....')
				$(".btn_submit").attr('disabled', true)
			},
			complete: function(){
				$(".btn_submit").text('Submit')
				$(".btn_submit").attr('disabled', false)
			},
			success:function(data){
				$.Toast("Successfully Saved", successToast);
        $('#form').trigger("reset");
        $("#addMemoBtn").show()
        $('#cancelMemoBtn').hide();
        $('#memo_table').hide();
        $('#tbl_inter_office_memo').DataTable().destroy();
        $('#tbl_memo').DataTable().destroy();
        load_memo();
				// setTimeout(() => {
				// 	window.location.href="memo.php";
				// }, 1000)
			}
		});
	}
  function save_callback_form2(){
		var formData = new FormData($("#form2")[0]);
		$.ajax({
			url:"controller/controller.memo.php?uploadmemo",
			method:"POST",
			data: formData,
			processData: false,
			contentType: false,
			beforeSend: function(){
				$(".btn_submit").text('Loading....')
				$(".btn_submit").attr('disabled', true)
			},
			complete: function(){
				$(".btn_submit").text('Submit')
				$(".btn_submit").attr('disabled', false)
			},
			success:function(data){
				$.Toast("Successfully Saved", successToast);
        $('#form2').trigger("reset");
        $("#addMemoBtnDepartment").show()
        $('#cancelMemoBtnDepartment').hide();
        $('#memo_table_department').hide();
        $('#tbl_inter_office_memo').DataTable().destroy();
        $('#tbl_memo').DataTable().destroy();
        load_memo();
				// setTimeout(() => {
				// 	window.location.href="memo.php";
				// }, 1000)
			}
		});
	}

  // function lb(){

  //      $.ajax({
  //       url:"controller/controller.leavebalance.php?leave_credits_load",
  //       method:"POST",
  //       data:{
  //         id:""
  //       },success:function(){

  //       }
  //     });
       
  // }
  // lb();

  function goto(linkk){
	window.location.href=linkk;
  }

  function dl_memo(filename,employeeno){
  	window.open("memo/"+employeeno+'/'+filename);
  }

  function delete_memo(id,filename,employeeno){
    var data = [id, filename, employeeno];
    confirmed("delete",delete_memo_callback, "Do you really want to delete this?", "Yes", "No",data);

}

function delete_memo_callback(data){
    var id = data[0];
    var filename = data[1];
    var employeeno = data[2];
    $.ajax({
      url:"controller/controller.memo.php?deletememo",
      method:"POST",
      data:{
        id: id,
        filename: filename,
        employeeno: employeeno
      },success:function(){
        $.Toast("Successfully Deleted", successToast);
        $('#tbl_memo').DataTable().destroy();
        $('#tbl_inter_office_memo').DataTable().destroy();
        load_memo();
      }
    });

}

  function load_memo(){
    
    	$('#tbl_memo').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.memo.php?load_memo&memo=employee",
              "columns" : [
                    
                    { "data" : "employeeno"},
                    {"data" : "name"},
                    { "data" : "memo"},
                    { "data" : "date"},
                    { "data" : "remarks"},
                    { "data" : "status"},
                    { "data" : "action"}

                ],
         });
    	$('#tbl_inter_office_memo').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.memo.php?load_memo&memo=department",
              "columns" : [
                    
                    { "data" : "department"},
                    { "data" : "memo"},
                    { "data" : "date"},
                    { "data" : "remarks"},
                    { "data" : "status"},
                    { "data" : "action"}

                ],
         });
  }
  load_memo();

  function btnMemo(){
    $('#div_memo').show();
    $('#div_inter_office_memo').hide();
    $("#memo").addClass("active");
    $("#inter_office_memo").removeClass("active");
  }

 function btnInterOfficeMemo(){
   $('#div_memo').hide();
    $('#div_inter_office_memo').show();
    $("#memo").removeClass("active");
    $("#inter_office_memo").addClass("active");
 }

 function viewExplanation(explanation, type) {
    const link = "memo/Explanation/"+type+"/"+explanation;
    window.open(link);
 }
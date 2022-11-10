var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		 $('#employeeddown').load('controller/controller.memo.php?employeelist');

     $("#admin_memo").addClass("active_tab");
     $('.drawer').hide();
     $('.drawer').on('click',function(){
      $('.navnavnav').slideToggle();
     });

	});

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
        $.Toast("Successfully Deleted", errorToast);
        $('#tbl_memo').DataTable().destroy();
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
              "ajax" : "controller/controller.memo.php?load_memo",
              "columns" : [
                    
                    { "data" : "employeeno"},
                    {"data" : "name"},
                    { "data" : "memo"},
                    { "data" : "date"},
                    { "data" : "action"}

                ],
         });
  }
  load_memo();
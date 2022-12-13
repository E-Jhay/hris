var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
      $("#admin_dept").addClass("active_tab");
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

     function update_dept(id,dept){
      $('#adddept_modal').modal('show');
      $('#dept_id').val(id);
      $('#dept_text').val(dept); 
      $('#btnsave').hide();
      $('#btnupdate').show(); 
     }
     function delete_dept(id){
        confirmed("delete",delete_dept_callback, "Do you really want to delete this?", "Yes", "No",id);
     }

     function delete_dept_callback(id){
        $.ajax({
            url:"controller/controller.department.php?delete_dept",
            method:"POST",
            data:{
              id:id
            },success:function(){
              $.Toast("Successfully Deleted", errorToast);
              $('#tbl_department').DataTable().destroy();
              load_department();
            }
      })
     }


    function btn_savedept(){
      var dept_text = $('#dept_text').val();
      $.ajax({
        url:"controller/controller.department.php?add_dept",
        method:"POST",
        data:{
          dept_text: dept_text
        },success:function(){
          $.Toast("Successfully Saved", successToast);
          $('#adddept_modal').modal('hide');
          $('#tbl_department').DataTable().destroy();
          load_department();
        }
      });
      

    }

    function btn_updatedept(){
      var dept_id = $('#dept_id').val();
      var dept_text = $('#dept_text').val();
      $.ajax({
        url:"controller/controller.department.php?update_dept",
        method:"POST",
        data:{
          dept_text: dept_text,
          dept_id: dept_id
        },success:function(){
          $.Toast("Successfully Saved", successToast);
          $('#adddept_modal').modal('hide');
          $('#tbl_department').DataTable().destroy();
          load_department();
        }
      });
    }

    function btnaddnew(){
      $('#adddept_modal').modal('show');
      $('#dept_id').val("");
      $('#dept_text').val("");
      $('#btnsave').show();
      $('#btnupdate').hide();
    }

    function load_department(){
    
      $('#tbl_department').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.department.php?load_department",
              "columns" : [
                    
                    { "data" : "department"},
                    { "data" : "action"}

                ],
         });
  }                                       
  load_department();

  function goto(linkk){
  window.location.href=linkk;
  }

  function red(){
    alert("blue");
    alert("violet");
  }
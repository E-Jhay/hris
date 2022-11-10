var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
     $("#admin_job").addClass("active_tab");
     $('.drawer').hide();
     $('.drawer').on('click',function(){
      $('.navnavnav').slideToggle();
     });
     $('#div_employment_status').hide();
     $('#div_job_category').hide();
     
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


  function btn_savejobcat(){
    var modal_jobcatid = $('#modal_jobcatid').val();
    var modal_jobcatname = $('#modal_jobcatname').val();
    $.ajax({
      url:"controller/controller.job.php?addjobcat",
      method:"POST",
      data:{
        modal_jobcatid: modal_jobcatid,
        modal_jobcatname: modal_jobcatname
      },success:function(){
        $.Toast("Successfully Saved", successToast);
        $('#tbl_job_categories').DataTable().destroy();
        loadjobcategory();
        $('#jobcategory_modal').modal('hide');
      }
    });

  }

  function btn_updatejobcat(){
    var modal_jobcatid = $('#modal_jobcatid').val();
    var modal_jobcatname = $('#modal_jobcatname').val();
    $.ajax({
      url:"controller/controller.job.php?updatejobcat",
      method:"POST",
      data:{
        modal_jobcatid: modal_jobcatid,
        modal_jobcatname: modal_jobcatname
      },success:function(){
        $.Toast("Successfully Saved", successToast);
        $('#tbl_job_categories').DataTable().destroy();
        loadjobcategory();
        $('#jobcategory_modal').modal('hide');
      }
    });
  }

  function edit_jobcategory(id,job_category){
    $('#modal_jobcatid').val(id);
    $('#modal_jobcatname').val(job_category);
    $('#savejobcatbtn').hide();
    $('#updatejobcatbtn').show();
    $('#jobcategory_modal').modal('show');
  }
  function delete_jobcategory(id){
    confirmed("delete",delete_jobcategory_callback, "Do you really want to delete this?", "Yes", "No",id);
  }

  function delete_jobcategory_callback(id){
    $.ajax({
        url:"controller/controller.job.php?deletejobcat",
        method:"POST",
        data:{
          id:id
        },success:function(){
          $.Toast("Successfully Deleted", errorToast);
          $('#tbl_job_categories').DataTable().destroy();
          loadjobcategory();
          $('#jobcategory_modal').modal('hide');
        }
      });
  }


  function btn_saveempstatus(){
    var modal_empstatusid = $('#modal_empstatusid').val();
    var modal_empstatusname = $('#modal_empstatusname').val();
    $.ajax({
      url:"controller/controller.job.php?addempstatus",
      method:"POST",
      data:{
        modal_empstatusid: modal_empstatusid,
        modal_empstatusname: modal_empstatusname
      },success:function(){
        $.Toast("Successfully Saved", successToast);
        $('#tbl_employment_status').DataTable().destroy();
        loademployment_status();
        $('#employment_statusmodal').modal('hide');
      }
    });
    
  }
  function edit_empstatus(id,employment_status){
    $('#modal_empstatusid').val(id);
    $('#modal_empstatusname').val(employment_status);

    $('#employment_statusmodal').modal('show');
    $('#saveempstatusbtn').hide();
    $('#updateempstatusbtn').show();
  }
  function delete_empstatus(id){
    confirmed("delete",delete_empstatus_callback, "Do you really want to delete this?", "Yes", "No",id);
        
  }

  function delete_empstatus_callback(id){
    $.ajax({
      url:"controller/controller.job.php?deleteempstatus",
      method:"POST",
      data:{
        id:id
      },success:function(){
        $.Toast("Successfully Deleted", errorToast);
        $('#tbl_employment_status').DataTable().destroy();
        loademployment_status();
        $('#employment_statusmodal').modal('hide');
      }
    });
  }

  function btn_updateempstatus(){
    var modal_empstatusid = $('#modal_empstatusid').val();
    var modal_empstatusname = $('#modal_empstatusname').val();
    $.ajax({
      url:"controller/controller.job.php?updateempstatus",
      method:"POST",
      data:{
        modal_empstatusid: modal_empstatusid,
        modal_empstatusname: modal_empstatusname
      },success:function(){
        $.Toast("Successfully Saved", successToast);
        $('#tbl_employment_status').DataTable().destroy();
        loademployment_status();
        $('#employment_statusmodal').modal('hide');
      }
    });
    
  }

  function btnaddjob(){

    $('#modal_jobid').val("");
    $('#modal_jobtitle').val("");
    $('#modal_jobdescription').val("");
    $('#jobmodal').modal('show');
    $('#savejobbtn').show();
    $('#updatejobbtn').hide();
  }

  function btn_savejob(){
    var modal_jobtitle = $('#modal_jobtitle').val();
    var modal_jobdescription = $('#modal_jobdescription').val();

    $.ajax({
      url:"controller/controller.job.php?addjob",
      method:"POST",
      data:{
        modal_jobtitle: modal_jobtitle,
        modal_jobdescription: modal_jobdescription
      },success:function(){
        $.Toast("Successfully Saved", successToast);
        $('#tbl_jobtitle').DataTable().destroy();
        loadjobtitle();   
        $('#jobmodal').modal('hide');
      }
    });
    
  }

  function btn_updatejob(){
    var modal_jobid = $('#modal_jobid').val();
    var modal_jobtitle = $('#modal_jobtitle').val();
    var modal_jobdescription = $('#modal_jobdescription').val();

    $.ajax({
      url:"controller/controller.job.php?editjob",
      method:"POST",
      data:{
        modal_jobid: modal_jobid,
        modal_jobtitle: modal_jobtitle,
        modal_jobdescription: modal_jobdescription
      },success:function(){
        $.Toast("Successfully Saved", successToast);
        $('#tbl_jobtitle').DataTable().destroy();
        loadjobtitle();   
        $('#jobmodal').modal('hide');
      }
    });

  }

  function deletejob_title(id){
    confirmed("delete",deletejob_title_callback, "Do you really want to delete this?", "Yes", "No",id);
  }

  function deletejob_title_callback(id){
    $.ajax({
        url:"controller/controller.job.php?deletejob",
        method:"POST",
        data:{
          id:id
        },success:function(){
          $.Toast("Successfully Deleted", errorToast);
          $('#tbl_jobtitle').DataTable().destroy();
          loadjobtitle();   
        }
      });
  }

  function editjob_title(id,job_title,job_desc){
    $('#modal_jobid').val(id);
    $('#modal_jobtitle').val(job_title);
    $('#modal_jobdescription').val(job_desc);
    $('#jobmodal').modal('show');
    $('#savejobbtn').hide();
    $('#updatejobbtn').show();
  }
  

  function btnaddempstatus(){
    $('#employment_statusmodal').modal('show');
    $('#modal_empstatusid').val("");
    $('#modal_empstatusname').val("");
    $('#saveempstatusbtn').show();
    $('#updateempstatusbtn').hide();
  }
  function btnaddjobcategory(){
    $('#jobcategory_modal').modal('show');
    $('#modal_jobcatid').val("");
    $('#modal_jobcatname').val("");
    $('#savejobcatbtn').show();
    $('#updatejobcatbtn').hide();
  }

  function btnjobtitles(){

    $("#ljob_titles").addClass("active");
    $("#lsalary_components").removeClass("active");
    $("#lemp_status").removeClass("active");
    $("#ljob_categories").removeClass("active");
    $("#lwork_shifts").removeClass("active");

    $('#divjob_title').show();
    $('#div_salarycomponents').hide();
    $('#div_employment_status').hide();
    $('#div_job_category').hide();
    $('#div_workshift').hide();

  }

  function btnemp_status(){

    $("#ljob_titles").removeClass("active");
    $("#lsalary_components").removeClass("active");
    $("#lemp_status").addClass("active");
    $("#ljob_categories").removeClass("active");
    $("#lwork_shifts").removeClass("active");

    $('#divjob_title').hide();
    $('#div_salarycomponents').hide();
    $('#div_employment_status').show();
    $('#div_job_category').hide();
    $('#div_workshift').hide();

  }
  function btnjob_cat(){

    $("#ljob_titles").removeClass("active");
    $("#lsalary_components").removeClass("active");
    $("#lemp_status").removeClass("active");
    $("#ljob_categories").addClass("active");
    $("#lwork_shifts").removeClass("active");

    $('#divjob_title').hide();
    $('#div_salarycomponents').hide();
    $('#div_employment_status').hide();
    $('#div_job_category').show();
    $('#div_workshift').hide();

  }

  function loadjobtitle(){

    $('#tbl_jobtitle').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "pageLength":50,
              "ajax" : "controller/controller.job.php?loadjobtitle",
              "columns" : [
                    
                    { "data" : "job_title"},
                    { "data" : "job_desc"},
                    { "data" : "action"}

                ],
         });
  }
  loadjobtitle();

  function loademployment_status(){

    $('#tbl_employment_status').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.job.php?loademployment_status",
              "columns" : [

                    { "data" : "employment_status"},
                    { "data" : "action"}

                ],
         });
  }
  loademployment_status();

  function loadjobcategory(){

    $('#tbl_job_categories').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.job.php?loadjobcategory",
              "columns" : [

                    { "data" : "job_category"},
                    { "data" : "action"}

                ],
         });
  }
  loadjobcategory();

  function backmodule(){
    window.location.href="module.php";
  }

  function goto(linkk){
  window.location.href=linkk;
  }
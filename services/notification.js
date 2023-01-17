const errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
const successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
  $("#ess_notif").addClass("active_tab");
  $('.drawer').hide();
  $('.drawer').on('click',function(){
    $('.navnavnav').slideToggle();
  });
  
  $('#div_omnibus').hide();
  $('#div_overtime').hide();

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

  function loadnotifleave(){
    const currentUser = $('#currentUser').val();
    $('#tbl_notif_leave').DataTable({  
        "aaSorting": [],
        "bSearching": false,
        "bFilter": false,
        "bInfo": false,
        "bPaginate": true,
        "bLengthChange": false,
        "pagination": false,
			  "scrollX": true,
        "ajax" : "controller/controller.notifications.php?loadnotifleave&currentUser="+currentUser,
        "columns" : [
              
              { "data" : "trail"},
              { "data" : "date_time"}

          ],
    });
  }
  loadnotifleave()

  function loadNotifOmnibus(){
    const currentUser = $('#currentUser').val();
    $('#tbl_notif_omnibus').DataTable({  
        "aaSorting": [],
        "bSearching": false,
        "bFilter": false,
        "bInfo": false,
        "bPaginate": true,
        "bLengthChange": false,
        "pagination": false,
        "scrollX": true,
        "ajax" : "controller/controller.notifications.php?loadNotifOmnibus&currentUser="+currentUser,
        "columns" : [
              
              { "data" : "trail"},
              { "data" : "date_time"}

          ],
    });
  }
  loadNotifOmnibus()

  function loadNotifOvertime(){
    const currentUser = $('#currentUser').val();
    $('#tbl_notif_overtime').DataTable({  
        "aaSorting": [],
        "bSearching": false,
        "bFilter": false,
        "bInfo": false,
        "bPaginate": true,
        "bLengthChange": false,
        "pagination": false,
        "scrollX": true,
        "ajax" : "controller/controller.notifications.php?loadNotifOvertime&currentUser="+currentUser,
        "columns" : [
              
              { "data" : "trail"},
              { "data" : "date_time"}

          ],
    });
  }
  loadNotifOvertime()


  function backmodule(){
  	window.location.href="module.php";
  }


function btnLeave(){
  $('#div_leave').show();
  $('#div_omnibus').hide();
  $('#div_overtime').hide();
  $("#leave_tab").addClass("active");
  $("#omnibus_tab").removeClass("active");
  $("#overtime_tab").removeClass("active");
}

function btnOmnibus(){
  $('#div_leave').hide();
  $('#div_omnibus').show();
  $('#div_overtime').hide();
  $("#leave_tab").removeClass("active");
  $("#omnibus_tab").addClass("active");
  $("#overtime_tab").removeClass("active");
  const currentUser = $('#currentUser').val();
  $.ajax({
    url:"controller/controller.info.php?read_notifications&type=omnibus",
    method:"POST",
    data:{
      currentUser:currentUser
    },success:function(){
      countNotifications()
    }
  });
  
}

function btnOvertime(){
  $('#div_leave').hide();
  $('#div_omnibus').hide();
  $('#div_overtime').show();
  $("#leave_tab").removeClass("active");
  $("#omnibus_tab").removeClass("active");
  $("#overtime_tab").addClass("active");
  const currentUser = $('#currentUser').val();
  $.ajax({
    url:"controller/controller.info.php?read_notifications&type=overtime",
    method:"POST",
    data:{
      currentUser:currentUser
    },success:function(){
      countNotifications()
    }
  });
}

function countNotifications() {
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
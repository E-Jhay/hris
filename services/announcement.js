var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		 $("#admin_announce").addClass("active_tab");
     $('.drawer').hide();
     $('.drawer').on('click',function(){
      $('.navnavnav').slideToggle();
     });
	 
	 $('#departmentList').load('controller/controller.memo.php?departmentList');
	 $('#div_inter_office_news').hide();
	 $('#department_div').hide()

	 $('#form').on('submit', (e) => {
		e.preventDefault()
		var formData = new FormData($("#form")[0]);
		$.ajax({
			url:"controller/controller.announcement.php?newsfile",
			method:"POST",
			data: formData,
			processData: false,
			contentType: false,
			success:function(data){
				const b = $.parseJSON(data)
				if(b.type === 'error')
					$.Toast(b.message, errorToast)
				else {
					$.Toast(b.message, successToast)
					$('#tbl_news').DataTable().destroy();
					$('#tbl_inter_office_news').DataTable().destroy();
					load_news();
					$('#news_modal').modal('hide');
					$('#modal_newsid').val("");
					$('#modal_topic').val("");
					$('#departmentList').val("");
					$('#modal_date').val("");
					$('#modal_end_date').val("");
					$('#news_file').val("");
				}
			}
		});
	 })
	});

	// function lb(){

 //       $.ajax({
 //        url:"controller/controller.leavebalance.php?leave_credits_load",
 //        method:"POST",
 //        data:{
 //          id:""
 //        },success:function(){

 //        }
 //      });
       
	// }
	// lb();

	function btnaddnews(type){
		if(type == "department") {
			$('#department_div').show()
		} else {
			$('#department_div').hide()
		}

		$('#modal_newsid').val("");
		$('#modal_topic').val("");
		$('#modal_date').val("");
		$('#modal_end_date').val("");

		$('#news_modal').modal('show');
		$('#savenewsbtn').show();
		$('#updatenewsbtn').hide();

		$('#ack_status_label').hide();
		$('#modal_ack_status').hide();
	}

	function btn_savenews(){
		var modal_newsid = $('#modal_newsid').val();
		var modal_topic = $('#modal_topic').val();
		var departmentList = $('#departmentList').val();
		var modal_date = $('#modal_date').val();
		var modal_end_date = $('#modal_end_date').val();

		// $.ajax({
		// 	url:"controller/controller.announcement.php?newsfile",
		// 	method:"POST",
		// 	data:{
		// 		modal_newsid: modal_newsid,
		// 		modal_topic: modal_topic,
		// 		departmentList: departmentList,
		// 		modal_date: modal_date,
		// 		modal_end_date: modal_end_date
		// 	},success:function(){
		// 		$.Toast("Successfully Saved", successToast);
		// 		$('#tbl_news').DataTable().destroy();
		// 		load_news();
		// 		$('#news_modal').modal('hide');
		// 	}
		// });
		console.log(departmentList,modal_topic)
	}
	function btn_updatenews(){

		var modal_newsid = $('#modal_newsid').val();
		var modal_topic = $('#modal_topic').val();
		var modal_date = $('#modal_date').val();
		var modal_end_date = $('#modal_end_date').val();
		var modal_ack_status = $('#modal_ack_status').val();

		$.ajax({
			url:"controller/controller.announcement.php?updatenews",
			method:"POST",
			data:{
				modal_newsid: modal_newsid,
				modal_topic: modal_topic,
				modal_date: modal_date,
				modal_end_date: modal_end_date,
				modal_ack_status: modal_ack_status
			},success:function(){
				$.Toast("Successfully Saved", successToast);
				$('#tbl_news').DataTable().destroy();
				$('#tbl_inter_office_news').DataTable().destroy();
				load_news();
				$('#news_modal').modal('hide');
			}
		});

	}

	function edit_news(id,topic,publish_date,end_date,ack_status){

		$('#modal_newsid').val(id);
		$('#modal_topic').val(topic);
		$('#modal_date').val(publish_date);
		$('#modal_end_date').val(end_date);
		$('#modal_ack_status').val(ack_status)
		
		$('#savenewsbtn').hide();
		$('#updatenewsbtn').show();
		$('#news_modal').modal('show');
		$('#ack_status_label').show();
		$('#modal_ack_status').show();


	}

	function dl_news(file_name){
		window.open('news/'+file_name);
	}
	function delete_news(id,file_name){
		var data = [id,file_name];
		confirmed("delete",delete_news_callback, "Do you really want to delete this?", "Yes", "No",data);
	}

	function delete_news_callback(data){
			var id = data[0];
			var file_name = data[1];
			$.ajax({
				url:"controller/controller.announcement.php?deletenews",
				method:"POST",
				data:{
					id: id,
					file_name: file_name
				},success:function(){
					$.Toast("Successfully Deleted", successToast);
					$('#tbl_news').DataTable().destroy();
					$('#tbl_inter_office_news').DataTable().destroy();
					load_news();
				}
			});

	}

	function activestatuschange(id,stat){
		 	$.ajax({
		 		url:"controller/controller.announcement.php?updatestatus",
		 		method:"POST",
		 		data:{
		 			id:id,
		 			stat:stat
		 		},success:function(){
		 			$.Toast("Successfully Saved", successToast);
		 			setTimeout(function(){
		 				$('#tbl_news').DataTable().destroy();
						$('#tbl_inter_office_news').DataTable().destroy();
						load_news();
					}, 100);
		 			
		 		}
		 	});

	 }

	function load_news(){
    
    $('#tbl_news').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.announcement.php?load_news&news=all",
              "columns" : [
                    
                    { "data" : "topic"},
                    { "data" : "publish_date"},
                    { "data" : "end_date"},
                    { "data" : "ack_status"},
                    { "data" : "action"}

                ],
         });
    $('#tbl_inter_office_news').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.announcement.php?load_news&news=department",
              "columns" : [
                    
                    { "data" : "department"},
                    { "data" : "topic"},
                    { "data" : "publish_date"},
                    { "data" : "end_date"},
                    { "data" : "ack_status"},
                    { "data" : "action"}

                ],
         });
  }
  load_news();

  function backmodule(){
  	window.location.href="module.php";
  }

  function goto(linkk){
	window.location.href=linkk;
  }

  function btnAnnouncement(){
    $('#div_news').show();
    $('#div_inter_office_news').hide();
    $("#announcement").addClass("active");
    $("#inter_office_announcement").removeClass("active");
  }

 function btnInterOfficeAnnouncement(){
   $('#div_news').hide();
    $('#div_inter_office_news').show();
    $("#announcement").removeClass("active");
    $("#inter_office_announcement").addClass("active");
 }
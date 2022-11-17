var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
	$('#li_dashboard').addClass('active_tab');
	$('.drawer').hide();
     $('.drawer').on('click',function(){
      $('.navnavnav').slideToggle();
    });

	$('#logout').on('click',function(){
		confirmed("save",deleteCLient_callback, "Do you really want to logout?", "Yes", "No");
	});

});

function deleteCLient_callback(){

    $.ajax({
		url:"controller/controller.login.php?logout",
		method:"GET",
		success:function(){
			window.location.href="index.php";
		}
	});

}


	// function lb(){

	// 		 $.ajax({
	// 			url:"controller/controller.leavebalance.php?leave_credits_load",
	// 			method:"POST",
	// 			data:{
	// 				id:""
	// 			},success:function(){

	// 			}
	// 		});
			 
	// }
	// lb();

	function open_file_news(){
		var news_filename = $('#news_filename').val();
		window.open('news/'+news_filename);
	}
	
	function open_file_docu(){
		var docu_filename = $('#docu_filename').val();
		window.open('documents/'+docu_filename);
	}	

	function view(id){
		$.ajax({
			url:"controller/controller.modules.php?view_announce",
			method:"POST",
			data:{
				id: id
			},success:function(data){
				var b = $.parseJSON(data);
				$('#topic').val(b.topic);
				$('#publish_date').val(b.publish_date);
				$('#end_date').val(b.end_date);
				$('#ack_status').val(b.ack_status);
				$('#news_filename').val(b.file_name);


				$('#announce_modal').modal('show');
			}
		});
	}


	

	function goto(linkk){
		
		window.location.href=linkk;
	}
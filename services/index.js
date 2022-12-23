var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

});

	function login(){

		var username = $('#username').val();
		var password = $('#password').val();

		$.ajax({

			url:"controller/controller.login.php?login",
			method:"POST",
			data:{
				username : username,
				password : password
			},success:function(data){
				var b = $.parseJSON(data);
				if(b.emp_status=="meron"){
					window.location.href="module.php";
				}else{
					$.Toast("Invalid Username or Password", errorToast);
				}
				// console.log(data)
			}
		});

	}
<?php 
session_start();
// session_destroy(); 	
if(isset($_SESSION['fullname'])){
	header("location:module.php");
}else{
	session_destroy(); 	
}
require_once "header.php";
?>
<div class="loginform_div">
	
<center>
	<div class="loginform">
		<img src="lib/logo.png" class="loginlogo">
		<input type="text" class="text-login"  id="username" name="username" placeholder="Username">
		<input type="password" class="text-login" id="password" name="pass" placeholder="Password">
		<button type="button" onclick="login()" class="btn-login w-100">Login</button>
	</div>
</center>

</div>

<script src="services/index.js"></script>
<!-- <script src="//code.tidio.co/vc92ysg5tbaeqwehpt4akui6yfrqavj8.js" async></script> -->
</body>
</html>
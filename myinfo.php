<?php 
session_start();

$usertype = $_SESSION['usertype'];
$empno = $_SESSION['employeeno'];
$approver = $_SESSION['approver'];


if(!isset($_SESSION['fullname'])){
  header("location:index.php");
}
require_once "header.php";
require_once "controller/controller.leave.php";
$leaves = new crud();
$count = $leaves->countLeaves($empno);
 ?>

<div class="sidenavigation">
  <?php 
  require_once "ess_tab.php";
   ?>
</div>

<div class="navtabs">
      
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item">
          <a class="nav-link active" id="" href="#">Personal Details</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_myinfo" class="div_content">
  	<img src="" id="personal_pic">
		<br><br>
    <table class="table table-striped w-100">

						<tr>
							<td>First Name: <b><span id="fname"></span></b></td>
							<td>Middle Name: <b><span id="mname"></span></b></td>
							<td>Last Name: <b><span id="lname"></span></b></td>
						</tr>

						<tr>
							<td>Employee Number: <b><span id="empno"></b></td>
							<td>Date Hired: <b><span id="datehired"></span></b></td>
							<td>Date of Birth: <b><span id="dob"></span></b></td>
						</tr>

						<tr>
							<td>Nationality: <b><span id="nationality"></span></b></td>
							<td>Marital Status: <b><span id="marital_status"></span></b></td>
							<td>Gender: <b><span id="genderr"></span></b></td>
						</tr>

						<tr>
							<td><button type="button" onclick="change()" class="btn btn-sm btn-success"><i class="fas fa-sm fa-lock"></i> Change Password</button></td>
							<td><br></td>
							<td><br></td>
						</tr>

					</table>
  </div>
 
</div>

<div class="modal fade" id="password_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Account Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control txtbox" disabled="" id="username_modal" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Password</label>
            <input type="text" class="form-control txtbox" id="pass_modal" placeholder="">
          </div>
          
          <center>
          <button class="btn btn-success btn-sm" type="button" id="" onclick="save_pass()"><i class="fa fa-save"></i> Save</button>
          </center>

      </div>

    </div>
  </div>
</div>

<input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="">
</body>
<script src="services/info.js"></script>
</html>
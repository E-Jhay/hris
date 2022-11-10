<?php 
session_start();
$usertype = $_SESSION['usertype'];
$userrole = $_SESSION['userrole'];
if(!isset($_SESSION['fullname'])){
  header("location:index.php");
}
require_once "header.php";
 ?>

<div class="sidenavigation">
  <?php 
  require_once "master_tab.php";
   ?>
</div>

<div class="navtabs">
      
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item">
          <a class="nav-link active" id="" href="#">Contact information</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_myinfo" class="div_content">
  	<form action="">
			<?php 
		  require_once "info_tab.php";
		  ?>

			<table class="table-condensed grid12_master master_input">
    			<tr>
    				<td><b>Street/Brgy: </b><input type="text" class="form-control" id="street" name="street"></td>
    			</tr>
    			<tr>
						<td><b>Municipality: </b><input type="text" class="form-control" id="municipality" name="municipality"></td>
					</tr>
					<tr>
						<td><b>Province: </b><input type="text" class="form-control" id="province" name="province"></td>
					</tr>
					<tr>
						<td><b>Contact no: </b><input type="text" class="form-control" id="contactno" name="contactno"></td>
					</tr>
					<tr>
						<td><b>Telephone no: </b><input type="text" class="form-control" id="telephoneno" name="telephoneno"></td>
					</tr>
					<tr>
						<td><b>Corp Email: </b><input type="text" class="form-control" id="corp_email" name="corp_email"></td>
					</tr>
					<tr>
						<td><b>Personal Email: </b><input type="text" class="form-control" id="personal_email" name="personal_email"></td>
					</tr>
					<tr>
						<td><b>Nationality: </b><input type="text" class="form-control" id="nationality" name="nationality"></td>
					</tr>
					<tr>
						<td><b>Department Head Email: </b><input type="text" class="form-control" id="dept_head_email" name="dept_head_email"></td>
					</tr>
					<tr class="d-none">
						<td><b>Driver License Number: </b><input type="text" class="form-control" id="driver_license" name="driver_license"></td>
					</tr>
					<tr class="d-none">
						<td><b>License Expiry: </b><input type="text" class="form-control" id="driver_expdate" name="driver_expdate"></td>
					</tr>
			</table>
		</form>
  </div>
 
</div>

</body>
<script src="services/dashboard.js"></script>
</html>
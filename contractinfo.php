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
          <a class="nav-link active" id="" href="#">Contract information</a>
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
    				<td><b>Job Title: </b><input type="text" class="form-control" id="job_title" name="job_title"></td>
    			</tr>
    			<tr>
						<td><b>Job Category: </b><select class="form-control" id="job_category" name="job_category"></select></td>
					</tr>
					<tr>
						<td><b>Date Hired: </b><input type="date" class="form-control" id="date_hired" name="date_hired"></td>
					</tr>
					<tr>
						<td><b>End of Contract: </b><input type="date" class="form-control" id="eoc" name="eoc"></td>
					</tr>
					<tr>
						<td><b>Regularized: </b><input type="date" class="form-control" id="regularized" name="regularized"></td>
					</tr>
					<tr>
						<td><b>Resigned: </b><input type="date" class="form-control" id="resigned" name="resigned"></td>
					</tr>
					<tr>
						<td><b>Retired: </b><input type="date" class="form-control" id="retired" name="retired"></td>
					</tr>
					<tr>
						<td><b>Terminated: </b><input type="date" class="form-control" id="terminated" name="terminated"></td>
					</tr>
					<tr>
						<td><b>Last Pay: </b><input type="date" class="form-control" id="lastpay" name="lastpay"></td>
					</tr>
					<tr>
						<td><b>Remarks: </b><textarea class="form-control" id="remarks" name="remarks"></textarea></td>
					</tr>
					<input type="date" class="inpinfo d-none" id="preterm" name="preterm">
			</table>

		</form>
  </div>
 
</div>


</body>
<script src="services/contract.js"></script>
</html>
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
          <a class="nav-link active" id="" href="#">Medical information</a>
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
    				<td><b>Type: </b><input type="text" class="form-control" id="type1" name="type1"></td>
    			</tr>
    			<tr>
						<td><b>Classification: </b><input type="text" class="form-control" id="classification1" name="classification1"></td>
					</tr>
					<tr>
						<td><b>Status: </b><input type="text" class="form-control" id="status1" name="status1"></td>
					</tr>
					<tr>
						<td><b>Date of Examination: </b><input type="date" class="form-control" id="dateofexam1" name="dateofexam1"></td>
					</tr>
					<tr>
						<td><b>Remarks: </b><input type="text" class="form-control" id="remarks1" name="remarks1"></td>
					</tr>

					<tr>
    				<td><b>Type: </b><input type="text" class="form-control" id="type2" name="type2"></td>
    			</tr>
    			<tr>
						<td><b>Classification: </b><input type="text" class="form-control" id="classification2" name="classification2"></td>
					</tr>
					<tr>
						<td><b>Status: </b><input type="text" class="form-control" id="status2" name="status2"></td>
					</tr>
					<tr>
						<td><b>Date of Examination: </b><input type="date" class="form-control" id="dateofexam2" name="dateofexam2"></td>
					</tr>
					<tr>
						<td><b>Remarks: </b><input type="text" class="form-control" id="remarks2" name="remarks2"></td>
					</tr>

					<tr>
    				<td><b>Type: </b><input type="text" class="form-control" id="type3" name="type3"></td>
    			</tr>
    			<tr>
						<td><b>Classification: </b><input type="text" class="form-control" id="classification3" name="classification3"></td>
					</tr>
					<tr>
						<td><b>Status: </b><input type="text" class="form-control" id="status3" name="status3"></td>
					</tr>
					<tr>
						<td><b>Date of Examination: </b><input type="date" class="form-control" id="dateofexam3" name="dateofexam3"></td>
					</tr>
					<tr>
						<td><b>Remarks: </b><input type="text" class="form-control" id="remarks3" name="remarks3"></td>
					</tr>
					
			</table>
		</form>
  </div>
 
</div>

</body>
<script src="services/medical.js"></script>
</html>
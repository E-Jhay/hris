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
          <a class="nav-link active" id="" href="#">Other Personal information</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_myinfo" class="div_content">

  	<form action="" id="form" enctype="multipart/form-data">
			<?php 
		  require_once "info_tab.php";
		  ?>
		  

			<table class="table-condensed grid12_master master_input">
					<tr class="d-none">
						<td><input id="profile" type="file" name="profile"></td>
					</tr>
    			<tr>
    				<td><b>Nick Name: </b><input type="text" class="form-control" id="nickname" name="nickname"></td>
    			</tr>
    			<tr>
						<td><b>Birthdate: </b><input type="date" class="form-control" id="dateofbirth" name="dateofbirth"></td>
					</tr>
					<tr>
						<td><b>Age: </b><input type="text" class="form-control" id="age" name="age"></td>
					</tr>
					<tr>
						<td><b>Gender: </b>
							<select class="form-control" id="gender" name="gender">
										<option selected="" value="" disabled="">-- Select gender --</option>
										<option value="Male"> Male </option>
										<option value="Female"> Female </option>
							</select>
						</td>
					</tr>
					<tr>
						<td><b>Height: </b><input type="text" class="form-control" id="height" name="height"></td>
					</tr>
					<tr>
						<td><b>Weight: </b><input type="text" class="form-control" id="weight" name="weight"></td>
					</tr>
					<tr>
						<td><b>Marital Status: </b>
									<select class="form-control" id="marital_status" name="marital_status">
										<option selected="" value="" disabled="">-- Select Status --</option>
										<option value="Single"> Single </option>
										<option value="Married"> Married </option>
										<option value="Widowed"> Widowed </option>
										<option value="Annulled"> Annulled </option>
									</select>
						</td>
					</tr>
					<tr>
						<td><b>Birth Place: </b><input type="text" class="form-control" id="birth_place" name="birth_place"></td>
					</tr>
					<tr>
						<td><b>Birth Type: </b><input type="text" class="form-control" id="blood_type" name="blood_type"></td>
					</tr>
					<tr>
						<td><b> ** Contact Person ** </b></td>
					</tr>

					<tr>
						<td><b>Name: </b><input type="text" class="form-control" id="contact_name" name="contact_name"></td>
					</tr>
					<tr>
						<td><b>Address: </b><input type="text" class="form-control" id="contact_address" name="contact_address"></td>
					</tr>
					<tr>
						<td><b>Contact no: </b><input type="text" class="form-control" id="contact_celno" name="contact_celno"></td>
					</tr>
					<tr>
						<td><b>Telephone no: </b><input type="text" class="form-control" id="contact_telno" name="contact_telno"></td>
					</tr>

					<tr>
						<td><b>Relationship: </b><input type="text" class="form-control" id="contact_relation" name="contact_relation"></td>
					</tr>

			</table>
		</form>
  </div>
 
</div>


</body>

<script src="services/otherinfo.js"></script>
</html>
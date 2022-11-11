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
  require_once "pim_tab.php";
   ?>
</div>

<div class="navtabs">
      
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item">
          <a class="nav-link active" id="" href="#">New Employee</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_newemployee" class="div_content">
    <form>
		<table class="table-condensed grid3_master">
			<tr>
				<td class="text-center"><img style="border: 1px dashed #a7a7a7; cursor: pointer;" src="usera.png" id="personal_image"></td>
				<td class="d-none"><input id="profile" type="file" name="profile"></td>
			</tr>
			<tr>
				<td>
					<b>Employee no: </b>
					<input type="text" class="form-control" name="employeenoProxy" required="" id="employeenoProxy" disabled>
					<input type="hidden" class="form-control" placeholder="Employee number" name="employeeno" required="" id="employeeno">
					<input type="hidden" id="password" name="password">
				</td>
			</tr>
			<!-- <tr class="d-none">
				<td><b>Rank: </b><input type="text" class="form-control" id="rank" name="rank"></td>
			</tr>
				
			<tr class="d-none">
				<td><b>Company: </b><select class="form-control" id="company" name="company"></select></td>
			</tr>
				
			<tr class="d-none">
				<td><b>Leave Balance: </b><input type="text" class="form-control" id="leave_balance" name="leave_balance"></td>
			</tr> -->
		</table>

		<table class="table-condensed grid3_master">
			<tr>
				<td>
					<b>First name: </b>
					<input type="text" class="form-control" placeholder="Firstname" name="firstname" required="">
				</td>
			</tr>
			<tr>
				<td>
					<b>Middle name: </b>
					<input type="text" class="form-control" placeholder="Lastname" name="lastname" required="">
				</td>
			</tr>		
			<tr>
				<td>
					<b>Last name: </b>
					<input type="text" class="form-control" placeholder="Middlename" name="middlename">
				</td>
			</tr>
		</table>

		<table class="table-condensed grid3_master">
			<tr>
				<td><b>Status: </b>
					<select class="form-control" id="statuss" name="statuss">
						<option value="Active">Active</option>
						<option value="Inactive">Inactive</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<b>Employment Status: </b>
					<select class="form-control" id="employment_status" name="employment_status"></select>
				</td>
			</tr>
			<tr>
				<td>
					<b>Company: </b>
					<select class="form-control" id="company" name="company"></select>
				</td>
			</tr>		
		</table>

		<table class="table-condensed grid12_master">
			<tr>
				<td style="width: 33.33%">
					<b>Job Title: </b>
					<select class="form-control" id="company" name="company"></select>
				</td>
				<td style="width: 33.33%">
					<b>Job Category: </b>
					<select class="form-control" id="company" name="company"></select>
				</td>
				<td style="width: 33.33%">
					<b>Department: </b>
					<select class="form-control" id="company" name="company"></select>
				</td>
			</tr>
			<tr>
				<td>
					<b>Corp Email: </b>
					<input type="text" class="form-control" placeholder="Corp Email" name="corp_email" required="">
				</td>
				<td>
					<b>Contact Number: </b>
					<input type="text" class="form-control" placeholder="0000-0000000" maxlength="12" minlength="12" id="contactno" name="contact_no">
				</td>
			</tr>
		</table>
		<!-- <div class="row">
			<div class="col">
				<b>Contact Number: </b>
				<input type="text" class="form-control" placeholder="0000-0000000" maxlength="12" minlength="12" id="contactno" name="contact_no">
				<b>Contact Number: </b>
				<input type="text" class="form-control" placeholder="0000-0000000" maxlength="12" minlength="12" id="contactno" name="contact_no">
				<b>Contact Number: </b>
				<input type="text" class="form-control" placeholder="0000-0000000" maxlength="12" minlength="12" id="contactno" name="contact_no">
			</div>
			<div class="col">
				<b>Contact Number: </b>
				<input type="text" class="form-control" placeholder="0000-0000000" maxlength="12" minlength="12" id="contactno" name="contact_no">
				<b>Contact Number: </b>
				<input type="text" class="form-control" placeholder="0000-0000000" maxlength="12" minlength="12" id="contactno" name="contact_no">
				<b>Contact Number: </b>
				<input type="text" class="form-control" placeholder="0000-0000000" maxlength="12" minlength="12" id="contactno" name="contact_no">
			</div>
		</div> -->

		<center>
			<button type="submit" class="btn btn-success btn-md"><i class="fas fa-sm fa-save"></i> Save Employee</button>
		</center>
	</form>
  </div>
 
</div>

</body>
<script src="services/addemployee.js"></script>
</html>
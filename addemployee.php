<?php 
session_start();
$usertype = $_SESSION['usertype'];
$userrole = $_SESSION['userrole'];
$empno = $_SESSION['employeeno'];
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
    <form id="form" enctype="multipart/form-data">
		<table class="table-condensed grid3_master">
			<tr>
				<td class="text-center"><img style="border: 1px dashed #a7a7a7; cursor: pointer;" src="usera.png" id="personal_image"></td>
				<input class="d-none" id="profile" type="file" name="profile" accept="image/png, image/gif, image/jpeg">
			</tr>
			<tr>
				<td>
					<b>Employee no: </b>
					<input type="text" class="form-control" name="employeenoProxy" required="" id="employeenoProxy" disabled>
					<input type="hidden" class="form-control" placeholder="Employee number" name="employeeno" required="" id="employeeno">
					<input type="hidden" class="form-control" placeholder="Employee ID number" name="id_number" required="" id="id_number">
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
					<b>Job Title: </b>
					<select class="form-control" id="job_title" name="job_title"></select>
				</td>
			</tr>
			<tr>
				<td>
					<b>Job Category: </b>
					<select class="form-control" id="job_category" name="job_category"></select>
				</td>
			</tr>		
			<tr>
				<td>
					<b>Department: </b>
					<select class="form-control" id="department" name="department"></select>
				</td>
			</tr>
		</table>

		<table class="table-condensed grid3_master">
			<tr>
				<td><b>Status: </b>
					<select class="form-control" id="statuss" name="statuss">
						<option value="Active" selected>Active</option>
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

		<table class="table-condensed gridCustom_master">
			<tr>
				<td>
					<h4>Personal Information</h4>
				</td>
			</tr>
			<tr>
				<td>
					<b>First name: </b>
					<input type="text" class="form-control" placeholder="Firstname" name="firstname" required="">
				</td>
				<td>
					<b>Middle name: </b>
					<input type="text" class="form-control" placeholder="Middlename" name="middlename" required="">
				</td>
				<td>
					<b>Last name: </b>
					<input type="text" class="form-control" placeholder="Lastname" name="lastname">
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
				<td>
					<b>Gender: </b>
					<select class="form-control" id="gender" name="gender">
						<option selected="" value="" disabled="">-- Select gender --</option>
						<option value="Male"> Male </option>
						<option value="Female"> Female </option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<b>Birthday: </b>
					<input type="date" class="form-control" id="dateofbirth" name="dateofbirth">
					<input type="hidden" class="form-control" id="age" name="age">
				</td>
				<td>
					<b>Birth Place: </b>
					<input type="text" class="form-control" id="birth_place" name="birth_place" placeholder="Birth place">
				</td>
				<td>
					<b>Marital Status: </b>
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
				<td>
					<b>Nationality: </b>
					<input type="text" class="form-control" id="nationality" name="nationality" placeholder="Nationality">
				</td>
				<td>
					<b>Personal Email: </b>
					<input type="text" class="form-control" id="personal_email" name="personal_email" placeholder="personal@gmail.com">
				</td>
				<td>
					<b>Dept Head Email: </b>
					<input type="text" class="form-control" id="dept_head_email" name="dept_head_email" placeholder="depthead@gmail.com">
				</td>
			</tr>
			<tr>
				<td><h4>Address</h4></td>
			</tr>
			<tr>
				<td>
					<b>Street: </b>
					<input type="text" class="form-control" id="street" name="street" placeholder="Street">
				</td>
				<td>
					<b>Municipality: </b>
					<input type="text" class="form-control" id="municipality" name="municipality" placeholder="Municipality">
				</td>
				<td>
					<b>Province: </b>
					<input type="text" class="form-control" id="province" name="province" placeholder="Province">
				</td>
			</tr>
			<tr>
				<td><h4>Contract Information</h4></td>
			</tr>
			<tr>
				<td>
					<b>Date hired: </b>
					<input type="date" class="form-control" id="date_hired" name="date_hired">
				</td>
				<td>
					<b>End of contract: </b>
					<input type="date" class="form-control" id="end_of_contract" name="end_of_contract">
				</td>
				<td>
					<b>Regularized: </b>
					<input type="date" class="form-control" id="regularized" name="regularized">
				</td>
			</tr>
			<tr>
				<td><h4>Government ID's / ATM</h4></td>
			</tr>
			<tr>
				<td>
					<b>TIN#: </b>
					<input type="text" class="form-control" id="tin" name="tin" placeholder="TIN #">
				</td>
				<td>
					<b>SSS#: </b>
					<input type="text" class="form-control" id="sss" name="sss" placeholder="SSS Number">
				</td>
				<td>
					<b>PHIC#: </b>
					<input type="text" class="form-control" id="phic" name="phic" placeholder="PHIC Number">
				</td>
			</tr>
			<tr>
				<td>
					<b>HDMF#: </b>
					<input type="text" class="form-control" id="hdmf" name="hdmf" placeholder="HDMF Number">
				</td>
				<td>
					<b>ATM#: </b>
					<input type="text" class="form-control" id="atm" name="atm" placeholder="ATM Number">
				</td>
				<td>
					<b>Bank Name: </b>
					<input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name">
				</td>
			</tr>
		</table>
		<table class="table-condensed gridCustom_master">
			<tr>
				<h4>Additional Documents</h4>
			</tr>
			<tr>
				<td>
					<b>Marriage Contract: </b><br />
					<input id="marriageContract" type="file" name="marriageContract" accept="image/png, image/gif, image/jpeg, application/pdf">
				</td>
				<td>
					<b>Dependent (Birth Certificate): </b><br />
					<input id="dependent" type="file" name="dependent" accept="image/png, image/gif, image/jpeg, application/pdf">
				</td>
			</tr>
			<tr>
				<td>
					<b>Additional ID (Solo Parent ID/National ID or other types): </b><br />
					<input id="additionalId" type="file" name="additionalId" accept="image/png, image/gif, image/jpeg, application/pdf">
				</td>
				<td>
					<b>Proof of Billing: </b><br />
					<input id="proofOFBilling" type="file" name="proofOFBilling" accept="image/png, image/gif, image/jpeg, application/pdf">
				</td>
			</tr>
		</table>

		<center>
			<button type="submit" class="btn btn-success btn-md"><i class="fas fa-sm fa-save"></i> Save Employee</button>
		</center>
	</form>
  </div>
 
</div>

<input type="text" id="currentUser" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
</body>
<script src="services/addemployee.js"></script>
<script src="services/pim_tab.js"></script>
</html>
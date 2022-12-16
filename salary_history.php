<?php 
session_start();
$empno = $_SESSION['employeeno'];
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
          <a class="nav-link active" id="" href="#">Salary History information</a>
        </li>
      </ul>

</div>

<div class="navcontainer">
  	<div id="div_myinfo" class="div_content">
		<form action="">
			<input type="hidden" id="employeeno" value="<?php echo $_GET['employeeno']; ?>" name="employeeno">
			<table class="table-condensed grid3_master master_input">
				<tr>
					<td class="text-center"><img  style="border: 1px dashed #a7a7a7; cursor: pointer;" src="" id="personal_image"></td>
				</tr>
				<tr>
					<td><b>Employee no: </b><input type="text" class="form-control" id="emp_no" name="emp_no"></td>
				</tr>
				<tr class="d-none">
					<td><b>Rank: </b><input type="text" class="form-control" id="rank" name="rank"></td>
				</tr>
					
				<tr class="d-none">
					<td><b>Company: </b><select class="form-control" id="company" name="company"></select></td>
				</tr>
					
				<tr class="d-none">
					<td><b>Leave Balance: </b><input type="text" class="form-control" id="leave_balance" name="leave_balance"></td>
				</tr>
			</table>

			<table class="table-condensed grid3_master master_input">

				<tr>
					<td><b>First name: </b><input type="text" class="form-control" id="f_name" name="f_name"></td>
				</tr>
				<tr>
					<td><b>Last name: </b><input type="text" class="form-control" id="l_name" name="l_name"></td>
				</tr>
				<tr>
					<td><b>Middle name: </b><input type="text" class="form-control" id="m_name" name="m_name"></td>
				</tr>
								
			</table>

			<table class="table-condensed grid3_master master_input">

				<tr>
					<td><b>Status: </b>
						<select class="form-control" id="statuss" name="statuss">
							<option value="Active">Active</option>
							<option value="Inactive">Inactive</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><b>Employment Status: </b><select class="form-control" id="emp_statuss" name="emp_statuss"></select></td>
				</tr>
				<tr>
					<td><b>Department: </b><select class="form-control" required="" id="department" name="department"></select></td>
				</tr>
							
			</table>

		</form>
		<div class="grid12_master p-3">
			<button type="button" class="btn btn-sm btn-success" onclick="salary_adjust()"><i class="fas fa-sm fa-wallet"></i> Salary Adjustment</button>
			<div class="table-responsive">
				<table class="table" id="tbl_salaryhistory">
					<thead>
						<!-- <th>Position</th>
						<th>Employment Status</th> -->
						<!-- <th>Date Hired</th> -->
						<th>Basic salary</th>
						<th>Salary Type1</th>
						<th>Salary Rate1</th>
						<th>Salary Type2</th>
						<th>Salary Rate2</th>
						<th>Salary Type3</th>
						<th>Salary Rate3</th>
						<th>Salary Type4</th>
						<th>Salary Rate4</th>
						<th>Effective Date</th>
						<th width="200px" class="text-center">Action</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>   
  	</div>
</div>

<div class="modal fade" id="salarymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Salary Adjustment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formModal" enctype="multipart/form-data">
		<div class="modal-body">
			<div class="form-group">
				<input type="hidden" id="employeenoModal"  name="employeenoModal" value="<?php echo $_GET['employeeno']; ?>">
				<input type="text" name="file_name" id="file_name">
				<input type="hidden" id="action"  name="action">
				<input type="hidden" id="idsalary" name="idsalary">
			  <label for="exampleInputEmail1">Position</label>
			  <input type="text" class="form-control txtbox" id="positionemp" name="positionemp" placeholder="">
			</div>
			<div class="form-group">
			  <label for="exampleInputEmail1">Employment Status</label>
			  <select class="form-control" id="statusemp" name="statusemp"></select>
			</div>
			<div class="form-group">
			  <label for="exampleInputEmail1">Date Hired</label>
			  <input type="date" class="form-control txtbox" id="datehiredemp" name="datehiredemp" placeholder="">
			</div>
			<div class="form-group">
			  <label for="exampleInputEmail1">Basic Salary</label>
			  <input type="number" class="form-control txtbox" id="basic_salary" name="basic_salary" placeholder="">
			</div>
			<div class="form-group">
			  <label for="exampleInputEmail1">Allowance 1</label>
						<select class="form-control" id="salarytype" name="salarytype">
									<option value="" selected=""> --Select allowance-- </option>
									<option value="Subsidy"> Subsidy </option>
									<option value="Revolving Fund"> Revolving Fund </option>
									<option value="Transportation"> Transportation </option>
									<option value="Meal"> Meal </option>
									<option value="Housing"> Housing </option>
									<option value="Professional Fee"> Professional Fee </option>
									<option value="Car Rental"> Car Rental </option>
									<option value="Ecola"> Ecola </option>
					</select>
					<input class="form-control" type="number" id="salaryemp" name="salaryemp">
					<label for="exampleInputEmail1">Allowance 2</label>
							<select class="form-control" id="salarytype2" name="salarytype2">
									<option value="" selected=""> --Select allowance-- </option>
									<option value="Subsidy"> Subsidy </option>
									<option value="Revolving Fund"> Revolving Fund </option>
									<option value="Transportation"> Transportation </option>
									<option value="Meal"> Meal </option>
									<option value="Housing"> Housing </option>
									<option value="Professional Fee"> Professional Fee </option>
									<option value="Car Rental"> Car Rental </option>
									<option value="Ecola"> Ecola </option>
					</select>
					<input class="form-control" type="number" id="salaryemp2" name="salaryemp2">
					<label for="exampleInputEmail1">Allowance 3</label>
							<select class="form-control" id="salarytype3" name="salarytype3">
									<option value="" selected=""> --Select allowance-- </option>
									<option value="Subsidy"> Subsidy </option>
									<option value="Revolving Fund"> Revolving Fund </option>
									<option value="Transportation"> Transportation </option>
									<option value="Meal"> Meal </option>
									<option value="Housing"> Housing </option>
									<option value="Professional Fee"> Professional Fee </option>
									<option value="Car Rental"> Car Rental </option>
									<option value="Ecola"> Ecola </option>
					</select>
					<input class="form-control" type="number" id="salaryemp3" name="salaryemp3">
					<label for="exampleInputEmail1">Allowance 4</label>
							<select class="form-control" id="salarytype4" name="salarytype4">
									<option value="" selected=""> --Select allowance-- </option>
									<option value="Subsidy"> Subsidy </option>
									<option value="Revolving Fund"> Revolving Fund </option>
									<option value="Transportation"> Transportation </option>
									<option value="Meal"> Meal </option>
									<option value="Housing"> Housing </option>
									<option value="Professional Fee"> Professional Fee </option>
									<option value="Car Rental"> Car Rental </option>
									<option value="Ecola"> Ecola </option>
					</select>
					<input class="form-control" type="number" id="salaryemp4" name="salaryemp4">
			</div>
			<div class="form-group">
			  <label for="exampleInputEmail1">Effective Date</label>
			  <input type="date" class="form-control txtbox" id="effectdateemp" name="effectdateemp" placeholder="" required>
					<span style="color: red" id="error" class="d-none">Effected date is required</span>
			</div>
			<div class="form-group">
			  <label for="exampleInputEmail1">Remarks</label>
			  <input type="text" class="form-control txtbox" id="remarks" name="remarks" placeholder="">
			</div>
			<div class="form-group">
			  <label for="exampleInputEmail1">Salary Adjustment (Hardcopy)</label>
			  <input type="file" class="form-control txtbox" id="hardcopy" name="hardcopy">
			</div>
		
			<center>
					  <button type="submit" class="btn btn-sm btn-success" id="btnsave_histo"><i class="fas fa-sm fa-save"></i> Save</button>
				<button type="submit" class="btn btn-sm btn-success" id="btnupd_histo"><i class="fas fa-sm fa-save"></i> Update</button>
			</center>
		</div>
	  </form>

    </div>
  </div>
</div>


</body>
<script src="services/salary.js"></script>
</html>
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
			<?php 
		  require_once "info_tab.php";
		  ?>

		</form>
			<div class="grid12_master master_input p-3">
						<button type="button" class="btn btn-sm btn-success" onclick="salary_adjust()"><i class="fas fa-sm fa-wallet"></i> Salary Adjustment</button>
						<table class="table table-condensed master_input" id="tbl_salaryhistory">
			     			
								<thead>
									<th>Position</th>
									<th>Employment Status</th>
									<th>Date Hired</th>
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
									<th>Action</th>
								</thead>
								<tbody>
									
								</tbody>
					 </table>
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
      <div class="modal-body">

          <div class="form-group">
          	<input type="hidden" id="idemp" value="<?php echo $_GET['id']; ?>" name="">
        		<input type="hidden" id="empno" value="<?php echo $empno; ?>" name="">
        		<input type="hidden" id="idsalary" name="">

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
            <input type="date" class="form-control txtbox" id="effectdateemp" name="effectdateemp" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Remarks</label>
            <input type="text" class="form-control txtbox" id="remarks" name="remarks" placeholder="">
          </div>

          
          <center>
	          <button type="button" class="btn btn-sm btn-success" id="btnsave_histo" onclick="savesalary()"><i class="fas fa-sm fa-save"></i> Save</button>
        		<button type="button" class="btn btn-sm btn-success" id="btnupd_histo" onclick="updatesalary()"><i class="fas fa-sm fa-save"></i> Save</button>
          </center>

      </div>

    </div>
  </div>
</div>


</body>
<script src="services/salary.js"></script>
</html>
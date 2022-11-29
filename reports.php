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
          <a class="nav-link active" id="lnewly" href="#" onclick="btnnewly()">Newly Hired Employee</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="lbirthday" href="#" onclick="btnbirthday()">Birthday</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="lage" href="#" onclick="btnage()">Age</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="ldept" href="#" onclick="btndept()">Job Category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="lgender" href="#" onclick="btngender()">Gender</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="lemployment" href="#" onclick="btnemployment()">Employment Status</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="ldivision" href="#" onclick="btndivision()">Department</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="lmonths" href="#" onclick="btnMonthsEvaluation()">Evaluation</a>
        </li>
      </ul>

</div>

<div class="navcontainer">
  <div id="div_newly" class="div_content">
  	<span>From: </span><input type="date" id="newlyfrom" class="form-control" name="">
		<span>To: </span><input type="date" id="newlyto" name="" class="form-control">
		<div class="text-center">
			<button type="button" class="btn btn-sm btn-success" onclick="searchnewly()"><i class="fas fa-sm fa-search"></i> Generate List</button>
		</div><br />
		<button class="btn btn-sm btn-info" type="button" onclick="exportnewly()"><i class="fas fa-sm fa-file-excel"></i> Export to excel</button><br><br>
  </div>

  <div id="div_bday" class="div_content" style="display: none;">
  	<span>From: </span>
  	<select class="form-control" id="bdayfrom">
			<option value="01"> January </option>
			<option value="02"> February </option>
			<option value="03"> March </option>
			<option value="04"> April </option>
			<option value="05"> May </option>
			<option value="06"> June </option>
			<option value="07"> July </option>
			<option value="08"> August </option>
			<option value="09"> September </option>
			<option value="10"> October </option>
			<option value="11"> November </option>
			<option value="12"> December </option>
		</select>
		<span>To: </span>
		<select class="form-control" id="bdayto">
			<option value="01"> January </option>
			<option value="02"> February </option>
			<option value="03"> March </option>
			<option value="04"> April </option>
			<option value="05"> May </option>
			<option value="06"> June </option>
			<option value="07"> July </option>
			<option value="08"> August </option>
			<option value="09"> September </option>
			<option value="10"> October </option>
			<option value="11"> November </option>
			<option value="12"> December </option>
		</select>
		<div class="text-center">
			<button type="button" class="btn btn-sm btn-success" onclick="searchbday()"><i class="fas fa-sm fa-search"></i> Generate List</button>
		</div><br />
		<button class="btn btn-sm btn-info" type="button" onclick="exportbday()"><i class="fas fa-sm fa-file-excel"></i> Export to excel</button><br><br>
  </div>

  <div id="div_age" class="div_content" style="display: none;">
  	<span>From: </span><input type="number" id="agefrom" class="form-control" name="">
		<span>To: </span><input type="number" id="ageto" name="" class="form-control">
		<div class="text-center">
			<button type="button" class="btn btn-sm btn-success" onclick="searchage()"><i class="fas fa-sm fa-search"></i> Generate List</button>
		</div><br />
		<button class="btn btn-sm btn-info" type="button" onclick="exportage()"><i class="fas fa-sm fa-file-excel"></i> Export to excel</button><br><br>
  </div>

  <div id="div_department" class="div_content" style="display: none;">
  	<span>Job Category: </span><select  class="form-control" id="job_category" name="job_category"></select>
		<div class="text-center">
			<button type="button" class="btn btn-sm btn-success" onclick="searchdept()"><i class="fas fa-sm fa-search"></i> Generate List</button>
		</div><br />
		<button class="btn btn-sm btn-info" type="button" onclick="exportdept()"><i class="fas fa-sm fa-file-excel"></i> Export to excel</button><br><br>
  </div>

  <div id="div_gender" class="div_content" style="display: none;">
  	<span>Gender: </span>
  	<select class="form-control" id="gender" name="gender">
			<option value="All">All</option>
			<option value="Male">Male</option>
			<option value="Female">Female</option>
		</select>
		<div class="text-center">
			<button type="button" class="btn btn-sm btn-success" onclick="searchgender()"><i class="fas fa-sm fa-search"></i> Generate List</button>
		</div><br />
		<button class="btn btn-sm btn-info" type="button" onclick="exportgender()"><i class="fas fa-sm fa-file-excel"></i> Export to excel</button><br><br>
  </div>

  <div id="div_employment" class="div_content" style="display: none;">
  	<span>Employment Status: </span><select class="form-control" id="employment_status" name="employment_status"></select>
		<div class="text-center">
			<button type="button" class="btn btn-sm btn-success" onclick="searchemployment()"><i class="fas fa-sm fa-search"></i> Generate List</button>
		</div><br />
		<button class="btn btn-sm btn-info" type="button" onclick="exportemployment()"><i class="fas fa-sm fa-file-excel"></i> Export to excel</button><br><br>
  </div>

  <div id="div_division" class="div_content" style="display: none;">
  	<span>Department: </span><select class="form-control" id="division" name="division"></select>
		<div class="text-center">
			<button type="button" class="btn btn-sm btn-success" onclick="searchdivision()"><i class="fas fa-sm fa-search"></i> Generate List</button>
		</div><br />
		<button class="btn btn-sm btn-info" type="button" onclick="exportdivision()"><i class="fas fa-sm fa-file-excel"></i> Export to excel</button><br><br>
  </div>
  <div id="div_evaluation" class="div_content" style="display: none;">
		<span>Number of Months: </span>
		<select class="form-control" id="evaluationMonth">
			<option value="" disabled selected>--Select Months--</option>
			<option value="3"> 3rd Month Evaluation </option>
			<option value="6"> 5th Month Evaluation </option>
			<option value="18"> 18th Month Evaluation </option>
		</select>
		<div class="text-center">
			<button type="button" class="btn btn-sm btn-success" onclick="searchEvaluation()"><i class="fas fa-sm fa-search"></i> Generate List</button>
		</div>
		<br />
		<button class="btn btn-sm btn-info" type="button" onclick="exportEvaluation()"><i class="fas fa-sm fa-file-excel"></i> Export to excel</button><br><br>
  </div>

  <table class="table table-striped w-100" id="tbl_employee">
      <thead>
        <th>Employee No</th>
				<th>Lastname</th>
				<th>Firstname</th>
				<th>Middlename</th>
				<th>Job Title</th>
				<th>Employment Status</th>
				<th>Company</th>
      </thead>
      <tbody>
              
      </tbody>
  </table>
 
</div>

<input type="hidden" id="currentUser" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
</body>
<script src="services/reports.js"></script>
<script src="services/pim_tab.js"></script>
</html>
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
          <a class="nav-link active" id="" href="#">Employee List</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_employeelist" class="div_content">
  	<select class="form-control" id="statusdd">
			<option value="Active" selected=""> Active </option>
			<option value="Inactive"> Inactive </option>
			<option value="All"> All </option>
		</select><br><br>
    <table class="table table-striped w-100" id="tbl_employee">
            <thead>
              <th></th>
							<th>EmployeeNo</th>
							<th>Lastname</th>
							<th>Firstname</th>
							<th>Middlename</th>
							<th>Job Title</th>
							<th>Employment Status</th>
							<th>Company</th>
							<th>Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>

</div>

<input type="hidden" id="currentUser" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
</body>
<script src="services/employee.js"></script>
<script src="services/pim_tab.js"></script>
</html>
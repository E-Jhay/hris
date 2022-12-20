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
    <div class="text-right"><button onclick="updateEmployees()" id="updatedEmployeesBtn" class="btn btn-success btn-md">Update Employees</button></div>
    <br />
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
							<th width="150px" class="text-center">Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>

</div>

<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Upload Employee Masterfile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formModal" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>Upload File:</label>
            <input type="file" class="form-control" required="" id="file" name="file" accept=".xlsx,.xls">
          </div>
          
          <center>
            <button type="submit" class="btn btn-sm btn-success" id="updateEmployeeBtn">Upload</button>
          </center>
        </form>

      </div>

    </div>
  </div>
</div>

<input type="hidden" id="currentUser" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
</body>
<script src="services/employee.js"></script>
<script src="services/pim_tab.js"></script>
</html>
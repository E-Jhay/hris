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
          <a class="nav-link active" id="" href="#">Other Files</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_myinfo" class="div_content">
  	<form name="form" id="form" enctype="multipart/form-data">
	  	<input type="hidden" id="emp_id" value="<?php echo $_GET['id']; ?>" name="emp_id">
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

		<div class="grid12_master p-3">
			<table class="table-condensed w-100 mb-4">
    			<tr>
    				<td><p>Note: Maximum of 10 files can be uploaded on the same time.</p></td>
    			</tr>
    			<tr>
						<td><b>Choose File: </b><input class="form-control" multiple="" id="empfile" required="" type="file" name="empfile[]" onchange="filefile()" /></td>
					</tr>
					<tr>
						<td class="text-center"><button type="submit" class="btn btn-md btn-success">Save</button></td>
					</tr>
			</table>

			<table class="table table-condensed w-100" id="tbl_file">
							<thead>
								<th>File Name</th>
								<th class="text-center">Action</th>
							</thead>
							<tbody>
								
							</tbody>
			</table>
		</div>
		</form>

		
  </div>
 
</div>

</body>
<script src="services/file.js"></script>
</html>
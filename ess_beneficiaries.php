<?php 
session_start();
$usertype = $_SESSION['usertype'];
$userrole = $_SESSION['userrole'];
$employeeno = $_SESSION['employeeno'];
if(!isset($_SESSION['fullname'])){
  header("location:index.php");
}
require_once "header.php";
 ?>

<div class="sidenavigation">
  <?php 
  require_once "ess_tab.php";
   ?>
</div>

<div class="navtabs">
      
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item">
          <a class="nav-link active" id="" href="#">Benefits information</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_myinfo" class="div_content">
  	<!-- <form action="">
			<?php 
		  require_once "info_tab.php";
		  ?>

			<table class="table-condensed grid12_master master_input">
    			<tr>
    				<td><b>Dependents </b></td>
    			</tr>
    			<tr>
						<td><b>Name (Dependent 1): </b><input type="text" class="form-control" id="dependent1" name="dependent1"></td>
					</tr>
					<tr>
						<td><b>Age: </b><input type="number" class="form-control" id="age1" name="age1"></td>
					</tr>
					<tr>
						<td><b>Sex: </b>
									<select class="form-control" id="sex1" name="sex1">
										<option value="" selected=""> -- Select --</option>
										<option value="Male"> Male </option>
										<option value="Female"> Female </option>
									</select>
								</td>
					</tr>
					<tr>
						<td><b>Relationship: </b><input type="text" class="form-control" id="relation1" name="relation1"></td>
					</tr>

					<tr>
						<td><b>Name (Dependent 2): </b><input type="text" class="form-control" id="dependent2" name="dependent2"></td>
					</tr>
					<tr>
						<td><b>Age: </b><input type="number" class="form-control" id="age2" name="age2"></td>
					</tr>
					<tr>
						<td><b>Sex: </b>
									<select class="form-control" id="sex2" name="sex2">
										<option value="" selected=""> -- Select --</option>
										<option value="Male"> Male </option>
										<option value="Female"> Female </option>
									</select>
								</td>
					</tr>
					<tr>
						<td><b>Relationship: </b><input type="text" class="form-control" id="relation2" name="relation2"></td>
					</tr>

					<tr>
						<td><b>Name (Dependent 3): </b><input type="text" class="form-control" id="dependent3" name="dependent3"></td>
					</tr>
					<tr>
						<td><b>Age: </b><input type="number" class="form-control" id="age3" name="age3"></td>
					</tr>
					<tr>
						<td><b>Sex: </b>
									<select class="form-control" id="sex3" name="sex3">
										<option value="" selected=""> -- Select --</option>
										<option value="Male"> Male </option>
										<option value="Female"> Female </option>
									</select>
								</td>
					</tr>
					<tr>
						<td><b>Relationship: </b><input type="text" class="form-control" id="relation3" name="relation3"></td>
					</tr>

					<tr>
						<td><b>Name (Dependent 4): </b><input type="text" class="form-control" id="dependent4" name="dependent4"></td>
					</tr>
					<tr>
						<td><b>Age: </b><input type="number" class="form-control" id="age4" name="age4"></td>
					</tr>
					<tr>
						<td><b>Sex: </b>
									<select class="form-control" id="sex4" name="sex4">
										<option value="" selected=""> -- Select --</option>
										<option value="Male"> Male </option>
										<option value="Female"> Female </option>
									</select>
								</td>
					</tr>
					<tr>
						<td><b>Relationship: </b><input type="text" class="form-control" id="relation4" name="relation4"></td>
					</tr>

					<tr>
						<td><b>Name (Dependent 5): </b><input type="text" class="form-control" id="dependent5" name="dependent5"></td>
					</tr>
					<tr>
						<td><b>Age: </b><input type="number" class="form-control" id="age5" name="age5"></td>
					</tr>
					<tr>
						<td><b>Sex: </b>
									<select class="form-control" id="sex5" name="sex5">
										<option value="" selected=""> -- Select --</option>
										<option value="Male"> Male </option>
										<option value="Female"> Female </option>
									</select>
								</td>
					</tr>
					<tr>
						<td><b>Relationship: </b><input type="text" class="form-control" id="relation5" name="relation5"></td>
					</tr>
			</table>
	</form> -->

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
  	<form name="form" id="form" enctype="multipart/form-data" style="width: 100%; float: left; padding: 1em">
        <div>
        <button type="button" id="addBtn" class="btn btn-sm btn-primary mb-4">Add Dependent</button>
        <button type="button" id="cancelBtn" class="btn btn-sm btn-warning mb-4" style="display: none; ">Cancel</button>
        </div>
        
        <table class="table-condensed" id="dependent_table" style="width: 100%; float: left; padding: 1em">
            <tr>
                <td>
                    <b>Name of dependent: </b>
                    <input type="text" class="form-control" id="name_of_dependent" name="name_of_dependent" placeholder="Name of dependent" required>
                    <input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno']; ?>" name="employeeno">
                    <!-- <input type="hidden" id="employee_number" name="employee_number"> -->
                    <!-- <input type="hidden" id="action" name="action"> -->
                </td>
            </tr>
            <tr>
                <td>
                    <b>Gender: </b>
					<select class="form-control" name="gender_of_dependent" id="gender_of_dependent" required>
						<option value="" disabled selected>Select Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Age of dependent: </b>
					<input class="form-control" type="number" id="age_of_dependent" name="age_of_dependent" required>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Relation: </b>
					<input class="form-control" type="text" id="relation" name="relation" required>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Upload Birth Certificate: </b>
                    <input class="form-control" id="file" type="file" name="file" required/>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                <button type="submit" class="btn btn-md btn-success"><i class="fas fa-sm fa-save"></i> Save</button>
                </td>
            </tr>
        </table>
	  </form>
    <table class="table table-striped w-100" id="tbl_dependent">
        <thead>
            <th>Name of Dependent</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Relation</th>
            <th class="text-center">Birth Certificate</th>
            <th class="text-center" style="min-width: 150px">Action</th>
        </thead>
        <tbody>
            
        </tbody>
    </table>
  </div>
 
</div>

<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Dependent Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="dependent_form" enctype="multipart/form-data">
            <div class="form-group">
              <input type="hidden" id="dependent_id" name="dependent_id">
              <input type="text" class="form-control" id="dependent_birth_certificate" name="dependent_birth_certificate"></input>
			<input type="hidden" id="dependent_employee_number" name="dependent_employee_number" value="<?php echo $_SESSION['employeeno']; ?>">
              <label for="exampleInputEmail1">Name:</label>
              <input type="text" class="form-control" id="dependent_name" name="dependent_name"></input>
            </div>
            
            <div class="form-group">
              <label for="exampleInputEmail1">Gender:</label>
			  <select class="form-control" name="dependent_gender" id="dependent_gender" required>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
              <!-- <input type="text" class="form-control" id="dependent_gender" name="dependent_gender"></input> -->
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Age:</label>
              <input type="number" class="form-control" id="dependent_age" name="dependent_age"></input>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Relation:</label>
              <input type="text" class="form-control" id="dependent_relation" name="dependent_relation"></input>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Birth Certificate:</label>
              <input type="file" name="dependent_file" id="dependent_file" class="form-control">
            </div>
            <center>
              <button type="submit" class="btn btn-primary btn-sm" id="btn_submit">Submit</button>
            </center>
          </form>
      </div>

    </div>
  </div>
</div>
<input type="hidden" id="currentUser" value="<?php echo $_SESSION['employeeno'] ?>" name="">

</body>
<script src="services/ess_beneficiaries.js"></script>
</html>
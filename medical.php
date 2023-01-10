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
          <a class="nav-link active" id="" href="#">Medical information</a>
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
    				<td><b>Type: </b><input type="text" class="form-control" id="type1" name="type1"></td>
    			</tr>
    			<tr>
						<td><b>Classification: </b><input type="text" class="form-control" id="classification1" name="classification1"></td>
					</tr>
					<tr>
						<td><b>Status: </b><input type="text" class="form-control" id="status1" name="status1"></td>
					</tr>
					<tr>
						<td><b>Date of Examination: </b><input type="date" class="form-control" id="dateofexam1" name="dateofexam1"></td>
					</tr>
					<tr>
						<td><b>Remarks: </b><input type="text" class="form-control" id="remarks1" name="remarks1"></td>
					</tr>

					<tr>
    				<td><b>Type: </b><input type="text" class="form-control" id="type2" name="type2"></td>
    			</tr>
    			<tr>
						<td><b>Classification: </b><input type="text" class="form-control" id="classification2" name="classification2"></td>
					</tr>
					<tr>
						<td><b>Status: </b><input type="text" class="form-control" id="status2" name="status2"></td>
					</tr>
					<tr>
						<td><b>Date of Examination: </b><input type="date" class="form-control" id="dateofexam2" name="dateofexam2"></td>
					</tr>
					<tr>
						<td><b>Remarks: </b><input type="text" class="form-control" id="remarks2" name="remarks2"></td>
					</tr>

					<tr>
    				<td><b>Type: </b><input type="text" class="form-control" id="type3" name="type3"></td>
    			</tr>
    			<tr>
						<td><b>Classification: </b><input type="text" class="form-control" id="classification3" name="classification3"></td>
					</tr>
					<tr>
						<td><b>Status: </b><input type="text" class="form-control" id="status3" name="status3"></td>
					</tr>
					<tr>
						<td><b>Date of Examination: </b><input type="date" class="form-control" id="dateofexam3" name="dateofexam3"></td>
					</tr>
					<tr>
						<td><b>Remarks: </b><input type="text" class="form-control" id="remarks3" name="remarks3"></td>
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
        <button type="button" id="addBtn" class="btn btn-sm btn-primary mb-4">Add Medical</button>
        <button type="button" id="cancelBtn" class="btn btn-sm btn-warning mb-4" style="display: none; ">Cancel</button>
        </div>
        
        <table class="table-condensed" id="medical_table" style="width: 100%; float: left; padding: 1em">
            <tr>
                <td>
                    <b>Type: </b>
                    <input type="text" class="form-control" id="type" name="type" placeholder="Type" required>
                    <input type="hidden" id="employeeno" value="<?php echo $_GET['employeeno']; ?>" name="employeeno">
                </td>
            </tr>
            <tr>
                <td>
                    <b>Classification: </b>
                    <input type="text" class="form-control" id="classification" name="classification" placeholder="Classification" required>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Status: </b>
                    <input type="text" class="form-control" id="status" name="status" placeholder="Status" required>
                </td>
            </tr>
			<tr>
				<td>
					<b>Date of Examination: </b>
					<input type="date" class="form-control" id="date_of_examination" name="date_of_examination">
				</td>
			</tr>
			<tr>
				<td>
					<b>Remarks: </b>
					<input type="text" class="form-control" id="remarks" name="remarks" placeholder="Remarks">
				</td>
			</tr>
            <tr>
                <td>
                    <b>Upload Hardcopy: </b>
                    <input class="form-control" id="file" type="file" name="file"/>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                <button type="submit" class="btn btn-md btn-success"><i class="fas fa-sm fa-save"></i> Save</button>
                </td>
            </tr>
        </table>
	</form>

	<table class="table table-striped w-100" id="tbl_medical">
		<thead>
			<th>Type</th>
			<th>Classification</th>
			<th>Status</th>
			<th>Date of Examination</th>
			<th>Remarks</th>
			<th class="text-center" style="min-width: 10em">File</th>
			<th class="text-center" style="max-width: 14em">Action</th>
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
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Medical Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="medical_form" enctype="multipart/form-data">
            <div class="form-group">
              <input type="hidden" id="medical_id" name="medical_id">
              <input type="hidden" class="form-control" id="medical_file_name" name="medical_file_name"></input>
			  <input type="hidden" id="medical_employeeno" name="medical_employeeno">
              <label for="exampleInputEmail1">Type:</label>
              <input type="text" class="form-control" id="medical_type" name="medical_type"></input>
            </div>
            
            <div class="form-group">
              <label for="exampleInputEmail1">Classification:</label>
              <input type="text" class="form-control" id="medical_classification" name="medical_classification"></input>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Status:</label>
              <input type="text" class="form-control" id="medical_status" name="medical_status"></input>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Date OF Examination:</label>
              <input type="date" class="form-control" id="medical_date_of_examination" name="medical_date_of_examination"></input>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Remarks:</label>
              <input type="text" class="form-control" id="medical_remarks" name="medical_remarks"></input>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Upload Hardcopy:</label>
              <input type="file" name="medical_file" id="medical_file" class="form-control">
            </div>
            <center>
              <button type="submit" class="btn btn-primary btn-sm" id="btn_submit">Submit</button>
            </center>
          </form>
      </div>

    </div>
  </div>
</div>

</body>
<script src="services/medical.js"></script>
</html>
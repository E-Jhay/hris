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
          <a class="nav-link active" id="" href="#">Performance Evaluation</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_myinfo" class="div_content">
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
        <button type="button" id="addBtn" class="btn btn-sm btn-primary mb-4">Add Evaluation</button>
        <button type="button" id="cancelBtn" class="btn btn-sm btn-warning mb-4" style="display: none; ">Cancel</button>
        </div>
        
        <table class="table-condensed" id="performance_evaluation_table" style="width: 100%; float: left; padding: 1em">
            <tr>
                <td>
                    <b>Title: </b>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                    <input type="hidden" id="emp_id" value="<?php echo $_GET['id']; ?>" name="emp_id">
                    <input type="hidden" id="employee_number" name="employee_number">
                    <!-- <input type="hidden" id="action" name="action"> -->
                </td>
            </tr>
            <tr>
                <td>
                    <b>Description: </b>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Upload Hardcopy: </b>
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
    <table class="table table-striped w-100" id="tbl_performance_evaluation">
        <thead>
            <th>Employee No</th>
            <th>Title</th>
            <th>Description</th>
            <th>Date Created</th>
            <th class="text-center">File</th>
            <th class="text-center">Action</th>
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
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Performance Evaluation Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="evaluation_form" enctype="multipart/form-data">
            <div class="form-group">
              <input type="hidden" id="performance_evaluation_id" name="performance_evaluation_id">
              <input type="text" class="form-control" id="performance_evaluation_file_name" name="performance_evaluation_file_name"></input>
                    <input type="hidden" id="performance_evaluation_employee_number" name="performance_evaluation_employee_number">
              <label for="exampleInputEmail1">Title:</label>
              <input type="text" class="form-control" id="performance_evaluation_title" name="performance_evaluation_title"></input>
            </div>
            
            <div class="form-group">
              <label for="exampleInputEmail1">Description:</label>
              <input type="text" class="form-control" id="performance_evaluation_description" name="performance_evaluation_description"></input>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Upload Hardcopy:</label>
              <input type="file" name="performance_evaluation_file" id="performance_evaluation_file" class="form-control">
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
<script src="services/performance_evaluation.js"></script>
</html>
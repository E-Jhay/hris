<?php 
session_start();
$usertype = $_SESSION['usertype'];
$empno = $_SESSION['employeeno'];
$approver = $_SESSION['approver'];
$userrole = $_SESSION['userrole'];
if(!isset($_SESSION['fullname'])){
  header("location:index.php");
}
require_once "header.php";
require_once "controller/controller.leave.php";
$leaves = new crud();
$count = $leaves->countLeaves($empno);
 ?>
<div class="sidenavigation">
<?php 
  if($userrole == '1'){
    require_once "pim_tab.php";
  }else{
    require_once "ess_tab.php";
  }
   ?>
</div>

<div class="navtabs">
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item">
          <a class="nav-link active" href="#">Incident Report</a>
        </li>
      </ul>
</div>

<div class="navcontainer">

  <div id="div_incident" class="div_content">
    <form id="form" enctype="multipart/form-data">
        <div>
        <button type="button" id="addIncidentBtn" class="btn btn-primary mb-4">Add Incident Report</button>
        <button type="button" id="cancelIncidentBtn" class="btn btn-warning mb-4" style="display: none; ">Cancel</button>
        </div>

        <table class="table-condensed grid12_master" id="incident_table">
            <tr>
                <td>
                    <b>Incident title: </b>
                    <input type="text" class="form-control" id="incidentTitle" name="incidentTitle" placeholder="Incident Title" required>
                    <input type="hidden" value="<?php echo $_SESSION['employeeno'] ?>" name="employee_number">
                </td>
            </tr>
            <tr>
                <td>
                    <b>Description: </b>
                    <input type="text" class="form-control" id="incidentDescription" name="incidentDescription" placeholder="Incident Description" required>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Incident File: </b>
                    <input class="form-control" id="incidentFile" required="" type="file" name="incidentFile" />
                </td>
            </tr>
            <tr>
                <td class="text-center">
                <button type="submit" class="btn btn-md btn-success" id="btn_submit"><i class="fas fa-sm fa-save"></i> Save</button>
                </td>
            </tr>
        </table>
    </form>
    <table class="table table-striped w-100" id="tbl_incident">
        <thead>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
            <th>Status</th>
            <th class="text-center">File</th>
            <th class="text-center">Action</th>
        </thead>
        <tbody>
            
        </tbody>
    </table>
  </div>

  <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Incident Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="incident_form" enctype="multipart/form-data">
              <div class="form-group">
                <input type="hidden" id="incident_id" name="incident_id">
                <label for="exampleInputEmail1">Title:</label>
                <input type="text" class="form-control" id="incident_title" name="incident_title"></input>
                    <input type="hidden" value="<?php echo $_SESSION['employeeno'] ?>" name="incident_employee_number">
              </div>
              
              <div class="form-group">
                <label for="exampleInputEmail1">Description:</label>
                <input type="text" class="form-control" id="incident_description" name="incident_description"></input>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Upload File:</label>
                <input type="file" name="incident_file" id="incident_file" class="form-control">
                <input type="hidden" name="file_name" id="file_name" class="form-control">
              </div>
              <center>
                <button type="submit" class="btn btn-primary btn-sm" id="btn_submit">Submit</button>
              </center>
            </form>
        </div>

      </div>
    </div>
  </div>
</div>

<input type="hidden" id="currentUser" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
</body>
<script src="services/ess_incident.js"></script>
<!-- <script src="services/ess_tab.js"></script> -->
</html>
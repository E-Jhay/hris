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
  require_once "pim_tab.php";
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
                <input type="hidden" id="incident_employeeno" name="incident_employeeno">
                <input type="hidden" id="incident_date" name="incident_date">
                <input type="hidden" id="incident_id" name="incident_id">
                <label for="exampleInputEmail1">Title:</label>
                <input type="text" class="form-control" id="incident_title" name="incident_title" disabled></input>
              </div>
              
              <div class="form-group">
                <label for="exampleInputEmail1">Description:</label>
                <input type="text" class="form-control" id="incident_description" name="incident_description" disabled></input>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Remarks:</label>
                <!-- <input type="text" class="form-control" id="incident_remarks" name="incident_remarks"></input> -->
                <textarea class="form-control" name="incident_remarks" id="incident_remarks" cols="30" rows="2"></textarea>
              </div>
              <center>
                <button type="submit" class="btn btn-primary btn-sm" id="btn_submit">Acknowledge</button>
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
<script src="services/incident.js"></script>
<script src="services/pim_tab.js"></script>
</html>
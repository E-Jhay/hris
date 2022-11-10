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
  require_once "admin_tab.php";
   ?>
</div>

<div class="navtabs">
      
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item">
          <a class="nav-link active" id="ljob_titles" href="#" onclick="btnjobtitles()">Job Titles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="lemp_status" href="#" onclick="btnemp_status()">Employment Status</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="ljob_categories" href="#" onclick="btnjob_cat()">Job Categories</a>
        </li>
      </ul>

</div>


<div class="navcontainer">
  <div id="divjob_title" class="div_content">
  	<button type="button" class="btn btn-sm btn-success" onclick="btnaddjob()"><i class="fa fa-plus"></i> Add New</button><br><br>
    <table class="table table-striped w-100" id="tbl_jobtitle">
            <thead>
              <th>Job Title</th>
							<th>Job Description</th>
							<th>Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>

  <div id="div_employment_status" class="div_content">
  	<button type="button" class="btn btn-sm btn-success" onclick="btnaddempstatus()"><i class="fa fa-plus"></i> Add New</button><br><br>
    <table class="table table-striped w-100" id="tbl_employment_status">
            <thead>
              <th>Employment Status</th>
							<th>Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>

  <div id="div_job_category" class="div_content">
  	<button type="button" class="btn btn-sm btn-success" onclick="btnaddjobcategory()"><i class="fa fa-plus"></i> Add New</button><br><br>
    <table class="table table-striped w-100" id="tbl_job_categories">
            <thead>
              <th>Job Category</th>
							<th>Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>


    
</div>

<!-- Modal -->

<div class="modal fade" id="jobmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Job Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">Job Title</label>
            <input type="hidden" id="modal_jobid" name="">
            <input type="text" class="form-control txtbox" id="modal_jobtitle" placeholder="">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Job Description</label>
            <input type="text" class="form-control" id="modal_jobdescription" placeholder="">
          </div>
          
          <center>
          <button class="btn btn-success btn-sm" type="button" id="savejobbtn" onclick="btn_savejob()"><i class="fa fa-save"></i> Save</button>
          <button class="btn btn-success btn-sm" id="updatejobbtn" onclick="btn_updatejob()"><i class="fa fa-save"></i> Update</button>
          </center>

      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="employment_statusmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Employment Status Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">Employment Status</label>
            <input type="hidden" id="modal_empstatusid" name="">
            <input type="text" class="form-control txtbox" id="modal_empstatusname" placeholder="">
          </div>
          
          <center>
          <button class="btn btn-success btn-sm" type="button" id="saveempstatusbtn" onclick="btn_saveempstatus()"><i class="fa fa-save"></i> Save</button>
          <button class="btn btn-success btn-sm" id="updateempstatusbtn" onclick="btn_updateempstatus()"><i class="fa fa-save"></i> Update</button>
          </center>

      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="jobcategory_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Job Category Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">Job Category</label>
            <input type="hidden" id="modal_jobcatid" name="">
            <input type="text" class="form-control txtbox" id="modal_jobcatname" placeholder="">
          </div>
          
          <center>
          <button class="btn btn-success btn-sm" type="button" id="savejobcatbtn" onclick="btn_savejobcat()"><i class="fa fa-save"></i> Save</button>
          <button class="btn btn-success btn-sm" id="updatejobcatbtn" onclick="btn_updatejobcat()"><i class="fa fa-save"></i> Update</button>
          </center>

      </div>

    </div>
  </div>
</div>

</body>
<script src="services/job.js"></script>
</html>

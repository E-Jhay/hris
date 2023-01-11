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
          <a class="nav-link active" id="" href="#">Department</a>
        </li>
      </ul>

</div>

<div class="navcontainer">
  <div id="div_leavetype" class="div_content">
    <button type="button" class="btn btn-sm btn-success" onclick="btnaddnew()"><i class="fa fa-plus"></i> Add New</button><br><br>
    <table class="table table-striped w-100" id="tbl_department">
            <thead>
              <th>Department</th>
              <th class="text-center w-25">Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>
    
</div>


<div class="modal fade" id="adddept_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Department Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">Department</label>
            <input type="hidden" id="dept_id" name="dept_id"><br>
            <input type="text" class="form-control txtbox" id="dept_text" placeholder="">
          </div>
          
          <center>
          <button class="btn btn-success btn-sm" type="button" id="btnsave" onclick="btn_savedept()"><i class="fa fa-save"></i> Save</button>
          <button class="btn btn-success btn-sm" id="btnupdate" onclick="btn_updatedept()"><i class="fa fa-save"></i> Update</button>
          </center>

      </div>

    </div>
  </div>
</div>

</body>
<script src="services/department.js"></script>
</html>

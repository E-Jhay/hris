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
          <a class="nav-link active" id="luser" href="#" onclick="btnuser()">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="luser_role" href="#" onclick="btnuserrole()">User Type</a>
        </li>
      </ul>

</div>

<div class="navcontainer">
  <div id="div_user" class="div_content">
    <table class="table table-striped w-100" id="tbl_user">
            <thead>
              <th>Employee No</th>
              <th>Fullname</th>
              <th>Username</th>
              <th>Password</th>
              <th>Usertype</th>
              <th>Active Status</th>
              <th>Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>

  <div id="div_user_role" class="div_content">
    <button type="button" class="btn btn-sm btn-success" onclick="btnadduserrole()"><i class="fa fa-plus"></i> Add New</button><br><br>
          <table class="table table-striped w-100" id="tbl_user_role">
            <thead>
              <th>User Role</th>
              <th>User Role Type</th>
              <th class="text-center w-25">Action</th>
            </thead>
            <tbody>

            </tbody>
          </table>
  </div>
    
</div>

<div class="modal fade" id="usermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Edit User Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


          <div class="form-group">
            <label for="exampleInputEmail1">Fullname</label>
            <input type="text" class="form-control txtbox" id="fullname" placeholder="Full name">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control" id="username" placeholder="User name">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Password</label>
            <input type="text" class="form-control" id="password" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Usertype</label>
            <select class="form-control" id="usertype" name="usertype"></select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Status</label>
            <select class="form-control" id="active_status" name="active_status">
              <option value="active"> active</option>
              <option value="inactive"> inactive</option>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">User Access</label>
            <input type="hidden" id="user_id" name="">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Dept Head</label>
            <input type="checkbox" id="1" name="role" value="1">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">ADMIN</label>
            <input type="checkbox" id="2" name="role" value="2">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Employee</label>
            <input type="checkbox" id="3" name="role" value="3" disabled>
          </div>
          <select class="form-control" id="approverr" name="approverr">
            <option value="" selected=""> --Choose type--</option>
            <option value="yes"> Approver </option>
            <option value="no"> Not approver </option>
          </select>
          <center>
          <button type="button" onclick="updateuser()" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
          </center>


      </div>

    </div>
  </div>
</div>


<div class="modal fade" id="userrole_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> User Role Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">User Role</label>
            <input type="hidden" id="modal_userroleid" name="">
            <input type="text" class="form-control txtbox" id="modal_userrole" placeholder="">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">User Role Type</label>
            <input type="text" class="form-control" id="modal_userroletype" placeholder="">
          </div>
          
          <center>
          <button class="btn btn-success btn-sm" type="button" id="saveuserrolebtn" onclick="btn_saveuserrole()"><i class="fa fa-save"></i> Save</button>
          <button class="btn btn-success btn-sm" id="updateuserrolebtn" onclick="btn_updateuserrole()"><i class="fa fa-save"></i> Update</button>
          </center>


      </div>

    </div>
  </div>
</div>

</body>
<script src="services/admin.js"></script>
</html>
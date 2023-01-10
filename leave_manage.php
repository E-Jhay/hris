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
          <a class="nav-link active" id="ltype" href="#" onclick="btnltype()">Leave Type</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="lbalance" href="#" onclick="btnlbalance()">Leave Balance</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="lmonitor" href="#" onclick="btnmonitor()">Monitoring of Leave</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_leavetype" class="div_content">
    <button type="button" class="btn btn-sm btn-success" onclick="btnaddleavetype()"><i class="fa fa-plus"></i> Add New</button><br><br>
    <table class="table table-striped w-100" id="tbl_leavetype">
            <thead>
              <th>Leave Type</th>
              <th>Leave Name</th>
              <th style="max-width: 10em">Status</th>
              <th class="text-center" style="max-width: 13em">Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>

  <div id="div_leavebalance" class="div_content">
    
    <table class="table table-striped w-100" id="tbl_leave">
            <thead>
              <th>Employee No</th>
              <th>Name</th>
              <th>Date hired</th>
              <th>No. of Years</th>
              <th>SL balance</th>
              <th>VL balance</th>
              <th class="text-center" style="max-width: 12em">Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
    <center>
      <button type="button" onclick="reset_balance()" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-sync-alt"></i> RESET</button>
      <button type="button" onclick="exportleave_balance()" class="btn btn-sm btn-warning text-white"><i class="fas fa-sm fa-file-excel"></i> EXPORT TO EXCEL</button>
      <button type="button" onclick="slconversion()" class="btn btn-sm btn-info"><i class="fas fa-sm fa-retweet"></i> SL CONVERSION</button>
    </center>
  </div>

  <div id="div_leavemonitor" class="div_content">

    <table class="table table-striped w-100" id="tbl_leavemonitor">
            <thead>
              <th>Tenure</th>
              <th>Earned Points</th>
              <th>Vacation</th>
              <th>Sick</th>
              <th>Total</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>
   
</div>

<div class="modal fade" id="leave_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-info-circle"></i> Leave Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">Employee no</label>
            <span class="form-control" id="employeeno"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <span class="form-control" id="fullname"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Rank</label>
            <span class="form-control" id="rank"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Employment Status</label>
            <span class="form-control" id="employment_status"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Company</label>
            <span class="form-control" id="company"></span>
          </div>
          <div class="form-group" style="display: none;">
            <label for="exampleInputEmail1">Remaining balance</label>
            <span class="form-control" id="leave_balance"></span>
          </div>

          <div class="form-group">
            <table id="tbl_leavebalofemp" class="table table-striped w-100">
                <thead>
                  <th>Type</th>
                  <th>Bal</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  
                </tbody>
            </table>
          </div>
          
          <center>
          <button class="btn btn-success btn-sm" type="button" id="savejobbtn" onclick="updateall()"><i class="fa fa-save"></i> Save</button>
          </center>

      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="addleave_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Add Leave</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">Employee No</label>
            <input type="text" class="form-control txtbox" disabled="" id="addempno" placeholder="">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" disabled="" id="addempname" placeholder="">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Leave Type</label>
            <select class="form-control" id="addleave_type"></select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Leave Balance</label>
            <input type="text" class="form-control" id="addleave_balance" placeholder="">
          </div>
          
          <center>
          <button class="btn btn-success btn-sm" type="button" id="savejobbtn" onclick="btn_addempleave()"><i class="fa fa-save"></i> Save</button>
          </center>

      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="leavemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Leave Type Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">Leave Type</label>
            <input type="hidden" class="form-control txtbox" id="id_leave" placeholder="">
            <input type="text" class="form-control txtbox" id="leave_type" placeholder="">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Leave Name</label>
            <input type="text" class="form-control" id="leave_name" placeholder="">
          </div>
          <div class="form-group" style="display: none;">
            <label for="exampleInputEmail1">Points to Deduct</label>
            <select id="points" name="points">
              <option value="1.13">1.13</option>
              <option value="1">1</option>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Leave Status</label>
            <select class="form-control" id="leave_stat" name="leave_stat">
              <option value="active"> Active</option>
              <option value="inactive"> Inactive</option>
            </select>
          </div>
          
          <center>
          <button class="btn btn-success btn-sm" type="button" id="addtype" onclick="addleavetype()"><i class="fa fa-save"></i> Save</button>
          <button class="btn btn-success btn-sm" type="button" id="updatetype" onclick="updateleavetype()"><i class="fa fa-save"></i> Update</button>
          </center>

      </div>

    </div>
  </div>
</div>

</body>
<script src="services/leave_manage.js"></script>
</html>
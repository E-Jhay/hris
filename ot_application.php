<?php 
session_start();

$usertype = $_SESSION['usertype'];
$approver = $_SESSION['approver'];
$empno = $_SESSION['employeeno'];
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
          <a class="nav-link active" id="lleave" href="#" onclick="btnotlist()">Overtime List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="lreports" href="#" onclick="btnreports()">Reports</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_otlist" class="div_content">
      <label>Status:</label>
      <select id="filter_status" class="form-control" onchange="filter_stat()">
        <option value="All">All</option>
        <option value="Pending" selected="">Pending</option>
        <option value="Approved">Approved</option>
        <option value="Disapproved">Disapproved</option>
      </select>
      <table class="table table-striped w-100" id="tbl_myot">
        <thead>
          <th>Employee Name</th>
          <th>Position</th>
          <th>Reasons</th>
          <th>Date Filed</th>
          <th>From</th>
          <th>To</th>
          <th>No. of hrs</th>
          <th>OT Date To</th>
          <th>OT Date From</th>
          <th>Status</th>
          <th  class="text-center" width="100px">Action</th>
        </thead>
        <tbody>
                
        </tbody>
      </table>
  </div>

  <div id="div_reports" class="div_content" style="display: none;">
      <label>Status:</label>
      <select id="filter_status_report" class="form-control" onchange="filter_stat()">
                <option value="All" selected="">All</option>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Disapproved">Disapproved</option>
      </select>
      <label>Date from:</label><input id="filter_from" class="form-control" type="date" name="">
      <label>Date to:</label><input id="filter_to" class="form-control" type="date" name="">
      <button type="button" class="btn btn-sm btn-success" onclick="filterotapp()"><i class="fas fa-sm fa-search"></i> Search</button>
      <button type="button" class="btn btn-sm btn-success" onclick="exportotapp()"><i class="fas fa-sm fa-file-excel"></i> Export</button><br><br>
      <table class="table table-striped w-100" id="tbl_otlist">
        <thead>
          <th>Employee Name</th>
          <th>Position</th>
          <th>Reasons</th>
          <th>Date Filed</th>
          <th>From</th>
          <th>To</th>
          <th>No. of hrs</th>
          <th>OT Date From</th>
          <th>OT Date To</th>
          <th>Status</th>
        </thead>
        <tbody>
                
        </tbody>
      </table>
  </div>
 
</div>


<div class="modal fade" id="overtimedetail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Overtime Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" id="ot_id" name="">
          <div class="form-group">
            <label for="exampleInputEmail1">Employee Name:</label>
            <span class="form-control" id="ot_emp_name"></span>
          </div>
          
          <div class="form-group">
            <label for="exampleInputEmail1">Position:</label>
            <span class="form-control" id="ot_position"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Reason(s)/Justification:</label>
            <span class="form-control" id="ot_reasons"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Date Filed:</label>
            <span class="form-control" id="ot_date_filed"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">From:</label>
            <span class="form-control" id="ot_from"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">To:</label>
            <span class="form-control" id="ot_to"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">No of hrs:</label>
            <span class="form-control" id="ot_no_of_hrs"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">OT Date:</label>
            <span class="form-control" id="ot_date"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Remarks:</label>
            <textarea class="form-control" id="ot_remarks"></textarea>
          </div>



          
          <?php if ($usertype=="admin" && $approver=="yes"): ?> 

          <center>
            <button class="btn btn-success btn-sm" id="btnapprove" onclick="approve()">Approve</button>
            <button class="btn btn-danger btn-sm" id="btndisapprove" onclick="disapproved()">Disapprove</button>
            <button class="btn btn-primary btn-sm" id="btncancelapprove" onclick="cancelapprove()">Undo Leave</button>
          </center>

          <?php endif ?>


      </div>

    </div>
  </div>
</div>


<input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
 
</body>
<script src="services/otapp.js"></script>
<script src="services/pim_tab.js"></script>
</html>
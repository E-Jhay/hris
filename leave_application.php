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
			<a class="nav-link active" id="lassign" onclick="btnassignleave()" href="#">Assign Leave</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" id="lleave" onclick="btnleavelist()" href="#">Leave List</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" id="lreports" onclick="btnreports()" href="#">Reports</a>
		</li>
	</ul>

</div>

<div class="navcontainer">

	<div id="div_assignleave" class="div_content">
		<br>
		<table class="table table-condensed">
				<tr>
					<td>
						<label>Employee:</label>
						<select class="form-control" id="employeeddown"></select>
					</td>
				</tr>
				<tr style="visibility: collapse;">
					<td>
						<label>Total leave balance:</label>
						<input disabled="" type="number" class="form-control" id="assignremaininglb">
					</td>
				</tr>
				<tr>
					<td>
						<label>Application Type:</label>
						<select class="form-control" id="assign_application_type">
							<option disabled="" selected="">-- Select Application type--</option>
							<option value="Whole Day">Whole Day</option>
							<option value="Half Day">Half Day</option>
							<option value="Under Time">Under Time</option>
						</select>
					</td>
				</tr>

				<tr style="display: none;">
					<td>
						<label>Balance Per L Type:</label>
						<div id="bal_pertype_parent">
								<span id="bal_pertype_child"></span>
						</div>
					</td>
				</tr>

				<tr>
					<td>
						<label>Leave Type:</label>
						<select class="form-control" id="assignlt"></select>
					</td>
				</tr>

				<tr>
					<td>
						<label>Balance:</label>
						<input type="hidden" id="assign_points_todeduct" name="">
						<input type="number" disabled="" class="form-control" id="assignleavebal" name="">
						<select class="form-control" id="pay_leave">
							<option value="With Pay" selected=""> WITH PAY </option>
							<option value="Without Pay"> WITHOUT PAY</option>	
						</select>
					</td>
				</tr>

				<tr style="display: none;" id="assign_date_column">
					<td>
						<label> Date:</label>
						<input type="date" class="form-control" id="assign_halfdate" name="">
					</td>
				</tr>

				<tr style="display: none;" id="assign_ampm_column">
					<td>
						<input type="radio" value="AM" onclick="assign_ampm()" checked="" name="assign_leaveampm"> AM <input type="radio" value="PM" onclick="assign_ampm()" name="assign_leaveampm"> PM 
						<select class="form-control" id="assign_amchoice">
							<option selected="" disabled="" value="">-- Select Time --</option>	
							<option value="0.5">8:00 AM - 12:00 PM</option>	
							<option value="0.63">8:00 AM - 2:00 PM</option>	
						</select>

						<select class="form-control" id="assign_pmchoice" style="display: none;">
							<option selected="" disabled="" value="">-- Select Time --</option>	
							<option value="sixpm">12:00 PM - 6:00 PM</option>	
							<option value="twopm">2:00 PM - 6:00 PM</option>
							<option value="fivepm">12:00 PM - 5:00 PM</option>	
						</select>
					</td>
				</tr>

				<tr style="display: none;" id="assign_timefrom_column">
					<td>
						<label>From Time:</label>
						<input type="time" value="15:00" class="form-control" id="assign_timefrom" name="">
					</td>
				</tr>

				<tr style="display: none;" id="assign_timeto_column">
					<td>
						<label>To Time:</label>
						<select class="form-control" id="assign_timeto">
							<option value="17:00">05:00 PM</option>
							<option value="18:00">06:00 PM</option>
						</select>
					</td>
				</tr>


				<tr id="assign_datefrom_column">
					<td>
						<label>From Date:</label>
						<input type="date" class="form-control" id="asssignfromdate" name="">
					</td>
				</tr>

				<tr id="assign_dateto_column">
					<td>
						<label>To Date:</label>
						<input type="date" class="form-control" id="asssigntodate" name="">
					</td>
				</tr>

				<tr style="display: none;">
					<td>
						<label>No Days:</label>
						<input disabled="" type="number" id="assigno_days" class="form-control" name="">
					</td>
				</tr>

				<tr>
					<td>
						<label>Reason:</label>
						<textarea class="form-control" id="assigncomment"></textarea>
					</td>
				</tr>
							
		</table>
		<center>
			<button class="btn btn-sm btn-success" type="button" onclick="submitassignleave()"><i class="fas fa-sm fa-save"></i> Submit</button>
		</center>
	</div>

	<div id="div_leavelist" class="div_content" style="display: none;">
		<label>Status:</label>
			<select id="filter_status" class="form-control" onchange="filter_stat()">
				<option value="All">All</option>
				<option value="Pending" selected="">Pending</option>
				<option value="Approved">Approved</option>
				<option value="Disapproved">Disapproved</option>
			</select><br>
			<table class="table table-striped w-100" id="tbl_leavelist">
				<thead>
				<th>Employee Name</th>
								<th>Date Applied</th>
								<th>Leave Type</th>
								<th>Leave Balance</th>
								<th>Credits to Deduct</th>
								<th>Status</th>
								<th>Action</th>
				</thead>
				<tbody>
				</tbody>
			</table>
	</div>


	<div id="div_reports" class="div_content" style="display: none;">

		<label>Status:</label>
		<select class="form-control" id="filter_type">
			<option value="All">All</option>
			<option value="Pending">Pending</option>
			<option value="Approved">Approved</option>
			<option value="Disapproved">Disapproved</option>
		</select>
		<label>Date from:</label><input id="filter_from" class="form-control" type="date" name="">
		<label>Date to:</label><input id="filter_to" class="form-control" type="date" name="">
		<button type="button" class="btn btn-sm btn-success" onclick="filterleaveapp()"><i class="fas fa-sm fa-search"></i> Search</button>
		<button type="button" class="btn btn-sm btn-success" onclick="exportleaveapp()"><i class="fas fa-sm fa-file-excel"></i> Export</button><br><br>
		<table class="table table-striped" id="tbl_leavelist_report" style="width: 100%">
			<thead>
				<th>Employee Name</th>
				<th>Date From</th>
				<th>Date To</th>
				<th>Leave Type</th>
				<th>Leave Balance</th>
				<th>Credits to Deduct</th>
				<th>Status</th>
			</thead>
			<tbody>
				
			</tbody>
		</table>

	</div>

 
</div>


<div class="modal fade" id="leavemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Leave Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      		<input type="hidden" id="emp_id" name="">
          <div class="form-group">
            <label for="exampleInputEmail1">Employee No</label>
            <span class="form-control" id="emp_number"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Employee Name</label>
            <span class="form-control" id="emp_fname"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Application Type</label>
            <span class="form-control" id="emp_application_type"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Leave Balance</label>
            <span class="form-control" id="emp_leavebalancetype"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Leave Type</label>
            <span class="form-control" id="emp_leavetype"></span>
            <span class="form-control" id="pay_leave_span"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Date Applied</label>
            <span class="form-control" id="emp_dateapplied"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Total Leave Balance(all type)</label>
            <span class="form-control" id="emp_leavebalance"></span>
          </div>

          <div class="form-group" id="dfrom_column">
            <label for="exampleInputEmail1">Date/Time From</label>
            <span class="form-control" id="emp_datefrom"></span>
          </div>

          <div class="form-group" id="dto_column">
            <label for="exampleInputEmail1">Date/Time To</label>
            <span class="form-control" id="emp_dateto"></span>
          </div>

          <div class="form-group" id="ap_column">
            <label for="exampleInputEmail1">AM/PM</label>
            <span class="form-control" id="emp_ampm"></span>
          </div>

          <div class="form-group" id="time_column">
            <label for="exampleInputEmail1">Time</label>
            <span class="form-control" id="emp_time"></span>
          </div>

          <div class="form-group" id="no_days_column">
            <label for="exampleInputEmail1">No. of days</label>
            <span class="form-control" id="emp_days"></span>
          </div>

		  <!-- ///////////////////////////////////////////////////////////////////// -->

          <!-- <div class="form-group" id="fivepm_column">
            <label for="exampleInputEmail1">No. of 8AM-5PM</label>
            <?php if ($usertype=="admin" && $approver=="yes"): ?>	
      			<input type="number" class="form-control" id="fivepm" name="">
      			<?php endif ?>

      			<?php if ($usertype=="admin" && $approver=="no"): ?>	
      			<input type="number" disabled="" class="form-control" id="fivepm" name="">
      			<?php endif ?>
          </div>

          <div class="form-group" id="sixpm_column">
            <label for="exampleInputEmail1">No. of 8AM-6PM</label>
            <input type="number"  class="form-control" id="sixpm" name="">
            <?php if ($usertype=="admin" && $approver=="yes"): ?>	
      			<button type="button" id="compute_btn" class="btn btn-sm btn-success" onclick="compute_rate()"><i class="fas fa-sm fa-calculator"></i> Compute</button>
      			<?php endif ?>
          </div> -->

		  <!-- ///////////////////////////////////////////////////////////////////// -->

          <div class="form-group" id="rate_column">
            <label for="exampleInputEmail1">Rate</label>
            <select id="emp_rate" style="width: 100%;font-size: 12px;padding: 4px">
      				<option value="1.13">1.13</option>
      				<option value="1">1</option>
      			</select>
      			<button type="button" class="btn btn-sm btn-success" onclick="upt()">update</button>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">No. of credits to deduct</label>
            <span class="form-control" id="emp_nodays"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Status</label>
            <span class="form-control" id="emp_status"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Reason</label>
            <span class="form-control" id="emp_comment"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Remarks</label>
            <textarea id="remarks" class="form-control"></textarea>
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
<script src="services/leave_app.js"></script>
</html>
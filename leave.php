<?php 
session_start();

$usertype = $_SESSION['usertype'];
$empno = $_SESSION['employeeno'];
$approver = $_SESSION['approver'];

if(!isset($_SESSION['fullname'])){
  header("location:index.php");
}
require_once "header.php";
require_once "controller/controller.leave.php";
$leaves = new crud();
$count = $leaves->countLeaves($empno);
$balance = $leaves->getleavebalance($empno);
 ?>

<div class="sidenavigation">
  <?php 
  require_once "ess_tab.php";
   ?>
</div>

<div class="navtabs">
      
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item">
          <a class="nav-link active" id="lapply" href="#" onclick="btnapply()">Apply</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="lmyapply" href="#" onclick="btnmyleave()">My Leave</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_apply" class="div_content">
  		<?php 
  		foreach ($balance as $a) { 
			if($a['balance'] < 0){ $a['balance'] = 0; } ?>
				<span class="mr-5"> <b><?= $a['leave_type']; ?> =</b> <span><?= $a['balance']; ?></span></span>
		  <?php } ?>
		  <br><br>
			<table class="table w-100">
								
				<tr>
					<td>
						<label>Application Type:</label>
						<select class="form-control" id="application_type">
							<option disabled="" selected="">-- Select Application type--</option>
							<option value="Whole Day">Whole Day</option>
							<option value="Half Day">Half Day</option>
							<option value="Under Time">Under Time</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label>Leave Type:</label>
						<select class="form-control" id="leave_type"></select>
					</td>
				</tr>

				<tr>
					<td>
						<label>Balance:</label>
						<input type="hidden" id="points_todeduct" name="">
						<input type="number" disabled="" class="form-control" id="leave_bal" name="">
						<select class="form-control" id="pay_leave">
							<option value="With Pay" selected=""> WITH PAY </option>
							<option value="Without Pay"> WITHOUT PAY</option>	
						</select>
					</td>
				</tr>

				<tr style="display: none;" id="date_column">
					<td>
						<label> Date:</label>
						<input type="date" class="form-control" id="halfdate" name="">
					</td>
				</tr>

				<tr style="display: none;" id="ampm_column">
					<td>
						<input type="radio" value="AM" onclick="ampm()" checked="" name="leaveampm"> AM <input type="radio" value="PM" onclick="ampm()" name="leaveampm"> PM 
						<select class="form-control" id="amchoice">
							<option selected="" disabled="" value="">-- Select Time --</option>	
							<option value="0.5">8:00 AM - 12:00 PM</option>	
							<option value="0.63">8:00 AM - 2:00 PM</option>	
						</select>

						<select class="form-control" id="pmchoice" style="display: none;">
							<option selected="" disabled="" value="">-- Select Time --</option>
							<option value="sixpm">12:00 PM - 6:00 PM</option>
							<option value="twopm">2:00 PM - 6:00 PM</option>
							<option value="fivepm">12:00 PM - 5:00 PM</option>
						</select>
					</td>
				</tr>

				<tr style="display: none;" id="timefrom_column">
					<td>
						<label>From Time:</label>
						<input type="time" value="15:00" class="form-control" id="timefrom" name="">
					</td>
				</tr>
				<tr style="display: none;" id="timeto_column">
					<td>
						<label>To Time:</label>
						<select class="form-control" id="timeto">
							<option value="17:00">05:00 PM</option>
							<option value="18:00">06:00 PM</option>
						</select>
					</td>
				</tr>

				<tr id="datefrom_column">
					<td>
						<label>From Date:</label>
						<input type="date" class="form-control" id="datefrom" name="">
					</td>
				</tr>

				<tr id="dateto_column">
					<td>
						<label>To Date:</label>
						<input type="date" class="form-control" id="dateto" name="">
					</td>
				</tr>

				<tr style="display: none;">
					<td>
						<label>No. of Days(credits to deduct):</label>
						<input disabled="" type="number" class="form-control" id="no_days" name="">
					</td>
				</tr>
				<tr>
					<td>
						<label>Reason:</label>
						<textarea id="comment" class="form-control"></textarea>
					</td>
				</tr>
			</table>

			<center>
				<button type="button" class="btn btn-sm btn-success" onclick="submitleave()"><i class="fas fa-sm fa-save"></i> Submit</button>
        <button type="button" class="btn btn-sm btn-success" onclick="leaveUploadBtn()"><i class="fas fa-sm fa-upload"></i> Upload</button>
			</center>
  </div>

  <div id="div_myleave" class="div_content" style="display: none;">

    <table class="table table-striped w-100" id="tbl_myleave">
            <thead>
              <th>Employee Name</th>
							<th>Date Applied</th>
							<th>Leave Type</th>
							<th>Remaining Balance</th>
							<th>Deducted Credits</th>
							<th>Status</th>
							<th>Action</th>
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

          <div class="form-group">
            <label for="exampleInputEmail1">Employee No</label>
            <input type="hidden" id="emp_id" name="">
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
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Date Applied</label>
            <span class="form-control" id="emp_dateapplied"></span>
          </div>

          <div class="form-group" style="display: none;">
            <label for="exampleInputEmail1">Total Leave Balance(all type)</label>
            <span class="form-control" id="emp_leavetype"></span>
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
            <label for="exampleInputEmail1">No. of days:</label>
            <input type="number" class="form-control" id="emp_days" name="">
          </div>

          <div class="form-group" id="fivepm_column" style="display: none;">
            <label for="exampleInputEmail1">No. of 8AM-5PM</label>
            <input type="number" class="form-control" id="fivepm" name="">
          </div>

          <div class="form-group" id="sixpm_column" style="display: none;">
            <label for="exampleInputEmail1">No. of 8AM-6PM</label>
            <input type="number" class="form-control" id="sixpm" name="">
            <button type="button" class="btn btn-sm btn-success" onclick="compute_rate()">Set</button>
          </div>

          <div class="form-group" id="rate_column">
            <label for="exampleInputEmail1">Rate</label>
            <select id="emp_rate" class="form-control">
      					<option value="1.13">1.13</option>
      					<option value="1">1</option>
      			</select> 
            <button type="button" class="btn btn-sm btn-success" onclick="upt()">update</button>
          </div>

          <div class="form-group" style="display: none;">
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
            <textarea id="remarks" disabled="" class="form-control"></textarea>
          </div>
     

      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="uploadform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeltwo" aria-hidden="true">
  <form action="" id="leaveUploadForm" class="ajax-form" enctype="multipart/form-data">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabeltwo"><i class="fas fa-file"></i> Upload Leave Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="image-area" data-target="leaveForm" style="border: 1px dashed #a7a7a7">
            <div class="text-center" style="padding: 2%; cursor: pointer;">
              <img id="prev" src="static/card-thumbnail.jpg" class="preview" width="100%" alt="thumbnails">
            </div>
          </div>

          <div class="d-none">
            <input required id="leaveForm" type="file" accept="image/png, image/gif, image/jpeg" name="leaveForm" onchange="previewImage()"/>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </form>
</div>

<input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
 
</body>
<script src="services/leave.js"></script>
</html>
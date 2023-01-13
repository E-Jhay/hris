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
          <a class="nav-link active" id="lapply" href="#" onclick="btnapply()">Apply</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="lmyapply" href="#" onclick="btnmyleave()">My OT</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_apply" class="div_content">

    <table class="table table-condensed w-100">

    		<tr>
					<td>
						<label>Reason(s) / Justification:</label>
						<textarea class="form-control" id="reasons" required></textarea>
					</td>
				</tr>

				<tr style="visibility: collapse;">
					<td>
						<label>Date Filed:</label>
						<input type="date" id="date_filed" class="form-control" value="<?php echo date('Y-m-d') ?>" name="">
					</td>
				</tr>

				<tr>
					<td>
						<label>From:</label>
						<select class="form-control" id="ot_from">
							<option value="01:00:00">1:00 AM</option>
							<option value="01:30:00">1:30 AM</option>
							<option value="02:00:00">2:00 AM</option>
							<option value="02:30:00">2:30 AM</option>
							<option value="03:00:00">3:00 AM</option>
							<option value="03:30:00">3:30 AM</option>
							<option value="04:00:00">4:00 AM</option>
							<option value="04:30:00">4:30 AM</option>
							<option value="05:00:00">5:00 AM</option>
							<option value="05:30:00">5:30 AM</option>
							<option value="06:00:00">6:00 AM</option>
							<option value="06:30:00">6:30 AM</option>
							<option value="07:00:00">7:00 AM</option>
							<option value="07:30:00">7:30 AM</option>
							<option value="08:00:00">8:00 AM</option>
							<option value="08:30:00">8:30 AM</option>
							<option value="09:00:00">9:00 AM</option>
							<option value="09:30:00">9:30 AM</option>
							<option value="10:00:00">10:00 AM</option>
							<option value="10:30:00">10:30 AM</option>
							<option value="11:00:00">11:00 AM</option>
							<option value="11:30:00">11:30 AM</option>
							<option value="12:00:00">12:00 AM</option>
							<option value="12:30:00">12:30 AM</option>

							<option value="13:00:00">1:00 PM</option>
							<option value="13:30:00">1:30 PM</option>
							<option value="14:00:00">2:00 PM</option>
							<option value="14:30:00">2:30 PM</option>
							<option value="15:00:00">3:00 PM</option>
							<option value="15:30:00">3:30 PM</option>
							<option value="16:00:00">4:00 PM</option>
							<option value="16:30:00">4:30 PM</option>
							<option value="17:00:00">5:00 PM</option>
							<option value="17:30:00">5:30 PM</option>
							<option value="18:00:00" selected="">6:00 PM</option>
							<option value="18:30:00">6:30 PM</option>
							<option value="19:00:00">7:00 PM</option>
							<option value="19:30:00">7:30 PM</option>
							<option value="20:00:00">8:00 PM</option>
							<option value="20:30:00">8:30 PM</option>
							<option value="21:00:00">9:00 PM</option>
							<option value="21:30:00">9:30 PM</option>
							<option value="22:00:00">10:00 PM</option>
							<option value="22:30:00">10:30 PM</option>
							<option value="23:00:00">11:00 PM</option>
							<option value="23:30:00">11:30 PM</option>
							<option value="24:00:00">12:00 PM</option>
							<option value="24:30:00">12:30 PM</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label>To:</label>
						<select class="form-control" id="ot_to">
						<option value="01:00:00">1:00 AM</option>
							<option value="01:30:00">1:30 AM</option>
							<option value="02:00:00">2:00 AM</option>
							<option value="02:30:00">2:30 AM</option>
							<option value="03:00:00">3:00 AM</option>
							<option value="03:30:00">3:30 AM</option>
							<option value="04:00:00">4:00 AM</option>
							<option value="04:30:00">4:30 AM</option>
							<option value="05:00:00">5:00 AM</option>
							<option value="05:30:00">5:30 AM</option>
							<option value="06:00:00">6:00 AM</option>
							<option value="06:30:00">6:30 AM</option>
							<option value="07:00:00">7:00 AM</option>
							<option value="07:30:00">7:30 AM</option>
							<option value="08:00:00">8:00 AM</option>
							<option value="08:30:00">8:30 AM</option>
							<option value="09:00:00">9:00 AM</option>
							<option value="09:30:00">9:30 AM</option>
							<option value="10:00:00">10:00 AM</option>
							<option value="10:30:00">10:30 AM</option>
							<option value="11:00:00">11:00 AM</option>
							<option value="11:30:00">11:30 AM</option>
							<option value="12:00:00">12:00 AM</option>
							<option value="12:30:00">12:30 AM</option>

							<option value="13:00:00">1:00 PM</option>
							<option value="13:30:00">1:30 PM</option>
							<option value="14:00:00">2:00 PM</option>
							<option value="14:30:00">2:30 PM</option>
							<option value="15:00:00">3:00 PM</option>
							<option value="15:30:00">3:30 PM</option>
							<option value="16:00:00">4:00 PM</option>
							<option value="16:30:00">4:30 PM</option>
							<option value="17:00:00">5:00 PM</option>
							<option value="17:30:00">5:30 PM</option>
							<option value="18:00:00" selected="">6:00 PM</option>
							<option value="18:30:00">6:30 PM</option>
							<option value="19:00:00">7:00 PM</option>
							<option value="19:30:00">7:30 PM</option>
							<option value="20:00:00">8:00 PM</option>
							<option value="20:30:00">8:30 PM</option>
							<option value="21:00:00">9:00 PM</option>
							<option value="21:30:00">9:30 PM</option>
							<option value="22:00:00">10:00 PM</option>
							<option value="22:30:00">10:30 PM</option>
							<option value="23:00:00">11:00 PM</option>
							<option value="23:30:00">11:30 PM</option>
							<option value="24:00:00">12:00 PM</option>
							<option value="24:30:00">12:30 PM</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label>Number of hours:</label>
						<input type="number" disabled="" id="no_of_hrs" class="form-control" name="">
					</td>
				</tr>

				<tr>
					<td>
						<label>OT Date From:</label>
						<input type="date" id="ot_date" class="form-control" name="" required>
					</td>
				</tr>
				<tr>
					<td>
					<label>Upload Approved Overtime Form:</label>
					<input type="file" class="form-control" id="overtimeForm" name"overtimeForm" required>
					</td>
				</tr>

    </table>
    <center>
				<button type="button" class="btn btn-sm btn-success" onclick="submitot()" id="btn_submit"><i class="fas fa-sm fa-save"></i> Submit</button>
		</center>

  </div>

  <div id="div_myleave" class="div_content" style="display: none;">
  <select id="filter_ot" class="form-control">
			<option value=""> All </option>
			<option value="Pending" selected=""> Pending </option>
			<option value="Approved"> Approved </option>
			<option value="Disapproved"> Disapproved </option>
		</select>
  		<table class="table table-striped w-100" id="tbl_myot">
				<thead>
					<th>Reasons</th>
					<th>Date Filed</th>
					<th>From</th>
					<th>To</th>
					<th>No. of hrs</th>
					<th>OT Date</th>
					<th>Status</th>
					<th class="text-center" style="max-width: 100px">Action</th>
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
          <div class="form-group">
            <label for="exampleInputEmail1">Status:</label>
            <span class="form-control" id="overtime_status"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Reason(s)/Justification:</label>
            <span class="form-control" id="overtime_reasons"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Date Filed:</label>
            <span class="form-control" id="overtime_date_filed"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">From:</label>
            <span class="form-control" id="overtime_from"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">To:</label>
            <span class="form-control" id="overtime_to"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">No of hrs:</label>
            <span class="form-control" id="overtime_no_of_hrs"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">OT Date:</label>
            <span class="form-control" id="overtime_date"></span>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Remarks:</label>
            <textarea disabled class="form-control" id="overtime_remarks"></textarea>
          </div>

      </div>

    </div>
  </div>
</div>

<input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
<input type="hidden" id="currentUser" value="<?php echo $_SESSION['employeeno'] ?>" name="">
 
</body>
<script src="services/overtime.js"></script>
</html>
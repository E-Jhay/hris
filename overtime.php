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
							<option value="01:00">1:00 AM</option>
							<option value="01:30">1:30 AM</option>
							<option value="02:00">2:00 AM</option>
							<option value="02:30">2:30 AM</option>
							<option value="03:00">3:00 AM</option>
							<option value="03:30">3:30 AM</option>
							<option value="04:00">4:00 AM</option>
							<option value="04:30">4:30 AM</option>
							<option value="05:00">5:00 AM</option>
							<option value="05:30">5:30 AM</option>
							<option value="06:00">6:00 AM</option>
							<option value="06:30">6:30 AM</option>
							<option value="07:00">7:00 AM</option>
							<option value="07:30">7:30 AM</option>
							<option value="08:00">8:00 AM</option>
							<option value="08:30">8:30 AM</option>
							<option value="09:00">9:00 AM</option>
							<option value="09:30">9:30 AM</option>
							<option value="10:00">10:00 AM</option>
							<option value="10:30">10:30 AM</option>
							<option value="11:00">11:00 AM</option>
							<option value="11:30">11:30 AM</option>
							<option value="12:00">12:00 AM</option>
							<option value="12:30">12:30 AM</option>

							<option value="13:00">1:00 PM</option>
							<option value="13:30">1:30 PM</option>
							<option value="14:00">2:00 PM</option>
							<option value="14:30">2:30 PM</option>
							<option value="15:00">3:00 PM</option>
							<option value="15:30">3:30 PM</option>
							<option value="16:00">4:00 PM</option>
							<option value="16:30">4:30 PM</option>
							<option value="17:00">5:00 PM</option>
							<option value="17:30">5:30 PM</option>
							<option value="18:00" selected="">6:00 PM</option>
							<option value="18:30">6:30 PM</option>
							<option value="19:00">7:00 PM</option>
							<option value="19:30">7:30 PM</option>
							<option value="20:00">8:00 PM</option>
							<option value="20:30">8:30 PM</option>
							<option value="21:00">9:00 PM</option>
							<option value="21:30">9:30 PM</option>
							<option value="22:00">10:00 PM</option>
							<option value="22:30">10:30 PM</option>
							<option value="23:00">11:00 PM</option>
							<option value="23:30">11:30 PM</option>
							<option value="24:00">12:00 PM</option>
							<option value="24:30">12:30 PM</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label>To:</label>
						<select class="form-control" id="ot_to">
							<option value="01:00">1:00 AM</option>
							<option value="01:30">1:30 AM</option>
							<option value="02:00">2:00 AM</option>
							<option value="02:30">2:30 AM</option>
							<option value="03:00">3:00 AM</option>
							<option value="03:30">3:30 AM</option>
							<option value="04:00">4:00 AM</option>
							<option value="04:30">4:30 AM</option>
							<option value="05:00">5:00 AM</option>
							<option value="05:30">5:30 AM</option>
							<option value="06:00">6:00 AM</option>
							<option value="06:30">6:30 AM</option>
							<option value="07:00">7:00 AM</option>
							<option value="07:30">7:30 AM</option>
							<option value="08:00">8:00 AM</option>
							<option value="08:30">8:30 AM</option>
							<option value="09:00">9:00 AM</option>
							<option value="09:30">9:30 AM</option>
							<option value="10:00">10:00 AM</option>
							<option value="10:30">10:30 AM</option>
							<option value="11:00">11:00 AM</option>
							<option value="11:30">11:30 AM</option>
							<option value="12:00">12:00 AM</option>
							<option value="12:30">12:30 AM</option>

							<option value="13:00">1:00 PM</option>
							<option value="13:30">1:30 PM</option>
							<option value="14:00">2:00 PM</option>
							<option value="14:30">2:30 PM</option>
							<option value="15:00">3:00 PM</option>
							<option value="15:30">3:30 PM</option>
							<option value="16:00">4:00 PM</option>
							<option value="16:30">4:30 PM</option>
							<option value="17:00">5:00 PM</option>
							<option value="17:30">5:30 PM</option>
							<option value="18:00" selected="">6:00 PM</option>
							<option value="18:30">6:30 PM</option>
							<option value="19:00">7:00 PM</option>
							<option value="19:30">7:30 PM</option>
							<option value="20:00">8:00 PM</option>
							<option value="20:30">8:30 PM</option>
							<option value="21:00">9:00 PM</option>
							<option value="21:30">9:30 PM</option>
							<option value="22:00">10:00 PM</option>
							<option value="22:30">10:30 PM</option>
							<option value="23:00">11:00 PM</option>
							<option value="23:30">11:30 PM</option>
							<option value="24:00">12:00 PM</option>
							<option value="24:30">12:30 PM</option>
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
						<label>OT Date To:</label>
						<input type="date" id="ot_date_to" class="form-control" name="" required>
					</td>
				</tr>

    </table>
    <center>
				<button type="button" class="btn btn-sm btn-success" onclick="submitot()"><i class="fas fa-sm fa-save"></i> Save</button>
		</center>

  </div>

  <div id="div_myleave" class="div_content" style="display: none;">
  		<table class="table table-striped w-100" id="tbl_myot">
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
					<th>Remarks</th>
					<th></th>
				</thead>
				<tbody>
								
				</tbody>
			</table>
  </div>
 
</div>

<input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
 
</body>
<script src="services/overtime.js"></script>
</html>
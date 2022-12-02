<?php 
session_start();

$usertype = $_SESSION['usertype'];
$empno = $_SESSION['employeeno'];
$approver = $_SESSION['approver'];
$employment_status = $_SESSION['employment_status'];
// $employee_month = $_SESSION['employee_month'];
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
          <a class="nav-link active" id="lemployee" href="#" onclick="btnemployee()">Employee's Reimbursement</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="l_apply_employee" href="#" onclick="btnapplyemployee()">Apply Employee's Reimbursement</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="l_reports" href="#" onclick="btnreports()">Reports</a>
        </li>
      </ul>

</div>

<div class="navcontainer">
	<input type="hidden" id="balance" value="<?php echo $_GET['balance'] ?>" name="">

	<div id="div_employee" class="div_content">
		<select id="filter_reimbursement" class="form-control">
			<option value=""> All </option>
			<option value="Pending" selected=""> Pending </option>
			<option value="Approved"> Approved </option>
			<option value="Disapproved"> Disapproved </option>
		</select>
		<table class="table table-striped w-100" id="tbl_reimburse_all">
			<thead>
				<th>Employee Name</th>
				<th>OR/SI Number</th>
				<th>Nature of Benefit</th>
				<th>Amount</th>
				<th>Date Applied</th>
				<th>Status</th>
				<th class="text-center">Action</th>
			</thead>
			<tbody>
								
			</tbody>
		</table>	

	</div>

	<div id="div_apply_employee" style="display: none;">
		<form name="form" method="post" action="esscontroller.php?uploadreimbursement" enctype="multipart/form-data">
			<table class="table table-condensed w-100">			
				<label>Available Credits: <span id="rem_bal2"></span></label>
				<input type="hidden" id="reimbursement_bal_apply" name="reimbursement_bal">
				<tr>
					<td>
						<label>Employee:</label>
						<select class="form-control" id="employeeddown" name="emp_no"></select>
					</td>
				</tr>

				<tr>
					<td>
						<label>OR/SI Number:</label>
						<input type="text" id="description" class="form-control" name="description">
					</td>
				</tr>

				<tr>
					<td>
						<label>Nature of benefit:</label>
						<select class="form-control" id="nature" name="nature">
							<option value="" selected=""> -- Select nature --</option>
							<option value="Dental"> Dental </option>
							<option value="Optical"> Optical </option>
							<option value="Medicine"> Medicine </option>
							<option value="Hospitalization/Medical"> Hospitalization/Medical </option>
						</select>
					</td>
				</tr>

				<tr>
					<td>
						<label>Amount:</label>
						<input type="number" step="any" id="amount" class="form-control" name="amount">
					</td>
				</tr>

				<tr>
					<td>
						<label>File:</label>
						<input class="form-control" id="empfile" required="" type="file" name="empfile" />
					</td>
				</tr>

		</table>

			<center>
				<button type="submit" class="btn btn-sm btn-success"><i class="fas fa-sm fa-save"></i> Submit</button>
			</center>

		</form>
	</div>

	<div id="div_reports" style="display: none;">
		
		<label>Remaining balance</label><br>
		<button type="button" class="btn btn-sm btn-success" onclick="export_emp_reim()"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
		<button type="button" onclick="reset_credit()" class="btn btn-danger btn-sm"><i class="fa fa-refresh"></i> Reset All Credits to 3,500</button>
	</div>


</div>

<div class="modal fade" id="reimbursement_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Reimbursement Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group d-none">
            <label for="exampleInputEmail1">id</label>
            <input type="text" class="form-control txtbox" id="rem_id" placeholder="">
          </div>

          <div class="form-group d-none">
            <label for="exampleInputEmail1">employeeno</label>
            <input type="text" class="form-control" id="employeeno_modal" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Employee Name</label>
            <input type="text" class="form-control" disabled="" id="employeename_modal" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Particular/Description</label>
            <input type="text" class="form-control" disabled="" id="description_modal" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Nature of Benefit</label>
            <input type="text" class="form-control" disabled="" id="nature_modal" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Date applied</label>
            <input type="text" class="form-control" disabled="" id="datee_modal" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Available credits</label>
            <input type="text" class="form-control" disabled="" id="credits_modal" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Amount</label>
            <input type="text" class="form-control" disabled="" id="amount_modal" placeholder="">
          </div>

          <div class="form-group d-none">
            <label for="exampleInputEmail1">orig amount</label>
            <input type="text" class="form-control" disabled="" id="orig_amount_modal" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Remarks</label>
            <textarea class="form-control" id="remarks"></textarea>
          </div>

          
          <center>
	        	<button type="button" class="btn btn-sm btn-success" id="approved_btn" onclick="approved()"> Approved</button>
	        	<button type="button" class="btn btn-sm btn-danger" id="disapproved_btn" onclick="disapproved()"> Disapproved</button>
	        	<button type="button" class="btn btn-sm btn-primary" id="undo_btn" onclick="undo()"> Undo </button>
	        </center>

      </div>

    </div>
  </div>
</div>

<input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
 
</body>
<script src="services/reimburse_report.js"></script>
</html>
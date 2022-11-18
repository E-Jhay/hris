<?php 
session_start();

$usertype = $_SESSION['usertype'];
$empno = $_SESSION['employeeno'];
$approver = $_SESSION['approver'];
$employment_status = $_SESSION['employment_status'];
$employee_month = $_SESSION['employee_month'];
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
          <a class="nav-link" id="lmyapply" href="#" onclick="btnmyapply()">My Reimbursement</a>
        </li>
      </ul>

</div>

<div class="navcontainer">
	<input type="hidden" id="balance" value="<?php echo $_GET['balance'] ?>" name="">
	<?php if ($employment_status == "Probationary"): ?>

	<div style="border: 1px solid lightgray;padding: 20px">
		<h1 style="color: gray">This benefit is for regular employees only.</h1>
	</div>

	<?php endif ?>

	<?php if ($employment_status != "Probationary"): ?>

	<div id="div_apply" class="div_content">
		<form name="form" id="form" method="post" enctype="multipart/form-data">
			<label>Available Credits: <span id="rem_bal"></span></label>
			<table class="table table-condensed w-100">
				<input type="hidden" id="emp_no" value="<?php echo $_SESSION['employeeno'] ?>" name="emp_no">
				<input type="hidden" id="reimbursement_bal" name="reimbursement_bal">
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
						<label>Receipt:</label>
						<input class="form-control" id="empfile" required="" type="file" name="empfile" />
					</td>
				</tr>

			</table>
			<center>
				<button type="submit" class="btn btn-sm btn-success"><i class="fas fa-sm fa-save"></i> Submit</button>
			</center>

		</form>				
	</div>

	<div id="div_myapply" style="display: none;">

		<table class="table table-striped w-100" id="tbl_reimburse">
			<thead>
				<th>OR/SI Number</th>
				<th>Nature of Benefit</th>
				<th>Amount</th>
				<th>Date Applied</th>
				<th>Status</th>
				<th>Action</th>
			</thead>
			<tbody>
								
			</tbody>
		</table>

	</div>

	<?php endif ?>

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

      </div>

    </div>
  </div>
</div>


<input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
 
</body>
<script src="services/reimbursement.js"></script>
</html>
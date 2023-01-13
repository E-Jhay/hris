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
  require_once "ess_tab.php";
   ?>
</div>

<div class="navtabs">
      
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item">
          <a class="nav-link active" id="" href="#">Other ID information</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_myinfo" class="div_content">
  	<!-- <form action="">


		<table class="table-condensed grid12_master master_input">
			<tr>
				<td><b>COMPANY ID </b></td>
			</tr>
			<tr>
				<td><b>Date issued: </b><input type="date" class="form-control" id="comp_id_dateissue" name="comp_id_dateissue"></td>
			</tr>
			<tr>
				<td><b>Validity Date: </b><input type="date" class="form-control" id="comp_id_vdate" name="comp_id_vdate"></td>
			</tr>
			<tr>
				<td><b>FACILITY ACCESS PASS </b></td>
			</tr>
			<tr>
				<td><b>Proximity Card Number: </b><input type="text" class="form-control" id="fac_card_number" name="fac_card_number"></td>
			</tr>
			<tr>
				<td><b>Date issued: </b><input type="date" class="form-control" id="fac_ap_dateissue" name="fac_ap_dateissue"></td>
			</tr>
			<tr>
				<td><b>Validity Date: </b><input type="date" class="form-control" id="fac_ap_vdate" name="fac_ap_vdate"></td>
			</tr>
			<tr>
				<td><b>Driver License Number: </b><input type="text" class="form-control" id="driver_id" name="driver_id"></td>
			</tr>
			<tr>
				<td><b>License Expiry: </b><input type="date" class="form-control" id="driver_exp" name="driver_exp"></td>
			</tr>
			<tr>
				<td><b>PRC Number: </b><input type="text" class="form-control" id="prc_number" name="prc_number"></td>
			</tr>
			<tr>
				<td><b>PRC Expiry: </b><input type="date" class="form-control" id="prc_exp" name="prc_exp"></td>
			</tr>
			<tr>
				<td><b>Civil Service Number: </b><input type="text" class="form-control" id="civil_service" name="civil_service"></td>
			</tr>
		</table>
	</form> -->
	<table class="table-condensed grid3_master master_input">
        <tr>
            <td class="text-center"><img  style="border: 1px dashed #a7a7a7; cursor: pointer;" src="" id="personal_image"></td>
        </tr>
        <tr>
            <td><b>Employee no: </b><input type="text" class="form-control" id="emp_no" name="emp_no"></td>
        </tr>
        <tr class="d-none">
            <td><b>Rank: </b><input type="text" class="form-control" id="rank" name="rank"></td>
        </tr>
            
        <tr class="d-none">
            <td><b>Company: </b><select class="form-control" id="company" name="company"></select></td>
        </tr>
            
        <tr class="d-none">
            <td><b>Leave Balance: </b><input type="text" class="form-control" id="leave_balance" name="leave_balance"></td>
        </tr>
    </table>

	<table class="table-condensed grid3_master master_input">

        <tr>
            <td><b>First name: </b><input type="text" class="form-control" id="f_name" name="f_name"></td>
        </tr>
        <tr>
            <td><b>Last name: </b><input type="text" class="form-control" id="l_name" name="l_name"></td>
        </tr>
        <tr>
            <td><b>Middle name: </b><input type="text" class="form-control" id="m_name" name="m_name"></td>
        </tr>
                        
    </table>

    <table class="table-condensed grid3_master master_input">

        <tr>
            <td><b>Status: </b>
                <select class="form-control" id="statuss" name="statuss">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><b>Employment Status: </b><select class="form-control" id="emp_statuss" name="emp_statuss"></select></td>
        </tr>
        <tr>
            <td><b>Department: </b><select class="form-control" required="" id="department" name="department"></select></td>
        </tr>
                    
    </table>

	<form name="form" id="form" enctype="multipart/form-data" style="width: 100%; float: left; padding: 1em">
        <div>
        <button type="button" id="addBtn" class="btn btn-sm btn-primary mb-4">Add ID</button>
        <button type="button" id="cancelBtn" class="btn btn-sm btn-warning mb-4" style="display: none; ">Cancel</button>
        </div>
        
        <table class="table-condensed" id="other_id_table" style="width: 100%; float: left; padding: 1em">
            <tr>
                <td>
                    <b>ID Type (Company / FAP / Others): </b>
                    <input type="text" class="form-control" id="id_type" name="id_type" placeholder="ID Type" required>
                    <input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno']; ?>" name="employeeno">
                </td>
            </tr>
            <tr>
                <td>
                    <b>Card Number: </b>
                    <input type="text" class="form-control" id="card_number" name="card_number" placeholder="Card Number" required>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Description: </b>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
                </td>
            </tr>
			<tr>
				<td>
					<b>Date Issued: </b>
					<input type="date" class="form-control" id="date_issued" name="date_issued">
				</td>
			</tr>
			<tr>
				<td>
					<b>Validity Date: </b>
					<input type="date" class="form-control" id="validity_date" name="validity_date">
				</td>
			</tr>
            <tr>
                <td>
                    <b>Upload Hardcopy: </b>
                    <input class="form-control" id="file" type="file" name="file"/>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                <button type="submit" class="btn btn-md btn-success"><i class="fas fa-sm fa-save"></i> Save</button>
                </td>
            </tr>
        </table>
	</form>

	<table class="table table-striped w-100" id="tbl_other_id">
		<thead>
			<th>ID Type</th>
			<th>Card No</th>
			<th>Description</th>
			<th>Date Issued</th>
			<th>Validity Date</th>
			<th class="text-center" style="min-width: 10em">File</th>
			<th class="text-center" style="max-width: 14em">Action</th>
		</thead>
		<tbody>
			
		</tbody>
    </table>
  </div>
 
</div>

<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Identification Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="other_id_form" enctype="multipart/form-data">
            <div class="form-group">
              <input type="hidden" id="other_id_id" name="other_id_id">
              <input type="hidden" class="form-control" id="other_id_file_name" name="other_id_file_name"></input>
			  <input type="hidden" id="other_id_employeeno" name="other_id_employeeno">
              <label for="exampleInputEmail1">ID Type (Company / FAP / Others):</label>
              <input type="text" class="form-control" id="other_id_id_type" name="other_id_id_type"></input>
            </div>
            
            <div class="form-group">
              <label for="exampleInputEmail1">Card Number:</label>
              <input type="text" class="form-control" id="other_id_card_number" name="other_id_card_number"></input>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Description:</label>
              <input type="text" class="form-control" id="other_id_description" name="other_id_description"></input>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Date Issued:</label>
              <input type="date" class="form-control" id="other_id_date_issued" name="other_id_date_issued"></input>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Validity Date:</label>
              <input type="date" class="form-control" id="other_id_validity_date" name="other_id_validity_date"></input>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Upload Hardcopy:</label>
              <input type="file" name="other_id_file" id="other_id_file" class="form-control">
            </div>
            <center>
              <button type="submit" class="btn btn-primary btn-sm" id="btn_submit">Submit</button>
            </center>
          </form>
      </div>

    </div>
  </div>
</div>
<input type="hidden" id="currentUser" value="<?php echo $_SESSION['employeeno'] ?>" name="">

</body>
<script src="services/ess_ids.js"></script>
</html>
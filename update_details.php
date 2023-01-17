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
          <a class="nav-link active" id="" href="#">Details to update</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_myinfo" class="div_content">
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

	<!-- <form name="form" id="form" enctype="multipart/form-data" style="width: 100%; float: left; padding: 1em">
        <div>
        <button type="button" id="addBtn" class="btn btn-sm btn-primary mb-4">Add ID</button>
        <button type="button" id="cancelBtn" class="btn btn-sm btn-warning mb-4" style="display: none; ">Cancel</button>
        </div>
        
	</form> -->

  <div class="grid12_master" style="margin-bottom: 0">
    <button type="button" id="civilStatusBtn" class="btn btn-sm btn-primary mb-4">Update Civil Status</button>
    <button type="button" id="addressBtn" class="btn btn-sm btn-warning mb-4">Update Address</button>
  </div>

  <form name="civilStatusForm" id="civilStatusForm" enctype="multipart/form-data">
    <table class="table-condensed" id="civilStatusTable" style="width: 100%;">
      <tr>
        <td>
          <b>Status:</b>
          <select class="form-control" name="civilStatus" id="civilStatus" required>
            <option value="Single"> Single </option>
            <option value="Married"> Married </option>
            <option value="Widowed"> Widowed </option>
            <option value="Annulled"> Annulled </option>
          </select>
          <input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno']; ?>" name="employeeno">
          <input type="hidden" id="marriage_contract" name="marriage_contract">
        </td>
      </tr>
      <tr id="marriage_contract_panel">
        <td>
          <b>Upload Marriage Contract: </b>
          <input class="form-control" id="marriageContractFile" type="file" name="marriageContractFile"/>
        </td>
      </tr>
      <tr>
        <td class="text-center">
          <button class="btn btn-primary" type="submit"><i class="fas fa-sm fa-save"></i> Save</button>
        </td>
      </tr>
    </table>
	</form>

  <form name="addressForm" id="addressForm" enctype="multipart/form-data">
    <table class="table-condensed" id="addressTable" style="width: 100%;">
      <tr>
        <td><h4>Address</h4></td>
        <input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno']; ?>" name="employeeno">
        <input type="hidden" id="proof_of_billing" name="proof_of_billing">
      </tr>
      <tr>
        <td>
          <b>Street / Barangay: </b>
          <input type="text" class="form-control" id="street" name="street" placeholder="Street">
        </td>
        <td>
          <b>Municipality: </b>
          <input type="text" class="form-control" id="municipality" name="municipality" placeholder="Municipality">
        </td>
        <td>
          <b>Province: </b>
          <input type="text" class="form-control" id="province" name="province" placeholder="Province">
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <b>Upload Proof of Billing: </b>
          <input class="form-control" id="addressFile" type="file" name="addressFile"/>
        </td>
      </tr>
      <tr>
        <td class="text-center" colspan="3">
          <button class="btn btn-primary" type="submit"><i class="fas fa-sm fa-save"></i> Save</button>
        </td>
      </tr>
    </table>
	</form>
 
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
<script src="services/update_details.js"></script>
</html>
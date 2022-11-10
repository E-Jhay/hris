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
          <a class="nav-link active" id="" href="#">Personal Details</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_myinfo" class="div_content">
  	<img src="" id="personal_pic">
		<br><br>
    <table class="table table-striped w-100">

						<tr>
							<td>First Name: <b><span id="fname"></span></b></td>
							<td>Middle Name: <b><span id="mname"></span></b></td>
							<td>Last Name: <b><span id="lname"></span></b></td>
						</tr>

						<tr>
							<td>Employee Number: <b><span id="empno"></b></td>
							<td>Date Hired: <b><span id="datehired"></span></b></td>
							<td>Date of Birth: <b><span id="dob"></span></b></td>
						</tr>

						<tr>
							<td>Nationality: <b><span id="nationality"></span></b></td>
							<td>Marital Status: <b><span id="marital_status"></span></b></td>
							<td>Gender: <b><span id="genderr"></span></b></td>
						</tr>

						<tr>
							<td>
                <button type="button" onclick="documentsModal()" class="btn btn-sm btn-success"><i class="fas fa-sm fa-pen"></i> Upload Additional Documents</button>
                <button type="button" onclick="change()" class="btn btn-sm btn-success"><i class="fas fa-sm fa-lock"></i> Change Password</button>
              </td>
							<td><br></td>
							<td><br></td>
						</tr>

					</table>
  </div>
 
</div>

<div class="modal fade" id="password_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Account Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control txtbox" disabled="" id="username_modal" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Password</label>
            <input type="text" class="form-control txtbox" id="pass_modal" placeholder="">
          </div>
          
          <center>
          <button class="btn btn-success btn-sm" type="button" id="" onclick="save_pass()"><i class="fa fa-save"></i> Save</button>
          </center>

      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="documentsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Upload Documents</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <form id="form" action="controller/controller.info.php?addDocuments" method="post" enctype="multipart/form-data">
        <div class="container">
          <div class="row mb-4">
            <div class="col d-flex justify-content-center">
                <div class="text-center" style="height: 180px; width: 180px; border: 1px dashed #a7a7a7; cursor: pointer; margin-bottom: 4em">
                  <img class="mb-4" title="Profile Picture" src="" id="personal_image" width="100%" height="100%">
                  <span style="font-size: 18px;">Profile Picture</span>
                  <button type="button" id="removeImage" class="btn btn-danger btn-sm">Remove</button>
                </div>
              <!-- <input type="hidden" name="employee_number" id="employee_number"> -->
              <input class="d-none" id="profile" type="file" name="profile" accept="image/png, image/gif, image/jpeg">
            </div>
          </div>
          <div class="row" style="margin-bottom: 4em;">
            <div class="col d-flex justify-content-center">
                <div class="text-center" style="height: 120px; width: 160px; border: 1px dashed #a7a7a7; cursor: pointer; margin-bottom: 4em">
                  <img class="mb-4" title="Marriage Contract" id="marriage_contract_image" width="100%" height="100%" src="static/card-thumbnail.jpg">
                  <span style="font-size: 18px;">Civil Status Change<span style="font-size: 12px; opacity: .8;"> Marriage Contract</span></span><br />
                  <button type="button" id="removeMarriageContract" onclick="removeFile('#removeMarriageContract', '#marriage_contract_image')" class="btn btn-danger btn-sm">Remove</button>
                </div>
              <input class="d-none" id="marriageContract" type="file" name="marriageContract" accept="image/png, image/gif, image/jpeg">
            </div>
            <div class="col d-flex justify-content-center">
                <div class="text-center" style="height: 120px; width: 160px; border: 1px dashed #a7a7a7; cursor: pointer; margin-bottom: 4em">
                  <img class="mb-4" title="Dependent" id="dependent_image" width="100%" height="100%" src="static/card-thumbnail.jpg">
                  <span style="font-size: 18px;">Dependent <span style="font-size: 12px; opacity: .8;">(Birth Certificate)</span></span><br />
                  <button type="button" id="removeDependent" onclick="removeFile('#removeDependent', '#dependent_image')" class="btn btn-danger btn-sm">Remove</button>
                </div>
              <input class="d-none" id="dependent" type="file" name="dependent" accept="image/png, image/gif, image/jpeg">
            </div>
          </div>
          <div class="row mb-4">
            <div class="col d-flex justify-content-center">
                <div class="text-center" style="height: 120px; width: 160px; border: 1px dashed #a7a7a7; cursor: pointer; margin-bottom: 4em">
                  <img class="mb-4" title="Additional Image" id="additional_id_image" width="100%" height="100%" src="static/card-thumbnail.jpg">
                  <span style="font-size: 18px;">ID <span style="font-size: 12px; opacity: .8;">(Solo Parent ID / National ID or other types)</span></span><br />
                  <button type="button" id="removeAdditionalId" onclick="removeFile('#removeAdditionalId', '#additional_id_image')" class="btn btn-danger btn-sm">Remove</button>
                </div>
              <input class="d-none" id="additionalId" type="file" name="additionalId" accept="image/png, image/gif, image/jpeg">
            </div>
            <div class="col d-flex justify-content-center">
                <div class="text-center" style="height: 120px; width: 160px; border: 1px dashed #a7a7a7; cursor: pointer; margin-bottom: 4em">
                  <img class="mb-4" title="Proof of Billing" id="proofOFBilling_image" width="100%" height="100%" src="static/card-thumbnail.jpg">
                  <span style="font-size: 18px;">Address Update <span style="font-size: 12px; opacity: .8;">(Proof of Billing)</span></span><br />
                  <button type="button" id="removeProofOfBilling" onclick="removeFile('#removeProofOfBilling', '#proofOFBilling_image')" onclick="removeFile('#removeImage')" class="btn btn-danger btn-sm">Remove</button>
                </div>
              <input class="d-none" id="proofOFBilling" type="file" name="proofOFBilling" accept="image/png, image/gif, image/jpeg">
            </div>
          </div>
        </div>
        <input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="employeeno">
        <center style="margin: 6em 0 2em 0">
        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Save Changes</button>
        </center>
      </form>
          

      </div>

    </div>
  </div>
</div>

</body>
<script src="services/info.js"></script>
</html>
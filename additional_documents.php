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
  require_once "master_tab.php";
   ?>
</div>

<div class="navtabs">
  <ul class="nav nav-tabs bb-none">
    <li class="nav-item">
      <a class="nav-link active" id="" href="#">Additional Documents</a>
    </li>
  </ul>
</div>

<div class="navcontainer">

  <div id="div_myinfo" class="div_content">
    <form id="form" action="" enctype="multipart/form-data">
        <?php 
        require_once "info_tab.php";
        ?>

      <table class="table-condensed gridCustom_master master_input">
        <tr>
          <td><b>Update Additional Documents</b></td>
        </tr>
        <tr>
            <td>
                <label for="marriageContract"><b>Marriage Contract: </b></label><br />
                <input id="marriageContract" type="file" name="marriageContract" accept="image/png, image/gif, image/jpeg, application/pdf">
            </td>
            <td>
                <label for="dependent"><b>Dependent (Birth Certificate): </b></label><br />
                <input id="dependent" type="file" name="dependent" accept="image/png, image/gif, image/jpeg, application/pdf">
            </td>
        </tr>
        <tr>
            <td>
                <label for="additionalId"><b>ID (Solo parent ID / National ID or other types): </b></label><br />
                <input id="additionalId" type="file" name="additionalId" accept="image/png, image/gif, image/jpeg, application/pdf">
            </td>
            <td>
                <label for="proofOFBilling"><b>Address Update (Proof of Billing): </b></label><br />
                <input id="proofOFBilling" type="file" name="proofOFBilling" accept="image/png, image/gif, image/jpeg, application/pdf">
            </td>
        </tr>
      </table>
    </form>

    <table class="table table-striped w-100" id="tbl_documents">
            <thead>
							<th>Marriage Contract</th>
							<th>Dependents</th>
							<th>Additional ID</th>
							<th>Proof of Billing</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>
 
</div>

</body>
<script src="services/additional_documents.js"></script>
</html>


<!-- <form action="" id="form" enctype="multipart/form-data">

			<table class="table-condensed gridCustom_master master_input">
        <tr>
          <td><b>Update Additional Documents</b></td>
        </tr>
        <tr>
            <td>
                <label for="marriageContract"><b>Marriage Contract: </b></label><br />
                <input id="marriageContract" type="file" name="marriageContract" accept="image/png, image/gif, image/jpeg, application/pdf">
            </td>
            <td>
                <label for="dependent"><b>Dependent (Birth Certificate): </b></label><br />
                <input id="dependent" type="file" name="dependent" accept="image/png, image/gif, image/jpeg, application/pdf">
            </td>
        </tr>
        <tr>
            <td>
                <label for="additionalId"><b>ID (Solo parent ID / National ID or other types): </b></label><br />
                <input id="additionalId" type="file" name="additionalId" accept="image/png, image/gif, image/jpeg, application/pdf">
            </td>
            <td>
                <label for="proofOFBilling"><b>Address Update (Proof of Billing): </b></label><br />
                <input id="proofOFBilling" type="file" name="proofOFBilling" accept="image/png, image/gif, image/jpeg, application/pdf">
            </td>
        </tr>
			</table>
		</form> -->

    
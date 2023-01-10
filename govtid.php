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
          <a class="nav-link active" id="" href="#">Govt. ID/ATM Information</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_myinfo" class="div_content">
  	<form action="">
			<?php 
		  require_once "info_tab.php";
		  ?>

			<table class="table-condensed grid12_master master_input">
    			<tr>
    				<td><b>Tin#: </b><input type="text" class="form-control" id="tin_no" name="tin_no" placeholder="000-000-000-000" maxlength="15" minlength="15"></td>
    			</tr>
    			<tr>
						<td><b>SSS#: </b><input type="text" class="form-control" id="sss_no" name="sss_no" placeholder="00-0000000-0" maxlength="12" minlength="12"></td>
					</tr>
					<tr>
						<td><b>PHIC#: </b><input type="text" class="form-control" id="phic_no" name="phic_no" placeholder="00-000000000-0" maxlength="14" minlength="14"></td>
					</tr>
					<tr>
						<td><b>HDMF#: </b><input type="text" class="form-control" id="hdmf_no" name="hdmf_no" placeholder="0000-0000-0000" maxlength="14"></td>
					</tr>
					<tr>
						<td><b>Account#: </b><input type="text" class="form-control" id="atm_no" name="atm_no"></td>
					</tr>
					<!-- <tr>
						<td><b>Bank Name: </b><input type="text" class="form-control" id="bank_name" name="bank_name"></td>
					</tr>
					</tr>
					<tr>
						<td><b>AUB#: </b><input type="text" class="form-control" id="aub_no" name="aub_no" placeholder="0000-0000-0000-0000" maxlength="19"></td>
					</tr> -->
					<tr>
						<td><b>SSS Remarks: </b><textarea class="form-control" id="sss_remarks" name="sss_remarks"></textarea></td>
					</tr>
					<tr>
						<td><b>PHIC Remarks: </b><textarea class="form-control" id="phic_remarks" name="phic_remarks"></textarea></td>
					</tr>
					<tr>
						<td><b>HDMF Remarks: </b><textarea class="form-control" id="hdmf_remarks" name="hdmf_remarks"></textarea></td>
					</tr>
			</table>
		</form>
  </div>
 
</div>

</body>
<script src="services/govt.js"></script>
</html>
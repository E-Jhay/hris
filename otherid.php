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
          <a class="nav-link active" id="" href="#">Other ID information</a>
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
		</form>
  </div>
 
</div>

</body>
<script src="services/otherid.js"></script>
</html>
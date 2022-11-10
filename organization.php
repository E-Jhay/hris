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
  require_once "admin_tab.php";
   ?>
</div>

<div class="navtabs">
      
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item">
          <a class="nav-link active" id="lgen_info" href="#" onclick="btngen_info()">General Information</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="llocations" href="#" onclick="btnlocations()">Locations</a>
        </li>
      </ul>

</div>

<div class="navcontainer">
  <div id="div_gen_info" class="div_content">
    <table class="table table-striped w-100 tabol" id="">
            <tr>
							<td><label>Organization Name</label></td>
							<td><input type="text" id="org_name" class="form-control" name=""></td>
							<td><label>Tax id</label></td>
							<td><input type="text" id="tax_id" class="form-control" name=""></td>
							<td><label>Number of Employee</label></td>
							<td><input type="text" id="numberof_emp" class="form-control" name=""></td>	
						</tr>

						<tr>
							<td><label>Registration Number</label></td>
							<td><input type="text" id="reg_number" class="form-control" name=""></td>
							<td><label>Cost Center</label></td>
							<td><input type="text" id="cost_center" class="form-control" name=""></td>
							<td><label>Cost Center Details</label></td>
							<td><input type="text" id="cost_center_detail" class="form-control" name=""></td>	
						</tr>

						<tr>
							<td><label>Contact Details</label></td>
							<td><input type="text" id="contact_details" class="form-control" name=""></td>
							<td><label>Fax</label></td>
							<td><input type="text" id="fax" class="form-control" name=""></td>
							<td><label>Email</label></td>
							<td><input type="text" id="email" class="form-control" name=""></td>	
						</tr>

						<tr>
							<td><label>Address St.</label></td>
							<td><input type="text" id="address_st" class="form-control" name=""></td>
							<td><label>Brgy</label></td>
							<td><input type="text" id="brgy" class="form-control" name=""></td>
							<td><label>City</label></td>
							<td><input type="text" id="city" class="form-control" name=""></td>	
						</tr>

						<tr>
							<td><label>Zipcode</label></td>
							<td><input type="text" id="zipcode" class="form-control" name=""></td>
							<td><label>Country</label></td>
							<td><input type="text" id="country" class="form-control" name=""></td>
							<td><label>Note</label></td>
							<td><input type="text" id="note" class="form-control" name=""></td>	
						</tr>
						
    </table>
    <center>
				<button type="button" class="btn btn-sm btn-success" onclick="updategeninfo()"><i class="fa fa-plus"></i> Update</button>
		</center>
  </div>

  <div id="div_locations" class="div_content">
  	<button type="button" class="btn btn-sm btn-success" onclick="btnaddlocation()"><i class="fa fa-plus"></i> Add New</button><br><br>
    <table class="table table-striped w-100" id="tbl_locations">
            <thead>
              <th>Name</th>
							<th>City</th>
							<th>Country</th>
							<th>Phone</th>
							<th>Number of Employee</th>
							<th>Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>

</div>

<div class="modal fade" id="location_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Location Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="hidden" id="modal_id" name="">
            <input type="text" class="form-control txtbox" id="modal_name" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">City</label>
            <input type="text" class="form-control txtbox" id="modal_city" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Country</label>
            <input type="text" class="form-control txtbox" id="modal_country" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Phone</label>
            <input type="text" class="form-control txtbox" id="modal_phone" placeholder="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Number of Employee</label>
            <input type="text" class="form-control txtbox" id="modal_noofemployee" placeholder="">
          </div>
          
          <center>
          <button class="btn btn-success btn-sm" type="button" id="savelocationbtn" onclick="btn_savelocation()"><i class="fa fa-save"></i> Save</button>
          <button class="btn btn-success btn-sm" id="updatelocationbtn" onclick="btn_updatelocation()"><i class="fa fa-save"></i> Update</button>
          </center>

      </div>

    </div>
  </div>
</div>

</body>
<script src="services/org.js"></script>
</html>
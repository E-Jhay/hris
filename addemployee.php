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
  require_once "pim_tab.php";
   ?>
</div>

<div class="navtabs">
      
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item">
          <a class="nav-link active" id="" href="#">New Employee</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_newemployee" class="div_content">
    <form action="">
				 <table class="table table-striped w-100">
				 	<tr>
				 		<td><input type="text" class="form-control" placeholder="Employee number" name="employeeno" required=""></td>
				 		<td>
				 			<input type="text" class="form-control" placeholder="Firstname" name="firstname" required="">
				 			
				 		</td>
				 	</tr>
				 	<tr>
				 		<td>
				 		<input type="text" class="form-control" placeholder="Middlename" name="middlename"></td>
				 		<td>
				 			<input type="text" class="form-control" placeholder="Lastname" name="lastname" required="">
				 			
				 		</td>
				 	</tr>
				 	<tr>
				 		<td><select class="form-control" id="employment_status" name="employment_status"></select></td>
				 		<td>
				 			<select class="form-control" id="company" name="company"></select>
				 		</td>
				 	</tr>
				 	<tr>
				 		<td><input type="text" class="form-control" placeholder="Corp Email" name="corp_email" required=""></td>
				 		<td>
				 			<input type="text" class="form-control" placeholder="0000-0000000" maxlength="12" minlength="12" id="contactno" name="contact_no">
				 			
				 		</td>
				 	</tr>
				 	<tr style="display: none;">
				 		<td><input type="hidden" id="password" name="password"></td>
				 		<td></td>
				 	</tr>
				 </table>
				 <center>
					 <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-sm fa-save"></i> Save Employee</button>
				 </center>

			 </form>
  </div>
 
</div>

</body>
<script src="services/addemployee.js"></script>
</html>
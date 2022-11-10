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
          <a class="nav-link active" id="" href="#">Benefits information</a>
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
    				<td><b>Dependents </b></td>
    			</tr>
    			<tr>
						<td><b>Name (Dependent 1): </b><input type="text" class="form-control" id="dependent1" name="dependent1"></td>
					</tr>
					<tr>
						<td><b>Age: </b><input type="number" class="form-control" id="age1" name="age1"></td>
					</tr>
					<tr>
						<td><b>Sex: </b>
									<select class="form-control" id="sex1" name="sex1">
										<option value="" selected=""> -- Select --</option>
										<option value="Male"> Male </option>
										<option value="Female"> Female </option>
									</select>
								</td>
					</tr>
					<tr>
						<td><b>Relationship: </b><input type="text" class="form-control" id="relation1" name="relation1"></td>
					</tr>

					<tr>
						<td><b>Name (Dependent 2): </b><input type="text" class="form-control" id="dependent2" name="dependent2"></td>
					</tr>
					<tr>
						<td><b>Age: </b><input type="number" class="form-control" id="age2" name="age2"></td>
					</tr>
					<tr>
						<td><b>Sex: </b>
									<select class="form-control" id="sex2" name="sex2">
										<option value="" selected=""> -- Select --</option>
										<option value="Male"> Male </option>
										<option value="Female"> Female </option>
									</select>
								</td>
					</tr>
					<tr>
						<td><b>Relationship: </b><input type="text" class="form-control" id="relation2" name="relation2"></td>
					</tr>

					<tr>
						<td><b>Name (Dependent 3): </b><input type="text" class="form-control" id="dependent3" name="dependent3"></td>
					</tr>
					<tr>
						<td><b>Age: </b><input type="number" class="form-control" id="age3" name="age3"></td>
					</tr>
					<tr>
						<td><b>Sex: </b>
									<select class="form-control" id="sex3" name="sex3">
										<option value="" selected=""> -- Select --</option>
										<option value="Male"> Male </option>
										<option value="Female"> Female </option>
									</select>
								</td>
					</tr>
					<tr>
						<td><b>Relationship: </b><input type="text" class="form-control" id="relation3" name="relation3"></td>
					</tr>

					<tr>
						<td><b>Name (Dependent 4): </b><input type="text" class="form-control" id="dependent4" name="dependent4"></td>
					</tr>
					<tr>
						<td><b>Age: </b><input type="number" class="form-control" id="age4" name="age4"></td>
					</tr>
					<tr>
						<td><b>Sex: </b>
									<select class="form-control" id="sex4" name="sex4">
										<option value="" selected=""> -- Select --</option>
										<option value="Male"> Male </option>
										<option value="Female"> Female </option>
									</select>
								</td>
					</tr>
					<tr>
						<td><b>Relationship: </b><input type="text" class="form-control" id="relation4" name="relation4"></td>
					</tr>

					<tr>
						<td><b>Name (Dependent 5): </b><input type="text" class="form-control" id="dependent5" name="dependent5"></td>
					</tr>
					<tr>
						<td><b>Age: </b><input type="number" class="form-control" id="age5" name="age5"></td>
					</tr>
					<tr>
						<td><b>Sex: </b>
									<select class="form-control" id="sex5" name="sex5">
										<option value="" selected=""> -- Select --</option>
										<option value="Male"> Male </option>
										<option value="Female"> Female </option>
									</select>
								</td>
					</tr>
					<tr>
						<td><b>Relationship: </b><input type="text" class="form-control" id="relation5" name="relation5"></td>
					</tr>
			</table>
		</form>
  </div>
 
</div>

</body>
<script src="services/benefits.js"></script>
</html>
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
          <a class="nav-link active" id="" href="#">Previous Employer information</a>
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
    				<td colspan="2"><b>Previous Company Name: </b><input type="text" class="form-control" id="company1" name="company1"></td>
    			</tr>
    			<tr>
						<td colspan="2"><b>Nature Of Business: </b><input type="text" class="form-control" id="naturebusiness1" name="naturebusiness1"></td>
					</tr>
					<tr>
						<td><b>Year: </b>
							<select id="year1" name="year1" class="form-control">
			          <option value="" selected="">YYYY</option>
			          <option value="PRESENT">PRESENT</option>
			          <?php $dateyear = date('Y');
			          for ($i=0; $i < 100; $i++) {?>
			            <option value="<?php echo $dateyear; ?>"><?php echo $dateyear; ?></option>
			          <?php $dateyear--;   
			          }?>              
			         </select>
			      </td>
			      <td><b>Year End: </b>
			         <select id="yearend1" name="yearend1" class="form-control">
			          <option value="" selected="">YYYY</option>
			          <option value="PRESENT">PRESENT</option>
			          <?php $dateyear = date('Y');
			          for ($i=0; $i < 100; $i++) {?>
			            <option value="<?php echo $dateyear; ?>"><?php echo $dateyear; ?></option>
			          <?php $dateyear--;   
			          }?>              
			         </select>
			       </td>
			       
					</tr>
					<tr>
						<td colspan="2"><b>Position: </b><input type="text" class="form-control" id="position1" name="position1"></td>
					</tr>
					<tr>
						<td colspan="2"><b>Rate: </b><input type="text" class="form-control" id="rate1" name="rate1"></td>
					</tr>

					<tr>
    				<td colspan="2"><b>Previous Company Name: </b><input type="text" class="form-control" id="company2" name="company2"></td>
    			</tr>
    			<tr>
						<td colspan="2"><b>Nature Of Business: </b><input type="text" class="form-control" id="naturebusiness2" name="naturebusiness2"></td>
					</tr>
					<tr>
						<td><b>Year: </b>
							<select id="year2" name="year2" class="form-control">
			          <option value="" selected="">YYYY</option>
			          <option value="PRESENT">PRESENT</option>
			          <?php $dateyear = date('Y');
			          for ($i=0; $i < 100; $i++) {?>
			            <option value="<?php echo $dateyear; ?>"><?php echo $dateyear; ?></option>
			          <?php $dateyear--;   
			          }?>              
			         </select>
			      </td>
			      <td><b>Year End: </b>
			         <select id="yearend2" name="yearend2" class="form-control">
			          <option value="" selected="">YYYY</option>
			          <option value="PRESENT">PRESENT</option>
			          <?php $dateyear = date('Y');
			          for ($i=0; $i < 100; $i++) {?>
			            <option value="<?php echo $dateyear; ?>"><?php echo $dateyear; ?></option>
			          <?php $dateyear--;   
			          }?>              
			         </select>
			       </td>
			       
					</tr>
					<tr>
						<td colspan="2"><b>Position: </b><input type="text" class="form-control" id="position2" name="position2"></td>
					</tr>
					<tr>
						<td colspan="2"><b>Rate: </b><input type="text" class="form-control" id="rate2" name="rate2"></td>
					</tr>

			</table>
		</form>
  </div>
 
</div>

</body>
<script src="services/previous.js"></script>
</html>
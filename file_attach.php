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
          <a class="nav-link active" id="" href="#">Other Files</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_myinfo" class="div_content">
  	<form name="form" method="post" action="pimcontroller2.php?uploadfile" enctype="multipart/form-data">
			<?php 
		  require_once "info_tab.php";
		  ?>

		  <div class="grid12_master master_input p-3">
			<table class="table-condensed w-100">
    			<tr>
    				<td><p>Note: Maximum of 10 files can be uploaded on the same time.</p></td>
    			</tr>
    			<tr>
						<td><b>Choose File: </b><input class="form-control" multiple="" id="empfile" required="" type="file" name="empfile[]" onchange="filefile()" /></td>
					</tr>
			</table>

			<table class="table table-condensed w-100" id="tbl_file">
							<thead>
								<th>File Name</th>
								<th>Action</th>
							</thead>
							<tbody>
								
							</tbody>
			</table>
			</div>
		</form>

		
  </div>
 
</div>

</body>
<script src="services/file.js"></script>
</html>
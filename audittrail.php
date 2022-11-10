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
          <a class="nav-link active" id="" href="#">Audit Trail</a>
        </li>
      </ul>

</div>

<div class="navcontainer">
  <div id="div_audit" class="div_content">
    <table class="table table-striped w-100" id="tbl_audit">
            <thead>
              <th>Audit Date</th>
              <th>Type</th>
              <th>Action</th>
              <th>End user</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>

</div>

</body>
<script src="services/audit.js"></script>
</html>
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
          <a class="nav-link active" id="" href="#">Memo</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_memo" class="div_content">
    <form name="form" method="post" action="controller/controller.memo.php?uploadmemo" enctype="multipart/form-data">
                        
        <table class="table table-striped w-100">
          <tr>
            <td><label>Employee:</label></td>
            <td><select class="form-control" id="employeeddown" name="employeeddown" required></select></td>
            <td><label>Memo name:</label></td>
            <td><input type="text" class="form-control" id="memoname" name="memoname" required></td>
          </tr>

          <tr>
            <td><label>File:</label></td>
            <td><input class="form-control" id="empfile" required="" type="file" name="empfile" /></td>
            <td><button type="submit" class="btn btn-sm btn-success"><i class="fas fa-sm fa-save"></i> Save</button></td>
            <td></td>
          </tr>
        </table>                  
                    
    </form>
    <table class="table table-striped w-100" id="tbl_memo">
            <thead>
              <th>Employee no</th>
              <th>Employee Name</th>
              <th>Memo Name</th>
              <th>Date</th>
              <th>Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
    <center>
        <button type="button" id="btncancel" onclick="canceledit()" style="display: none;" class="btn btn-sm btn-success"><i class="fa fa-ban"></i> Cancel</button>
    </center>
  </div>
 
</div>

</body>
<script src="services/memo.js"></script>
</html>
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
          <a class="nav-link active" id="" href="#">Announcements</a>
        </li>
      </ul>

</div>

<div class="navcontainer">
  <div id="div_news" class="div_content">
  	<button type="button" class="btn btn-sm btn-success" onclick="btnaddnews()"><i class="fa fa-plus"></i> Add New</button><br><br>
    <table class="table table-striped w-100" id="tbl_news">
            <thead>
              <th>Topic</th>
							<th>Published Date</th>
							<th>End Date</th>
							<th>Acknowledgment Status</th>
							<th>Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>
    
</div>

<div class="modal fade" id="news_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Announcement Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form name="form" method="post" action="controller/controller.announcement.php?newsfile" enctype="multipart/form-data">
          <div class="form-group">
            <label for="exampleInputEmail1">Topic</label>
            <input type="hidden" id="modal_newsid" name="modal_newsid">
            <input type="text" class="form-control txtbox" id="modal_topic" name="modal_topic" placeholder="">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Published Date</label>
            <input type="date" class="form-control" id="modal_date" name="modal_date" placeholder="">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">End Date</label>
            <input type="date" class="form-control" id="modal_end_date" name="modal_end_date" placeholder="">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">File</label>
            <input type="file" class="form-control" id="news_file" name="news_file" placeholder="">
          </div>
          <div class="form-group" id="ack_status_label">
            <label for="exampleInputEmail1">Status</label>
           	<select class="form-control" id="modal_ack_status" name="modal_ack_status">
		      		<option value="active"> Active </option>
		      		<option value="inactive"> Inactive </option>
		      	</select>
          </div>
          
          <center>
          <button class="btn btn-success btn-sm" type="submit" id="savejobcatbtn"><i class="fa fa-save"></i> Save</button>
          </center>
        </form>

      </div>

    </div>
  </div>
</div>

</body>
<script src="services/announcement.js"></script>
</html>
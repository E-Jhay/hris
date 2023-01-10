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
          <a class="nav-link active" id="announcement" href="#" onclick="btnAnnouncement()" href="#">Announcements</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="inter_office_announcement" href="#" onclick="btnInterOfficeAnnouncement()" href="#">Inter Office Announcements</a>
        </li>
      </ul>

</div>

<div class="navcontainer">
  <div id="div_news" class="div_content">
  	<button type="button" class="btn btn-sm btn-success" onclick="btnaddnews('all')"><i class="fa fa-plus"></i> Add New Announcement</button><br><br>
    <table class="table table-striped w-100" id="tbl_news">
            <thead>
              <th width="25%">Topic</th>
							<th>Published Date</th>
							<th>End Date</th>
							<th>Acknowledgment Status</th>
							<th class="text-center">Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>
  <div id="div_inter_office_news" class="div_content">
  	<button type="button" class="btn btn-sm btn-success" onclick="btnaddnews('department')"><i class="fa fa-plus"></i> Add New Inter Office Announcement</button><br><br>
    <table class="table table-striped w-100" id="tbl_inter_office_news">
            <thead>
              <th>Department</th>
              <th width="25%">Topic</th>
							<th>Published Date</th>
							<th>End Date</th>
							<th>Acknowledgment Status</th>
							<th class="text-center">Action</th>
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
      	<form name="form" id="form" enctype="multipart/form-data">
          <div class="form-group" id="department_div">
            <label for="exampleInputEmail1">Department</label>
            <select class="form-control" id="departmentList" name="departmentList"></select>
          </div>
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

<input type="hidden" id="currentUser" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
</body>
<script src="services/announcement.js"></script>
<script src="services/pim_tab.js"></script>
</html>
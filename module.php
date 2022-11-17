<?php 
session_start();
$usertype = $_SESSION['usertype'];
$userrole = $_SESSION['userrole'];


$role = explode(",",$userrole);
$countt = count($role);
$pim = "";
$admin = "";
$ess = "";

for ($i=0; $i < $countt; $i++){ 
	  if($role[$i]=="1"){
	  	$pim = "tru";
	  }else if($role[$i]=="2"){
	  	$admin = "tru";
	  }else if($role[$i]=="3"){
	  	$ess = "tru";
	  }
}

if(!isset($_SESSION['fullname'])){
  header("location:index.php");
}

require_once "header.php";
require_once "controller/controller.modules.php";
$modules = new crud();
$announcements = $modules->getAnnouncements();
$birthday = $modules->getBirthdaycelebrators();
$count_announce = 0;
$countbday = 0;
foreach ($announcements as $x) {
	$count_announce++;
}
foreach ($birthday as $x) {
	$countbday++;
}
?>
<div class="sidenavigation">
	<h3 class="tab_header_db">HRIS <span class="drawer"><i class="fas fa-sm fa-bars"></i></span></h3>
	<div class="navnavnav">
		<h6 class="admin_tab" id="li_dashboard"><i class="fas fa-md fa-chalkboard-teacher"></i><span class="admin_tab_name">Dashboard</span></h6>
		<?php if ($admin=="tru"): ?>
	  <h6 class="admin_tab" id="li_admin" onclick="goto('admin.php')"><i class="fas fa-md fa-user-shield"></i><span class="admin_tab_name">Admin</span></h6>
	  <?php endif ?>
	  <?php if ($pim=="tru"): ?>
	  <h6 class="admin_tab" id="li_pim" onclick="goto('employee.php')"><i class="fas fa-md fa-user-lock"></i><span class="admin_tab_name">PIM</span></h6>
	  <?php endif ?>
	  <?php if ($ess=="tru"): ?>
	  <h6 class="admin_tab" id="li_ess" onclick="goto('myinfo.php')"><i class="fas fa-lg fa-portrait"></i><span class="admin_tab_name">ESS</span></h6>
	  <?php endif ?>
	  <br><br>
	  <h6 class="admin_tab" id="logout"><i class="fas fa-md fa-power-off"></i><span class="admin_tab_name">Logout</span></h6>
	</div> 
</div>

<div class="navtabs">
      
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item" >
          <a class="nav-link active" id="" href="#">Welcome to HRIS</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_dashboard" class="">
  			
				<h4 class=""><i class="fas fa-sm fa-bullhorn"></i> Announcements <span><b>(<?= $count_announce ?>)</b></span></h4>
				<div class="row">
					
				<?php foreach ($announcements as $x) { ?>
					<div class="grid_3">
							<p class="announcement_name" onclick="view(<?= $x['id'] ?>)" ><?= substr($x['topic'], 0, 20); if(strlen($x['topic']) > 20) echo "..." ?> <span class="announce_btn"><i class="fa fa-chevron-circle-right "></i> View</span></p>
					</div>
				<?php } ?>

				</div>

				<?php if ($count_announce <=0): ?>
					<div class="announce_null">
						<br>
						<h1 class="announce_null_msg">NO ANNOUNCEMENT THIS MONTH.</h1>
					</div>
				<?php endif ?>

				<br><br>
				<h4 class=""><i class="fas fa-sm fa-birthday-cake"></i> Birthday celebrators for this month. <span><b>(<?= $countbday ?>)</b></span></h4>
				<div class="row">

					<?php
						foreach ($birthday as $a) { 
							if($a['imagepic']=="" || $a['imagepic']==null){
								$a['imagepic'] = "usera.png";
							}
					?>
					<div class="grid_4">
							<div class="bday_card">
									<center>
										<h5 class="bday_name">Happy Birthday<br><span><?php echo $a['firstname']; ?></h5><br>
										<img class="bday_img" src="<?= 'personal_picture/'.$a['imagepic'] ?>"><br>
										<br>
										<span class="bday">Birthday: <?= date('F d',strtotime($a['dateofbirth'])); ?><br>Department: <?= $a['department']; ?></span>
									</center>
							</div>
					</div>

					<?php } ?>
					
				</div>
				<?php if ($countbday <=0): ?>
					<div class="announce_null">
						<br>
						<h1 class="announce_null_msg">NO BIRTHDAY THIS MONTH.</h1>
					</div>

				<?php endif ?>

  </div>

</div>

<div class="modal fade" id="announce_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-info-circle"></i> Announcement Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      	<form>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Topic</label>
				    <input type="text" class="form-control txtbox" id="topic" aria-describedby="emailHelp">
				  </div>
					<div class="form-group">
				    <label for="exampleInputEmail1">Published Date</label>
				    <input type="text" class="form-control" id="publish_date" aria-describedby="emailHelp">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">End Date</label>
				    <input type="text" class="form-control" id="end_date" aria-describedby="emailHelp">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Acknowledgement Status</label>
				    <input type="text" class="form-control" id="ack_status" aria-describedby="emailHelp">
				  </div>
				  <center>
				  <input type="hidden" id="news_filename" name="">
       		<button class="btn btn-sm btn-success" type="button" onclick="open_file_news()">open file</button>
       		</center>
				</form>

      </div>

    </div>
  </div>
</div>

</body>
<script src="services/module.js"></script>
</html>
<h3 class="tab_header"><i class="fas fa-sm fa-user-lock"></i> PIM <span class="drawer"><i class="fas fa-sm fa-bars"></i></span></h3>
<div class="navnavnav">
  <h6 class="admin_tab" id="pim_list" onclick="goto('employee.php')"><i class="fas fa-md fa-user-cog"></i><span class="admin_tab_name">Employee List</span></h6>

  <h6 class="admin_tab" id="pim_add" onclick="goto('addemployee.php')"><i class="fas fa-md fa-user-plus"></i><span class="admin_tab_name">Add New Employee</span></h6>

  <h6 class="admin_tab" id="pim_reports" onclick="goto('reports.php')"><i class="fas fa-md fa-print"></i><span class="admin_tab_name">Reports</span></h6>

  <?php if($userrole == '1'): ?>
  <h6 class="admin_tab" id="ess_myinfo" onclick="goto('myinfo.php')"><i class="fas fa-md fa-user-circle"></i><span class="admin_tab_name">My Info</span></h6>

  <h6 class="admin_tab" id="ess_leaveapp" onclick="goto('leave.php')"><i class="fas fa-md fa-suitcase-rolling"></i><span class="admin_tab_name">Leave Application</span></h6>
  <?php endif ?>

  <h6 class="admin_tab" id="ess_leavereports" onclick="goto('leave_application.php')"><i class="fas fa-md fa-print"></i><span class="admin_tab_name">Leave Reports</span> <span id="leave_app_number" class="notif_val"></span></h6>

  <?php if($userrole == '1'): ?>
  <h6 class="admin_tab" id="ess_overtime" onclick="goto('overtime.php')"><i class="fas fa-md fa-file-alt"></i><span class="admin_tab_name">Overtime Application</span></h6>
  <?php endif ?>

  <h6 class="admin_tab" id="ess_overtimereports" onclick="goto('ot_application.php')"><i class="fas fa-md fa-print"></i><span class="admin_tab_name">Overtime Reports</span> <span id="ot_app_number" class="notif_val"></span></h6>

  <?php if($userrole == '1'): ?>
  <h6 class="admin_tab" id="ess_omnibus" onclick="goto('reimbursement.php?balance=yes')"><i class="fas fa-md fa-file-contract"></i><span class="admin_tab_name">Omnibus Reimbursement</span></h6>
  <?php endif ?>
  
  <h6 class="admin_tab" id="ess_omnibus_report" onclick="goto('reimbursement_report.php?balance=yes')"><i class="fas fa-md fa-print"></i><span class="admin_tab_name">Omnibus Reports</span>
      <span id="reim_app_number" class="notif_val"></span></h6>

  <h6 class="admin_tab" id="ess_uploadpayslip" onclick="goto('uplo.php')"><i class="fas fa-md fa-file-upload"></i><span class="admin_tab_name">Upload Payslip</span></h6>
  <?php if($userrole == '1'): ?>
    <h6 class="admin_tab" id="ess_payslip" onclick="goto('ess_payslip.php')"><i class="fas fa-md fa-file-alt"></i><span class="admin_tab_name">My Payslip</span> <span id="payslip_number" class="notif_val"></span></h6>
  <?php endif ?>

  <h6 class="admin_tab" id="admin_announce" onclick="goto('announcement.php')"><i class="fas fa-md fa-microphone-alt"></i><span class="admin_tab_name">Announcements</span></h6>
  <h6 class="admin_tab" id="admin_memo" onclick="goto('memo.php')"><i class="fas fa-md fa-file-pdf"></i><span class="admin_tab_name">Memorandum</span></h6>

  <?php if($userrole == '1'): ?>
    <h6 class="admin_tab" id="ess_memo" onclick="goto('ess_memo.php')"><i class="fas fa-md fa-file-word"></i><span class="admin_tab_name">My Memorandum</span></h6>
  <?php endif ?>

  <br><br>
  <h6 class="admin_tab" id="admin_dashboard" onclick="goto('module.php')"><i class="fas fa-md fa-clipboard"></i><span class="admin_tab_name">Back to Dashboard</span></h6>
</div> 


<script src="services/pim_tab.js"></script>
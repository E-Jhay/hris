<h3 class="tab_header"><i class="fas fa-sm fa-portrait"></i> Employee <span class="drawer"><i class="fas fa-sm fa-bars"></i></span></h3>
<div class="navnavnav">
  <h6 class="admin_tab" id="ess_myinfo" onclick="goto('myinfo.php')"><i class="fas fa-md fa-user-circle"></i><span class="admin_tab_name">My Info</span></h6>
  <h6 class="admin_tab" id="master_update" onclick="goto('update_details.php')"><i class="fas fa-md fa-user-circle"></i><span class="admin_tab_name">Update Details</span></h6>
  <h6 class="admin_tab" id="master_benefits" onclick="goto('ess_beneficiaries.php')"><i class="fas fa-md fa-briefcase"></i><span class="admin_tab_name">Beneficiaries</span></h6>
  <h6 class="admin_tab" id="master_id" onclick="goto('ess_ids.php')"><i class="fas fa-md fa-id-card-alt"></i><span class="admin_tab_name">ID's</span></h6>
  <h6 class="admin_tab" id="ess_leaveapp" onclick="goto('leave.php')"><i class="fas fa-md fa-suitcase-rolling"></i><span class="admin_tab_name">Leave Application</span></h6>

  <h6 class="admin_tab" id="ess_overtime" onclick="goto('overtime.php')"><i class="fas fa-md fa-file-alt"></i><span class="admin_tab_name">Overtime Application</span></h6>
  
  <h6 class="admin_tab" id="ess_omnibus" onclick="goto('reimbursement.php?balance=yes')"><i class="fas fa-md fa-file-contract"></i><span class="admin_tab_name">Omnibus Reimbursement</span></h6>
  
  <h6 class="admin_tab" id="ess_notif" onclick="goto('notification.php')"><i class="fas fa-md fa-globe-asia"></i><span class="admin_tab_name">Notifications</span><span id="notif_number" class="notif_val"></span></h6>
  <h6 class="admin_tab" id="ess_payslip" onclick="goto('ess_payslip.php')"><i class="fas fa-md fa-file-alt"></i><span class="admin_tab_name">My Payslip</span> <span id="payslip_number" class="notif_val"></span></h6>
  
  <h6 class="admin_tab" id="ess_memo" onclick="goto('ess_memo.php')"><i class="fas fa-md fa-file-word"></i><span class="admin_tab_name">My Memorandum</span></h6>

  <!-- <h6 class="admin_tab" id="incident" onclick="goto('ess_incident_report.php')"><i class="fas fa-md fa-file-word"></i><span class="admin_tab_name">Incident Report</span></h6> -->

  <br><br>
  <h6 class="admin_tab" id="admin_dashboard" onclick="goto('module.php')"><i class="fas fa-md fa-clipboard"></i><span class="admin_tab_name">Back to Dashboard</span></h6>
</div>

<script defer src="services/ess_tab.js"></script>
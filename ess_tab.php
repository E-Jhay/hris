<h3 class="tab_header"><i class="fas fa-sm fa-portrait"></i> ESS <span class="drawer"><i class="fas fa-sm fa-bars"></i></span></h3>
<div class="navnavnav">
  <h6 class="admin_tab" id="ess_myinfo" onclick="goto('myinfo.php')"><i class="fas fa-md fa-user-circle"></i><span class="admin_tab_name">My Info</span></h6>
  <h6 class="admin_tab" id="ess_leaveapp" onclick="goto('leave.php')"><i class="fas fa-md fa-suitcase-rolling"></i><span class="admin_tab_name">Leave Application</span></h6>

  <h6 class="admin_tab" id="ess_overtime" onclick="goto('overtime.php')"><i class="fas fa-md fa-file-alt"></i><span class="admin_tab_name">Overtime Application</span></h6>
  
  <h6 class="admin_tab" id="ess_omnibus" onclick="goto('reimbursement.php?balance=yes')"><i class="fas fa-md fa-file-contract"></i><span class="admin_tab_name">Omnibus Reimbursement</span></h6>
  
  <h6 class="admin_tab" id="ess_notif" onclick="goto('notification.php')"><i class="fas fa-md fa-globe-asia"></i><span class="admin_tab_name">Notifications</span><?php if($count > 0): ?><span id="notif_number" class="notif_val"><?php echo $count; ?></span> <?php endif ?></h6>
  <h6 class="admin_tab" id="ess_payslip" onclick="goto('ess_payslip.php')"><i class="fas fa-md fa-file-alt"></i><span class="admin_tab_name">My Payslip</span><?php if($count > 0): ?> <span id="payslip_number" class="notif_val"></span><?php endif ?></h6>
  
  <h6 class="admin_tab" id="ess_memo" onclick="goto('ess_memo.php')"><i class="fas fa-md fa-file-word"></i><span class="admin_tab_name">My Memorandum</span></h6>

  <br><br>
  <h6 class="admin_tab" id="admin_dashboard" onclick="goto('module.php')"><i class="fas fa-md fa-clipboard"></i><span class="admin_tab_name">Back to Dashboard</span></h6>
</div>
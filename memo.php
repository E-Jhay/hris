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
          <a class="nav-link active" id="memo" href="#" onclick="btnMemo()">Individual Memo</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="inter_office_memo" href="#" onclick="btnInterOfficeMemo()">Inter Office Memo</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_memo" class="div_content">
    <form id="form" enctype="multipart/form-data">
    <div>
      <button type="button" id="addMemoBtn" class="btn btn-primary mb-4">Add Individual Memo</button>
      <button type="button" id="cancelMemoBtn" class="btn btn-warning mb-4" style="display: none; ">Cancel</button>
    </div>

    <table class="table-condensed grid12_master" id="memo_table">
			<tr>
				<td>
					<b>Employee: </b>
					<select class="form-control" id="employeeddown" name="employeeddown" required></select>
          <input type="hidden" class="form-control" name="departmentList" value="">
				</td>
			</tr>
      <tr>
        
				<td>
					<b>Memo title: </b>
					<input type="text" class="form-control" id="memoname" name="memoname" placeholder="Memo Title" required>
				</td>
      </tr>
			<tr>
				<td>
					<b>Memorandum File: </b>
					<input class="form-control" id="empfile" required="" type="file" name="empfile" />
				</td>
			</tr>
      <tr>
				<td>
					<b>Remarks: </b>
					<textarea name="remarks" id="remarks" cols="20" rows="3" class="form-control" placeholder="Remarks"></textarea>
				</td>
      </tr>
      <tr>
        <td class="text-center">
          <button type="submit" class="btn btn-md btn-success"><i class="fas fa-sm fa-save"></i> Save</button>
        </td>
      </tr>
		</table>
                    
                    
    </form>
    <table class="table table-striped w-100" id="tbl_memo">
            <thead>
              <th>Employee no</th>
              <th>Employee Name</th>
              <th>Memo Name</th>
              <th>Date</th>
              <th>Remarks</th>
              <th>Status</th>
              <th class="text-center">Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>

  <div id="div_inter_office_memo" class="div_content">
    <form id="form2" name="form2" enctype="multipart/form-data">
                        
        <!-- <table class="table table-striped w-100">
          <tr>
            <td><label>Department:</label></td>
            <td><select class="form-control" id="departmentList" name="departmentList" required></select></td>
            <td><label>Memo name:</label></td>
            <td>
              <input type="text" class="form-control" id="memoname" name="memoname" required>
              <input type="hidden" class="form-control" name="employeeddown" value="">
            </td>
          </tr>

          <tr>
            <td><label>Memorandum File:</label></td>
            <td><input class="form-control" id="empfile" required="" type="file" name="empfile" /></td>
            <td><button type="submit" class="btn btn-sm btn-success"><i class="fas fa-sm fa-save"></i> Save</button></td>
            <td></td>
          </tr>
        </table>   -->

        <div>
          <button type="button" id="addMemoBtnDepartment" class="btn btn-primary mb-4">Add Inter Office Memo</button>
          <button type="button" id="cancelMemoBtnDepartment" class="btn btn-warning mb-4" style="display: none; ">Cancel</button>
        </div>
        
        <table class="table-condensed grid12_master" id="memo_table_department">
          <tr>
            <td>
              <b>Department: </b>
              <select class="form-control" id="departmentList" name="departmentList" required></select>
              <input type="hidden" class="form-control" name="employeeddown" value="">
            </td>
          </tr>
          <tr>
            
            <td>
              <b>Memo title: </b>
              <input type="text" class="form-control" id="memoname" name="memoname" placeholder="Memo Title" required>
            </td>
          </tr>
          <tr>
            <td>
              <b>Memorandum File: </b>
              <input class="form-control" id="empfile" required="" type="file" name="empfile" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Remarks: </b>
              <textarea name="remarks" id="remarks" cols="20" rows="3" class="form-control" placeholder="Remarks"></textarea>
            </td>
          </tr>
          <tr>
            <td class="text-center">
              <button type="submit" class="btn btn-md btn-success"><i class="fas fa-sm fa-save"></i> Save</button>
            </td>
          </tr>
        </table>
                    
    </form>
    <table class="table table-striped w-100" id="tbl_inter_office_memo">
            <thead>
              <th>Department Name</th>
              <th>Memo Name</th>
              <th>Date</th>
              <th>Remarks</th>
              <th>Status</th>
              <th class="text-center">Action</th>
            </thead>
            <tbody>
              
            </tbody>
    </table>
  </div>
 
</div>

<input type="hidden" id="currentUser" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="datenow" value="<?php echo date('Y-m-d') ?>" name="">
</body>
<script src="services/memo.js"></script>
<script src="services/pim_tab.js"></script>
</html>
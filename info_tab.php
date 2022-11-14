<button type="button" id="btnedit" onclick="editcontact()" class="btn btn-sm btn-secondary "><i class="fas fa-sm fa-edit"></i> Edit</button>
<button type="submit" id="btnsave" class="btn btn-sm btn-info d-none"><i class="fas fa-sm fa-save"></i> Save</button>
<button type="button" id="btncancel" onclick="canceledit()" class="btn btn-sm btn-danger d-none"><i class="fa fa-ban"></i> Cancel</button>
<br><br>
<input type="hidden" id="emp_id" value="<?php echo $_GET['id']; ?>" name="emp_id">
<table class="table-condensed grid3_master master_input">
   	<tr>
   		<td class="text-center"><img  style="border: 1px dashed #a7a7a7; cursor: pointer;" src="" id="personal_image"></td>
   	</tr>
   	<tr>
		<td><b>Employee no: </b><input type="text" class="form-control" id="emp_no" name="emp_no"></td>
	</tr>
	<tr class="d-none">
		<td><b>Rank: </b><input type="text" class="form-control" id="rank" name="rank"></td>
	</tr>
		
	<tr class="d-none">
		<td><b>Company: </b><select class="form-control" id="company" name="company"></select></td>
	</tr>
		
	<tr class="d-none">
		<td><b>Leave Balance: </b><input type="text" class="form-control" id="leave_balance" name="leave_balance"></td>
	</tr>
</table>

<table class="table-condensed grid3_master master_input">

    <tr>
		<td><b>First name: </b><input type="text" class="form-control" id="f_name" name="f_name"></td>
	</tr>
	<tr>
		<td><b>Last name: </b><input type="text" class="form-control" id="l_name" name="l_name"></td>
	</tr>
	<tr>
		<td><b>Middle name: </b><input type="text" class="form-control" id="m_name" name="m_name"></td>
	</tr>
					
</table>

<table class="table-condensed grid3_master master_input">

    <tr>
		<td><b>Status: </b>
			<select class="form-control" id="statuss" name="statuss">
				<option value="Active">Active</option>
				<option value="Inactive">Inactive</option>
			</select>
		</td>
	</tr>
	<tr>
		<td><b>Employment Status: </b><select class="form-control" id="emp_statuss" name="emp_statuss"></select></td>
	</tr>
	<tr>
		<td><b>Department: </b><select class="form-control" required="" id="department" name="department"></select></td>
	</tr>
				
</table>
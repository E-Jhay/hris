var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		$('#btnsave').hide();
		$("#master_salary").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});
		$('#btnupd_histo').hide()
		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.salary.php?selectotherid",
			method:"POST",
			data:{
				employeeno:employeeno
			},success:function(data){
				var b = $.parseJSON(data);
				$('#emp_no').val(b.emp_no);
				$('#f_name').val(b.f_name);
				$('#l_name').val(b.l_name);
				$('#m_name').val(b.m_name);
				$('#rank').val(b.rank);
				$('#statuss').val(b.statuss);
				$('#emp_statuss').val(b.emp_statuss);
				$('#company').val(b.company);
				$('#leave_balance').val(b.leave_balance);
				$('#employeeno').val(b.emp_no);
				$('#department').val(b.department);

				$('#statusemp').load('controller/controller.salary.php?demp_stat',function(){
					$('#statusemp').val(b.emp_statuss);
				});

				$('#positionemp').load('controller/controller.salary.php?d_jobtitle',function(){
					$('#positionemp').val(b.job_title);
				});

				$('#emp_statuss').load('controller/controller.salary.php?demp_stat',function(){
					$('#emp_statuss').val(b.emp_statuss);
				});

				$('#company').load('controller/controller.salary.php?dcompany',function(){
					$('#company').val(b.company);
				});


				$('#department').load('controller/controller.salary.php?ddepartment',function(){
					$('#department').val(b.department);
				});

				$('#datehiredemp').val(b.date_hired);

				document.getElementById("personal_image").src = b.imagepic;

				                                                                                                                                                  

				loadsalary(b.emp_no);                                                          
				// alert(b.emp_no)
			}
		});

});
// function lb(){

//        $.ajax({
//         url:"controller/controller.leavebalance.php?leave_credits_load",
//         method:"POST",
//         data:{
//           id:""
//         },success:function(){

//         }
//       });
       
//   }
//   lb();
	$('#formModal').on('submit', (e) => {
		e.preventDefault()
		var effectdateemp = $('#effectdateemp').val();
		if(!effectdateemp) {
			$('#error').removeClass('d-none')
		} else {
			confirmed("save",savesalary_callback, "Do you really want to save this?", "Yes", "No");
		}
	})
	function savesalary_callback(){
		var formData = new FormData($("#formModal")[0]);
		$.ajax({
			url:"controller/controller.salary.php?savesalary",
			method:"POST",
			data: formData,
			processData: false,
			contentType: false,
			success:function(data){
				var b = $.parseJSON(data);
				if(b.type === "error")
					$.Toast(b.message, errorToast)
				else
					$.Toast(b.message, successToast)
				const employeeno = b.employeeno;
				clearFields()
				$('#salarymodal').modal('hide');
				$('#error').addClass('d-none')
				$('#tbl_salaryhistory').DataTable().destroy();
				loadsalary(employeeno);
				$('#btnupd_histo').hide()
			}
		});
	}

	function viewHardcopy(filename, employeeno) {
		var link = "salary_adjustment/"+employeeno+"/"+filename;
		window.open(link);
	}

	// function updatesalary(){
	// 	confirmed("save",updatesalary_callback, "Do you really want to save this?", "Yes", "No");
	// }

	// function updatesalary_callback(){
	// 	var empno = $('#empno').val();
	// 	var idemp = $('#idemp').val();
	// 	var id = $('#idsalary').val();
	// 	var job_title = $('#positionemp').val();
	// 	var employment_status = $('#statusemp').val();
	// 	var date_hired = $('#datehiredemp').val();
	// 	var salarytype = $('#salarytype').val();
	// 	var salaryemp = $('#salaryemp').val();
	// 	var salarytype2 = $('#salarytype2').val();
	// 	var salaryemp2 = $('#salaryemp2').val();
	// 	var salarytype3 = $('#salarytype3').val();
	// 	var salaryemp3 = $('#salaryemp3').val();
	// 	var salarytype4 = $('#salarytype4').val();
	// 	var salaryemp4 = $('#salaryemp4').val();
	// 	var effective_date = $('#effectdateemp').val();
	// 	var basic_salary = $('#basic_salary').val();
	// 	var remarks = $('#remarks').val();

	// 	$.ajax({
	// 		url:"controller/controller.salary.php?updatesalaryhisto",
	// 		method:"POST",
	// 		data:{
	// 			id : id,
	// 			job_title : job_title,
	// 			employment_status : employment_status,
	// 			date_hired : date_hired,
	// 			salarytype: salarytype,
	// 			salaryemp: salaryemp,
	// 			salarytype2: salarytype2,
	// 			salaryemp2: salaryemp2,
	// 			salarytype3: salarytype3,
	// 			salaryemp3: salaryemp3,
	// 			salarytype4: salarytype4,
	// 			salaryemp4: salaryemp4,
	// 			effective_date : effective_date,
	// 			idemp: idemp,
	// 			basic_salary: basic_salary,
	// 			remarks: remarks
	// 		},success:function(data){
	// 			$.Toast("Successfully Saved", successToast);
	// 			var b = $.parseJSON(data);
	// 			var employeeno = b.employeeno;
	// 			clearFields()
	// 			$('#salarymodal').modal('hide');
	// 			$('#tbl_salaryhistory').DataTable().destroy();
	// 			loadsalary(employeeno);
	// 		}
	// 	});
	// }

	function salary_adjust(){
		$('#action').val('insert')
		$('#salarymodal').modal('show');

		clearFields()
		
	}
	
	function clearFields() {
		$('#idsalary').val("");
		$('#basic_salary').val("");
		$('#salarytype').val("");
		$('#salaryemp').val("");
		$('#salarytype2').val("");
		$('#salaryemp2').val("");
		$('#salarytype3').val("");
		$('#salaryemp3').val("");
		$('#salarytype4').val("");
		$('#salaryemp4').val("");
		$('#effectdateemp').val("");
		$('#remarks').val("");
		$('#hardcopy').val("");
		$('#file_name').val("");

		$('#btnsave_histo').show();
		$('#btnupd_histo').hide();
	}


	function editcontact(){
		$('.master_input').addClass('master_input_open');
		$('.master_input').removeClass('master_input');
		$('#btnsave').removeClass('d-none');
		$('#btncancel').removeClass('d-none');
		$('#btnedit').addClass('d-none');
	}

	function canceledit(){
		var employeeno = $('#employeeno').val();
		window.location.href="salary_history.php?employeeno="+employeeno;
	}

	function goto(linkk){
		var employeeno = $('#employeeno').val();
		var link = linkk+"?employeeno="+employeeno;
		window.location.href=link;
	}

	function loadsalary(employeeno){

    	$('#tbl_salaryhistory').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
			  "scrollX": true,
              "pagination": true,
              "pageLength": 5,
              "ajax" : "controller/controller.salary.php?loadsalary_history&employeeno="+employeeno,
              "columns" : [
                    
                    // { "data" : "job_title"},
                    // { "data" : "employment_status"},
                    // { "data" : "date_hired"},
                    { "data" : "basic_salary"},
                    { "data" : "salary_type"},
                    { "data" : "salary_rate"},
                    { "data" : "salary_type2"},
                    { "data" : "salary_rate2"},
                    { "data" : "salary_type3"},
                    { "data" : "salary_rate3"},
                    { "data" : "salary_type4"},
                    { "data" : "salary_rate4"},
                    { "data" : "effective_date"},
                    { "data" : "action"}


                ],
         });
  }

  function edit_salaryhistory(id,job_title,employment_status,date_hired,salary_type,salary_rate,salary_type2,salary_rate2,salary_type3,salary_rate3,salary_type4,salary_rate4,effective_date,remarks,basic_salary,hardcopy){
  	$('#salarymodal').modal('show');

  	$('#idsalary').val(id);
	$('#positionemp').val(job_title);
	$('#statusemp').val(employment_status);
	$('#datehiredemp').val(date_hired);
	$('#salarytype').val(salary_type);
	$('#salaryemp').val(salary_rate);
	$('#salarytype2').val(salary_type2);
	$('#salaryemp2').val(salary_rate2);
	$('#salarytype3').val(salary_type3);
	$('#salaryemp3').val(salary_rate3);
	$('#salarytype4').val(salary_type4);
	$('#salaryemp4').val(salary_rate4);
	$('#effectdateemp').val(effective_date);
	$('#remarks').val(remarks);
	$('#btnsave_histo').hide();
	$('#btnupd_histo').show();
	$('#basic_salary').val(basic_salary);
	$('#file_name').val(hardcopy);
	$('#action').val('update')

  }

  function delete_salaryhistory(id,employeeno, hardcopy){
  	var data = [id,employeeno, hardcopy];
  	confirmed("delete",delete_salaryhistory_callback, "Do you really want to delete this?", "Yes", "No",data);
  }

  function delete_salaryhistory_callback(data){
	  	var id = data[0];
	  	var employeeno = data[1];
	  	var hardcopy = data[2];
  		$.ajax({
	  		url:"controller/controller.salary.php?delete_salaryhistory",
	  		method:"POST",
	  		data:{
	  			id:id,
	  			employeeno:employeeno,
	  			hardcopy:hardcopy,
	  		},success:function(){
				$.Toast("Deleted Successfully", successToast);
				$('#tbl_salaryhistory').DataTable().destroy();
				loadsalary(employeeno);
	  		}
	  	}); 
  }
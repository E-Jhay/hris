var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		$("#master_medical").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});
		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.medical.php?selectmedical",
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
				document.getElementById("personal_image").src = b.imagepic;
				
				$('#emp_statuss').load('controller/controller.medical.php?demp_stat',function(){
					$('#emp_statuss').val(b.emp_statuss);
				});

				$('#company').load('controller/controller.medical.php?dcompany',function(){
					$('#company').val(b.company);
				});

				$('#department').load('controller/controller.medical.php?ddepartment',function(){
					$('#department').val(b.department);
				});
			}
		});

		$('#emp_statuss').on('change',function(){
			var emp_statuss = $('#emp_statuss').val();
			if(emp_statuss=="Resigned" || emp_statuss=="Terminated"){
				$('#statuss').val("Inactive");
			}else{
				$('#statuss').val("Active");
			}
		});

		$('#medical_table').hide()

		$('#addBtn').on('click', () => {
			$("#addBtn").hide()
			$('#cancelBtn').show();
			$('#medical_table').show()
			$('#action').val('insert')
		})
		$('#cancelBtn').on('click', () => {
			$("#addBtn").show()
			$('#cancelBtn').hide();
			$('#medical_table').hide()
		})

		load_medical()

	});


$('#form').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
})

function save_callback(){
    var formData = new FormData($("#form")[0]);
    $.ajax({
        url:"controller/controller.medical.php?addMedical",
        method:"POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            const b = $.parseJSON(data)
            if(b.type === 'success'){
                $.Toast(b.message, successToast)
                $('#form').trigger("reset");
                $('#tbl_medical').DataTable().destroy();
                load_medical();
                $("#addBtn").show()
                $('#cancelBtn').hide();
                $('#medical_table').hide()
            }
            else
                $.Toast(b.message, errorToast)
            // setTimeout(() => {
            // 	window.location.href="memo.php";
            // }, 1000)
        }
    });
}

function load_medical(){
    const employeeno = $('#employeeno').val()
    $('#tbl_medical').DataTable({  
        "aaSorting": [],
        "bSearching": true,
        "bFilter": true,
        "bInfo": true,
        "bPaginate": true,
        "bLengthChange": true,
        "pagination": true,
        "ajax" : "controller/controller.medical.php?load_medical&employeeno=" + employeeno,
        "columns" : [
            { "data" : "type"},
            { "data" : "classification"},
            { "data" : "status"},
            { "data" : "date_of_examination"},
            { "data" : "remarks"},
            { "data" : "file"},
            { "data" : "action"},

        ],
    });
}

function viewFile(file_name, employee_number) {
    const link = "medical/"+employee_number+"/"+file_name;
    window.open(link);
}

function deleteMedical(id, file_name, employeeno) {
    var data = [id, file_name, employeeno];
    confirmed("delete",delete_medical_callback, "Do you really want to delete this?", "Yes", "No",data);
}

function delete_medical_callback(data){
    var id = data[0];
    var file_name = data[1];
    var employeeno = data[2];
    $.ajax({
      url:"controller/controller.medical.php?deleteMedical",
      method:"POST",
      data:{
        id: id,
        file_name: file_name,
        employeeno: employeeno
      },success:function(){
        $.Toast("Successfully Deleted", successToast);
        $('#tbl_medical').DataTable().destroy();
        load_medical();
      }
    });
}

function edit(id, type, classification, status, date_of_examination, remarks, file_name, employeeno) {
    $('#edit_modal').modal('show')
    $('#medical_id').val(id)
    $('#medical_type').val(type)
    $('#medical_classification').val(classification)
    $('#medical_status').val(status)
    $('#medical_date_of_examination').val(date_of_examination)
    $('#medical_remarks').val(remarks)
    $('#medical_file_name').val(file_name)
    $('#medical_employeeno').val(employeeno)
}

$('#medical_form').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",update_callback, "Do you really want to update this?", "Yes", "No");
})

function update_callback() {
    const formData = new FormData($("#medical_form")[0]);
    $.ajax({
        url:"controller/controller.medical.php?updateMedical",
        method:"POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            const b = $.parseJSON(data)
            if(b.type === "error")
                $.Toast(b.message, errorToast)
            else
                $.Toast(b.message, successToast)
            $('#edit_modal').modal('hide')
            $('#medical_form').trigger("reset");
            $('#tbl_medical').DataTable().destroy();
            load_medical();
        }
    });
}

function goto(linkk){
	var employeeno = $('#employeeno').val();
	var link = linkk+"?employeeno="+employeeno;
	window.location.href=link;
}
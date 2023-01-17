var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
	$("#master_id").addClass("active_tab");
	$('.drawer').hide();
	$('.drawer').on('click',function(){
		$('.navnavnav').slideToggle();
	});
	var employeeno = $('#employeeno').val();
	$.ajax({
		url:"controller/controller.otherid.php?selectotherid",
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
			
			$('#emp_statuss').load('controller/controller.otherid.php?demp_stat',function(){
				$('#emp_statuss').val(b.emp_statuss);
			});

			$('#company').load('controller/controller.otherid.php?dcompany',function(){
				$('#company').val(b.company);
			});

			$('#department').load('controller/controller.otherid.php?ddepartment',function(){
				$('#department').val(b.department);
			});
			$('#leave_balance').val(b.leave_balance);

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
	
    $('#other_id_table').hide()

	$('#addBtn').on('click', () => {
		$("#addBtn").hide()
		$('#cancelBtn').show();
		$('#other_id_table').show()
		$('#action').val('insert')
	})
	$('#cancelBtn').on('click', () => {
		$("#addBtn").show()
		$('#cancelBtn').hide();
		$('#other_id_table').hide()
	})

	load_other_id()
});

$('#form').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
})

function save_callback(){
    var formData = new FormData($("#form")[0]);
    $.ajax({
        url:"controller/controller.otherid.php?addId",
        method:"POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            const b = $.parseJSON(data)
            if(b.type === 'success'){
                $.Toast(b.message, successToast)
                $('#form').trigger("reset");
                $('#tbl_other_id').DataTable().destroy();
                load_other_id();
                $("#addBtn").show()
                $('#cancelBtn').hide();
                $('#other_id_table').hide()
            }
            else
                $.Toast(b.message, errorToast)
            // setTimeout(() => {
            // 	window.location.href="memo.php";
            // }, 1000)
        }
    });
}

function load_other_id(){
    const employeeno = $('#employeeno').val()
    $('#tbl_other_id').DataTable({  
        "aaSorting": [],
        "bSearching": true,
        "bFilter": true,
        "bInfo": true,
        "bPaginate": true,
        "bLengthChange": true,
        "pagination": true,
        "scrollX": true,
        "ajax" : "controller/controller.otherid.php?load_other_id&type=employee&employeeno=" + employeeno,
        "columns" : [
            { "data" : "id_type"},
            { "data" : "card_number"},
            { "data" : "description"},
            { "data" : "date_issued"},
            { "data" : "validity_date"},
            { "data" : "file"},
            { "data" : "action"},

        ],
    });
}

function viewFile(file_name, employee_number) {
    const link = "ids/"+employee_number+"/"+file_name;
    window.open(link);
}

function deleteId(id, file_name, employeeno) {
    var data = [id, file_name, employeeno];
    confirmed("delete",delete_id_callback, "Do you really want to delete this?", "Yes", "No",data);
}

function delete_id_callback(data){
    var id = data[0];
    var file_name = data[1];
    var employeeno = data[2];
    $.ajax({
      url:"controller/controller.otherid.php?deleteId",
      method:"POST",
      data:{
        id: id,
        file_name: file_name,
        employeeno: employeeno
      },success:function(){
        $.Toast("Successfully Deleted", successToast);
        $('#tbl_other_id').DataTable().destroy();
        load_other_id();
      }
    });
}


function edit(id, id_type, card_number, description, date_issued, validity_date, file_name, employeeno) {
    $('#edit_modal').modal('show')
    $('#other_id_id').val(id)
    $('#other_id_id_type').val(id_type)
    $('#other_id_card_number').val(card_number)
    $('#other_id_description').val(description)
    $('#other_id_date_issued').val(date_issued)
    $('#other_id_validity_date').val(validity_date)
    $('#other_id_file_name').val(file_name)
    $('#other_id_employeeno').val(employeeno)
}

$('#other_id_form').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",update_callback, "Do you really want to update this?", "Yes", "No");
})

function update_callback() {
    const formData = new FormData($("#other_id_form")[0]);
    $.ajax({
        url:"controller/controller.otherid.php?updateOtherId",
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
            $('#other_id_form').trigger("reset");
            $('#tbl_other_id').DataTable().destroy();
            load_other_id();
        }
    });
}
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
	function editcontact(){
		$('.master_input').addClass('master_input_open');
		$('.master_input').removeClass('master_input');
		$('#btnsave').removeClass('d-none');
		$('#btncancel').removeClass('d-none');
		$('#btnedit').addClass('d-none');
	}

	function canceledit(){
		var employeeno = $('#employeeno').val();
		window.location.href="otherid.php?employeeno="+employeeno;
	}

	function goto(linkk){
		var employeeno = $('#employeeno').val();
		var link = linkk+"?employeeno="+employeeno;
		window.location.href=link;
	}
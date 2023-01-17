var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
	$("#master_benefits").addClass("active_tab");
	$('.drawer').hide();
	$('.drawer').on('click',function(){
		$('.navnavnav').slideToggle();
	});
	var employeeno = $('#employeeno').val();
	$.ajax({
		url:"controller/controller.benefits.php?selectbenefit",
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
			
			$('#emp_statuss').load('controller/controller.benefits.php?demp_stat',function(){
				$('#emp_statuss').val(b.emp_statuss);
			});

			$('#company').load('controller/controller.benefits.php?dcompany',function(){
				$('#company').val(b.company);
			});

			$('#department').load('controller/controller.benefits.php?ddepartment',function(){
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
	
    $('#dependent_table').hide()

});

	$('#addBtn').on('click', () => {
		$("#addBtn").hide()
		$('#cancelBtn').show();
		$('#dependent_table').show()
		$('#action').val('insert')
	})
	$('#cancelBtn').on('click', () => {
		$("#addBtn").show()
		$('#cancelBtn').hide();
		$('#dependent_table').hide()
	})


// 	$('form').on('submit', function (e) {

//             e.preventDefault();
//             confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
// });

// function save_callback(){
// 				$.ajax({
// 	        	url:"controller/controller.benefits.php?editbenefits",
// 	        	method:"POST",
// 	        	data: $('form').serialize(),
// 	        	success:function(data){
// 					$.Toast("Successfully Saved", successToast);
// 					setTimeout(() => {
// 						var b = $.parseJSON(data);
// 						var employeeno = b.employeeno;
// 						window.location.href="benefits.php?employeeno="+employeeno;
// 					}, 1000)
	        		
// 	        	}
// 	        });
// }

function load_dependent(){
    const employeeno = $('#employeeno').val()
    $('#tbl_dependent').DataTable({  
        "aaSorting": [],
        "bSearching": true,
        "bFilter": true,
        "bInfo": true,
        "bPaginate": true,
        "bLengthChange": true,
        "pagination": true,
        "scrollX": true,
        "ajax" : "controller/controller.benefits.php?load_dependent&type=employee&employeeno=" + employeeno,
        "columns" : [
            { "data" : "name"},
            { "data" : "gender"},
            { "data" : "age"},
            { "data" : "relation"},
            { "data" : "birth_certificate"},
            { "data" : "action"}

        ],
    });
}

load_dependent()

function deleteDependent(id, birth_certificate, employeeno) {
    var data = [id, birth_certificate, employeeno];
    confirmed("delete",delete_dependent_callback, "Do you really want to delete this?", "Yes", "No",data);
}

function delete_dependent_callback(data){
    var id = data[0];
    var birth_certificate = data[1];
    var employeeno = data[2];
    $.ajax({
      url:"controller/controller.benefits.php?deleteDependent",
      method:"POST",
      data:{
        id: id,
        birth_certificate: birth_certificate,
        employeeno: employeeno
      },success:function(){
        $.Toast("Successfully Deleted", successToast);
        $('#tbl_dependent').DataTable().destroy();
        load_dependent();
      }
    });
}

function viewFile(birth_certificate, employeeno) {
    const link = "dependents/"+employeeno+"/"+birth_certificate;
    window.open(link);
}

$('#form').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
})

function save_callback(){
    var formData = new FormData($("#form")[0]);
    $.ajax({
        url:"controller/controller.benefits.php?addDependent",
        method:"POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            const b = $.parseJSON(data)
            if(b.type === 'success'){
                $.Toast(b.message, successToast)
                $('#form').trigger("reset");
                $('#tbl_dependent').DataTable().destroy();
                load_dependent();
                $("#addBtn").show()
                $('#cancelBtn').hide();
                $('#dependent_table').hide()
            }
            else
                $.Toast(b.message, errorToast)
            // setTimeout(() => {
            // 	window.location.href="memo.php";
            // }, 1000)
        }
    });
}

function editDependent(id, name, gender, age, birth_certificate, relation) {
    $('#edit_modal').modal('show')
    $('#dependent_id').val(id)
    $('#dependent_name').val(name)
    $('#dependent_gender').val(gender)
    $('#dependent_age').val(age)
    $('#dependent_birth_certificate').val(birth_certificate)
    $('#dependent_relation').val(relation)
}

$('#dependent_form').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",update_callback, "Do you really want to update this?", "Yes", "No");
})

function update_callback() {
    const formData = new FormData($("#dependent_form")[0]);
    $.ajax({
        url:"controller/controller.benefits.php?updateDependent",
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
            $('#dependent_form').trigger("reset");
            $('#tbl_dependent').DataTable().destroy();
            load_dependent();
        }
    });
}

  // function lb(){

  //      $.ajax({
  //       url:"controller/controller.leavebalance.php?leave_credits_load",
  //       method:"POST",
  //       data:{
  //         id:""
  //       },success:function(){

  //       }
  //     });
       
  // }
  // lb();
  
	function editcontact(){
		$('.master_input').addClass('master_input_open');
		$('.master_input').removeClass('master_input');
		$('#btnsave').removeClass('d-none');
		$('#btncancel').removeClass('d-none');
		$('#btnedit').addClass('d-none');
	}

	function canceledit(){
		var employeeno = $('#employeeno').val();
		window.location.href="benefits.php?employeeno="+employeeno;
	}

	function goto(linkk){
		var employeeno = $('#employeeno').val();
		var link = linkk+"?employeeno="+employeeno;
		window.location.href=link;
	}
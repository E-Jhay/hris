const errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
const successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
	$("#master_update").addClass("active_tab");
	$('.drawer').hide();
	$('.drawer').on('click',function(){
		$('.navnavnav').slideToggle();
	});
	const employeeno = $('#currentUser').val();
    console.log(employeeno)
	$.ajax({
		url:"controller/controller.updateDetails.php?select",
		method:"POST",
		data:{
			employeeno:employeeno
		},success:function(data){
			const b = $.parseJSON(data);
			$('#emp_no').val(b.emp_no);
			$('#f_name').val(b.f_name);
			$('#l_name').val(b.l_name);
			$('#m_name').val(b.m_name);
			$('#rank').val(b.rank);
			$('#statuss').val(b.statuss);
			$('#civilStatus').val(b.marital_status);
			$('#street').val(b.street);
			$('#municipality').val(b.municipality);
			$('#province').val(b.province);
			$('#proof_of_billing').val(b.proof_of_billing);
			$('#marriage_contract').val(b.marriage_contract);
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
		const emp_statuss = $('#emp_statuss').val();
		if(emp_statuss=="Resigned" || emp_statuss=="Terminated"){
			$('#statuss').val("Inactive");
		}else{
			$('#statuss').val("Active");
		}
	});

    
    $("#addressForm").hide()
    $("#civilStatusForm").hide()
    $("#marriage_contract_panel").hide()
});

$('#civilStatusBtn').on('click', () => {
    $("#addressForm").hide()
    $("#civilStatusForm").show()
})
$('#addressBtn').on('click', () => {
    $("#addressForm").show()
    $("#civilStatusForm").hide()
})

$('#civilStatus').on('change', () => {
    if($('#civilStatus').val() === 'Married') {
        $("#marriage_contract_panel").show()
        $('#marriageContractFile').attr('required', true)
    } else {
        $("#marriage_contract_panel").hide()
        $('#marriageContractFile').attr('required', false)
    }
})

$('#addressForm').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",save_address, "Do you really want to save this?", "Yes", "No");
})

function save_address(){
    const formData = new FormData($("#addressForm")[0]);
    $.ajax({
        url:"controller/controller.updateDetails.php?updateAddress",
        method:"POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            const b = $.parseJSON(data)
            if(b.type === 'success'){
                $.Toast(b.message, successToast)
                setTimeout(() => {
                    window.location.reload()
                }, 1500)
            }
            else
                $.Toast(b.message, errorToast)
            // setTimeout(() => {
            // 	window.location.href="memo.php";
            // }, 1000)
        }
    });
}

$('#civilStatusForm').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",save_civil, "Do you really want to save this?", "Yes", "No");
})

function save_civil(){
    const formData = new FormData($("#civilStatusForm")[0]);
    if($('#civilStatus').val() === 'Married') {
        if($('marriageContractFile').val() === '') return $.Toast('Marriage Contract is required', errorToast)
    }
    $.ajax({
        url:"controller/controller.updateDetails.php?updateCivilStatus",
        method:"POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            const b = $.parseJSON(data)
            if(b.type === 'success'){
                $.Toast(b.message, successToast)
                setTimeout(() => {
                    window.location.reload()
                }, 1500)
            }
            else
                $.Toast(b.message, errorToast)
            // setTimeout(() => {
            // 	window.location.href="memo.php";
            // }, 1000)
        }
    });
}
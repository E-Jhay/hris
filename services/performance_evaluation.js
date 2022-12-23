var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}

$(document).ready(function(){

    $("#master_performance_evaluaion").addClass("active_tab");
    $('.drawer').hide();
    $('.drawer').on('click',function(){
       $('.navnavnav').slideToggle();
    });
    
    $('#performance_evaluation_table').hide()

    var employeeno = $('#employeeno').val();
    $.ajax({
        url:"controller/controller.file.php?selectotherid",
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
            $('#emp_no').val(b.emp_no);
            $('#employee_number').val(b.emp_no);
            $('#performance_evaluation_employee_number').val(b.emp_no);
            $('#department').val(b.department);
            document.getElementById("personal_image").src = b.imagepic;

            // if(b.imagepic=="" || b.imagepic==null){
            //     document.getElementById("personal_image").src = "usera.png";
            // }else{
            //     document.getElementById("personal_image").src = "personal_picture/"+b.emp_no+"/"+b.imagepic;
            //     // document.getElementById("personal_image").src = "personal_picture/"+b.imagepic;
            // }

            $('#emp_statuss').load('controller/controller.file.php?demp_stat',function(){
                $('#emp_statuss').val(b.emp_statuss);
            });

            $('#company').load('controller/controller.file.php?dcompany',function(){
                $('#company').val(b.company);
            });


            $('#department').load('controller/controller.file.php?ddepartment',function(){
                $('#department').val(b.department);
            });
        }
    });

})

$('#addBtn').on('click', () => {
    $("#addBtn").hide()
    $('#cancelBtn').show();
    $('#performance_evaluation_table').show()
    $('#action').val('insert')
})
$('#cancelBtn').on('click', () => {
    $("#addBtn").show()
    $('#cancelBtn').hide();
    $('#performance_evaluation_table').hide()
})

function load_performance_evaluation(){
    const employeeno = $('#employeeno').val()
    $('#tbl_performance_evaluation').DataTable({  
        "aaSorting": [],
        "bSearching": true,
        "bFilter": true,
        "bInfo": true,
        "bPaginate": true,
        "bLengthChange": true,
        "pagination": true,
        "ajax" : "controller/controller.performance_evaluation.php?load_performance_evaluation&employeeno=" + employeeno,
        "columns" : [
            { "data" : "employee_no"},
            { "data" : "title"},
            { "data" : "description"},
            { "data" : "date_created"},
            { "data" : "file"},
            { "data" : "action"}

        ],
    });
}

load_performance_evaluation()

function goto(linkk){
    var employeeno = $('#employeeno').val();
    var link = linkk+"?employeeno="+employeeno;
    window.location.href=link;
}

function viewFile(file_name, employee_number) {
    const link = "performance_evaluation/"+employee_number+"/"+file_name;
    window.open(link);
}

$('#form').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
})

function save_callback(){
    var formData = new FormData($("#form")[0]);
    $.ajax({
        url:"controller/controller.performance_evaluation.php?addPerformanceEvaluation",
        method:"POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            const b = $.parseJSON(data)
            if(b.type === 'success'){
                $.Toast(b.message, successToast)
                $('#form').trigger("reset");
                $('#tbl_performance_evaluation').DataTable().destroy();
                load_performance_evaluation();
                $("#addBtn").show()
                $('#cancelBtn').hide();
                $('#performance_evaluation_table').hide()
            }
            else
                $.Toast(b.message, errorToast)
            // setTimeout(() => {
            // 	window.location.href="memo.php";
            // }, 1000)
        }
    });
}

function deleteEvaluation(id, file_name, employee_number) {
    var data = [id, file_name, employee_number];
    confirmed("delete",delete_evaluation_callback, "Do you really want to delete this?", "Yes", "No",data);
}

function delete_evaluation_callback(data){
    var id = data[0];
    var file_name = data[1];
    var employee_number = data[2];
    $.ajax({
      url:"controller/controller.performance_evaluation.php?deleteEvaluation",
      method:"POST",
      data:{
        id: id,
        file_name: file_name,
        employee_number: employee_number
      },success:function(){
        $.Toast("Successfully Deleted", successToast);
        $('#tbl_performance_evaluation').DataTable().destroy();
        load_performance_evaluation();
      }
    });
}

function editEvaluation(id, title, description, file_name) {
    $('#edit_modal').modal('show')
    $('#action').val('update')
    $('#performance_evaluation_id').val(id)
    $('#performance_evaluation_title').val(title)
    $('#performance_evaluation_description').val(description)
    $('#performance_evaluation_file_name').val(file_name)
}

$('#evaluation_form').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",update_callback, "Do you really want to update this?", "Yes", "No");
})

function update_callback() {
    const formData = new FormData($("#evaluation_form")[0]);
    $.ajax({
        url:"controller/controller.performance_evaluation.php?updatePerformanceEvaluation",
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
            $('#evaluation_form').trigger("reset");
            $('#tbl_performance_evaluation').DataTable().destroy();
            load_performance_evaluation();
        }
    });
}
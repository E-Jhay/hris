var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}

$(document).ready(function(){

    $("#incident").addClass("active_tab");
    $('.drawer').hide();
    $('.drawer').on('click',function(){
       $('.navnavnav').slideToggle();
    });
    $('#incident_table').hide()

})

$('#addIncidentBtn').on('click', () => {
    $("#addIncidentBtn").hide()
    $('#cancelIncidentBtn').show();
    $('#incident_table').show()
  })
  $('#cancelIncidentBtn').on('click', () => {
    $("#addIncidentBtn").show()
    $('#cancelIncidentBtn').hide();
    $('#incident_table').hide()
  })

function load_employee_incident(status){
    const employee_number = $('#currentUser').val()
    $('#tbl_incident').DataTable({  
        createdRow: function (row, data, index) {
            if ($('td', row).eq(3)[0].innerText == 'Pending') {
                $('td', row).eq(3).addClass('reject')
            } else if($('td', row).eq(3)[0].innerText == 'Acknowledged') {
                $('td', row).eq(3).addClass('acknowledged')
            }
        }, 
        "aaSorting": [],
        "bSearching": true,
        "bFilter": true,
        "bInfo": true,
        "bPaginate": true,
        "bLengthChange": true,
        "pagination": true,
        "ajax" : "controller/controller.incident.php?load_employee_incident&employee=" + employee_number+"&status="+status,
        "columns" : [
            { "data" : "title"},
            { "data" : "description"},
            { "data" : "date"},
            { "data" : "status"},
            { "data" : "file"},
            { "data" : "action"}

        ],
    });
}
load_employee_incident('pending');

$('#filter_incident').on('change', () => {
	$('#tbl_incident').DataTable().destroy();
	load_employee_incident($('#filter_incident').val());
})

// function goto(linkk){
//     window.location.href=linkk;
// }

function viewFile(file_name, employee_number) {
    const link = "incident_report/"+employee_number+"/"+file_name;
    window.open(link);
}

$('#form').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
})

function save_callback(){
    var formData = new FormData($("#form")[0]);
    $.ajax({
        url:"controller/controller.incident.php?addIncidentReport",
        method:"POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(){
            $("#btn_submit").text('Loading....')
            $("#btn_submit").attr('disabled', true)
        },
        complete: function(){
            $("#btn_submit").text('Acknowledge')
            $("#btn_submit").attr('disabled', false)
        },
        success:function(data){
            const b = $.parseJSON(data)
            $.Toast(b.message, successToast);
            $('#form').trigger("reset");
            $('#tbl_incident').DataTable().destroy();
            load_employee_incident('pending');
            $("#addIncidentBtn").show()
            $('#cancelIncidentBtn').hide();
            $('#incident_table').hide()
            // setTimeout(() => {
            // 	window.location.href="memo.php";
            // }, 1000)
        }
    });
}

function delete_incident(id, file_name, employee_number) {
    var data = [id, file_name, employee_number];
    confirmed("delete",delete_memo_callback, "Do you really want to delete this?", "Yes", "No",data);
}

function delete_memo_callback(data){
    var id = data[0];
    var file_name = data[1];
    var employee_number = data[2];
    $.ajax({
      url:"controller/controller.incident.php?deleteIncidentReport",
      method:"POST",
      data:{
        id: id,
        file_name: file_name,
        employee_number: employee_number
      },success:function(){
        $.Toast("Successfully Deleted", successToast);
        $('#tbl_incident').DataTable().destroy();
        load_employee_incident();
      }
    });
}

function editIncident(id, title, description, file_name) {
    $('#edit_modal').modal('show')
    $('#incident_id').val(id)
    $('#incident_title').val(title)
    $('#incident_description').val(description)
    $('#file_name').val(file_name)
}

$('#incident_form').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",update_callback, "Do you really want to update this?", "Yes", "No");
})

function update_callback() {
    const formData = new FormData($("#incident_form")[0]);
    $.ajax({
        url:"controller/controller.incident.php?updateIncidentReport",
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
            $('#incident_form').trigger("reset");
            $('#tbl_incident').DataTable().destroy();
            load_employee_incident('pending');
        }
    });
}
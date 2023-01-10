var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}

$(document).ready(function(){

    $("#incident").addClass("active_tab");
    $('.drawer').hide();
    $('.drawer').on('click',function(){
       $('.navnavnav').slideToggle();
    });
    $('#incident_table').hide()

    load_employee_incident_all('pending')
    $('#status').on('change', () => {
        $('#tbl_incident').DataTable().destroy();
        load_employee_incident_all($('#status').val())
    })

})

// $('#addIncidentBtn').on('click', () => {
//     $("#addIncidentBtn").hide()
//     $('#cancelIncidentBtn').show();
//     $('#incident_table').show()
//   })
//   $('#cancelIncidentBtn').on('click', () => {
//     $("#addIncidentBtn").show()
//     $('#cancelIncidentBtn').hide();
//     $('#incident_table').hide()
//   })

function load_employee_incident_all(status){
    $('#tbl_incident').DataTable({  
        createdRow: function (row, data, index) {
            if ($('td', row).eq(3)[0].innerText == 'Rejected') {
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
        "ajax" : "controller/controller.incident.php?load_employee_incident_all&status=" + status,
        "columns" : [
            { "data" : "title"},
            { "data" : "description"},
            { "data" : "date"},
            { "data" : "status"},
            { "data" : "file"},
            { "data" : "action"},
        ],
    });
}

function count_incident_reports(){

    $.ajax({
        url:"controller/controller.info.php?count_incident_reports",
        method:"POST",
        success:function(data){
            var b = $.parseJSON(data);
            
          if(b.count > 0){
              $('#incident_reports_number').show();
              $('#incident_reports_number').html(b.count);
          }else{
              $('#incident_reports_number').hide();
          }

        }
    });
}
count_incident_reports();

function goto(linkk){
    window.location.href=linkk;
}

function viewFile(file_name, employee_number) {
    const link = "incident_report/"+employee_number+"/"+file_name;
    window.open(link);
}

// $('#form').on('submit', (e) => {
//     e.preventDefault()
//     confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
// })

// function save_callback(){
//     var formData = new FormData($("#form")[0]);
//     $.ajax({
//         url:"controller/controller.incident.php?addIncidentReport",
//         method:"POST",
//         data: formData,
//         processData: false,
//         contentType: false,
//         success:function(data){
//             const b = $.parseJSON(data)
//             $.Toast(b.message, successToast);
//             $('#form').trigger("reset");
//             $('#tbl_incident').DataTable().destroy();
//             load_employee_incident();
//             $("#addIncidentBtn").show()
//             $('#cancelIncidentBtn').hide();
//             $('#incident_table').hide()
//             // setTimeout(() => {
//             // 	window.location.href="memo.php";
//             // }, 1000)
//         }
//     });
// }

// function delete_incident(id, file_name, employee_number) {
//     var data = [id, file_name, employee_number];
//     confirmed("delete",delete_memo_callback, "Do you really want to delete this?", "Yes", "No",data);
// }

// function delete_memo_callback(data){
//     var id = data[0];
//     var file_name = data[1];
//     var employee_number = data[2];
//     $.ajax({
//       url:"controller/controller.incident.php?deleteIncidentReport",
//       method:"POST",
//       data:{
//         id: id,
//         file_name: file_name,
//         employee_number: employee_number
//       },success:function(){
//         $.Toast("Successfully Deleted", successToast);
//         $('#tbl_incident').DataTable().destroy();
//         load_employee_incident();
//       }
//     });
// }

function editIncident(id, title, description, file_name, employeeno, date, status) {
    $('#edit_modal').modal('show')
    $('#incident_id').val(id)
    $('#incident_title').val(title)
    $('#incident_description').val(description)
    $('#incident_employeeno').val(employeeno)
    $('#incident_date').val(date)
    if(status !== 'pending'){
        $('#btn_cancel').show()
        $('#btn_submit').hide()
        $('#btn_reject').hide()
    } else {
        $('#btn_cancel').hide()
        $('#btn_submit').show()
        $('#btn_reject').show()
    }
    
}

$('#incident_form').on('submit', (e) => {
    e.preventDefault()
    confirmed("save",update_callback, "Do you really want to update this?", "Yes", "No");
})

function update_callback() {
    const remarks = $('#incident_remarks').val();
    const incident_id = $('#incident_id').val();
    const incident_employeeno = $('#incident_employeeno').val();
    const incident_date = $('#incident_date').val();
    $.ajax({
        url:"controller/controller.incident.php?acknowledgeIncidentReport",
        method:"POST",
        data: {
            remarks : remarks,
            incident_id : incident_id,
            incident_employeeno : incident_employeeno,
            incident_date : incident_date,
        },
        beforeSend: function(){
            $("#btn_submit").text('Loading....')
            $("#btn_submit").attr('disabled', true)
            $("#btn_reject").text('Loading....')
            $("#btn_reject").attr('disabled', true)
        },
        complete: function(){
            $("#btn_submit").text('Acknowledge')
            $("#btn_submit").attr('disabled', false)
            $("#btn_reject").text('Reject')
            $("#btn_reject").attr('disabled', false)
        },
        success:function(data){
            const b = $.parseJSON(data)
            if(b.type === "error")
                $.Toast(b.message, errorToast)
            else
                $.Toast(b.message, successToast)
            $('#edit_modal').modal('hide')
            $('#incident_form').trigger("reset");
            $('#tbl_incident').DataTable().destroy();
            load_employee_incident_all('pending');
            count_incident_reports();
            $('#status').val('pending')
        }
    });
}

$('#btn_reject').on('click', (e) => {
    e.preventDefault()
    confirmed("save",reject_callback, "Do you really want to reject this?", "Yes", "No");
})

$('#btn_cancel').on('click', (e) => {
    e.preventDefault()
    confirmed("save",cancel_callback, "Do you really want to cancel this?", "Yes", "No");
})

function cancel_callback() {
    const remarks = $('#incident_remarks').val();
    const incident_id = $('#incident_id').val();
    const incident_employeeno = $('#incident_employeeno').val();
    const incident_date = $('#incident_date').val();
    $.ajax({
        url:"controller/controller.incident.php?cancelIncidentReport",
        method:"POST",
        data: {
            remarks : remarks,
            incident_id : incident_id,
            incident_employeeno : incident_employeeno,
            incident_date : incident_date,
        },
        beforeSend: function(){
            $("#btn_cancel").text('Loading....')
            $("#btn_cancel").attr('disabled', true)
        },
        complete: function(){
            $("#btn_cancel").text('Cancel')
            $("#btn_cancel").attr('disabled', false)
        },
        success:function(data){
            const b = $.parseJSON(data)
            if(b.type === "error")
                $.Toast(b.message, errorToast)
            else
                $.Toast(b.message, successToast)
            $('#edit_modal').modal('hide')
            $('#incident_form').trigger("reset");
            $('#tbl_incident').DataTable().destroy();
            load_employee_incident_all('pending');
            count_incident_reports();
            $('#status').val('pending')
        }
    });
} 
function reject_callback() {
    const remarks = $('#incident_remarks').val();
    const incident_id = $('#incident_id').val();
    const incident_employeeno = $('#incident_employeeno').val();
    const incident_date = $('#incident_date').val();
    $.ajax({
        url:"controller/controller.incident.php?rejectIncidentReport",
        method:"POST",
        data: {
            remarks : remarks,
            incident_id : incident_id,
            incident_employeeno : incident_employeeno,
            incident_date : incident_date,
        },
        beforeSend: function(){
            $("#btn_submit").text('Loading....')
            $("#btn_submit").attr('disabled', true)
            $("#btn_reject").text('Loading....')
            $("#btn_reject").attr('disabled', true)
        },
        complete: function(){
            $("#btn_submit").text('Acknowledge')
            $("#btn_submit").attr('disabled', false)
            $("#btn_reject").text('Reject')
            $("#btn_reject").attr('disabled', false)
        },
        success:function(data){
            const b = $.parseJSON(data)
            if(b.type === "error")
                $.Toast(b.message, errorToast)
            else
                $.Toast(b.message, successToast)
            $('#edit_modal').modal('hide')
            $('#incident_form').trigger("reset");
            $('#tbl_incident').DataTable().destroy();
            load_employee_incident_all('pending');
            count_incident_reports();
            $('#status').val('pending')
        }
    });
} 
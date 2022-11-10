var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

		$("#master_file").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});
		var emp_id = $('#emp_id').val();
		$.ajax({
			url:"controller/controller.file.php?selectotherid",
			method:"POST",
			data:{
				emp_id:emp_id
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
				$('#department').val(b.department);

				if(b.imagepic=="" || b.imagepic==null){
					document.getElementById("personal_image").src = "usera.png";
				}else{
					document.getElementById("personal_image").src = "personal_picture/"+b.imagepic;
				}

				$('#emp_statuss').load('controller/controller.file.php?demp_stat',function(){
					$('#emp_statuss').val(b.emp_statuss);
				});

				$('#company').load('controller/controller.file.php?dcompany',function(){
					$('#company').val(b.company);
				});


				$('#department').load('controller/controller.file.php?ddepartment',function(){
					$('#department').val(b.department);
				});

				

				loadfile(b.emp_no);
			}
		});

	});

	// function lb(){

 //       $.ajax({
 //        url:"controller/controller.leavebalance.php?leave_credits_load",
 //        method:"POST",
 //        data:{
 //          id:""
 //        },success:function(){

 //        }
 //      });
       
 //  }
 //  lb();

	function filefile(){

        var $fileUpload = $("input[type='file']");
        if (parseInt($fileUpload.get(0).files.length)>10){
         alert("You can only upload a maximum of 10 files");
         $('#submitsumbit').hide();
        }else{ 
        	var employeeno = $('#emp_no').val();
        	var fp = $('#empfile');
		    var lg = fp[0].files.length; 
		    var items = fp[0].files;
		    var fragment = "";
		    if (lg > 0) {
		        for (var i = 0; i < lg; i++) {
		            var fileName = items[i].name;
		            fragment += fileName + '**';
		        }

		        $.ajax({
		        	url:"controller/controller.file.php?check_file",
		        	method:"POST",
		        	data:{
		        		fragment: fragment,
		        		employeeno: employeeno
		        	},success:function(data){
		        		var b = $.parseJSON(data);
		        		if(b.founded !=""){
		        			alert(b.founded+"\n File already exists ");
		        		}
		        		
		        	}
		        });
		        
		    }


         	$('#submitsumbit').show();
        }
      
	}

	function dl_file(filename){
		var employeeno = $('#emp_no').val();
		var link = "attach_file/"+employeeno+"/"+filename;
		window.open(link);
	}
	function delete_file(id,filename){
		var data = [id,filename];
		confirmed("delete",delete_file_callback, "Do you really want to delete this?", "Yes", "No",data);
		
	}

	function delete_file_callback(data){
		var id = data[0];
		var filename = data[1];
		var employeeno = $('#emp_no').val();
		var employeeid = $('#emp_id').val();
		$.ajax({
			url:"controller/controller.file.php?deletefile",
			method:"POST",
			data:{
				id: id,
				filename: filename,
				employeeno: employeeno
			},success:function(){
				window.location.href="file_attach.php?id="+employeeid;
			}
		});
	}


	function editcontact(){
		$('.master_input').addClass('master_input_open');
		$('.master_input').removeClass('master_input');
		$('#btnsave').removeClass('d-none');
		$('#btncancel').removeClass('d-none');
		$('#btnedit').addClass('d-none');
	}

	function canceledit(){
		var id = $('#emp_id').val();
		window.location.href="file_attach.php?id="+id;
	}

	function goto(linkk){
		var id = $('#emp_id').val();
		var link = linkk+"?id="+id;
		window.location.href=link;
	}

	function loadfile(employeeno){

    	$('#tbl_file').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "pageLength": 20,
              "ajax" : "controller/controller.file.php?loadfile&employeeno="+employeeno,
              "columns" : [
                    
                    { "data" : "file_name"},
                    { "data" : "action"}

                ],
         });
  }
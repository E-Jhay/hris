var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

		$("#master_additional_documents").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});

		$('#telephoneno').on('keyup',function(){
			var telephoneno = $('#telephoneno').val();
			var len = telephoneno.length;
			if(len==4){
				
				$('#telephoneno').val(telephoneno+"-");
			}

		});

		$('#contactno').on('keyup',function(){
			var contactno = $('#contactno').val();
			var len = contactno.length;
			if(len==4){
				
				$('#contactno').val(contactno+"-");
			}

		});


		var emp_id = $('#emp_id').val();
		$.ajax({
			url:"controller/controller.dashboard.php?selectcontact",
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

				if(b.imagepic=="" || b.imagepic==null){
					document.getElementById("personal_image").src = "usera.png";
				}else{
					document.getElementById("personal_image").src = "personal_picture/"+b.emp_no+"/"+b.imagepic;
					// document.getElementById("personal_image").src = "personal_picture/"+b.imagepic;
				}
				
				$('#emp_statuss').load('controller/controller.additional_documents.php?demp_stat',function(){
					$('#emp_statuss').val(b.emp_statuss);
				});

				$('#company').load('controller/controller.additional_documents.php?dcompany',function(){
					$('#company').val(b.company);
				});


				$('#department').load('controller/controller.additional_documents.php?ddepartment',function(){
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

		$('#li1').addClass("active");
		
	});

	$('form').on('submit', function (e) {

            e.preventDefault();
            confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
            
            

      });

	function save_callback(){
		var formData = new FormData($("#form")[0]);
		$.ajax({
	  	url:"controller/controller.additional_documents.php?update",
		method:"POST",
		data: formData,
		processData: false,
		contentType: false,
	  	success:function(data){
			$.Toast("Successfully Saved", successToast);
			setTimeout(() => {
				var b = $.parseJSON(data);
				var id = b.id;
				window.location.href="additional_documents.php?id="+id;
				console.log(data)
			}, 1000)
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
		var id = $('#emp_id').val();
		window.location.href="additional_documents.php?id="+id;
	}

	function goto(linkk){
		var id = $('#emp_id').val();
		var link = linkk+"?id="+id;
		window.location.href=link;
	}

	function loadDocuments(emp_id){

		$('#tbl_documents').DataTable({  
				"aaSorting": [],
				"bSearching": false,
				"bFilter": false,
				"bInfo": false,
				"bPaginate": false,
				"bLengthChange": false,
				"pagination": false,
				"pageLength": 20,
				"ajax" : "controller/controller.additional_documents.php?selectAdditionalDocuments&emp_id=" + emp_id,
				"columns" : [
					
					{ "data" : "marriage_contract"},
					{ "data" : "dependent"},
					{ "data" : "additional_id"},
					{ "data" : "proof_of_billing"}

				],
		});
	}
	loadDocuments($('#emp_id').val())

	function viewDocument(filename,employeeno, type){
		var link = "documents/"+employeeno+"/"+type+"/"+filename;
		window.open(link);
	}
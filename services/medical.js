var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		$("#master_medical").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});
		var emp_id = $('#emp_id').val();
		$.ajax({
			url:"controller/controller.medical.php?selectmedical",
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
				
				$('#emp_statuss').load('controller/controller.medical.php?demp_stat',function(){
					$('#emp_statuss').val(b.emp_statuss);
				});

				$('#company').load('controller/controller.medical.php?dcompany',function(){
					$('#company').val(b.company);
				});

				$('#department').load('controller/controller.medical.php?ddepartment',function(){
					$('#department').val(b.department);
				});

				$('#type1').val(b.type1);
				$('#classification1').val(b.classification1);
				$('#status1').val(b.status1);
				$('#dateofexam1').val(b.dateofexam1 !== '0000-00-00' ? b.dateofexam1 : '');
				$('#remarks1').val(b.remarks1);
				$('#type2').val(b.type2);
				$('#classification2').val(b.classification2);
				$('#status2').val(b.status2);
				$('#dateofexam2').val(b.dateofexam2 !== '0000-00-00' ? b.dateofexam2 : '');
				$('#remarks2').val(b.remarks2);
				$('#type3').val(b.type3);
				$('#classification3').val(b.classification3);
				$('#status3').val(b.status3);
				$('#dateofexam3').val(b.dateofexam3 !== '0000-00-00' ? b.dateofexam3 : '');
				$('#remarks3').val(b.remarks3);
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

	});


	$('form').on('submit', function (e) {

            e.preventDefault();
            confirmed("save",save_callback, "Do you really want to save this?", "Yes", "No");
            
      });

function save_callback(){
					$.ajax({
	        	url:"controller/controller.medical.php?editmedical",
	        	method:"POST",
	        	data: $('form').serialize(),
	        	success:function(data){
					$.Toast("Successfully Saved", successToast);
					setTimeout(() => {
						var b = $.parseJSON(data);
						var id = b.id;
						window.location.href="medical.php?id="+id;
					}, 1000)
	        		
	        	}
	        });
}
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

	function editcontact(){
		$('.master_input').addClass('master_input_open');
		$('.master_input').removeClass('master_input');
		$('#btnsave').removeClass('d-none');
		$('#btncancel').removeClass('d-none');
		$('#btnedit').addClass('d-none');
	}

	function canceledit(){
		var id = $('#emp_id').val();
		window.location.href="medical.php?id="+id;
	}

	function goto(linkk){
		var id = $('#emp_id').val();
		var link = linkk+"?id="+id;
		window.location.href=link;
	}
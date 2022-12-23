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

				$('#comp_id_dateissue').val(b.comp_id_dateissue !== '0000-00-00' ? b.comp_id_dateissue : '');
				$('#comp_id_vdate').val(b.comp_id_vdate !== '0000-00-00' ? b.comp_id_vdate : '');
				$('#fac_ap_dateissue').val(b.fac_ap_dateissue !== '0000-00-00' ? b.fac_ap_dateissue : '');
				$('#fac_ap_vdate').val(b.fac_ap_vdate !== '0000-00-00' ? b.fac_ap_vdate : '');
				$('#leave_balance').val(b.leave_balance);
				$('#fac_card_number').val(b.card_number);
				$('#driver_id').val(b.driver_id);
				$('#driver_exp').val(b.driver_exp !== '0000-00-00' ? b.driver_exp : '');
				$('#prc_number').val(b.prc_number);
				$('#prc_exp').val(b.prc_exp !== '0000-00-00' ? b.prc_exp : '');
				$('#civil_service').val(b.civil_service);

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
	        	url:"controller/controller.otherid.php?editotherid",
	        	method:"POST",
	        	data: $('form').serialize(),
	        	success:function(data){
					$.Toast("Successfully Saved", successToast);
					setTimeout(() => {
						var b = $.parseJSON(data);
						var employeeno = b.employeeno;
						window.location.href="otherid.php?employeeno="+employeeno;
					}, 1000)
	        		
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
var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		
		$("#master_govt").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});

		$('#tin_no').on('keyup',function(){
			var tin_no = $('#tin_no').val();
			var len = tin_no.length;
			if(len==3){
				
				$('#tin_no').val(tin_no+"-");
			}

			if(len==7){
				
				$('#tin_no').val(tin_no+"-");
			}

			if(len==11){
				
				$('#tin_no').val(tin_no+"-");
			}

		});

		$('#sss_no').on('keyup',function(){
			var sss_no = $('#sss_no').val();
			var len = sss_no.length;
			if(len==2){
				
				$('#sss_no').val(sss_no+"-");
			}

			if(len==10){
				
				$('#sss_no').val(sss_no+"-");
			}

		});

		$('#phic_no').on('keyup',function(){
			var phic_no = $('#phic_no').val();
			var len = phic_no.length;
			if(len==2){
				
				$('#phic_no').val(phic_no+"-");
			}

			if(len==12){
				
				$('#phic_no').val(phic_no+"-");
			}

			

		});

		$('#hdmf_no').on('keyup',function(){
			var hdmf_no = $('#hdmf_no').val();
			var len = hdmf_no.length;
			if(len==4){
				
				$('#hdmf_no').val(hdmf_no+"-");
			}

			if(len==9){
				
				$('#hdmf_no').val(hdmf_no+"-");
			}


		});




		$('#li3').addClass("active");
		var employeeno = $('#employeeno').val();
		$.ajax({
			url:"controller/controller.govt.php?selectgovt",
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
				
				$('#emp_statuss').load('controller/controller.govt.php?demp_stat',function(){
					$('#emp_statuss').val(b.emp_statuss);
				});

				$('#company').load('controller/controller.govt.php?dcompany',function(){
					$('#company').val(b.company);
				});

				$('#department').load('controller/controller.govt.php?ddepartment',function(){
					$('#department').val(b.department);
				});
				
				$('#tin_no').val(b.tin_no);
				$('#sss_no').val(b.sss_no);
				$('#phic_no').val(b.phic_no);
				$('#hdmf_no').val(b.hdmf_no);
				$('#atm_no').val(b.atm_no);
				$('#bank_name').val(b.bank_name);
				$('#sss_remarks').val(b.sss_remarks);
				$('#phic_remarks').val(b.phic_remarks);
				$('#hdmf_remarks').val(b.hdmf_remarks);
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
	 	url:"controller/controller.govt.php?editgovtid",
	 	method:"POST",
	 	data: $('form').serialize(),
	 	success:function(data){
	 		$.Toast("Successfully Saved", successToast);
			setTimeout(() => {
				var b = $.parseJSON(data);
				var employeeno = b.employeeno;
				window.location.href="govtid.php?employeeno="+employeeno;
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
		window.location.href="govtid.php?employeeno="+employeeno;
	}

	function goto(linkk){
		var employeeno = $('#employeeno').val();
		var link = linkk+"?employeeno="+employeeno;
		window.location.href=link;
	}
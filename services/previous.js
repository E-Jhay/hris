var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		$("#master_employer").addClass("active_tab");
		$('.drawer').hide();
		$('.drawer').on('click',function(){
		   $('.navnavnav').slideToggle();
		});
		var emp_id = $('#emp_id').val();
		$.ajax({
			url:"controller/controller.previous.php?selectprevious",
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
					document.getElementById("personal_image").src = "personal_picture/"+b.imagepic;
				}

				$('#emp_statuss').load('controller/controller.previous.php?demp_stat',function(){
					$('#emp_statuss').val(b.emp_statuss);
				});

				$('#company').load('controller/controller.previous.php?dcompany',function(){
					$('#company').val(b.company);
				});

				$('#department').load('controller/controller.previous.php?ddepartment',function(){
					$('#department').val(b.department);
				});
				
				$('#company1').val(b.company1);
				$('#naturebusiness1').val(b.naturebusiness1);
				$('#year1').val(b.year1);
				$('#position1').val(b.position1);
				$('#rate1').val(b.rate1);
				$('#company2').val(b.company2);
				$('#naturebusiness2').val(b.naturebusiness2);
				$('#year2').val(b.year2);
				$('#position2').val(b.position2);
				$('#rate2').val(b.rate2);
				$('#leave_balance').val(b.leave_balance);
				$('#yearend1').val(b.yearend1);
				$('#yearend2').val(b.yearend2);
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
	        	url:"controller/controller.previous.php?editpreviousemployer",
	        	method:"POST",
	        	data: $('form').serialize(),
	        	success:function(data){
	        		var b = $.parseJSON(data);
	        		var id = b.id;
	        		window.location.href="previousemployer.php?id="+id;
	        		
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
		var id = $('#emp_id').val();
		window.location.href="previousemployer.php?id="+id;
	}

	function goto(linkk){
		var id = $('#emp_id').val();
		var link = linkk+"?id="+id;
		window.location.href=link;
	}
var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

		$("#pim_reports").addClass("active_tab");
	  $('.drawer').hide();
	  $('.drawer').on('click',function(){
	   $('.navnavnav').slideToggle();
	  });
	  
		$("#lnewly").addClass("active");
		$('#employment_status').load('controller/controller.reports.php?demp_stat');
		$('#division').load('controller/controller.reports.php?ddepartment');
		$('#job_category').load('controller/controller.reports.php?d_jobcategory');
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

	function btnMonthsEvaluation() {
		
		$('#div_evaluation').show();
		$('#div_newly').hide();
		$('#div_bday').hide();
		$('#div_age').hide();
		$('#div_department').hide();
		$('#div_gender').hide();
		$('#div_employment').hide();

		$('#lmonths').addClass("active");
		$('#lbirthday').removeClass("active");
		$('#lage').removeClass("active");
		$('#ldept').removeClass("active");
		$('#lgender').removeClass("active");
		$('#lemployment').removeClass("active");
		$('#ldivision').removeClass("active");
		$('#lnewly').removeClass("active");
		$('#div_division').hide();

		// var month = $('#evaluationMonth').val();
		// var a = "";
		// var report_type = "evaluation";
		// $('#tbl_employee').DataTable().destroy();
		// loademployee(month,a,report_type);
		// $.ajax({
		// 	url:"controller/controller.reports.php?monthsEvaluation",
		// 	method:"POST",
		// 	success:function(data){
		// 		// var b = $.parseJSON(data);
		// 		// $.Toast("Successfully Saved", successToast);
		// 		// setTimeout(() => {
		// 		// 	window.location.href="employee.php";
		// 		// }, 1000)
		// 		console.log(data)
		// 	}
		// });
	}
 
	function btnnewly(){
		$('#div_newly').show();
		$('#div_bday').hide();
		$('#div_age').hide();
		$('#div_department').hide();
		$('#div_gender').hide();
		$('#div_employment').hide();
		$('#div_evaluation').hide();

		$('#lnewly').addClass("active");
		$('#lbirthday').removeClass("active");
		$('#lage').removeClass("active");
		$('#ldept').removeClass("active");
		$('#lgender').removeClass("active");
		$('#lemployment').removeClass("active");
		$('#ldivision').removeClass("active");
		$('#lmonths').removeClass("active");
		$('#div_division').hide();

		var newlyfrom = $('#newlyfrom').val();
		var newlyto = new Date().toISOString().slice(0, 10);
		var report_type = "newly";
		$('#tbl_employee').DataTable().destroy();
		loademployee(newlyfrom,newlyto,report_type);

	}
	function btnbirthday(){
		$('#div_newly').hide();
		$('#div_bday').show();
		$('#div_age').hide();
		$('#div_department').hide();
		$('#div_gender').hide();
		$('#div_employment').hide();
		$('#div_evaluation').hide();

		$('#lnewly').removeClass("active");
		$('#lbirthday').addClass("active");
		$('#lage').removeClass("active");
		$('#ldept').removeClass("active");
		$('#lgender').removeClass("active");
		$('#lemployment').removeClass("active");
		$('#ldivision').removeClass("active");
		$('#lmonths').removeClass("active");
		$('#div_division').hide();
	}
	function btnage(){
		$('#div_newly').hide();
		$('#div_bday').hide();
		$('#div_age').show();
		$('#div_department').hide();
		$('#div_gender').hide();
		$('#div_employment').hide();
		$('#div_evaluation').hide();

		$('#lnewly').removeClass("active");
		$('#lbirthday').removeClass("active");
		$('#lage').addClass("active");
		$('#ldept').removeClass("active");
		$('#lgender').removeClass("active");
		$('#lemployment').removeClass("active");
		$('#ldivision').removeClass("active");
		$('#lmonths').removeClass("active");
		$('#div_division').hide();
	}
	function btndept(){
		$('#div_newly').hide();
		$('#div_bday').hide();
		$('#div_age').hide();
		$('#div_department').show();
		$('#div_gender').hide();
		$('#div_employment').hide();
		$('#div_evaluation').hide();

		$('#lnewly').removeClass("active");
		$('#lbirthday').removeClass("active");
		$('#lage').removeClass("active");
		$('#ldept').addClass("active");
		$('#lgender').removeClass("active");
		$('#lemployment').removeClass("active");
		$('#ldivision').removeClass("active");
		$('#lmonths').removeClass("active");
		$('#div_division').hide();
	}
	function btngender(){
		$('#div_newly').hide();
		$('#div_bday').hide();
		$('#div_age').hide();
		$('#div_department').hide();
		$('#div_gender').show();
		$('#div_employment').hide();
		$('#div_evaluation').hide();

		$('#lnewly').removeClass("active");
		$('#lbirthday').removeClass("active");
		$('#lage').removeClass("active");
		$('#ldept').removeClass("active");
		$('#lgender').addClass("active");
		$('#lemployment').removeClass("active");
		$('#ldivision').removeClass("active");
		$('#lmonths').removeClass("active");
		$('#div_division').hide();
	}
	function btnemployment(){
		$('#div_newly').hide();
		$('#div_bday').hide();
		$('#div_age').hide();
		$('#div_department').hide();
		$('#div_gender').hide();
		$('#div_employment').show();
		$('#div_evaluation').hide();

		$('#lnewly').removeClass("active");
		$('#lbirthday').removeClass("active");
		$('#lage').removeClass("active");
		$('#ldept').removeClass("active");
		$('#lgender').removeClass("active");
		$('#lemployment').addClass("active");
		$('#ldivision').removeClass("active");
		$('#lmonths').removeClass("active");
		$('#div_division').hide();
	}

	function btndivision(){

		$('#div_newly').hide();
		$('#div_bday').hide();
		$('#div_age').hide();
		$('#div_department').hide();
		$('#div_gender').hide();
		$('#div_employment').hide();
		$('#div_division').show();
		$('#div_evaluation').hide();

		$('#lnewly').removeClass("active");
		$('#lbirthday').removeClass("active");
		$('#lage').removeClass("active");
		$('#ldept').removeClass("active");
		$('#lgender').removeClass("active");
		$('#lemployment').removeClass("active");
		$('#lmonths').removeClass("active");
		$('#ldivision').addClass("active");

	}
	



  function searchnewly(){

  	var newlyfrom = $('#newlyfrom').val();
	var newlyto = $('#newlyto').val();
	var report_type = "newly";
	$('#tbl_employee').DataTable().destroy();
	loademployee(newlyfrom,newlyto,report_type);

  }

  function exportnewly(){
  	var newlyfrom = $('#newlyfrom').val();
	var newlyto = $('#newlyto').val();
	var report_type = "newly";
	window.location.href="tcpdf/examples/employeelist.php?type="+report_type+"&from="+newlyfrom+"&to="+newlyto;
  }


  function searchbday(){
  	var bdayfrom = $('#bdayfrom').val();
	var bdayto = $('#bdayto').val();
	var report_type = "bday";
	$('#tbl_employee').DataTable().destroy();
	loademployee(bdayfrom,bdayto,report_type);
  }

  function exportbday(){
  	var bdayfrom = $('#bdayfrom').val();
	var bdayto = $('#bdayto').val();
	var report_type = "bday";
	window.location.href="tcpdf/examples/employeelist.php?type="+report_type+"&from="+bdayfrom+"&to="+bdayto;
  }

  function searchgender(){
  	var gender = $('#gender').val();
  	var a = "";
  	var report_type = "gender";
  	$('#tbl_employee').DataTable().destroy();
	loademployee(gender,a,report_type);

  }

  function exportgender(){
  	var gender = $('#gender').val();
  	var a = "";
  	var report_type = "gender";
  	window.location.href="tcpdf/examples/employeelist.php?type="+report_type+"&from="+gender+"&to="+a;
  }

  function searchage(){
  	var agefrom = $('#agefrom').val();
	var ageto = $('#ageto').val();
	var report_type = "age";
	$('#tbl_employee').DataTable().destroy();
	loademployee(agefrom,ageto,report_type);
  }

  function exportage(){
  	var agefrom = $('#agefrom').val();
	var ageto = $('#ageto').val();
	var report_type = "age";
	window.location.href="tcpdf/examples/employeelist.php?type="+report_type+"&from="+agefrom+"&to="+ageto;
  }

  function searchdivision(){
  	var division = $('#division').val();
  	var a = "";
  	var report_type = "division";
  	$('#tbl_employee').DataTable().destroy();
	loademployee(division,a,report_type);
  }

  function exportdivision(){
  	var division = $('#division').val();
  	var a = "";
  	var report_type = "division";
  	window.location.href="tcpdf/examples/employeelist.php?type="+report_type+"&from="+division+"&to="+a;
  }

 

  function searchemployment(){
  	var employment_status = $('#employment_status').val();
  	var a = "";
  	var report_type = "employment";
  	$('#tbl_employee').DataTable().destroy();
	loademployee(employment_status,a,report_type);
  }

  function exportemployment(){
  	var employment_status = $('#employment_status').val();
  	var a = "";
  	var report_type = "employment";
  	window.location.href="tcpdf/examples/employeelist.php?type="+report_type+"&from="+employment_status+"&to="+a;
  }

  function searchdept(){
  	var job_category = $('#job_category').val();
  	var a = "";
  	var report_type = "job_category";
  	$('#tbl_employee').DataTable().destroy();
	loademployee(job_category,a,report_type);
  } 

  function exportdept(){
  	var job_category = $('#job_category').val();
  	var a = "";
  	var report_type = "job_category";
  	window.location.href="tcpdf/examples/employeelist.php?type="+report_type+"&from="+job_category+"&to="+a;
  }

  function searchEvaluation(){
	var month = $('#evaluationMonth').val();
	var a = "";
	var report_type = "evaluation";
	$('#tbl_employee').DataTable().destroy();
  loademployee(month,a,report_type);
} 

function exportEvaluation(){
	var month = $('#evaluationMonth').val();
	var a = "";
	var report_type = "evaluation";
	$('#tbl_employee').DataTable().destroy();
	window.location.href="tcpdf/examples/employeelist.php?type="+report_type+"&from="+month+"&to="+a;
}

  function loademployee(from,to,type){
    // alert(type);
    $('#tbl_employee').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "pageLength":50,
              "ajax" : "controller/controller.reports.php?loademployeereport&type="+type+"&from="+from+"&to="+to,
              "columns" : [
                    
                    { "data" : "employeeno"},
                    { "data" : "lastname"},
                    { "data" : "firstname"},
                    { "data" : "middlename"},
                    { "data" : "job_title"},
                    { "data" : "employment_status"},
                    { "data" : "company"}

                ],
         });
  }
  var from = "";
  var to = new Date().toISOString().slice(0, 10);
  var type = "all";
  loademployee(from,to,type);


  function backmodule(){
  	window.location.href="module.php";
  }

  function goto(linkk){
	window.location.href=linkk;
  }
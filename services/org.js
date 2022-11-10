var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
		 $("#admin_org").addClass("active_tab");
		 $('#div_locations').hide();
		 $('.drawer').hide();
     $('.drawer').on('click',function(){
      $('.navnavnav').slideToggle();
     });

		 $.ajax({
		 	url:"controller/controller.org.php?load_geninfo",
		 	method:"POST",
		 	data:{
		 		id:"1"
		 	},success:function(data){
		 		var b = $.parseJSON(data);
		 		$('#org_name').val(b.org_name);
		 		$('#tax_id').val(b.tax_id);
		 		$('#numberof_emp').val(b.numberof_emp);
		 		$('#reg_number').val(b.reg_number);
				$('#cost_center').val(b.cost_center);
				$('#cost_center_detail').val(b.cost_center_detail);
				$('#contact_details').val(b.contact_details);
				$('#fax').val(b.fax);
				$('#email').val(b.email);
				$('#address_st').val(b.address_st);
				$('#brgy').val(b.brgy);
				$('#city').val(b.city);
				$('#zipcode').val(b.zipcode);
				$('#country').val(b.country);
				$('#note').val(b.note);
		 	}
		 });

	});
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
  function btnaddlocation(){

  	$('#modal_id').val("");
	$('#modal_name').val("");
	$('#modal_city').val("");
	$('#modal_country').val("");
	$('#modal_phone').val("");
	$('#modal_noofemployee').val("");

  	$('#savelocationbtn').show();
	$('#updatelocationbtn').hide();
   
    $('#location_modal').modal('show');

  }

  function btn_savelocation(){

  var modal_id = $('#modal_id').val();
	var modal_name = $('#modal_name').val();
	var modal_city = $('#modal_city').val();
	var modal_country = $('#modal_country').val();
	var modal_phone = $('#modal_phone').val();
	var modal_noofemployee = $('#modal_noofemployee').val();

	$.ajax({
		url:"controller/controller.org.php?addlocation",
		method:"POST",
		data:{
			modal_id: modal_id,
			modal_name: modal_name,
			modal_city: modal_city,
			modal_country: modal_country,
			modal_phone: modal_phone,
			modal_noofemployee: modal_noofemployee
		},success:function(){
			$.Toast("Successfully Saved", successToast);
			$('#tbl_locations').DataTable().destroy();
			load_locations();
			$('#location_modal').modal('hide');
		}
	});
  	
  }


  function edit_location(id,name,city,country,phone,numberofemp){

  	$('#modal_id').val(id);
	$('#modal_name').val(name);
	$('#modal_city').val(city);
	$('#modal_country').val(country);
	$('#modal_phone').val(phone);
	$('#modal_noofemployee').val(numberofemp);

	$('#savelocationbtn').hide();
	$('#updatelocationbtn').show();
	$('#location_modal').modal('show');

  }
  function delete_location(id){
  	confirmed("delete",delete_location_callback, "Do you really want to delete this?", "Yes", "No", id);
  }

  function delete_location_callback(id){
  	$.ajax({

    		url:"controller/controller.org.php?deletelocation",
    		method:"POST",
    		data:{
    			id:id
    		},success:function(){
    		$.Toast("Successfully Deleted", errorToast);
    		$('#tbl_locations').DataTable().destroy();
				load_locations();
    		}

  		});
  }

  function btn_updatelocation(){


  var modal_id = $('#modal_id').val();
	var modal_name = $('#modal_name').val();
	var modal_city = $('#modal_city').val();
	var modal_country = $('#modal_country').val();
	var modal_phone = $('#modal_phone').val();
	var modal_noofemployee = $('#modal_noofemployee').val();


  	$.ajax({
		url:"controller/controller.org.php?updatelocation",
		method:"POST",
		data:{
			modal_id: modal_id,
			modal_name: modal_name,
			modal_city: modal_city,
			modal_country: modal_country,
			modal_phone: modal_phone,
			modal_noofemployee: modal_noofemployee
		},success:function(){
			$.Toast("Successfully Saved", successToast);
			$('#tbl_locations').DataTable().destroy();
			load_locations();
			$('#location_modal').modal('hide');
		}
	});
  	
  }

	function updategeninfo(){
		confirmed("save",updategeninfo_callback, "Do you really want to change this?", "Yes", "No");
	}

	function updategeninfo_callback(){
			var org_name = $('#org_name').val();
			var tax_id = $('#tax_id').val();
			var numberof_emp = $('#numberof_emp').val();
			var reg_number = $('#reg_number').val();
			var cost_center = $('#cost_center').val();
			var cost_center_detail = $('#cost_center_detail').val();
			var contact_details = $('#contact_details').val();
			var fax = $('#fax').val();
			var email = $('#email').val();
			var address_st = $('#address_st').val();
			var brgy = $('#brgy').val();
			var city = $('#city').val();
			var zipcode = $('#zipcode').val();
			var country = $('#country').val();
			var note = $('#note').val();
			
			$.ajax({
				url:"controller/controller.org.php?updategeninfo",
				method:"POST",
				data:{
					id: "1",
					org_name: org_name,
					tax_id: tax_id,
					numberof_emp: numberof_emp,
					reg_number: reg_number,
					cost_center: cost_center,
					cost_center_detail: cost_center_detail,
					contact_details: contact_details,
					fax: fax,
					email: email,
					address_st: address_st,
					brgy: brgy,
					city: city,
					zipcode: zipcode,
					country: country,
					note: note
				},success:function(){
					$.Toast("Successfully Saved", successToast);
					window.location.href="organization.php";
				}
			});	
	}

	function btngen_info(){
		$("#lgen_info").addClass("active");
		$("#llocations").removeClass("active");

		$('#div_gen_info').show();
		$('#div_locations').hide();
	}
	function btnlocations(){
		$("#lgen_info").removeClass("active");
		$("#llocations").addClass("active");

		$('#div_gen_info').hide();
		$('#div_locations').show();
	}

	function load_locations(){
    
    $('#tbl_locations').DataTable({  
              "aaSorting": [],
              "bSearching": true,
              "bFilter": true,
              "bInfo": true,
              "bPaginate": true,
              "bLengthChange": true,
              "pagination": true,
              "ajax" : "controller/controller.org.php?load_locations",
              "columns" : [
                    
                    { "data" : "name"},
                    { "data" : "city"},
                    { "data" : "country"},
                    { "data" : "phone"},
                    { "data" : "numberofemp"},
                    { "data" : "action"}

                ],
         });
  }
  load_locations();

  function backmodule(){
  	window.location.href="module.php";
  }

  function goto(linkk){
	window.location.href=linkk;
  }
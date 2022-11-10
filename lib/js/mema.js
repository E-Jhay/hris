$(function(){
	// responsiveTable();

	$('.logout').on('click',function(){
                
                confirmed(logOut, "Do you really want to log-out?", "Yes", "Cancel");
    });
    $('.logout-mobile').on('click',function(){
                
                confirmed(logOut, "Do you really want to log-out?", "Yes", "Cancel");
    });

    $('input').attr("autocomplete","off")
    
})

function logOut(){
	window.location.href="login.php";
}

function dataTable_load(id,mode,columns,show_entries){
	$(""+id+"").DataTable().destroy();
	$(""+id+"").DataTable({ 
		 "pageLength": show_entries,
		 "ordering": true,
         "ajax" : "controller/"+mode,
         "columns" : columns,
    });

}

function post_Data(mode,columns){
	 var b;
	 $.ajax({
	   url:"controller/"+mode,
	   method:"POST",
	   async: false,
	   data:columns,
	   success:function(data){
	    b = $.parseJSON(data);
	   
	   }
	 });

 	 return b;

}

function get_Data(mode){
	 var b;
	 $.ajax({
	   url:"controller/"+mode,
	   method:"GET",
	   async: false,
	   success:function(data){
	    b = $.parseJSON(data);
	   
	   }
	 });

 	 return b;

}

function fetch_Data(mode,columns){
	 var b;
	 $.ajax({
	   url:"controller/"+mode,
	   method:"POST",
	   async: false,
	   data:columns,
	   success:function(data){
	    b = data;
	   
	   }
	 });

 	 return b;

}

// function responsiveTable(){

// 	$('table').each(function(){
// 		$(this).wrap('<div class="responsive-table"></div>');
// 	})

// } 
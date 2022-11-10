$(function(){
    adjustText('.rowx h4');  
    adjustText('.sidebar a');
    adjustText('.labellgroup *, .label4group *');
    hideEmptyEl('.sidebar a span');
})

function adjustText(selector){

    var $t = $(selector);
    $.each($t, function(){

        var t = $(this).clone().children().remove().end().text();
        elemshtml = '';
        $(this).children('i').each(function(){  elemshtml +=$(this)[0].outerHTML });
        $(this).children('span').each(function(){ 
            if($(this).text().trim() !== "") { elemshtml +=$(this)[0].outerHTML }
        });
        $(this).html(elemshtml  + t.toLowerCase()).css({'text-transform' : 'capitalize'});;
    })
}

function toggleLoad(){
   return $('.i-loader').fadeToggle(100);
}

function hideEmptyEl(selector){

    if("" !=  $(selector).text().trim()) {
        $(selector).fadeIn(100);
    }
}

$(function(){
    $('#category-dances').sortable();
    $('#tur-dances').sortable();
    $('#category-chesses_list').sortable();
});

$('.showTrener').click(function(){
//    if ($(this).find('i').hasClass('glyphicon-plus')) {
        $(this).find('i').toggleClass('glyphicon-minus').toggleClass('glyphicon-plus');
        $('#' + $(this).attr('class').slice(11)).slideToggle(100).find('input').val('');
        
        
//        var trener_count = parseInt($("div#trener_list>div:last-child").attr("id").slice(7));
//        var new_id = 'trener_' + (trener_count + 1);
//        var last_id = '#trener_' + trener_count;
//        $(last_id).clone(true).appendTo( "#trener_list" ).attr('id', new_id).find('input').val('');
//        $(last_id).find('i').toggleClass('glyphicon-minus').toggleClass('glyphicon-plus');
//    } else {
//        $(this).parent().remove();
//    }   
//    
//    $('#trener_list>div').each(function(index, element){
//        var newClass = 'field-in-dancer_trener-' + index + '-sname';
//        $(element).children().removeClass().addClass('form-group').addClass(newClass);
//    })
    
}) 
    
    
    //  $( "div.field-in-dancer_trener-0-name" ).clone().appendTo( "#trener_list" );
    //  $("div#add_field_area").append("<div id="add" telnum "" class="add"><label> Поле №" telnum "</label><input type="text" width="120" name="val[]" id="val"  value=""/></div>");
    


$('.colaps').click(function(){
    $(this).nextUntil('tr.colaps').slideToggle(100);
});


//
//
//$('.next_trener').click(function(){
//    if ($(this).parent().next().is(':visible') or ){
//        $(this).parent().slideToggle(100);
//    } else {
//        $(this).parent().next().slideToggle(100).children().children().children('input').val('');
//    }
//    $(this).find('i').toggleClass('glyphicon-minus').toggleClass('glyphicon-plus');
//    
////    $(this).parent().next().find('i').toggleClass('glyphicon-minus').toggleClass('glyphicon-plus');
//});

$(function(){
    $('#category-dances').sortable();
    $('#tur-dances').sortable();
    $('#category-chesses_list').sortable();
});

function addField () {
  
    $( "#trener_1" ).clone().appendTo( "#trener_list" ).attr('id', 'trener_2');
    //  $( "div.field-in-dancer_trener-0-name" ).clone().appendTo( "#trener_list" );
    //  $("div#add_field_area").append("<div id="add" telnum "" class="add"><label> Поле №" telnum "</label><input type="text" width="120" name="val[]" id="val"  value=""/></div>");
    var trener_num = parseInt($("#trener_list").find("div#trener_1:last").attr("id").slice(7));
    alert (trener_num);
  
}

$('.colaps').click(function(){
    $(this).nextUntil('tr.colaps').slideToggle(100);
});
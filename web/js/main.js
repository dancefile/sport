
$(function(){
    $('#category-dances').sortable();
    $('#tur-dances').sortable();
    $('#category-chesses_list').sortable();
});

$('.showTrener').click(function(){
        $(this).find('i').toggleClass('glyphicon-minus').toggleClass('glyphicon-plus');
//        $('#' + $(this).attr('class').slice(11)).slideToggle(100).find('input').val('');
        $('#' + $(this).attr('class').slice(11)).slideToggle(100);
});

//$(document).ready(function(){
//    $.each($('.trenerItem'), function(){
//        if ($(this).find('input').val()){
//            $(this).attr('display', 'block');
//        }
//    });
    
//    $.each($('.trenerItem'), function(){
//        if ($(this).find('input.tt-input').val()!==''){
//            $(this).css('display', 'block');
//        }
//    });
//    if ($('.trenerItem').find('input').val()){
//        $('.showTrener').find('i').toggleClass('glyphicon-minus').toggleClass('glyphicon-plus');
//    }
//});
    
$('.colaps').click(function(){
    $(this).nextUntil('tr.colaps').slideToggle(100);
});



$(function(){
    
    $('.registration_tur_item input').change(function(){
        var str = '';
        $('.registration_tur_item').each(function(){
            if ($(this).children('input').val()){
                str += "№" + $(this).children('input').val() + " - " + $(this).children('label').html() + ', ';
            }
        })
        
        $('.list_registrations').replaceWith('<p class="list_registrations">' + str + '</p>');
//        $str = $('.registration_tur_item input').val() + " - " + $('.registration_tur_item label').html();
//        alert("#" + $(this).val() + " - " + $(this).parent().next().html());
    });
})

$(document).ready(function(){
    var str = '';
    $('.registration_tur_item').each(function(){
        if ($(this).children('input').val()){
            str += "<span>№" + $(this).children('input').val() + "</span> - " + $(this).children('label').html() + ', ';
        }
    })

    $('.list_registrations').replaceWith('<p class="list_registrations">' + str + '</p>');
})

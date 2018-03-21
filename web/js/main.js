
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
    });
})


$(document).ready(function(){
    var str = '';
    $('.registration_tur_item').each(function(){
        if ($(this).children('input').val()){
            str += "<span>№" + $(this).children('input').val() + "</span> - " + 
                    '<a href="#' + $(this).parent().attr("id") + '" data-toggle="tab">' + $(this).children('label').html() + '</a>, ';
        }
    })

    $('.list_registrations').replaceWith('<p class="list_registrations">' + str + '</p>');
})


//var loc = window.location.hash;
//if (loc != "") {
//        var href = loc;
//        var target = $('.nav-tabs').find(href);
//        $('.nav-tabs li').removeClass('active');
//        $('.nav-tabs a[href="'+href  +'"]').addClass('active');
//        $('.content-fade .content-fade-panel').hide();
//        $(target).fadeIn('fast');
//}
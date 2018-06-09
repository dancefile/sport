
$(function () {
    $('#category-dances').sortable();
    $('#tur-dances').sortable();
    $('#category-chesses_list').sortable();
});

$('.showTrener').click(function () {
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

$('.colaps').click(function () {
    $(this).nextUntil('tr.colaps').slideToggle(100);
});




$(function () {
    $('.registration_tur_item input').change(function () {
//        onFlyImg = new Image();
//	onFlyImg.src = "/registration/check";

        var str = '';
        $('[id ^="w1-"]>.registration_tur_item').each(function () {
            if ($(this).children('input').val()) {
                str += "<span>№" + $(this).children('input').val() + "</span> - " +
                        '<a href="#' + $(this).parent().attr("id") +
                        '" data-toggle="tab">' + $(this).children('label').html() + '</a>, ';
            }
        })

        $('.list_registrations').
                replaceWith('<p class="list_registrations">' + str + '</p>');

        var str = '';
        $('.number_m').each(function () {
            if ($(this).val()) {
                str += "<span>№" + $(this).val() + "</span> - " +
                        '<a href="#' + $(this).parent().parent().attr("id") + '" data-toggle="tab">' +
                        $(this).parent().find('label').html() + '</a>, ';
            }
        })

        $('.list_registrations_solo_M').
                replaceWith('<p class="list_registrations_solo_M">' + str + '</p>');
        var str = '';
        $('.number_w').each(function () {
            if ($(this).val()) {
                str += "<span>№" + $(this).val() + "</span> - " +
                        '<a href="#' + $(this).parent().parent().attr("id") + '" data-toggle="tab">' +
                        $(this).parent().find('label').html() + '</a>, ';
            }
        })

        $('.list_registrations_solo_W').
                replaceWith('<p class="list_registrations_solo_W">' + str + '</p>');
    });
})


$(document).ready(function () {
    var str = '';
    $('[id ^="w1-"]>.registration_tur_item').each(function () {
        if ($(this).children('input').val()) {
            str += "<span>№" + $(this).children('input').val() + "</span> - " +
                    '<a href="#' + $(this).parent().attr("id") + '" data-toggle="tab">' +
                    $(this).children('label').html() + '</a>, ';
        }
    })

    $('.list_registrations').
            replaceWith('<p class="list_registrations">' + str + '</p>');

    var str = '';
    $('.number_m').each(function () {
        if ($(this).val()) {
            str += "<span>№" + $(this).val() + "</span> - " +
                    '<a href="#' + $(this).parent().parent().attr("id") + '" data-toggle="tab">' +
                    $(this).parent().find('label').html() + '</a>, ';
        }
    })

    $('.list_registrations_solo_M').
            replaceWith('<p class="list_registrations_solo_M">' + str + '</p>');
    var str = '';
    $('.number_w').each(function () {
        if ($(this).val()) {
            str += "<span>№" + $(this).val() + "</span> - " +
                    '<a href="#' + $(this).parent().parent().attr("id") + '" data-toggle="tab">' +
                    $(this).parent().find('label').html() + '</a>, ';
        }
    })

    $('.list_registrations_solo_W').
            replaceWith('<p class="list_registrations_solo_W">' + str + '</p>');
})

$('.rightBlock').delegate('p>a', 'click', function () {

    $('#tab a[href="' + $(this).attr('href') + '"]').tab('show');

    var a;
    a = $('li>a[href="' + $(this).attr('href') + '"]');
    a.parents('ul').find('li.active').removeClass();
    a.parent('li').addClass('active');
});



$(function () {
    var suggest_count = 0;
    var input_initial_value = '';
    var suggest_selected = 0;
    var id_search = '';
    var lastnomer = '';


    function chek_kat()
    {
        var msg = $("form").serialize();

        $.ajax({
            type: 'POST',
            url: 'ajax_kat.php',
            data: msg,
            success: function (data) {
                $('#results').html(data);
                //  alert(data);
                //  $("."+program).addClass("dis");
                //  list = jQuery.parseJSON(data);
                // for(var i in list){
                //  $('#'+program+list[i]).removeClass('dis');
                //}				//	if(list[i].name != '' 
            },
            error: function (xhr, str) {
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });
    }
    ;




function get_current_age(date) {
var d = date.split('-');
if( typeof d[2] !== "undefined" ){
    date = d[2]+'.'+d[1]+'.'+d[0];
    return ((new Date().getTime() - new Date(date)) / (24 * 3600 * 365.25 * 1000)) | 0;
}
return 0;
}

});

function find_in(data, dancer_sufix) {
    $.ajax({
       url: "/in/find-by-dancer-id",
       data: {dancer_id: data.id},
       dataType: "json",
       success: function(ins){
                    var update = false;
                    if (ins.id > 0){
                        update = confirm(
                                'Найдена зарегистрированная пара' +
                                '\n№-'+ ins.number +
                                '\n' + ins.dancer1_sname + ' ' + ins.dancer1_name +
                                '\n' + ins.dancer2_sname + ' ' + ins.dancer2_name +                                                                
                                "\n\nРедактировать?");
                    };
                    if (update){
                        window.location.href = "/registration/update?id=" + ins.id;
                    } else {
                        $("#registration-"+dancer_sufix+"_id").val(data.id);
                        $("#registration-"+dancer_sufix+"_name").val(data.name);
                        $("#registration-"+dancer_sufix+"_date-disp").val($.datepicker.formatDate("dd-mm-yy", new Date(data.date)));
                        $("#registration-"+dancer_sufix+"_date").val($.datepicker.formatDate("yy-mm-dd", new Date(data.date)));
                        $("#registration-"+dancer_sufix+"_class_st").val(data.clas_id_st);
                        $("#registration-"+dancer_sufix+"_class_la").val(data.clas_id_la);
                        $("#registration-"+dancer_sufix+"_booknumber").val(data.booknumber); 
                    };
                    switch (dancer_sufix){
                        case 'd1':
                            $('#registration-d2_sname').focus();
                            break;
                        case 'd2':
                            $('#registration-club').focus();
                            break;
                    }
                }
    });
}
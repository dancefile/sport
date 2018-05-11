
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



        $("#zayavka").keydown(function (event) {
            if (event.keyCode == 13) {
                id_search = 'zayavka';
                loaddancer($(this).val(), 1);
            }
            ;
        });


        $("form").keydown(function (event) {
            if (event.keyCode == 13) {
                if ("registration-d1_sname" == $(event.target).attr('id')) {
                    var tmp = $(event.target).val();
                    arr = tmp.split(' ');
                    $(event.target).val(arr[0]);
                    $('#registration-d1_name').val(arr[1]);
                    if (arr[1])
                        $('#registration-d1_date').focus();
                    else
                        $('#registration-d1_name').focus();
                }
                ;
                if ("registration-d2_sname" == $(event.target).attr('id')) {
                    var tmp = $(event.target).val();
                    arr = tmp.split(' ');
                    $(event.target).val(arr[0]);
                    $('#registration-d1_name').val(arr[1]);
                    if (arr[1])
                        $('#registration-d2_date').focus();
                    else
                        $('#registration-d1_name').focus();
                }
                ;
                if ("registration-d1_class_st" == $(event.target).attr('id')) {
                    var tmp = $(event.target).val();
                    $('#registration-d2_class_st').val(tmp);
                    $('#registration-d1_class_la').val(tmp);
                    $('#registration-d2_class_la').val(tmp);
                }
                ;

                if ("t_l_1" == $(event.target).attr('id')) {
                    if ($(event.target).val() == '')
                        $(event.target).val($("#t_s_1").val());
                }
                ;
                if ("t_l_2" == $(event.target).attr('id')) {
                    if ($(event.target).val() == '')
                        $(event.target).val($("#t_s_2").val());
                }
                ;
                if ("t_l_3" == $(event.target).attr('id')) {
                    if ($(event.target).val() == '')
                        $(event.target).val($("#t_s_3").val());
                }
                ;



                // alert($( event.target ).attr('id'));
                event.preventDefault();
                $('#search_advice_wrapper').hide();
                return false;
            }
        });

        // читаем ввод с клавиатуры
        $("#registration-d1_sname, #registration-d2_sname, #registration-club, #registration-city, #registration-d_trener1_sname, #registration-d_trener2_sname, #registration-d_trener3_sname, #registration-d_trener4_sname, #registration-d_trener5_sname, #registration-d_trener6_sname").
                keyup(function (I) {
            //alert('data');
            // определяем какие действия нужно делать при нажатии на клавиатуру
            switch (I.keyCode) {
                // игнорируем нажатия на эти клавишы
                case 13:  // enter
                case 27:  // escape
                case 38:  // стрелка вверх
                case 40:  // стрелка вниз
                    break;

                default:

                    loc = $(this).offset();
                    // производим поиск только при вводе более 2х символов
                    if ($(this).val().length > 0) {
                        id_search = $(this).attr('id');
                        input_initial_value = $(this).val();
                        // производим AJAX запрос к /ajax/ajax.php, передаем ему GET query, в который мы помещаем наш запрос
                        $.get("/in/dancer-list", {"q": $(this).val(), "id_search": id_search}, function (data) {
                            list = jQuery.parseJSON(data);
                            // $("#"+id_search).val(data);
                            suggest_count = list.length;
                            if (suggest_count > 0) {
                                // перед показом слоя подсказки, его обнуляем
                                $("#search_advice_wrapper").html("").show();
                                $('#search_advice_wrapper').offset({top: loc.top + 23, left: loc.left});
                                for (var i in list) {
                                    if (list[i].name != '') {
                                        // добавляем слою позиции
                                        $('#search_advice_wrapper').append('<div class="advice_variant advice_variant' + list[i].type + '" id="' + list[i].id + '" ttype="' + list[i].type + '">' + list[i].name + '</div>');
                                    }
                                }
                            } else {$('#search_advice_wrapper').hide();}
                        }, 'html');
                    }
                    break;
            }
        });

        //считываем нажатие клавишь, уже после вывода подсказки
        $("#registration-d1_sname, #registration-d2_sname, #registration-club, #registration-city, #registration-d_trener1_sname, #registration-d_trener2_sname, #registration-d_trener3_sname, #registration-d_trener4_sname, #registration-d_trener5_sname, #registration-d_trener6_sname").keydown(function (I) {
            switch (I.keyCode) {
                // по нажатию клавишь прячем подсказку
                case 13: // enter
                    if ($(this).hasClass("simple")) {
                        $(this).val(list[suggest_selected - 1].name);
                    } else {
                        loaddancer(list[suggest_selected - 1].id, list[suggest_selected - 1].type);
                    }

                    //alert(list[suggest_selected-1].id);
                case 27: // escape
                    $('#search_advice_wrapper').hide();
                    return false;
                    break;
                    // делаем переход по подсказке стрелочками клавиатуры
                case 38: // стрелка вверх
                case 40: // стрелка вниз
                    I.preventDefault();
                    if (suggest_count) {
                        //делаем выделение пунктов в слое, переход по стрелочкам
                        key_activate(I.keyCode - 39);
                    }
                    break;
            }
        });

        // делаем обработку клика по подсказке
        $('#search_advice_wrapper').on('click', '.advice_variant', function () {
            // ставим текст в input поиска
            //alert($(this).attr('ttype'));
            //	$('#search_box').val($(this).text());
            //
            if ($('#' + id_search).hasClass("simple")) {
                $('#' + id_search).val($(this).text());
            } else {
                loaddancer($(this)[0].id, $(this).attr('ttype'));
            }

            // прячем слой подсказки
            $('#search_advice_wrapper').fadeOut(350).html('');
        });

        // если кликаем в любом месте сайта, нужно спрятать подсказку


        $('html').click(function () {
            $('#search_advice_wrapper').hide();
        });
        $(".cuplenomer").focusout(function () {
            lastnomer = $(this).val();
        });

        $('.cuplenomer').click(function () {
            //	alert('a');
            if (($(this).val() == '' || $(this).val() == 'XX') && (lastnomer != ''))
                $(this).val(lastnomer);
        });

        // если кликаем на поле input и есть пункты подсказки, то показываем скрытый слой
        $('.search_box').click(function (event) {
            //alert(suggest_count);
            loc = $(this).offset();
            var id_search_new = $(this).attr('id');
            if (id_search != id_search_new) {
                id_search = id_search_new;
                suggest_count = 0;
                suggest_selected = 0;
                $('#search_advice_wrapper').hide();
            }
            if (suggest_count) {

                $('#search_advice_wrapper').show();
                $('#search_advice_wrapper').offset({top: loc.top + 23, left: loc.left});
            }
            event.stopPropagation();
        });
  //  });

    function key_activate(n) {
        $('#search_advice_wrapper div').eq(suggest_selected - 1).removeClass('active');

        if (n == 1 && suggest_selected < suggest_count) {
            suggest_selected++;
        } else if (n == -1 && suggest_selected > 0) {
            suggest_selected--;
        }

        if (suggest_selected > 0) {
            $('#search_advice_wrapper div').eq(suggest_selected - 1).addClass('active');
            //$("#search_box").val( $('#search_advice_wrapper div').eq(suggest_selected-1).text() );
            //loaddancer(list[suggest_selected-1].id);
        } else {
            $("#search_box").val(input_initial_value);
        }
    }

    function loaddancer(id, type)
    {//if (typeof(id) != "undefined")

        $.ajax({url: "/in/dancer-info?id=" + id + "&id_search=" + id_search + "&type=" + type,
            timeout: 3000}).done(
                function (result, status) {
                    $('#results').html(result);
                    if (result.length > 0) {

                        var json = jQuery.parseJSON(result);
                        //  alert(json.kniga_m);
                        if (typeof (json.registration_d1_sname) != "undefined") {
                            $("#registration-d1_sname").val(json.registration_d1_sname);
                        }
                        if (typeof (json.registration_d1_name) != "undefined") {
                            $("#registration-d1_name").val(json.registration_d1_name);
                        }
                      if (typeof (json.registration_d2_sname) != "undefined") {
                            $("#registration-d2_sname").val(json.registration_d2_sname);
                        }
                        if (typeof (json.registration_d2_name) != "undefined") {
                            $("#registration-d2_name").val(json.registration_d2_name);
                        }
                        
                        if (typeof (json.trener1_sname) != "undefined") {
                         
                            $("#registration-d_trener1_sname").val(json.trener1_sname);
                            
                        }
                        if (typeof (json.trener2_sname) != "undefined") {
                            $("#registration-d_trener2_sname").val(json.trener2_sname);
                        }
                        
                        if (typeof (json.trener2_sname) != "undefined") {
                            $("#registration-d_trener2_sname").val(json.trener2_sname);
                        }
                        
                        if (typeof (json.trener3_sname) != "undefined") {
                            $("#registration-d_trener3_sname").val(json.trener3_sname);
                        }
                        
                        if (typeof (json.trener4_sname) != "undefined") {
                            $("#registration-d_trener4_sname").val(json.trener4_sname);
                        }
                        
                        if (typeof (json.trener5_sname) != "undefined") {
                            $("#registration-d_trener5_sname").val(json.trener5_sname);
                        }
                        
                        if (typeof (json.trener6_sname) != "undefined") {
                            $("#registration-d_trener6_sname").val(json.trener6_sname);
                        }
                        
                        if (typeof (json.trener1_name) != "undefined") {
                            $("#registration-d_trener1_name").val(json.trener1_name);
                        }
                        if (typeof (json.trener2_name) != "undefined") {
                            $("#registration-d_trener2_name").val(json.trener2_name);
                        }
                        
                        if (typeof (json.trener2_name) != "undefined") {
                            $("#registration-d_trener2_name").val(json.trener2_name);
                        }
                        
                        if (typeof (json.trener3_name) != "undefined") {
                            $("#registration-d_trener3_name").val(json.trener3_name);
                        }
                        
                        if (typeof (json.trener4_name) != "undefined") {
                            $("#registration-d_trener4_name").val(json.trener4_name);
                        }
                        
                        if (typeof (json.trener5_name) != "undefined") {
                            $("#registration-d_trener5_name").val(json.trener5_name);
                        }
                        
                        if (typeof (json.trener6_name) != "undefined") {
                            $("#registration-d_trener6_ame").val(json.trener6_name);
                        }
                        
                        
                        if (typeof (json.date_m) != "undefined") {
                            $("#date_m").val(json.date_m);
                            $("#date_m").removeClass("red_input");
                        }
                        if (typeof (json.clas_st_m) != "undefined") {
                            $("#clas_st_m").val(json.clas_st_m);
                            $("#clas_st_m").removeClass("red_input");
                        }
                        if (typeof (json.clas_la_m) != "undefined") {
                            $("#clas_la_m").val(json.clas_la_m);
                            $("#clas_la_m").removeClass("red_input");
                        }
                        if (typeof (json.sname_w) != "undefined") {
                            $("#sname_w").val(json.sname_w);
                            $("#sname_w").removeClass("red_input");
                        }
                        if (typeof (json.name_w) != "undefined") {
                            $("#name_w").val(json.name_w);
                            $("#name_w").removeClass("red_input");
                        }
                        if (typeof (json.date_w) != "undefined") {
                            $("#date_w").val(json.date_w);
                            $("#date_w").removeClass("red_input");
                        }
                        if (typeof (json.clas_st_w) != "undefined") {
                            $("#clas_st_w").val(json.clas_st_w);
                            $("#clas_st_w").removeClass("red_input");
                        }
                        if (typeof (json.clas_la_w) != "undefined") {
                            $("#clas_la_w").val(json.clas_la_w);
                            $("#clas_la_w").removeClass("red_input");
                        }
                        if (typeof (json.kniga_w) != "undefined") {
                            $("#kniga_w").val(json.kniga_w);
                            $("#kniga_w").removeClass("red_input");
                        }
                        if (typeof (json.club1) != "undefined") {
                            $("#club1").val(json.club1);
                            $("#club1").removeClass("red_input");
                        }
                        if (typeof (json.sity1) != "undefined") {
                            $("#sity1").val(json.sity1);
                            $("#sity1").removeClass("red_input");
                        }
                        if (typeof (json.country1) != "undefined") {
                            $("#country1").val(json.country1);
                            $("#country1").removeClass("red_input");
                        }
                        if (typeof (json.club2) != "undefined") {
                            $("#club2").val(json.club2);
                        }
                        if (typeof (json.sity2) != "undefined") {
                            $("#sity2").val(json.sity2);
                        }
                        if (typeof (json.country2) != "undefined") {
                            $("#country2").val(json.country2);
                        }
                        if (typeof (json.t_s_1) != "undefined") {
                            $("#t_s_1").val(json.t_s_1);
                        }
                        if (typeof (json.t_s_2) != "undefined") {
                            $("#t_s_2").val(json.t_s_2);
                        }
                        if (typeof (json.t_s_3) != "undefined") {
                            $("#t_s_3").val(json.t_s_3);
                        }
                        if (typeof (json.t_l_1) != "undefined") {
                            $("#t_l_1").val(json.t_l_1);
                        }
                        if (typeof (json.t_l_2) != "undefined") {
                            $("#t_l_2").val(json.t_l_2);
                        }
                        if (typeof (json.t_l_3) != "undefined") {
                            $("#t_l_3").val(json.t_l_3);
                        }
                        //  chek_kat();
                        if (typeof (json.kat) != "undefined") {
                            var arr = json.kat.split(';');
                            jQuery.each(arr, function () {
                                var kat = $.trim(this);
                                if (kat.length > 0) {
                                    //$("#" + this).text("Mine is " + this + ".");
                                    //alert(this);
                                    $("#nomer" + kat).val('XX');
                                    // return (this != "three"); // Выйти из цикла после "three"
                                }
                                ;
                            });
                        }
                    }

                });// else {alert(id_search);}
    }
});


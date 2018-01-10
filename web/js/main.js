
$(function(){
    $('#category-dances').sortable();
    $('#tur-dances').sortable();

    $('#category-chesses_list').sortable();
    // if ($("#category-solo inpur:radio").value = 2) {alert('rere')};

    // $("input:radio").click(function(){
    // 	alert ('gfgfg');
    // });
});

    

// $(function () {
//     $('#regButton').click(function(){
//         $.post(
//             [ "create", 
//                 {
//                     turList : $('#grid-reg').yiiGridView('getSelectedRows')
//             },]

//         );

//     });

// });

$('.colaps').click(function(){
    $(this).nextUntil('tr.colaps').slideToggle(100);
});
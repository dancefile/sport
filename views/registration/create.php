<?php

use yii\helpers\Html;

$this->registerJsFile('@web/js/jquery-ui.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile('@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerCssFile('@web/css/jquery-ui.css');


/* @var $this yii\web\View */
/* @var $model app\models\In */

//$this->title = 'Create In';
$this->params['breadcrumbs'][] = ['label' => 'Ins', 'url' => ['in/index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        
	]) ?>
 	
 	
</div>

<?php 
/*
<script type="text/javascript">
var suggest_count = 0;
var input_initial_value = '';
var suggest_selected = 0;
var id_search='';
var lastnomer='';


function chek_kat()
{

  var msg   = $("form").serialize();

      	   $.ajax({
          type: 'POST',
          url: 'ajax_kat.php',
          data: msg,
          success: function(data) {
            $('#results').html(data);
          //  alert(data);
         //  $("."+program).addClass("dis");
          //  list = jQuery.parseJSON(data);
          // for(var i in list){
          //  $('#'+program+list[i]).removeClass('dis');
			//}				//	if(list[i].name != '' 
          },
          error:  function(xhr, str){
	    alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });
};



window.onload=function(){
	
	
// читаем ввод с клавиатуры
	$("#registration-d1_sname").keyup(function(I){
		//alert('data');
		// определяем какие действия нужно делать при нажатии на клавиатуру
		switch(I.keyCode) {
			// игнорируем нажатия на эти клавишы
			case 13:  // enter
			case 27:  // escape
			case 38:  // стрелка вверх
			case 40:  // стрелка вниз
			break;

			default:
			
			loc=$(this).offset();
				// производим поиск только при вводе более 2х символов
				if($(this).val().length>1){
					// производим AJAX запрос к /ajax/ajax.php, передаем ему GET query, в который мы помещаем наш запрос
					$.get("search", { "query":$(this).val() },function(data){
alert(data);/*
					   list = jQuery.parseJSON(data);
					 // $("#"+id_search).val(data);
						suggest_count = list.length;
						if(suggest_count > 0){
							// перед показом слоя подсказки, его обнуляем
							$("#search_advice_wrapper").html("").show();
							$('#search_advice_wrapper').offset({top:loc.top+23, left:loc.left});
							for(var i in list){
								if(list[i].name != ''){
									// добавляем слою позиции
									$('#search_advice_wrapper').append('<div class="advice_variant advice_variant'+list[i].type+'" id="'+list[i].id+'" ttype="'+list[i].type+'">'+list[i].name+'</div>');
								}
							}
						}
					}, 'html');
				}
			break;
		}
	});

	//считываем нажатие клавишь, уже после вывода подсказки
	$(".search_box").keydown(function(I){
		switch(I.keyCode) {
			// по нажатию клавишь прячем подсказку
			case 13: // enter
			if ( $(this).hasClass("simple") ) {$(this).val(list[suggest_selected-1].name);} else {
			loaddancer(list[suggest_selected-1].id,list[suggest_selected-1].type);}
			
			//alert(list[suggest_selected-1].id);
			case 27: // escape
				$('#search_advice_wrapper').hide();
				return false;
			break;
			// делаем переход по подсказке стрелочками клавиатуры
			case 38: // стрелка вверх
			case 40: // стрелка вниз
				I.preventDefault();
				if(suggest_count){
					//делаем выделение пунктов в слое, переход по стрелочкам
					key_activate( I.keyCode-39 );
				}
			break;
		}
	});

	// делаем обработку клика по подсказке
	$('#search_advice_wrapper').on('click','.advice_variant',function(){
		// ставим текст в input поиска
		//alert($(this).attr('ttype'));
	//	$('#search_box').val($(this).text());
	//
	if ( $('#'+id_search).hasClass("simple") ) {$('#'+id_search).val($(this).text());} else {
	loaddancer($(this)[0].id,$(this).attr('ttype'));}
	
		// прячем слой подсказки
		$('#search_advice_wrapper').fadeOut(350).html('');
	});

	// если кликаем в любом месте сайта, нужно спрятать подсказку

	
	$('html').click(function(){
		$('#search_advice_wrapper').hide();
	});
		$(".cuplenomer").focusout(function(){
			lastnomer=$(this).val();
		});
	
		$('.cuplenomer').click(function(){
		//	alert('a');
		if (($(this).val()=='' || $(this).val()=='XX') && (lastnomer!='')) $(this).val(lastnomer);
	});
	
	// если кликаем на поле input и есть пункты подсказки, то показываем скрытый слой
	$('.search_box').click(function(event){
		//alert(suggest_count);
		loc=$(this).offset();
		var id_search_new=$(this).attr('id');
		if (id_search!=id_search_new) {id_search =id_search_new;suggest_count=0;suggest_selected = 0;$('#search_advice_wrapper').hide();}
		if(suggest_count) {
			
			$('#search_advice_wrapper').show();
			$('#search_advice_wrapper').offset({top:loc.top+23, left:loc.left});
		}
		event.stopPropagation();
	});
};

function key_activate(n){
	$('#search_advice_wrapper div').eq(suggest_selected-1).removeClass('active');

	if(n == 1 && suggest_selected < suggest_count){
		suggest_selected++;
	}else if(n == -1 && suggest_selected > 0){
		suggest_selected--;
	}

	if( suggest_selected > 0){
		$('#search_advice_wrapper div').eq(suggest_selected-1).addClass('active');
		//$("#search_box").val( $('#search_advice_wrapper div').eq(suggest_selected-1).text() );
		//loaddancer(list[suggest_selected-1].id);
	} else {
		$("#search_box").val( input_initial_value );
	}
}

        function loaddancer(id,type)
        {//if (typeof(id) != "undefined")
            $.ajax({ url: "getdancer.php?id="+id+"&id_search="+id_search+"&type="+type,
                timeout: 3000 }).done(
                function (result, status) {
                $('#results').html(result);
                      if (result.length >0){
                        
                        var json = jQuery.parseJSON(result);
                      //  alert(json.kniga_m);
                         if (typeof(json.sname_m) != "undefined")  {$("#sname_m").val(json.sname_m);$("#sname_m").removeClass("red_input");}           
                         if (typeof(json.name_m) != "undefined") {$("#name_m").val(json.name_m);$("#name_m").removeClass("red_input");}
                         if (typeof(json.date_m) != "undefined") {$("#date_m").val(json.date_m);$("#date_m").removeClass("red_input");}
                         if (typeof(json.clas_st_m) != "undefined") {$("#clas_st_m").val(json.clas_st_m);$("#clas_st_m").removeClass("red_input");}
                         if (typeof(json.clas_la_m) != "undefined") {$("#clas_la_m").val(json.clas_la_m);$("#clas_la_m").removeClass("red_input");} 
                         if (typeof(json.kniga_m) != "undefined") {$("#kniga_m").val(json.kniga_m);$("#kniga_m").removeClass("red_input");} 
                         if (typeof(json.sname_w) != "undefined") {$("#sname_w").val(json.sname_w);$("#sname_w").removeClass("red_input");}             
                         if (typeof(json.name_w) != "undefined") {$("#name_w").val(json.name_w);$("#name_w").removeClass("red_input");}
                         if (typeof(json.date_w) != "undefined") {$("#date_w").val(json.date_w);$("#date_w").removeClass("red_input");}
                         if (typeof(json.clas_st_w) != "undefined") {$("#clas_st_w").val(json.clas_st_w);$("#clas_st_w").removeClass("red_input");}
                         if (typeof(json.clas_la_w) != "undefined") {$("#clas_la_w").val(json.clas_la_w);$("#clas_la_w").removeClass("red_input");}
                         if (typeof(json.kniga_w) != "undefined") {$("#kniga_w").val(json.kniga_w);$("#kniga_w").removeClass("red_input");} 
                         if (typeof(json.club1) != "undefined") {$("#club1").val(json.club1);$("#club1").removeClass("red_input");}
                         if (typeof(json.sity1) != "undefined") {$("#sity1").val(json.sity1);$("#sity1").removeClass("red_input");}
                         if (typeof(json.country1) != "undefined") {$("#country1").val(json.country1);$("#country1").removeClass("red_input");}
                         if (typeof(json.club2) != "undefined") {$("#club2").val(json.club2);}
                         if (typeof(json.sity2) != "undefined") {$("#sity2").val(json.sity2);} 
                         if (typeof(json.country2) != "undefined") {$("#country2").val(json.country2);}                        
                         if (typeof(json.t_s_1) != "undefined") {$("#t_s_1").val(json.t_s_1);}
                         if (typeof(json.t_s_2) != "undefined") {$("#t_s_2").val(json.t_s_2);}
                         if (typeof(json.t_s_3) != "undefined") {$("#t_s_3").val(json.t_s_3);}
                         if (typeof(json.t_l_1) != "undefined") {$("#t_l_1").val(json.t_l_1);}
                         if (typeof(json.t_l_2) != "undefined") {$("#t_l_2").val(json.t_l_2);}
                         if (typeof(json.t_l_3) != "undefined") {$("#t_l_3").val(json.t_l_3);}                         
         //  chek_kat();
         if (typeof(json.kat) != "undefined") {
         	var arr = json.kat.split(';');
         	jQuery.each(arr, function() {
         	var kat=$.trim(this);
         	if (kat.length >0){
      //$("#" + this).text("Mine is " + this + ".");
      //alert(this);
      $("#nomer"+kat).val('XX');
      // return (this != "three"); // Выйти из цикла после "three"
      };
     });
         	} 
                        }
                    
                });// else {alert(id_search);}
        }
</script>



<style>

		#search_advice_wrapper{
			display:none;
			width: 350px;
			background-color: rgb(80, 80, 80);
			color: rgb(255, 227, 189);
			-moz-opacity: 0.95;
			opacity: 0.95;
			-ms-filter:"progid:DXImageTransform.Microsoft.Alpha"(Opacity=95);
			filter: progid:DXImageTransform.Microsoft.Alpha(opacity=95);
			filter:alpha(opacity=95);
			z-index:999;
			position: absolute;
			top: 60px; left: 10px;
		}

		#search_advice_wrapper .advice_variant1{
			cursor: pointer;
			padding: 5px;
			text-align: left;
		}
		#search_advice_wrapper .advice_variant1:hover{
			color:#FEFFBD;
			background-color:#818187;
		}
				#search_advice_wrapper .advice_variant2{
			cursor: pointer;
			padding: 5px;
			text-align: left;
			color:#d3fb8e;
		}
		#search_advice_wrapper .advice_variant2:hover{
			color:#FEFFBD;
			background-color:#818187;
		}
		#search_advice_wrapper .active{
			cursor: pointer;
			padding: 5px;
			color:#FEFFBD;
			background-color:#818187;
		}
   
    </style>
<div id="search_advice_wrapper"></div>*/
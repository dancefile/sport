
    $(function(){
        $('#fruitContainer').sortable({
            connectWith: '#flowerContainer'
        });
        $('#flowerContainer').sortable({
            connectWith: '#fruitContainer'
        });
         
        $('#save').click(function() {
            var str='';
            var order = $('#fruitContainer').sortable("toArray");
            for (var i = 0; i < order.length; i++) {
            str=str+','+order[i].substr(6);
            }
            $('#dances').val(str);
        });
        
        
    });

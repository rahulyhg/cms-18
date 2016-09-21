/**
patient attach file Module
**/
var Patient = function () {
   
    // function image 
    
    var default_item_1 = '';
    var default_item_2 = '';
    var default_item_3 = '';

    var addImage = function() {
        $(document).on('click','.glyphicon-plus-1,.glyphicon-plus-2,.glyphicon-plus-3',function(){
           
            var num = $(this).attr('data-number');
            var type = $(this).attr('data-type');
            var n = $(this).attr('data-name');
            var item = addItem(num,type,n);
            $('#image-main-'+type+'').append(item);
            $(this).attr('data-number', parseInt(num) + 1);
        });
    }
    var addItem = function(num,type,name) {
        var item = default_item_1.clone();
        if(type == 2) {
          
            item = default_item_2.clone();
        }
        
        if(type == 3) {
             item = default_item_3.clone();
        }
        
        item.find('.image-imageFile').attr('name','Patient['+name+'_file][' + num + ']');
        item.find('.click-file-'+type).removeClass('hide');
        item.find('.image-id').remove();
        item.find('.file-text-show').remove();
        item.find('.image-description').attr('name','Patient['+name+'_description][' + num + ']');
        item.find('.image-description').val('');
        console.info(item);
        return item;
    }
    $(document).on('change','input[type=file]',function(){
        var type = $(this).attr('data-type');
        var img = $(this).parents('tr').find('.click-file-'+type);
        // var tmppath = URL.createObjectURL(event.target.files[0]);
        console.info(event.target.files[0].name);
        img.html('<i style="font-size: 40px;" class="glyphicon glyphicon-file"></i><p>'+event.target.files[0].name+'<p>');
       
    });

    $(document).on('click','.glyphicon-minus',function(){
        var id = $(this).parents('tr').find('.image-id').val();
        var this_value =  $('#delete_image').val();
        $('#delete_image').val(this_value + ',' + id);
        $(this).parents('tr').remove();
    });
            
    var sortImage = function() {
        $(document).on('click','.up, .down',function(e){
            e.preventDefault();
            var row = $(this).parents("tr:first");
            if($(this).is('.up')){
                row.insertBefore(row.prev());
            } else{
                row.insertAfter(row.next());
            }
        })
    }
        
        
    var FileClick = function() {
        $(document).on('click','.click-file-1,.click-file-2,.click-file-3', function(){
                
            $(this).prev('.image-imageFile').trigger('click');
        })
    }
    // public functions
    return {

        //main function
        init: function () { 
            default_item_1 = $('.image-item-1').first().clone();
            default_item_2 = $('.image-item-2').first().clone();
            default_item_3 = $('.image-item-3').first().clone();
            addImage();
            FileClick();
        
           
        }

    };
}();


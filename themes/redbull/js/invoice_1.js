/**
Quote Module
**/
var Invoice = function () {
   
    var changeService = function(){
        $(document).on('change','.item-service',function(){
            var elm = $(this);
            var parent = elm.parents('.invoice-item');
            var elm_quantity = parent.find('.item-quantity');
            var elm_price   = parent.find('.item-price');
            var _service_info = loadServiceInfo(elm.val()).responseJSON;
            if(_service_info){
                if(elm_quantity.val()=='' || elm_quantity.val()==null) {
                      elm_quantity.val('1');
                }
                elm_price.val(_service_info.price);
            } else {
                elm_quantity.val(0);
                elm_price.val(0);
            }
            totalRow(elm);
        });
    }
    
     var loadServiceInfo = function(service_id){
        return $.ajax({
                      method: "GET",
                      url: "/ajax/service-info",
                      dataType: 'json',
                      async: false,
                      data: {"id" : service_id}
                    });
    }
    
    var totalRow = function(elm){
        var parent = elm.parents('.invoice-item');
        var elm_quantity = parent.find('.quantity');
        var elm_price   = parent.find('.price');
        var elm_total   = parent.find('.total');
        var elm_price_quantity = parent.find('price_quantity');
        var elm_price_after_discount = parent.find('.price_after_discount');
        var discount = parent.find('.discount').val();
        var _price_quantity =  parseFloat(elm_quantity.val()) * parseFloat(elm_price.val());
        var _total = parseFloat(elm_quantity.val()) * parseFloat(elm_price.val());
        var _price_discount = parseFloat(_price_quantity) - (parseFloat(_price_quantity) * parseFloat(discount)/100);
        
        if(isNaN(_total)) {
           _total = 0;
        }
        if(isNaN(_price_quantity)) {
           _price_quantity = 0;
        }
         if(isNaN(_price_discount)) {
           _price_discount = 0;
        }
        elm_total.val(_total.toFixed(2));
        elm_price_quantity.val(_price_quantity.toFixed(2));
        elm_price_after_discount.val(_price_discount.toFixed(2));
        total();
        totalDisCount();
    }
    var total = function(){
        var total_rows = $('.total');
        var total = 0;
        $.each(total_rows,function(index,value){
            total += Number($(this).val().replace(/[^0-9\.]+/g,""));

        });
        if(isNaN(total)) {
            total = 0;
        }
        $('#subtotal').val(total.toFixed(2));
      
      
    }
    var changeRow = function(){
        $(document).on('change','.quantity,.price, price_quantity, .discount',function(){
            totalRow($(this));
        });
    }
    
    var totalDisCount = function() {
        var _total_discount = $('.total-discount');
        var _elm_subtotal = $('#subtotal');
        var _elm_discount_total = $('#discount-total');
        var _elm_total_without_gst = $('#total_without_gst');
        var _elm_add_gst_7 = $('#add_gst_7');
        var _elm_total_with_gst = $('#total_with_gst');
        
        var price_subtotal = _elm_subtotal.val();
        var price_discount = parseFloat(_elm_subtotal.val()) * parseFloat(_total_discount.val())/100;
        var price_without_gst = parseFloat(_elm_subtotal.val()) - price_discount;
        var price_gst_7 = parseFloat(price_without_gst) * parseFloat(7)/100;
        var price_total_with_gst =  price_gst_7 +10;
        
        if(isNaN(price_discount)) {
            price_discount = 0;
        }
        if(isNaN(price_without_gst)) {
            price_without_gst = 0;
        }
        
        if(isNaN(price_gst_7)) {
            price_gst_7 = 0;
        }
        
        if(isNaN(price_total_with_gst)) {
            price_total_with_gst = 0;
        }
        
        _elm_discount_total.val(price_discount.toFixed(2));
        _elm_total_without_gst.val(price_without_gst.toFixed(2));
        _elm_add_gst_7.val(price_gst_7.toFixed(2));
        _elm_total_with_gst.val(price_total_with_gst.toFixed(2));
    };
    
    var changeTotalDiscount = function() {
         $(document).on('change','.total-discount',function(){
             totalDisCount()
        });
    };

    var addItem = function(){
         $(document).on('click','div.invoice-icon .glyphicon-plus',function(e){
            e.preventDefault();
            var index = $(this).attr('data-number');
            var item = buildRowItem(index);
            
            
            $('.invoice-main').append(item);
            $(this).attr('data-number',parseInt(index)+1);
            if($('.remove').length > 1) {
                    $('.remove').find('.glyphicon-trash').removeClass('hide');
            }
            else
            {
                $('.remove').find('.glyphicon-trash').addClass('hide');
            }
        });
    }
    var removeItem = function(){
         $(document).on('click','.remove .glyphicon-trash ',function(e){
             e.preventDefault();
             var elm = $(this);
             if(!elm.hasClass('hide')) {
                    elm.parents('tr.invoice-item').remove();
             }
             var number = $('.number-td');
             number.each(function(key,item){
                $(item).text(parseInt(key+1));

             })
            if($('.remove').length > 1) {
                    $('.remove').find('.glyphicon-trash').removeClass('hide');
            }
            else
            {
                $('.remove').find('.glyphicon-trash').addClass('hide');
            }
             total();
             totalDisCount();
             return false;
        });
    }
    var buildRowItem = function(index){
        var rowItem = invoice_item.clone();
        rowItem.find(".error").removeClass('has-error');
        rowItem.find(".errorMessage").html('');
        rowItem.find(".item-id").remove();
        rowItem.find(".item-service").attr('name','DispenseItems['+index+'][item_name]');
        rowItem.find(".item-quantity").attr('name','DispenseItems['+index+'][quantity]').attr('value','0');
        rowItem.find(".item-price").attr('name','DispenseItems['+index+'][price]').attr('value','0');
        rowItem.find(".item-total").attr('name','DispenseItems['+index+'][total]').attr('value','0.00');
        rowItem.find(".discount").attr('name','DispenseItems['+index+'][discount]').attr('value','0');
        rowItem.find(".price_after_discount").attr('name','DispenseItems['+index+'][price_after_discount]').attr('value','0');
        rowItem.find(".price_quantity").attr('name','DispenseItems['+index+'][price_quantity]').attr('value','0.00');
      
         
       
        rowItem.find(".item-name").attr('id','DispenseItems-'+index+'-item_name');
        rowItem.find(".price").attr('id','DispenseItems-'+index+'-quantity').attr('value','0');
        rowItem.find(".quantity").attr('id','DispenseItems-'+index+'-price').attr('value','1');
        rowItem.find(".price_quantity").attr('id','DispenseItems-'+index+'-price_quantity').attr('value','0.00');
        rowItem.find(".discount").attr('id','DispenseItems-'+index+'-discount').attr('value','0');
        rowItem.find(".total").attr('id','DispenseItems-'+index+'-total').attr('value','0.00');
        rowItem.find(".price_after_discount").attr('id','DispenseItems-'+index+'-price_after_discount').attr('value','0.00');
        var number = $('.number-td').length;
        rowItem.find('.number-td').text(parseInt(number+1));
        rowItem.find('.remove').removeClass('hide');
   
        return rowItem;
    }
    
  
    // check hidden button remove
    var checkRemove = function(){
        if($('.remove').length > 1) {
                    $('.remove').find('.glyphicon-trash').removeClass('hide');
        }
        else
        {
            $('.remove').find('.glyphicon-trash').addClass('hide');
        }
    }
    
    var checkMethod= function(){
        
       $(document).on('click','.invoice-icon .glyphicon',function(){
              var index = $('.invoice-item').length;
              var url = location.origin;
              $.ajax({
                    url: url+'".$href."/invoice/default/create-invoice-item?owner_id=".$model->owner_id."',
                    data: {
                        index:index
                    },
                    dataType:'JSON',
                    success: function(r)
                    {
                        if(r.status ==true) 
                        {   
                             $('.invoice-main').append(r.data);  
                             if($('.remove-icon').length > 1) {
                                    $('.remove-icon').removeClass('hide');
                              }
                              else
                              {
                                $('.remove-icon').addClass('hide');
                              }
                              return false;
                        }
                     }
              });
              
        });
      
                
       
    };

    // public functions
    return {

        //main function
        init: function () { 
            invoice_item = $( "tr.invoice-item" ).first().clone();
            buildRowItem();
            addItem();
            removeItem();
           
            changeRow();
            total();
            
            changeTotalDiscount();
            totalDisCount();
            
            checkRemove();
        }

    };
    
  

}();


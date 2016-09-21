/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Hoang Han
 */

$(document).ready(function(){
    
     for(i=0;i<10;i++)
    {
        $('#DispenseItems_'+i+'_quantity').val('1');
         $('#DispenseItems_'+i+'_price').val('0');
          $('#DispenseItems_'+i+'_discount').val('0');
           $('#DispenseItems_'+i+'_discount').val('0');
    }
    callCaculator();
    function callCaculator()
    {
        for(var i=0; i<10; i++)
        {
            caculator(i);
        }
    }
   
    function caculator(number)
    {
         
        $('#DispenseItems_'+number+'_quantity').keypress(function(e){
                 
            if (e.keyCode >= 49 && e.keyCode <= 57) {}
            else {
                if (e.keyCode >= 97 && e.keyCode <= 122) {
                    return false;
                } else {};
            }
        });
        $('#DispenseItems_'+number+'_price').keypress(function(e){
               
            if (e.keyCode >= 49 && e.keyCode <= 57) {}
            else {
                if (e.keyCode >= 97 && e.keyCode <= 122) {
                    return false;
                } else {};
            }
        });
            
        $('#DispenseItems_'+number+'_discount').keypress(function(e){
               
            if (e.keyCode >= 49 && e.keyCode <= 57) {}
            else {
                if (e.keyCode >= 97 && e.keyCode <= 122) {
                    return false;
                } else {};
            }
        });
            
        $('#DispenseItems_'+number+'_price').change(function(){
            if($.trim($('#DispenseItems_'+number+'_item_name').val())!='')
            {
                            
                TotalItem(number);
                    
            }
                
        });
               
        $('#DispenseItems_'+number+'_quantity').change(function(){
                    
            if($.trim($('#DispenseItems_'+number+'_item_name').val())!='')
            {
                            
                TotalItem(number);
            }
        });
                
        $('#DispenseItems_'+number+'_discount').change(function(){
                    
            if($.trim($('#DispenseItems_'+number+'_item_name').val())!='')
            {
                            
                TotalItem(number);
            }
                  
        });
        $('#DispenseItems_'+number+'_item_name').click(function(){
               
            if($.trim($('#DispenseItems_'+number+'_item_name').val())!='')
            {
                            
                TotalItem(number);
            }
        });
    }
              
              
    // function total item drug         
    function TotalItem(number)
    {
        var price= parseFloat($('#DispenseItems_'+number+'_price').val());
        var quantity=parseFloat($('#DispenseItems_'+number+'_quantity').val());
        var price_quantity= price*quantity;
        var discount=parseFloat($('#DispenseItems_'+number+'_discount').val());
        var price_discount= price_quantity - ((price_quantity*discount)/100);
        $('#DispenseItems_'+number+'_price_quantity').val(price_quantity.toFixed(2));
        $('#DispenseItems_'+number+'_price_after_discount').val(price_discount.toFixed(2));
        $('#DispenseItems_'+number+'_total').val(price_discount.toFixed(2));
    }
    
    // call subtotal
    Callsubtotal(10);
    function Callsubtotal(number)
    {
     
        for(i=0;i<number;i++)
        {
            subtotal(i);
        }
    
    }
 
   
    
    $(document).on('change','#DispenseItems_discount',function(){
        var discount= parseInt($('#DispenseItems_discount').val());
        $('.discount-dispense').val(discount);
        DiscountTotal();
       
    });
    /**
     *
     *function subtotal
     *
     **/
    function subtotal(number)
    {
    
        $(document).on('change','.price_'+number+'', function(){
            SubTotalSwith(number)
        })
   
        $(document).on('change','.quantity_'+number+'', function(){
            SubTotalSwith(number)
        })
   
        $(document).on('change','.discount_'+number+'', function(){
            SubTotalSwith(number)

        })
   
   
    }
    /**
     *
     *function total subtotal
     *
     **/
    function SubTotalSwith(number)
    {
        switch(number) {
            case 0:
                DiscountTotal();
                break;
            case 1:
                DiscountTotal();
                break;
            case 2:
                DiscountTotal();
                break;
            case 3:
                DiscountTotal();
                break;
            case 4:
                DiscountTotal();
                break;
            case 5:
                DiscountTotal();
                break;
            case 6:
                DiscountTotal();
                break;
            case 7:
                DiscountTotal();
                break;
            case 8:
                DiscountTotal();
                break;
            case 9:
                DiscountTotal();
                break;
            default:
                alert('errors');
             
        }
    }
    /**
     *
     *functiom total discount
     *
     **/
    function DiscountTotal()
    {
        var discount= parseInt($('#DispenseItems_discount').val());
        
        var total=0;
     
        
            
        for(i=0;i<10;i++)
        {
            if($('#DispenseItems_'+i+'_total').val()!='')
            {
                total+= parseFloat($('#DispenseItems_'+i+'_total').val());
            }
              
        }
      
        var discount_total=total-(total*(discount/100));
        if(total!=discount_total)
        {
            var add_gst=discount_total*0.07;
            var total_with_gst=discount_total+add_gst;
            $('#discount-total').val(discount_total.toFixed(2));
            $('#subtotal').val(discount_total.toFixed(2));
            $('#total_without_gst').val(discount_total.toFixed(2));
            $('#add_gst_7').val(add_gst.toFixed(2));
            $('#total_with_gst').val(total_with_gst.toFixed(2));
            $('#bill-total').text(total_with_gst.toFixed(2));
        }
        else
        {
            var add_gst=discount_total*0.07;
            var total_with_gst=discount_total+add_gst;
            $('#discount-total').val('');
            $('#subtotal').val(discount_total.toFixed(2));
            $('#total_without_gst').val(discount_total.toFixed(2));
            $('#add_gst_7').val(add_gst.toFixed(2));
            $('#total_with_gst').val(total_with_gst.toFixed(2));
            $('#bill-total').text(total_with_gst.toFixed(2));
        }
       
    }
    $('#DispenseItems_type').hide();
  
    $('#dispense-pay').click(function(){
        $('#DispenseItems_type').val(1);
        $('#dispense-model-form').submit();
    })
    $('#pay').click(function(){
        $('#DispenseItems_type').val(2);
        $('#dispense-model-form').submit();
    })
    $('#dispense').click(function(){
        $('#DispenseItems_type').val(3);
        $('#dispense-model-form').submit();
    })
       
   
    $(document).on('click','td.select-patient .select-on-check',function(){
        r=$(this);
        var url='';
        if(r.is(':checked'))
        {
            url='/redbull/dispensing/addpatient'
            
        }
        else
        {
            url='/redbull/dispensing/unpatient'
        }
        $.ajax({
            type     : 'POST',
            url      : url,
            dataType : 'json',
            data     :{
                patient: r.val()
            },
            success: function(data) {

                console.log(data);
            }
        });
      
       
       
    })
  
    $(document).on('click','#add-entry',function(e){
       e.preventdefaul;
        var url='/redbull/dispensing/Getpatient'
        $.ajax({
            type     : 'POST',
            url      : url,
            dataType : 'json',
            data     :{
                 
            },
            success: function(r) {
                if(r.status)
                {
                    
                     window.location.href="/redbull/dispensing/entry?id="+r.data+"";
                }
                else
                {
                    alert('You have not select patient !');
                }
            }
        });
       
    });
    
    $(document).on('click','#add-payments',function(e){
       e.preventdefaul;
        var url='/redbull/dispensing/Getpatient'
        $.ajax({
            type     : 'POST',
            url      : url,
            dataType : 'json',
            data     :{
                 
            },
            success: function(r) {
                if(r.status)
                {
                    
                     window.location.href="/redbull/dispensing/entry?id="+r.data+"";
                }
                else
                {
                    alert('You have not select patient !');
                }
            }
        });
       
    });
    
    $(document).on('click','#payments',function(e){
       e.preventdefaul;
        var url='/redbull/dispensing/Getpatient'
        $.ajax({
            type     : 'POST',
            url      : url,
            dataType : 'json',
            data     :{
                 
            },
            success: function(r) {
                if(r.status)
                {
                    
                     window.location.href="/redbull/payments/index?patient="+r.data+"";
                }
                else
                {
                    alert('You have not select patient !');
                }
            }
        });
       
    });
    $(document).on('click','.make-payment',function(){
        $('#amount-model-form').submit();
    });
   
   
    $(document).on('change','input#PaymentAmount_american_express',function(){
        
        var elm=$(this).val();
        var PaymentAmount_cash=$('#PaymentAmount_cash').val();
        var PaymentAmount_cheque=$('#PaymentAmount_cheque').val();
        var PaymentAmount_credit_card=$('#PaymentAmount_credit_card').val();
        var PaymentAmount_nets=$('#PaymentAmount_nets').val();
        var PaymentAmount_amount_pay=parseFloat(elm)+parseFloat(PaymentAmount_cash)+parseFloat(PaymentAmount_cheque) + parseFloat(PaymentAmount_credit_card) + parseFloat(PaymentAmount_nets);
        $('#PaymentAmount_amount_pay').val(PaymentAmount_amount_pay.toFixed(2));
       var change_amount=parseFloat($('#bill-cr').val());
        $('#PaymentAmount_change').val((change_amount - PaymentAmount_amount_pay).toFixed(2));
    });
   
    $(document).on('change','input#PaymentAmount_cash',function(){
        
        var elm=$(this).val();
        var PaymentAmount_cash=$('#PaymentAmount_american_express').val();
        var PaymentAmount_cheque=$('#PaymentAmount_cheque').val();
        var PaymentAmount_credit_card=$('#PaymentAmount_credit_card').val();
        var PaymentAmount_nets=$('#PaymentAmount_nets').val();
        var PaymentAmount_amount_pay=parseFloat(elm)+parseFloat(PaymentAmount_cash)+parseFloat(PaymentAmount_cheque) + parseFloat(PaymentAmount_credit_card) + parseFloat(PaymentAmount_nets);
        $('#PaymentAmount_amount_pay').val(PaymentAmount_amount_pay.toFixed(2));
       var change_amount=parseFloat($('#bill-cr').val());
        $('#PaymentAmount_change').val((change_amount - PaymentAmount_amount_pay).toFixed(2));
    });
   
    $(document).on('change','input#PaymentAmount_cheque',function(){
        
        var elm=$(this).val();
        var PaymentAmount_cash=$('#PaymentAmount_american_express').val();
        var PaymentAmount_cheque=$('#PaymentAmount_cash').val();
        var PaymentAmount_credit_card=$('#PaymentAmount_credit_card').val();
        var PaymentAmount_nets=$('#PaymentAmount_nets').val();
        var PaymentAmount_amount_pay=parseFloat(elm)+parseFloat(PaymentAmount_cash)+parseFloat(PaymentAmount_cheque) + parseFloat(PaymentAmount_credit_card) + parseFloat(PaymentAmount_nets);
        $('#PaymentAmount_amount_pay').val(PaymentAmount_amount_pay.toFixed(2));
       var change_amount=parseFloat($('#bill-cr').val());
        $('#PaymentAmount_change').val((change_amount - PaymentAmount_amount_pay).toFixed(2));
    });
   
    $(document).on('change','input#PaymentAmount_credit_card',function(){
        
        var elm=$(this).val();
        var PaymentAmount_cash=$('#PaymentAmount_american_express').val();
        var PaymentAmount_cheque=$('#PaymentAmount_cash').val();
        var PaymentAmount_credit_card=$('#PaymentAmount_cheque').val();
        var PaymentAmount_nets=$('#PaymentAmount_nets').val();
         var PaymentAmount_amount_pay=parseFloat(elm)+parseFloat(PaymentAmount_cash)+parseFloat(PaymentAmount_cheque) + parseFloat(PaymentAmount_credit_card) + parseFloat(PaymentAmount_nets);
        $('#PaymentAmount_amount_pay').val(PaymentAmount_amount_pay.toFixed(2));
         var change_amount=parseFloat($('#bill-cr').val());
        $('#PaymentAmount_change').val((change_amount - PaymentAmount_amount_pay).toFixed(2));
    });
   
    $(document).on('change','input#PaymentAmount_nets',function(){
        
        var elm=$(this).val();
        var PaymentAmount_cash=$('#PaymentAmount_american_express').val();
        var PaymentAmount_cheque=$('#PaymentAmount_cash').val();
        var PaymentAmount_credit_card=$('#PaymentAmount_cheque').val();
        var PaymentAmount_nets=$('#PaymentAmount_credit_card').val();
        var PaymentAmount_amount_pay=parseFloat(elm)+parseFloat(PaymentAmount_cash)+parseFloat(PaymentAmount_cheque) + parseFloat(PaymentAmount_credit_card) + parseFloat(PaymentAmount_nets);
        $('#PaymentAmount_amount_pay').val(PaymentAmount_amount_pay.toFixed(2));
        var change_amount=parseFloat($('#bill-cr').val());
        $('#PaymentAmount_change').val((change_amount - PaymentAmount_amount_pay).toFixed(2));
    });
    
  
  
       $('#PaymentAmount_nets').keypress(function(e){
                 
            if (e.keyCode >= 49 && e.keyCode <= 57) {}
            else {
                if (e.keyCode >= 97 && e.keyCode <= 122) {
                    return false;
                } else {};
            }
        });
        $('#PaymentAmount_american_express').keypress(function(e){
                 
            if (e.keyCode >= 49 && e.keyCode <= 57) {}
            else {
                if (e.keyCode >= 97 && e.keyCode <= 122) {
                    return false;
                } else {};
            }
        });
        $('#PaymentAmount_cheque').keypress(function(e){
                 
            if (e.keyCode >= 49 && e.keyCode <= 57) {}
            else {
                if (e.keyCode >= 97 && e.keyCode <= 122) {
                    return false;
                } else {};
            }
        });
      $('#PaymentAmount_credit_card').keypress(function(e){
                 
            if (e.keyCode >= 49 && e.keyCode <= 57) {}
            else {
                if (e.keyCode >= 97 && e.keyCode <= 122) {
                    return false;
                } else {};
            }
        });
         $('#PaymentAmount_cash').keypress(function(e){
                 
            if (e.keyCode >= 49 && e.keyCode <= 57) {}
            else {
                if (e.keyCode >= 97 && e.keyCode <= 122) {
                    return false;
                } else {};
            }
        });
        
       setTimeout(function(){ 
               $('.alert-danger').hide();
       } , 3000);
});
$(document).on('keypress','.qty',function(e){
    var key = window.event ? e.keyCode : e.which;
    var value= $(this).val();
    if ( e.keyCode == 46 && value!='' && value.indexOf('.') == -1) {
        return true;
    }
    if ( key < 48 || key > 57 ) {
        return false;
    }
   return true;
});

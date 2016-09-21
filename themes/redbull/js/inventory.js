/**
inventory Module
**/
var Inventory = function () {
   
   var selectedType = function() {
       $(document).on('click','.type_inventory', function(e){
           var elm =$(this); 
           var v = elm.val();
           if(v==1)
           {
               $('.patient_name').removeClass('hide');
               $('.drug_name').addClass('hide');
               $('#Inventory_patient_name').val('');
               
           }
           else
           {
               $('.patient_name').addClass('hide');
               $('#Inventory_drug_name').val('');
               $('.drug_name').removeClass('hide');
           }
           
       });
       
       $(document).on('click','#Inventory_date_type', function(e){
           var elm =$(this); 
           var v = elm.val();
           if(v==0)
           {
               $('#from_date').val('');
               $('#to_date').val('');
               
           }
          
           
       });
   }
   
   var autocomPleted = function() {
            
        $.get( url_data_autocomplete_patient, function(r){
           if(r.code == 200) {
                $('#Inventory_patient_name').typeahead('destroy');
                $('#Inventory_patient_name').typeahead({ source:r.data});
           }
        }, 'json');
           
      };
      
      

    // public functions
    return {

        //main function
        init: function () { 
            selectedType()
            autocomPleted();
           
        }

    };
    
  

}();


/**
inventory Module
**/
var Print = function () {
   
  
   var autocomPleted = function() {
            
            $.get( url, function(r){
               if(r.code == 200) {
                    $('#PrintForm_patient_name').typeahead('destroy');
                    $('#PrintForm_patient_name').typeahead({ source:r.data});
               }
            }, 'json');
}
   
      
      

    // public functions
    return {

        //main function
        init: function () { 
            autocomPleted();
           
        }

    };
    
  

}();


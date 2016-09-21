/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
    $('#patient-name-enquiry').hide();
    $('#drug-name-enquiry').hide();
   
    if($('#patient-enquiry').is(":checked"))
    {
          
        $('#patient-name-enquiry').show();
        $('#drug-enquiry').removeAttr('checked');
            
    }
     if($('#drug-enquiry').is(":checked"))
    {
       $('#drug-name-enquiry').show();
       $('#patient-enquiry').removeAttr('checked');
            
    }
     
        
    $('#patient-enquiry').click(function(){
            
        if($('#patient-enquiry').is(":checked"))
        {
            $('#drug-enquiry').removeAttr('checked');
            $('#patient-name-enquiry').show();
            $('#drug-name-enquiry').hide();
        }
    })
    
    
         
    $('#drug-enquiry').click(function(){
            
        if($('#drug-enquiry').is(":checked"))
        {
            $('#patient-enquiry').removeAttr('checked');
            $('#drug-name-enquiry').show();
            $('#patient-name-enquiry').hide();
        }
    })
       
  
    
})

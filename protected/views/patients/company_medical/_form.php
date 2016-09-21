
    
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'Patient-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data'),
                ));
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Company Information</h3>
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form">
                        <div class="col-md-6">
                            <div class="form-group form-group-sm">
                                <label  class="col-md-4">Company Name  </label>      
                                <div class="col-md-8">
                                    <input type="text"  class="form-control "/>        
                                </div>
                            </div>

                            <div class="form-group form-group-sm">
                                <label  class="col-md-4">Department  </label>      
                                <div class="col-md-8">
                                    <input type="text"  class="form-control "/>        
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-sm">
                                <label  class="col-md-4">Staff No  </label>      
                                <div class="col-md-8">
                                    <input type="text"  class="form-control "/>        
                                </div>
                            </div>

                            <div class="form-group form-group-sm">
                                <label  class="col-md-4">Entitlement  </label>      
                                <div class="col-md-4">
                                    <input type="text" placeholder="$" class="form-control "/>        
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Medical Insurance Information</h3>
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form">
                        <div class="col-md-6">
                            <div class="form-group form-group-sm">
                                <label  class="col-md-4">To Bill Insurance  :  </label>      
                                <div class="col-md-7">
                                    <select class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                        <option value="3">Patient to pay first & claim from insurance      </option>
                                    </select>   
                                </div>
                            </div>

                            <div class="form-group form-group-sm">
                                

                                <label  class="col-md-4">Follow  :  </label>      
                                <div class="col-md-4">
                                    <select class="form-control">
                                        <option value="1">Clinic Price</option>
                                        <option value="2">Insurance Listed Price </option>
                                    </select>   
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-group-sm">
                                <label  class="col-md-4">Insurance Name  </label>      
                                <div class="col-md-8">
                                    <input type="text"  class="form-control "/>        
                                </div>
                            </div>

                            <div class="form-group form-group-sm">
                                <label  class="col-md-4">Copayment  </label>      
                                <div class="col-md-4">
                                    <select id="copayment" class="form-control">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>   
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-group-sm">
                                
                            </div>

                            <div class="form-group form-group-sm copayment-amount">
                                <label  class="col-md-4">Copayment amount  </label>      
                                <div class="col-md-4">
                                    <input type="text" placeholder="$" class="form-control "/>        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">File Attachments</h3>
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label  class="col-md-4">Insurance Card  </label>      
                                <div class="col-md-8">
                                    <input type="file" name="referal_report[]" multiple="multiple" accept="image/*" />          
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label  class="col-md-4">Insurance Referal letter  </label>      
                                <div class="col-md-8">
                                    <input type="file" name="referal_report[]" multiple="multiple" accept="image/*" />          
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label  class="col-md-4">Insurance Document A  </label>      
                                <div class="col-md-8">
                                    <input type="file" name="referal_report[]" multiple="multiple" accept="image/*" />          
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>

<style>
    .copayment-amount{
        display: none;
    }    
</style>

<script>
    $('#copayment').on('change', function(){
        var copayment = $(this).val();
        if (copayment == 1){
            $('.copayment-amount').css({'display': 'block'});
        }
        else{
            $('.copayment-amount').css({'display': 'none'});   
        }
    });
</script>
   

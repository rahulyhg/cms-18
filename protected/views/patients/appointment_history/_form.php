
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'Patient-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data'),
                ));
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Appointment History Information</h3>
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form">
                        <div class="row">
                            <div class="col-md-8 form-group form-group-sm">
                                <label  class="col-md-3"> Reason  </label>      
                                <div class="col-md-9">
                                    <input type="text"  class="form-control "/>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-8 form-group form-group-sm">
                                <label  class="col-md-3">Turn Up Yes/No  </label>      
                                <div class="col-md-3">
                                    <select class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select> 
                                </div>
                            </div>

                        </div>
                        
                        <div class="row">
                            <div class="col-md-8 form-group form-group-sm">
                                <label  class="col-md-3">Comments  </label>      
                                <div class="col-md-9">
                                    <textarea rows="5" cols="40" style="width: 100%" ></textarea>    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php $this->endWidget(); ?>

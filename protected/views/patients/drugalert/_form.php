
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'Patient-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data'),
                ));
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Drug Alert Information</h3>
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form">

                        <div class="row">
                            <div class="col-md-8 form-group form-group-sm">
                                <label  class="col-md-3"> Drug Name  </label>      
                                <div class="col-md-9">
                                    <input type="text"  class="form-control "/>
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
                        <div class="row">
                            <div class="col-md-8 form-group form-group-sm">
                                <label  class="col-md-3">Entry Date  </label>      
                                <div class="col-md-4">
                                    <div class="date-of-birth">
                                        <input type="text" class="form-control datepicker hasDatepicker" id="dp1430274047319">
                                        <img class="ui-datepicker-trigger" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/icon_calendar_r.gif" alt="..." title="...">              
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-8 form-group form-group-sm">
                                <label  class="col-md-3">Edit Date  </label>      
                                <div class="col-md-4">
                                    <div class="date-of-birth">
                                        <input type="text" class="form-control datepicker hasDatepicker" id="dp1430274047319">
                                        <img class="ui-datepicker-trigger" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/icon_calendar_r.gif" alt="..." title="...">              
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php $this->endWidget(); ?>

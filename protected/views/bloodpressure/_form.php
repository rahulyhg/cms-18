
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $this->pluralTitle ?></h3>
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form">
                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                            <?php echo $form->labelEx($model,'blood_pressure', array('class' => 'col-md-3')); ?>  
                                <div class="col-md-9">
                                <?php echo $form->dropDownList($model, 'blood_pressure', DeclareHelper::$yesNoFormat, array('class'=>'form-control')); ?>
                                <?php echo $form->error($model,'blood_pressure'); ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                                <?php echo $form->labelEx($model,'drugs', array('class' => 'col-md-3')); ?>  
                                <div class="col-md-9">
                                <?php echo $form->textField($model,'drugs',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                                <?php echo $form->error($model,'drugs'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                            <?php echo $form->labelEx($model,'comment', array('class' => 'col-md-3')); ?>  
                                <div class="col-md-9">
                                <?php echo $form->textArea($model,'comment',array('rows'=>5,'cols'=>76, 'style' => "width: 100%;", 'class' => '')); ?>
                                <?php echo $form->error($model,'comment'); ?>
                                </div>
                            </div>

                        </div>
                        <!-- <div class="row">
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

                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        
      

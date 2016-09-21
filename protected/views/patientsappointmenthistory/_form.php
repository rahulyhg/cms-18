
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $this->pluralTitle ?></h3>
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form">
                        <div class="row">
                            <div class="col-md-8 form-group form-group-sm">
                                <?php echo $form->labelEx($model,'reason', array('class' => 'col-md-3')); ?>  
                                <div class="col-md-9">
                                <?php echo $form->textField($model,'reason',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                                <?php echo $form->error($model,'reason'); ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-8 form-group form-group-sm">
                            <?php echo $form->labelEx($model,'turn_up', array('class' => 'col-md-3')); ?>  
                                <div class="col-md-3">
                                <?php echo $form->dropDownList($model, 'turn_up', DeclareHelper::$yesNoFormat, array('class'=>'form-control')); ?>
                                <?php echo $form->error($model,'turn_up'); ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-8 form-group form-group-sm">
                            <?php echo $form->labelEx($model,'comment', array('class' => 'col-md-3')); ?>  
                                <div class="col-md-9">
                                <?php echo $form->textArea($model,'comment',array('rows'=>5,'cols'=>76, 'class' => '')); ?>
                                <?php echo $form->error($model,'comment'); ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        
      

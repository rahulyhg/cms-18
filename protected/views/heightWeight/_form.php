
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $this->pluralTitle ?></h3>
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form">
                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                            <?php echo $form->labelEx($model,'height', array('class' => 'col-md-3')); ?>  
                                <div class="col-md-6">
                                    <?php echo $form->textField($model,'height',array('maxlength'=>255, 'class' => 'form-control numeric-control')); ?>
                                <?php echo $form->error($model,'height'); ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                                <?php echo $form->labelEx($model,'weight', array('class' => 'col-md-3')); ?>  
                                <div class="col-md-6">
                                <?php echo $form->textField($model,'weight',array('maxlength'=>255, 'class' => 'form-control numeric-control')); ?>
                                <?php echo $form->error($model,'weight'); ?>
                                </div>
                            </div>

                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        
      

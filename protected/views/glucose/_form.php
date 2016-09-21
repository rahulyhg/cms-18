
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $this->pluralTitle ?></h3>
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form">
                        <div class="row">
                            <div class="col-md-6 form-group form-group-sm">
                            <?php echo $form->labelEx($model,'comment', array('class' => 'col-md-3')); ?>  
                                <div class="col-md-9">
                                <?php echo $form->textArea($model,'comment',array('rows'=>5,'cols'=>76, 'style' => "width: 100%;", 'class' => '')); ?>
                                <?php echo $form->error($model,'comment'); ?>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
      

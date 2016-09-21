<div class="panel panel-default">
    <div class="panel-body">

        <?php
          $url = Yii::app()->createAbsoluteUrl('/inventories/checkDate');
            $form = $this->beginWidget('CActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'post',
                'id'=>'search-form',
                'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form',
                    'data-url'=>$url,
                    )
                    ));
        ?>
        <div class="col-sm-4">
             <div class="form-group form-group-sm">
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                   
                    <?php echo $form->radioButton($model,'type',array('value'=>1,'class'=>'type_inventory','checked'=>true)); ?> Check By Patient
                    <?php echo $form->radioButton($model,'type',array('value'=>2 ,'class'=>'type_inventory',)); ?> Check By Drug
                   
                </div>
            </div>
            <div class="form-group form-group-sm patient_name">
                <?php echo $form->labelEx($model, 'patient_name', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'patient_name', array('class' => 'form-control','autocomplete'=>"off")); ?>
                    <?php echo $form->error($model, 'patient_name'); ?>
                </div>
            </div>
            <div class="form-group form-group-sm drug_name hide">
                <?php echo $form->labelEx($model, 'drug_name', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'drug_name', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'drug_name'); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-12"><lable class="col-sm-2 control-label">Date</lable></div>
                    <div class="col-sm-12"><lable class="col-sm-2 control-label"><?php echo $form->radioButton($model,'date_type',array('value'=>0 ,'checked'=>true)); ?> ALL</lable></div>
                    <div class="col-sm-12">
                       <lable class="col-sm-2 control-label"><?php echo $form->radioButton($model,'date_type',array('value'=>1)); ?> From</lable>
                        <div class="col-sm-3">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
                                array(
                                        'name' => 'from_date',
                                        'attribute' => 'from_date',
                                        'model'=>$model,
                                        'options'=> array(
                                            'dateFormat' =>'yy/mm/dd',
                                            'altFormat' =>'yy/mm/dd',
                                            'changeMonth' => true,
                                            'changeYear' => true,


                                        ),
                                       'htmlOptions'=> array(
                                           'class' => 'form-control',
                                           'readonly' => true,
                                        )
                                ));
                            ?>
                            <div class="errorMessage Fromdate"></div>
                        </div>
                        <lable class="col-sm-1 control-label">To</lable>
                        <div class="col-sm-3">
                           <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
                                array(
                                        'name' => 'to_date',
                                        'attribute' => 'to_date',
                                        'model'=>$model,
                                        'options'=> array(
                                            'dateFormat' =>'yy/mm/dd',
                                            'altFormat' =>'yy/mm/dd',
                                            'changeMonth' => true,
                                            'changeYear' => true,


                                        ),
                                       'htmlOptions'=> array(
                                           'class' => 'form-control',
                                           'readonly' => true,
                                         )
                                ));
                            ?>
                            <div class="errorMessage Todate"></div>
                        </div>
                    </div>
                </div>
            </div>
         
        </div>
        <div class="col-sm-12">
            <div class="well">
                <?php echo CHtml::htmlButton('<span class="glyphicon glyphicon-search"></span> Search', array('class' => 'btn btn-default btn-sm', 'type' => 'submit')); ?>			
                <?php echo CHtml::htmlButton('<span class="glyphicon glyphicon-off"></span> Clear', array('class' => 'btn btn-default btn-sm', 'type' => 'reset', 'id' => 'clearsearch')); ?>		</div>
        </div> 
        
        
        <?php $this->endWidget(); ?>

    </div>
</div>


<div class="panel panel-default">
    <div class="panel-body">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'search-form'),
                ));
        ?>
        <div class="col-sm-4">
            <div class="form-group form-group-sm">
                <?php echo $form->labelEx($model, 'property_type', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'property_type', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'property_type'); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group form-group-sm">
                <?php echo $form->labelEx($model, 'display_order', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'display_order', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'display_order'); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group form-group-sm">
                <?php echo $form->labelEx($model, 'created_date', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'created_date', array('class' => 'my-datepicker-control form-control')); ?>
                    <?php echo $form->error($model, 'created_date'); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="well">
                <?php echo CHtml::htmlButton('<span class="' . $this->iconSearch . '"></span> Search', array('class' => 'btn btn-default btn-sm', 'type' => 'submit')); ?>			
                <?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Clear', array('class' => 'btn btn-default btn-sm', 'type' => 'reset', 'id' => 'clearsearch')); ?>		</div>
        </div> 
        <?php $this->endWidget(); ?>

    </div>
</div>


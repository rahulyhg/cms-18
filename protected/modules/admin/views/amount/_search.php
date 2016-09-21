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
                <?php echo $form->labelEx($model, 'amount_pay', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'amount_pay', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'amount_pay'); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group form-group-sm">
                <?php echo $form->labelEx($model, 'no_receipt', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'no_receipt', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'no_receipt'); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group form-group-sm">
                <?php echo $form->labelEx($model, 'pay_type', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->dropDownList($model, 'pay_type', $model->getDropDownlistPayType(), array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'pay_type'); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group form-group-sm">
                <?php echo $form->labelEx($model, 'created', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'created', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'created'); ?>
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


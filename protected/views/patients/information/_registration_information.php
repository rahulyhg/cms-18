
<?php $patient_id = isset($_GET['patient_id'])?$_GET['patient_id']:0;?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('static', 'Patient Registration Information') ?></h3>
        <?php //echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), array('patients/print'), array('class' => 'btn-1 pull-right')); ?>
        <?php //echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-trash"></span> Delete'), array('patients/delete', 'patient_id' => $patient_id), array("submit"=> array('patients/delete', 'patient_id' => $patient_id),"confirm"=>"Are you sure you want to delete the selected records?", 'class' => 'btn-1 pull-right delete-button')); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Delete',
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon' => 'glyphicon glyphicon-trash',
            'htmlOptions'=>array(
                'data-toggle'=>'modal',
                'data-target'=>'#myModal',
                'class' => 'btn-1 pull-right delete-button',
                'name'=>'ActionButton',
                'confirm' => 'Are you sure you want to delete the selected records?',
            ),
        )); ?> 
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-pencil"></span> Edit'), array('patients/update', 'patient_id' => $patient_id), array('class' => 'btn-1 pull-right')); ?>
    </div>
    <div class="panel-body">
        <div class="form">
            <?php echo $this->renderPartial('information/registration/_biodata', compact('model')); ?>
            <?php echo $this->renderPartial('information/registration/_patient_contact_information', compact('model')); ?>
            <?php echo $this->renderPartial('information/registration/_patient_medical_information', compact('model')); ?>
            <?php echo $this->renderPartial('information/registration/_partner_sponsor', compact('model')); ?>
            <?php echo $this->renderPartial('information/registration/_patient_medical_insurrance', compact('model', 'defaultInsurrance')); ?>
        </div>
    </div>
</div>

<?php
$this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'myModal')
); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>
            <h4>Write your comment</h4>
        </div>

        <div class="modal-body">
            <p><?php $this->renderPartial('information/registration/_comment_form', compact('model'),false)?></p>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

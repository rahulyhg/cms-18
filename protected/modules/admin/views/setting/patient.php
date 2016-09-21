<?php
$this->breadcrumbs = array(
   'Patient Configurations',
);
?>

<h1>Patient configurations</h1>

<?php if (Yii::app()->user->hasFlash('setting')): ?>
<div class="alert alert-success">
    <?php echo Yii::app()->user->getFlash('setting'); ?>
</div>
<?php endif; ?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'setting-form-admin-form',
    'enableAjaxValidation' => false,
    'method'=>'post',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

    <?php echo $form->errorSummary($model); ?>
    <?php 
        if (SettingPatientForm::$settingDefine && is_array(SettingPatientForm::$settingDefine)):
            foreach(SettingPatientForm::$settingDefine as $key => $item):
            $active = $i == 1?'class="tab-pane active"':'class="tab-pane"';
            $itemObject = (object)$item;
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-cog"></span> <?php echo $itemObject->label;?></h3>
        </div>
        <div class="panel-body">
            <div class="column">
            <?php 
            if ($itemObject->items && is_array($itemObject->items)):
                foreach($itemObject->items as $data):
                $dataObj = (object)$data;
                ?>
                <div class="form-group form-group-sm">
                    <?php echo $form->labelEx($model, $dataObj->name, array('class' => "col-sm-2 control-label")); ?>
                    <?php 
                    $unit = '';
                    if(isset($dataObj->unit) && $dataObj->unit != '')
                        $unit = ' ' . $dataObj->unit;
                    
                    $note = '';
                    if(isset($dataObj->notes) && $dataObj->notes != '')
                        $note = '<div class="notes">' . $dataObj->notes . '</div>';
                    
                    if ($dataObj->controlTyle == 'text'):
                        echo '<div class="col-sm-3">' . $form->textField($model, $dataObj->name, array_merge($dataObj->htmlOptions, array('class' => "form-control"))) . $unit . $note . '</div>'; 
                    elseif($dataObj->controlTyle == 'textarea'):
                        echo '<div class="col-sm-5">' . $form->textArea($model, $dataObj->name, $dataObj->htmlOptions) . $note . '</div>'; 
                    elseif($dataObj->controlTyle == 'dropdown'):
                        echo '<div class="col-sm-3">' . $form->dropDownList($model, $dataObj->name, $dataObj->data, array('class' => "form-control")) . $unit . $note . '</div>'; 
                    elseif($dataObj->controlTyle == 'password'):
                        echo '<div class="col-sm-3">' . $form->passwordField($model, $dataObj->name, array_merge($dataObj->htmlOptions, array('class' => "form-control"))) . $unit . $note . '</div>';
                    
                    endif;
                    ?>
                    <?php echo $form->error($model, $dataObj->name); ?>
                </div>
            <?php 
                endforeach;
            endif;
            ?>
            </div>
        </div>
    </div>
    <?php 
        $i++;
        endforeach;
    endif;?>

    <div class='clr'></div>
    <div class="well">
        <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
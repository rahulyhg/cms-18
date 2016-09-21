<div class="panel panel-default">
  <div class="panel-body">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
		'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'search-form'),
	)); ?>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'time_in', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'time_in', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'time_in'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'time_out', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'time_out', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'time_out'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'patient_name', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'patient_name', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'patient_name'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'seen', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'seen', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'seen'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'dispense', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'dispense', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'dispense'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'bill', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'bill', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'bill'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'paid', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'paid', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'paid'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'contact_insurance', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'contact_insurance', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'contact_insurance'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'height', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'height', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'height'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'weight', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'weight', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'weight'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'status', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'status', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'status'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'doctor_id', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'doctor_id', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'doctor_id'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'patient_id', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'patient_id', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'patient_id'); ?>
		</div>
	</div>
</div>
	<div class="col-sm-12">
		<div class="well">
			<?php echo CHtml::htmlButton('<span class="' . $this->iconSearch .  '"></span> Search', array('class' => 'btn btn-default btn-sm', 'type' => 'submit')); ?>			
<?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Clear', array('class' => 'btn btn-default btn-sm', 'type' => 'reset', 'id' => 'clearsearch')); ?>		</div>
	</div> 
	<?php $this->endWidget(); ?>

	</div>
</div>


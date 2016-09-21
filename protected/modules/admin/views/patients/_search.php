<div class="panel panel-default">
  <div class="panel-body">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
		'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'search-form'),
	)); ?>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'salutation', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'salutation', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'salutation'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'name', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'name', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'identity', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'identity', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'identity'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nationality', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nationality', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nationality'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'dob', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'dob', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'dob'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'age', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'age', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'age'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'gender', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'gender', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'gender'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'marital', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'marital', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'marital'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'race', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'race', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'race'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'religion', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'religion', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'religion'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'registration_date', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'registration_date', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'registration_date'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'reference_no', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'reference_no', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'reference_no'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'occupation', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'occupation', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'occupation'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'company', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'company', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'company'); ?>
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
<?php echo $form->labelEx($model,'residential_country', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'residential_country', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'residential_country'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'residential_block_house', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'residential_block_house', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'residential_block_house'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'residential_unit_from', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'residential_unit_from', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'residential_unit_from'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'residential_unit_to', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'residential_unit_to', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'residential_unit_to'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'residential_street', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'residential_street', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'residential_street'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'residential_building_name', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'residential_building_name', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'residential_building_name'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'residential_postal_code', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'residential_postal_code', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'residential_postal_code'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'residential_geo_name', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'residential_geo_name', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'residential_geo_name'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'mailling_country', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'mailling_country', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'mailling_country'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'mailling_block_house', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'mailling_block_house', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'mailling_block_house'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'mailling_unit_from', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'mailling_unit_from', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'mailling_unit_from'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'mailling_unit_to', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'mailling_unit_to', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'mailling_unit_to'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'mailling_street', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'mailling_street', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'mailling_street'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'mailling_building_name', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'mailling_building_name', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'mailling_building_name'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'mailling_postal_code', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'mailling_postal_code', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'mailling_postal_code'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'mailling_geo_name', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'mailling_geo_name', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'mailling_geo_name'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'contact_mobile_1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'contact_mobile_1', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'contact_mobile_1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'contact_country_1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'contact_country_1', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'contact_country_1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'contact_number_1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'contact_number_1', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'contact_number_1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'referred_contact_1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'referred_contact_1', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'referred_contact_1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'contact_mobile_2', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'contact_mobile_2', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'contact_mobile_2'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'contact_country_2', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'contact_country_2', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'contact_country_2'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'contact_number_2', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'contact_number_2', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'contact_number_2'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'referred_contact_2', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'referred_contact_2', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'referred_contact_2'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'contact_mobile_3', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'contact_mobile_3', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'contact_mobile_3'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'contact_country_3', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'contact_country_3', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'contact_country_3'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'contact_number_3', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'contact_number_3', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'contact_number_3'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'referred_contact_3', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'referred_contact_3', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'referred_contact_3'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'contact_email', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'contact_email', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'contact_email'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'singapore_contact_number', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'singapore_contact_number', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'singapore_contact_number'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'singapore_address', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'singapore_address', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'singapore_address'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'person_contact_singapore', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'person_contact_singapore', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'person_contact_singapore'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'allergy', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'allergy', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'allergy'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'comment_allergy', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'comment_allergy', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'comment_allergy'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'g6pd_deficiency', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'g6pd_deficiency', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'g6pd_deficiency'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'comment_g6pd_deficiency', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'comment_g6pd_deficiency', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'comment_g6pd_deficiency'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'had_any_medical_illness', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'had_any_medical_illness', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'had_any_medical_illness'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'comment_had_any_medical_illness', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'comment_had_any_medical_illness', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'comment_had_any_medical_illness'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'had_any_surgery', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'had_any_surgery', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'had_any_surgery'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'comment_had_any_surgery', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'comment_had_any_surgery', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'comment_had_any_surgery'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'referral', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'referral', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'referral'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'comment_referral', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'comment_referral', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'comment_referral'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'attach_referral_letter', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'attach_referral_letter', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'attach_referral_letter'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'attach_report', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'attach_report', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'attach_report'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'spouse_name', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'spouse_name', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'spouse_name'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'spouse_mobile', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'spouse_mobile', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'spouse_mobile'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'spouse_country', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'spouse_country', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'spouse_country'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'spouse_number', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'spouse_number', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'spouse_number'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'spouse_dob', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'spouse_dob', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'spouse_dob'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'spouse_age', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'spouse_age', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'spouse_age'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'spouse_identity', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'spouse_identity', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'spouse_identity'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_number_1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_number_1', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_number_1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_occupation_1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_occupation_1', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_occupation_1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_company_1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_company_1', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_company_1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_comment_1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_comment_1', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_comment_1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_relationship_2', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_relationship_2', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_relationship_2'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'spouse_occupation', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'spouse_occupation', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'spouse_occupation'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'spouse_company', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'spouse_company', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'spouse_company'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'spouse_comment', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'spouse_comment', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'spouse_comment'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_relationship_1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_relationship_1', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_relationship_1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_name_1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_name_1', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_name_1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_mobile_1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_mobile_1', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_mobile_1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_country_1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_country_1', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_country_1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_name_2', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_name_2', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_name_2'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_mobile_2', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_mobile_2', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_mobile_2'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_country_2', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_country_2', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_country_2'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_number_2', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_number_2', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_number_2'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_occupation_2', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_occupation_2', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_occupation_2'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_company_2', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_company_2', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_company_2'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'nok_comment_2', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'nok_comment_2', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'nok_comment_2'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'medical_company_name', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'medical_company_name', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'medical_company_name'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'medical_department', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'medical_department', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'medical_department'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'medical_staff_no', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'medical_staff_no', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'medical_staff_no'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'medical_entitlement_from', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'medical_entitlement_from', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'medical_entitlement_from'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'medical_entitlement_to', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'medical_entitlement_to', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'medical_entitlement_to'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'medical_bill_insurance', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'medical_bill_insurance', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'medical_bill_insurance'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'medical_insurance_name', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'medical_insurance_name', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'medical_insurance_name'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'medical_follow', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'medical_follow', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'medical_follow'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'medical_copayment', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'medical_copayment', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'medical_copayment'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'medical_copayment_amount_from', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'medical_copayment_amount_from', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'medical_copayment_amount_from'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'medical_copayment_amount_to', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'medical_copayment_amount_to', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'medical_copayment_amount_to'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'medical_attachment', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'medical_attachment', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'medical_attachment'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'same_resedential_address', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'same_resedential_address', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'same_resedential_address'); ?>
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
<?php echo $form->labelEx($model,'contact1', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'contact1', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'contact1'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'first_char', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'first_char', array('class' => 'form-control')); ?>
<?php echo $form->error($model,'first_char'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'is_deleted', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->dropDownList($model,'is_deleted', $model->optionActive, array('class' => 'form-control')); ?>
<?php echo $form->error($model,'is_deleted'); ?>
		</div>
	</div>
</div>
<div class="col-sm-4">
				<div class="form-group form-group-sm">
<?php echo $form->labelEx($model,'date_deleted', array('class' => 'col-sm-3 control-label')); ?>
<div class="col-sm-7">
<?php echo $form->textField($model,'date_deleted', array('class' => 'my-datepicker-control form-control')); ?>
<?php echo $form->error($model,'date_deleted'); ?>
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


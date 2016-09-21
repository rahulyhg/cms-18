<?php
$this->breadcrumbs=array(
	$this->pluralTitle => array('index'),
	'View ' . $this->singleTitle . ' : ' . $title_name,
);

$this->menu = array(
    array('label'=> $this->pluralTitle, 'url'=>array('index'), 'icon' => $this->iconList),	
    array('label'=> 'Update '. $this->singleTitle, 'url'=>array('update', 'id'=>$model->id)),
	array('label' => 'Create ' . $this->singleTitle, 'url' => array('create')),
);   

?>
<h1>View <?php echo $this->singleTitle . ' : ' . $title_name; ?></h1>

<?php
//for notify message
$this->renderNotifyMessage(); 
//for list action button
echo $this->renderControlNav();
?><div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> View <?php echo $this->singleTitle?></h3>
	</div>
	<div class="panel-body">
	<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        	'salutation',
	'name',
	'identity',
	'nationality',
	'dob',
	'age',
	'gender',
	'marital',
	array(
      	'header' => 'race',
      	'value' => $model->race->name,
  	),
	array(
      	// 'name' => 'religion',
      	'value' => $model->religion->name,
  	),
	'registration_date',
	'reference_no',
	'occupation',
	'company',
	'doctor_id',
	array(
                        'name' => 'important_comment_to_notes',
                        'type' => 'html',
                    ),
	'residential_country',
	'residential_block_house',
	'residential_unit_from',
	'residential_unit_to',
	'residential_street',
	'residential_building_name',
	'residential_postal_code',
	'residential_geo_name',
	'mailling_country',
	'mailling_block_house',
	'mailling_unit_from',
	'mailling_unit_to',
	'mailling_street',
	'mailling_building_name',
	'mailling_postal_code',
	'mailling_geo_name',
	'contact_mobile_1',
	'contact_country_1',
	'contact_number_1',
	'referred_contact_1',
	'contact_mobile_2',
	'contact_country_2',
	'contact_number_2',
	'referred_contact_2',
	'contact_mobile_3',
	'contact_country_3',
	'contact_number_3',
	'referred_contact_3',
	'contact_email',
	'singapore_contact_number',
	'singapore_address',
	'person_contact_singapore',
	'allergy',
	'comment_allergy',
	'g6pd_deficiency',
	'comment_g6pd_deficiency',
	'had_any_medical_illness',
	'comment_had_any_medical_illness',
	'had_any_surgery',
	'comment_had_any_surgery',
	'referral',
	'comment_referral',
	'attach_referral_letter',
	'attach_report',
	'spouse_name',
	'spouse_mobile',
	'spouse_country',
	'spouse_number',
	'spouse_dob',
	'spouse_age',
	'spouse_identity',
	'nok_number_1',
	'nok_occupation_1',
	'nok_company_1',
	'nok_comment_1',
	'nok_relationship_2',
	'spouse_occupation',
	'spouse_company',
	'spouse_comment',
	'nok_relationship_1',
	'nok_name_1',
	'nok_mobile_1',
	'nok_country_1',
	'nok_name_2',
	'nok_mobile_2',
	'nok_country_2',
	'nok_number_2',
	'nok_occupation_2',
	'nok_company_2',
	'nok_comment_2',
	'medical_company_name',
	'medical_department',
	'medical_staff_no',
	'medical_entitlement_from',
	'medical_entitlement_to',
	'medical_bill_insurance',
	'medical_insurance_name',
	'medical_follow',
	'medical_copayment',
	'medical_copayment_amount_from',
	'medical_copayment_amount_to',
	'medical_attachment',
	'same_resedential_address',
	'contact1',
	'first_char',
	'is_deleted',
	array(
                        'name' => 'date_deleted',
                        'type' => 'date',
                    ),
	array(
                        'name' => 'comment_deleted',
                        'type' => 'html',
                    ),
		),
	)); ?>
	<div class="well">
		<?php echo CHtml::htmlButton('<span class="' . $this->iconBack . '"></span> Back', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\''.  $this->baseControllerIndexUrl() . '\'')); ?>	</div>
	</div>
</div>

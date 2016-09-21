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
        	'company_name',
	'contact_name',
	'street_name',
	'city',
	'country',
	'phone',
	'email',
	'website',
	'enquiry_date',
	'part',
	'project',
	'sorting_services',
	'system_intergration',
	'assembly_services',
	'retrofit',
	'vision',
	'eddy_current',
	'laser',
	'air_gage',
	'inspection_solutions_development',
	'portable_inspections_sorting_station',
	'automates_sorting_system',
	'imss_interlligent_multi_sorting_system',
	'pcl_control',
	'pc_control',
	'motion_control',
	'complete_custom_solutions',
	'blue_print_attached',
	'picture_attached',
	array(
                        'name' => 'note',
                        'type' => 'html',
                    ),
		),
	)); ?>
	<div class="well">
		<?php echo CHtml::htmlButton('<span class="' . $this->iconBack . '"></span> Back', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\''.  $this->baseControllerIndexUrl() . '\'')); ?>	</div>
	</div>
</div>

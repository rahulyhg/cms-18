<?php
$this->breadcrumbs=array(
	$this->pluralTitle => array('index'),
	'View ' . $this->singleTitle . ' : ' . $title_name,
);

$this->menu = array(
    array('label'=> $this->pluralTitle, 'url'=>array('index'), 'icon' => $this->iconList),	
    
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
        	'property_adress',
	array(
                    'name' => 'type_id',
                    'value' => isset($model->propertytype->property_type)?$model->propertytype->property_type:"",
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'type' => 'raw',
                ),
	'unit_no_1',
	'unit_no_2',
	'size',
	
            array(
                    'name' => 'pes',
                    'value' =>($model->pes==1)? "Yes":"No",
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'type' => 'raw',
                ),
	'owner_name',
	'owner_mobile',
	'owner_email',
	array(
                        'name' => 'created_date',
                        'type' => 'date',
                    ),
		),
	)); ?>
	<div class="well">
		<?php echo CHtml::htmlButton('<span class="' . $this->iconBack . '"></span> Back', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\''.  $this->baseControllerIndexUrl() . '\'')); ?>	</div>
	</div>
</div>

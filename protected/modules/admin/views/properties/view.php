<?php
$this->breadcrumbs = array(
    $this->pluralTitle => array('index'),
    'View ' . $this->singleTitle . ' : ' . $title_name,
);

$this->menu = array(
    array('label' => $this->pluralTitle, 'url' => array('index'), 'icon' => $this->iconList),
    array('label' => 'Update ' . $this->singleTitle, 'url' => array('update', 'id' => $model->id)),
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
        <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> View <?php echo $this->singleTitle ?></h3>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                
                array(
                    'name' => 'featured_image',
                    'type' => 'raw',
                    'value' => $model->featured_image != '' ? '<div class="thumbnail col-sm-3">' . CHtml::image(
                                    Yii::app()->createAbsoluteUrl($model->uploadImageFolder . '/' . $model->id . '/' . $model->featured_image), '', array(
                                'style' => 'width :100%',
                            )) . '</div>' : ''
                ),
                'title',
                'slug',
               
                'address',
                array(
                    'name' => 'type_id',
                    'value' => isset($model->propertytype->property_type)?$model->propertytype->property_type:"",
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'type' => 'raw',
                ),
                'address',
                array(
                    'name' => 'district_id',
                    'value' => isset($model->district->district_name)?$model->district->district_name:"",
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'type' => 'raw',
                ),
               
                'est_top',
                array(
                    'name' => 'posted_by',
                    'value' => isset($model->users->username)?$model->users->username:"",
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'type' => 'raw',
                ),
                array(
                    'name' => 'created_date',
                    'type' => 'date',
                ),
                array(
                    'name' => 'modified_date',
                    'type' => 'date',
                ),
                 array(
                    'name' => 'brief_description',
                    'type' => 'html',
                ),
                array(
                    'name' => 'contact_enquiry',
                    'type' => 'html',
                ),
                 array(
                    'name' => 'over_view',
                    'type' => 'html',
                ),
            ),
        ));
        ?>
        <div class="well">
        <?php echo CHtml::htmlButton('<span class="' . $this->iconBack . '"></span> Back', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>	</div>
    </div>
</div>

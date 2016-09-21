<?php
$this->breadcrumbs = array(
    $this->pluralTitle => array('index', 'group_id' => $groupName->id),
    'View ' . $this->singleTitle . ' : ' . $title_name,
);

$this->menu = array(
    array('label' => $this->pluralTitle, 'url' => array('index', 'group_id' => $groupName->id), 'icon' => $this->iconList),
    array('label' => 'Update ' . $this->singleTitle, 'url' => array('update', 'id' => $model->id, 'group_id' => $groupName->id)),
    array('label' => 'Create ' . $this->singleTitle, 'url' => array('create', 'group_id' => $groupName->id)),
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
                    'name' => 'banner_title',
                    'type' => 'html',
                ),
                array(
                    'name' => 'banner_description',
                    'type' => 'html',
                ),
                array(
                    'name' => 'large_image',
                    'type' => 'raw',
                    'value' => $model->large_image != '' ? '<div class="thumbnail col-sm-3">' . CHtml::image(
                                    Yii::app()->createAbsoluteUrl($model->uploadImageFolder . '/' . $model->id . '/' . $model->large_image), '', array(
                                'style' => 'width :100%',
                            )) . '</div>' : ''
                ),
                'link',
                'order_display',
                array(
                    'name' => 'created_date',
                    'type' => 'date',
                ),
            ),
        ));
        ?>
        <div class="well">
            <?php echo CHtml::htmlButton('<span class="' . $this->iconBack . '"></span> Back', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>	</div>
    </div>
</div>

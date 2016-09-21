<?php Yii::app()->clientScript->registerScript('gridclick', "
    $('#patient-grid-bulk .clickable').click(function()
    {
        var _id = $(this).parent().find('input:first').val();
        window.open('".$this->createUrl('/patients/detail')."?patient_id='+ _id);
    });
"); 
?>

<div class="box-1">
    <?php Yii::app()->helper->renderMessage(); ?>
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'All Patients') ?></h2>
        <?php //echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), array('mpdfprint/index', 'type' => 'patient'), array('class' => 'btn-1 pull-right', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-print"></span> Print'), array('patients/print'), array('class' => 'btn-1 pull-right')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-pencil"></span> Edit'), 'javascript:void(0);', array('class' => 'btn-1 pull-right', 'onclick' => 'editPatient("patient-grid", "patient")')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-search"></span> Search'), array('patients/search'), array('class' => 'btn-1 pull-right')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Add New Patient'), array('patients/create'), array('class' => 'btn-1 pull-right')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Add To Queue'), 'javascript:void(0);', array('class' => 'btn-1 pull-right add-to-queue', 'onclick' => 'addToQueue("patient-grid")')); ?>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Add To Appointment'), 'javascript:void(0);', array('class' => 'btn-1 pull-right add-to-appointment', 'onclick' => 'processAddToAppointment("patient-grid", "'. Yii::app()->createAbsoluteUrl('/appointments/addAppointment') .'")')); ?>
    </div>
    <div class="box-body">
        <?php 
        $firstChar = isset($_REQUEST['Patient']['first_char']) ? $_REQUEST['Patient']['first_char'] : '';
        $isDeleted  = isset($_REQUEST['deleted']) ? $_REQUEST['deleted']: '';
        $form=$this->beginWidget('CActiveForm', array(
          'id'=>'patient-grid-bulk',
          // 'method' => 'get',
          'enableAjaxValidation'=>false,
          'htmlOptions'=>array('enctype' => 'multipart/form-data')));
          ?>
          <ul class="search-list">
            <?php 
            $characterList = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
            foreach ($characterList as $item):
                ?>
            <li><a href="#" onclick="$('#Patient_first_char').val('<?php echo $item;?>'); $('#patient-grid-bulk').submit();">
                <?php if ($firstChar != '' && strtolower($firstChar) == $item) echo "<strong>";?>
                <?php echo $item; ?></a>
                <?php if ($firstChar != '' && strtolower($firstChar) == $item) echo "</strong>";?>
            </li>
            
        <?php endforeach;?>
            <?php if ($firstChar == '' && $isDeleted == '') : ?>
                <li><strong><a href="<?php echo Yii::app()->createAbsoluteUrl('patients/index');?>">All</a></strong></li>
            <?php else: ?>
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl('patients/index');?>">All</a></li>
            <?php endif ?>
                
            <?php if ($isDeleted != '') : ?>
                <li><strong><a href="<?php echo Yii::app()->createAbsoluteUrl('patients/index?deleted=1');?>">Deleted</a></strong></li>
            <?php else: ?>
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl('patients/index?deleted=1');?>">Deleted</a></li>
            <?php endif ?>
    </ul> <br />
    <?php echo $form->hiddenField($model, 'first_char', array('class' => 'form-control')); ?>            
    <?php 
    $columnArray = array();
    $columnArray[] = array(
        'value'=>'$data->id',
        'class'=> "CCheckBoxColumn",
        'htmlOptions' => array('style' => 'width: 1%','class'=>'select-patient')
        );
    $columnArray = array_merge($columnArray, array(
        array(
          'name' => 'name',
          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width: 14%')
          ),
        array(
              'name' => 'contact_number_1',
              'header' => 'Contact Number',
              'value' => 'AreaCode::model()->getAreaCodeSpecific($data->contact_country_1) . " " .$data->contact_number_1',
              'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 7%')
              ),
        array(
          'name' => 'identity',
          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 7%')
          ),
        array(
              'name' => 'reference_no',
              'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 10%')
              ),
        array(
          'header' => 'Speaks',
          'type' => 'languagename',
          'value' => '$data->id',
          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 10%')
          ),
        array(
          'header' => 'Date of birth',
          'type' => 'date',
          'value' => '$data->dob',
          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 10%')
          ),
        array(
          'name' => 'gender',
          'value' => '$data->gender',
          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 5%')
          ),
        array(
          'header' => 'Address',
          'type' => 'address',
          'value' => '$data',
          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 13%')
          ),
        array(
          'name' => 'important_comment_to_notes',
          'type' => 'html',
          'value' => 'nl2br($data->important_comment_to_notes)',
          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 22%')
          ),
        
        ));


$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'patient-grid',
    'dataProvider'=>$model->search(),
    'ajaxUpdate'=>'false',
    'pager'=>array(
    'header'         => '',
    'prevPageLabel'  => 'Prev',
    'firstPageLabel' => 'First',
    'lastPageLabel'  => 'Last',
    'nextPageLabel'  => 'Next',
  ),
'selectableRows'=>2,
'columns'=>$columnArray,
  )); 
$this->endWidget();
?>
</div>

</div>

<style type="text/css">
    /*.fc-header-left,.fc-header-title { display: none;}*/
    .appt { background: none !important; border: none !important;}
</style>

<script>
    jQuery(document).ready(function ($) {
        $('.table tr[data-href]').each(function () {
            $(this).css('cursor', 'pointer').hover(
                function () {
                    $(this).addClass('active');
                },
                function () {
                    $(this).removeClass('active');
                }).click(function () {
                    document.location = $(this).attr('data-href');
                }
                );
            });

        $('table').floatThead({
            position: 'fixed'
        });
        
        $('.select-on-check').click(function(){
            var checkedItems = $('input.my_class:checked').length;
        })
    });

    var urlAddToQueue       = "<?php echo $this->createAbsoluteUrl('queues/create'); ?>";
    var urlUpdatePatient    = "<?php echo $this->createAbsoluteUrl('patients/update'); ?>";
</script>

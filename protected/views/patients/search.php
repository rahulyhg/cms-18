<?php Yii::app()->clientScript->registerScript('gridclick', "
$('#patient-grid .clickable').click(function()
{
    var _id = $(this).parent().find('input:first').val();
    window.open('".$this->createUrl('/patients/detail')."/patient_id/'+ _id);
});
");
?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Delete',
    'buttonType'=>'submit',
    'type'=>'primary',
    'icon' => 'glyphicon glyphicon-trash',
    'htmlOptions'=>array(
        'data-toggle'=>'modal',
        'data-target'=>'#myModal',
        'class' => 'btn-1',
        'id' => 'search-no-result-button',
        'name'=>'ActionButton',
        'confirm' => 'This name is not in database. 
Do you want to add this name to database?',
    ),
));

$this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'myModal')
); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>
            <h4>Confirm your action</h4>
        </div>

        <div class="modal-body">
            <p><?php $this->renderPartial('_confirm_add_new_form', array('name' => $model->name),false)?></p>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'patient-search-form',
        'action'=>Yii::app()->createUrl($this->route),
        'method' => 'get',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data'),
    ));
    $alpha = isset($_GET['Patient']['first_char']) ? $_GET['Patient']['first_char'] : '';
?>

<div class="form-horizontal">
<div class="box-1">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Search Patients') ?></h2>
        <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Add To Queue'), 'javascript:void(0);', array('class' => 'btn-1 pull-right add-to-queue', 'onclick' => 'addToQueue("patient-grid")')); ?>
        <?php echo CHtml::htmlButton('<span class="glyphicon glyphicon-search"></span> Search', array('class' => 'btn-1 pull-right', 'type' => 'submit')); ?> &nbsp;  
        
    </div>
    <div class="box-body">
        <ul class="search-list">
            <?php 
            $characterList = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', 'all');
            foreach ($characterList as $item):
              $cls = '';
              if ($item == strtolower($alpha)) {
                $cls = 'alpha-active';
              }
            ?>
            <li><a href="#" class="<?php echo $cls ?>" onclick="$('#Patient_first_char').val($(this).html()); $('#patient-search-form').submit();"><?php echo $item; ?></a></li>
            <?php endforeach;?>
        </ul> <br />
        

        <div class="row">
            <div class="col-md-6">
                <div class="col-md-12 form-group form-group-sm">
                    <label class="col-md-4">Name  </label>      
                    <div class="col-md-8">
                    <?php //echo $form->dropDownList($model, 'id', Patient::model()->getListPatients(), array('class' => 'form-control', 'empty' => '--Select Patient--')) ?>
                    <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>            
                    <?php echo $form->hiddenField($model, 'first_char', array('class' => 'form-control')); ?>            
                    </div>
                </div>
            
                <div class="col-md-12 form-group form-group-sm">
                    <label class="col-md-4">ID</label>      
                    <div class="col-md-8">
                        <?php echo $form->textField($model, 'identity', array('class' => 'form-control')); ?>            
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="col-md-12 form-group form-group-sm">
                    <label class="col-md-4">Contact Number</label>      
                    <div class="col-md-4">
                        <?php echo $form->dropDownList($model,'contact_country_1', AreaCode::getAreaCode() ,array('class' => 'form-control', 'empty' => 'Select your country code')); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo $form->textField($model,'contact_number_1',array('size'=>47,'maxlength'=>255, 'class' => 'form-control')); ?>
                    </div>
                </div>

                <div class="col-md-12 form-group form-group-sm">
                    <label class="col-md-4">Clinic Reference No.</label>      
                    <div class="col-md-8">
                        <?php echo $form->textField($model, 'reference_no', array('class' => 'form-control')); ?>
                    </div>
                </div>
            </div>
        </div>    

       
        <?php 
        $columnArray = array();
        $columnArray[] = array(
            'value'=>'$data->id',
            'class'=> "CCheckBoxColumn",
            'htmlOptions' => array('style' => 'width: 1%')
            );
        $columnArray = array_merge($columnArray, array(
            array(
              'name' => 'name',
              'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width: 14%')
              ),
            array(
              'name' => 'contact_number_1',
              'header' => 'Contact Number',
              'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 7%')
              ),
            array(
              'name' => 'identity',
              'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 7%')
              ),
            array(
              'header' => 'Dr Name',
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
                'header' => 'Important comments to note',
              'type' => 'html',
              'value' => 'nl2br($data->important_comment_to_notes)',
              'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 22%')
              ),
           
            ));
        $form=$this->beginWidget('CActiveForm', array(
          'id'=>'patient-grid-bulk',
          'enableAjaxValidation'=>false,
          'htmlOptions'=>array('enctype' => 'multipart/form-data')));

        $this->widget('zii.widgets.grid.CGridView', array(
          'id'=>'patient-grid',
          'dataProvider'=>$model->search(),
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
</div>
<?php $this->endWidget(); ?>

<style type="text/css">
    /*.fc-header-left,.fc-header-title { display: none;}*/
    .appt { background: none !important; border: none !important;}
    .alpha-active{
        color: red !important;
        font-weight: bold;
    }

    #search-no-result-button{
        display: none;
    }
</style>

<?php if ( $model->is_popup ): ?>
    <script>
        jQuery(document).ready(function($) {
            document.getElementById('search-no-result-button').click(); 
        });
    </script>
<?php endif ?>

<script>
    jQuery(document).ready(function($) {
        $('.table tr[data-href]').each(function(){
            $(this).css('cursor','pointer').hover(
                function(){ 
                    $(this).addClass('active'); 
                },  
                function(){ 
                    $(this).removeClass('active'); 
                }).click( function(){ 
                    document.location = $(this).attr('data-href'); 
                }
            );
        });

        $('table').floatThead({
            position: 'fixed'
        });
    });

    var urlAddToQueue = "<?php echo $this->createAbsoluteUrl('queues/create'); ?>";
</script>
<?php Yii::app()->clientScript->registerScript('gridclick', "
$('#patient-grid .clickable').click(function()
{
    var _id = $(this).parent().find('input:first').val();
    window.open('".$this->createUrl('/patients/detail')."/patient_id/'+ _id);
});
");
?>

<?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'patient-search-form',
            'action'=>Yii::app()->createUrl($this->route),
            'method' => 'get',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data'),
        ));
?>

<div class="form-horizontal">
<div class="box-1">
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Search Patient') ?></h2>
        <?php echo CHtml::htmlButton(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> View Payment'), array('class' => 'btn-1 pull-right', 'type' => 'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('static', '<span class="glyphicon glyphicon-plus"></span> Make Payment'), array('class' => 'btn-1 pull-right', 'type' => 'submit')); ?>
        <?php //echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-list-alt"></span> View Patient Profile'), array('patients/create'), array('class' => 'btn-1 pull-right')); ?>
        <?php echo CHtml::htmlButton('<span class="glyphicon glyphicon-search"></span> Search', array('class' => 'btn-1 pull-right', 'type' => 'submit')); ?> &nbsp;  
        
    </div>
    <div class="box-body">
        <ul class="search-list">
            <?php 
            $characterList = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', 'all');
            foreach ($characterList as $item):
            ?>
            <li><a href="#" onclick="$('#Patient_first_char').val($(this).html()); $('#patient-search-form').submit();"><?php echo $item; ?></a></li>
            <?php endforeach;?>
        </ul> <br />
        

        <div class="row">
            <div class="col-md-4">
                <div class="col-md-12 form-group form-group-sm">
                    <label class="col-md-4">Name  </label>      
                    <div class="col-md-8">
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

            <div class="col-md-4">
                <div class="col-md-12 form-group form-group-sm">
                    <label class="col-md-4">Contact Number</label>      
                    <div class="col-md-8">
                        <?php echo $form->textField($model, 'contact_number_1', array('class' => 'form-control')); ?>
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
</style>

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
    });
</script>
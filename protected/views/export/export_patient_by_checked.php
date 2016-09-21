<?php
/* @var $this DoctorController */
/* @var $model Doctor */


$this->title = Yii::t('static', $title);

?>

<div class="form-type">
    <div class="box-1">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'export-patient-form',
            'action' => Yii::app()->createUrl($this->route),
            ));
            ?>
            <div class="title-box clearfix">
                <h2 class="title"><?php echo Yii::t('static', $title) ?></h2>

            </div>
            <div class="box-body form-horizontal">
                <div class="row">
                    <div class="col-md-5 col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="col-sm-5">Select columns to export:</label> <br>
                            <div class="col-sm-12">
                                <label class="col-sm-4"></label>
                                <div class="col-sm-8" style="display: inline-block">
                                    <?php foreach (ExportForm::$listExportName as $key => $value): ?>
                                        <div style="float: left; margin-right: 5px">                       
                                            <p><input type="checkbox" name="export-column[<?php echo $key ?>]" <?php echo $this->listExportColumnsChecked[$key]; ?> value="<?php echo $value ?>"/> <?php echo $value ?></p>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-7 col-sm-12 ">
                        <div class="form-group">
                            <?php echo CHtml::button(Yii::t('static', 'Export Excel'), array('class' => 'btn btn-primary btnexport excel')); ?>
                            <?php echo CHtml::button(Yii::t('static', 'Export Word'), array('class' => 'btn btn-primary btnexport word')); ?>
                            <?php echo CHtml::link(Yii::t('static', 'Back'), array('tools/export'), array('class' => 'btn btn-primary')); ?>                            
                        </div>   
                    </div>   
                </div>
            </div>

            <div class="box-body">
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
                          'name' => 'identity',
                          'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left;width: 7%')
                          ),
                        array(
                          'header' => 'Preferred Contact No',
                          'name' => 'reference_no',
                          'value' => '$data->contact_no',
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
                      'dataProvider'=>$dataProvider->search(),
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
        <?php $this->endWidget(); ?>
    </div><!-- form -->

<script type="application/javascript">
    $('.excel').click(function() {
        $('#export-patient-form').append('<input type="hidden" name="export_type" value="excel" />');
        var action = $('#export-patient-form').attr('action');
        $('#export-patient-form').attr('action', action);
        $('#export-patient-form').submit();
    });
    $('.word').click(function() {
        $('#export-patient-form').append('<input type="hidden" name="export_type" value="word" />');
        var action = $('#export-patient-form').attr('action');
        $('#export-patient-form').attr('action', action);
        $('#export-patient-form').submit();
    });
</script>

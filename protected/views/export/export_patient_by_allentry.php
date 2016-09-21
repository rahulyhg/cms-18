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
                                <div class="col-sm-8">
                                    <?php foreach (ExportForm::$listExportName as $key => $value): ?>
                                        <div class="">                       
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

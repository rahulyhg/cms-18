<?php
/* @var $this DoctorController */
/* @var $model Doctor */


$this->title = Yii::t('static', $title);
$alphas = range('A', 'Z');
?>

<div class="form-type">
    <div class="box-1">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'print-patient-form',
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
                            <?php echo $form->labelEx($model, 'alpha_from', array('class' => 'col-sm-4')); ?>
                            <div class="col-sm-8">
                                <?php echo $form->dropDownList($model, 'alpha_from', PrintForm::$alphabet, array('class' => 'form-control','options' => array('a'=>array('selected'=>true)))) ?>
                                <?php echo $form->error($model, 'alpha_from'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group form-group-sm">
                            <?php echo $form->labelEx($model, 'alpha_to', array('class' => 'col-sm-4')); ?>
                            <div class="col-sm-8">
                                <?php echo $form->dropDownList($model, 'alpha_to', PrintForm::$alphabet, array('class' => 'form-control','options' => array('z'=>array('selected'=>true)))) ?>
                                <?php echo $form->error($model, 'alpha_to'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group form-group-sm">
                            <label class="col-sm-5">Select columns to print:</label> <br>
                            <div class="col-sm-12">
                                <label class="col-sm-4"></label>
                                <div class="col-sm-8">
                                    <?php foreach (PrintForm::$listPrintName as $key => $value): ?>
                                        <div class="">                       
                                            <p><input type="checkbox" name="print-column[<?php echo $key ?>]" <?php echo $this->listPrintColumnsChecked[$key]; ?> value="<?php echo $value ?>"/> <?php echo $value ?></p>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                      <div class="col-sm-7 pull-right form-group-sm">
                          <?php echo CHtml::button(Yii::t('static', 'Print'), array('class' => 'btn btn-default active btnprint')); ?>
                          <?php echo CHtml::link(Yii::t('static', 'Back'), array('tools/print'), array('class' => 'btn btn-primary')); ?>                            
                      </div>   
                  </div> 
                </div>                  
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->

<script type="application/javascript">
    $('.btnprint').click(function() {
        $('#print-patient-form').append('<input type="hidden" name="print_type" value="print" />');
        var action = $('#print-patient-form').attr('action');
        $('#print-patient-form').attr('action', action);
        $('#print-patient-form').submit();
    });
</script>

<?php
/* @var $this DoctorController */
/* @var $model Doctor */


$this->title = Yii::t('static', $title);
?>

<div class="form-type">
    <div class="box-1">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'print-patient-name-label-form',
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
                            <label class="col-sm-5">Select columns to print:</label> <br>
                            <div class="col-sm-12">
                                <label class="col-sm-4"></label>
                                <div class="col-sm-8">
                                    <?php foreach (PrintForm::$listPrintName as $key => $value): ?>
                                        <div class="">                       
                                            <p><input type="checkbox" name="<?php echo $key ?>" <?php echo $this->listPrintColumnsChecked[$key]; ?> value="<?php echo $value ?>"/> <?php echo $value ?></p>
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
                          <?php echo CHtml::button(Yii::t('static', 'Print'), array('class' => 'btn btn-default active', 'onclick' => 'printPatientNameLabel()')); ?>
                          <?php echo CHtml::link(Yii::t('static', 'Back'), array('tools/print'), array('class' => 'btn btn-primary')); ?>                            
                      </div>   
                  </div> 
                </div>                
                <?php $this->endWidget(); ?>
                <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'print-patient-name-label-grid',
                        'action' => Yii::app()->createUrl($this->route),
                    ));
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php 
                                $count = 0;
                                $countend = 1;
                                foreach ($dataProvider as $value):
                                    $patient = Patient::model()->findByPk($value['id']);
                            ?>
                            <?php if (($count == 0) || !($count % 4)): ?>
                                <div class="col-md-12 columns">
                            <?php endif ?>
                                <label class="checkbox-inline" for="Checkboxes_<?php echo $patient->id ?>">                       
                                    <input type="checkbox" name="print-patient-name-label-grid_c0[]" id="Checkboxes_<?php echo $patient->id ?>" value="<?php echo $patient->id ?>">                       
                                    <?php echo $patient->name ?>                     
                                </label> 
                            <?php if (!($countend % 4)): ?>
                                </div>
                            <?php endif ?>
                            <?php 
                                $count++;
                                $countend ++;
                                endforeach; 
                            ?>
                        </div>
                    </div>
                </div>  
                <?php $this->endWidget(); ?>         
            </div>
        </div>
    </div><!-- form -->

<script type="application/javascript">
    $(document).ready(function() {
        $('.form-group').on('click','input[type=checkbox]',function() {         
            $(this).closest('.checkbox-inline, .checkbox').toggleClass('checked');     
        }); 
    });
    var urlPrintPatientNameLabel = "<?php echo $this->createAbsoluteUrl('mpdfprint/printpatientnamelabel'); ?>";
</script>

<?php
/* @var $this DoctorController */
/* @var $model Doctor */


$this->title = Yii::t('static', $title);
?>

<div class="form-type">
    <div class="box-1">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'print-patient-checked-form',
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
                          <?php echo CHtml::button(Yii::t('static', 'Print'), array('class' => 'btn btn-default active', 'onclick' => 'printPatientChecked()')); ?>
                          <?php echo CHtml::link(Yii::t('static', 'Back'), array('tools/print'), array('class' => 'btn btn-primary')); ?>                            
                      </div>   
                  </div> 
                </div>                   
        <?php $this->endWidget(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php 
                            $columnArray = array();
                            $columnArray[] = array(
                                'value'=>'$data->id',
                                'class'=> "CCheckBoxColumn",
                                // 'id'=>'example-check-boxes',
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
                              'id'=>'print-patient-checked-grid-bulk',
                              'enableAjaxValidation'=>false,
                              'htmlOptions'=>array('enctype' => 'multipart/form-data')));

                            $this->widget('zii.widgets.grid.CGridView', array(
                              'id'=>'print-patient-checked-grid',
                              'dataProvider'=>$patient->search(),
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
        </div>
    </div><!-- form -->

<script type="application/javascript">
  var urlPrintPatientChecked = "<?php echo $this->createAbsoluteUrl('mpdfprint/printpatientchecked'); ?>";
</script>


<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/function.js"></script>
<div class="box-1">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'dispense-model-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>
    <div class="title-box clearfix">
        <h2 class="title"><?php echo Yii::t('static', 'Dispensing Enquiry') ?></h2>
        <button type="submit" class = 'btn-1 pull-right'><span class="glyphicon glyphicon-search"></span> Search</button>
    </div>

    <div class=" box-body form-horizontal">
        <div class="row">

            <div class = "col-md-5">
                <div class = "col-md-12 form-group form-group-sm">
                    <label class = "col-md-2"> </label>
                    <div class = "col-md-9">
                        <?php if ($type == 0): ?>
                            <?php echo $form->checkbox($model, 'check_type', array('value' => 0, 'checked' => true, 'id' => "patient-enquiry")); ?> Check by patient
                            <?php echo $form->checkbox($model, 'check_type', array('value' => 1, 'id' => "drug-enquiry", 'style' => 'margin-left:20px;')); ?>check by drug
                        <?php else : ?>
                            <?php echo $form->checkbox($model, 'check_type', array('value' => 0, 'checked' => false, 'id' => "patient-enquiry")); ?> Check by patient
                            <?php echo $form->checkbox($model, 'check_type', array('value' => 1, 'checked' => true, 'id' => "drug-enquiry", 'style' => 'margin-left:20px;')); ?>check by drug
                        <?php endif; ?>

                    </div>
                </div>
                <div id = "patient-name-enquiry" class = "col-md-12 form-group form-group-sm">
                    <label class = "col-md-2">Patient Name </label>
                    <div class = "col-md-9">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'patient_id',
                            'name' => 'patient_id',
                            'source' => Patient::model()->getDropDownListPatientName(),
                            // additional javascript options for the autocomplete plugin
                            'options' => array(
                                'minLength' => '2',
                            ),
                            'htmlOptions' => array(
                                'class' => 'form-control'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'patient_id'); ?>
                    </div>
                </div>
                <div id = "drug-name-enquiry" class = "col-md-12 form-group form-group-sm">
                    <label class = "col-md-2">Drug Name </label>
                    <div class = "col-md-9">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'name',
                            'name' => 'name',
                            'source' => Drug::model()->getAutoCompleteDrugName(),
                            // additional javascript options for the autocomplete plugin
                            'options' => array(
                                'minLength' => '2',
                            ),
                            'htmlOptions' => array(
                                'class' => 'form-control'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'name'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <label class = "col-md-12">Date </label>
                <div class = "col-md-12  form-group-sm">
                    <?php if ($date == 0) { ?>
                        <?php
                        echo $form->radioButton($model, 'date_type', array(
                            'value' => 0,
                            'checked' => true,
                        ));
                    } else {

                        echo $form->radioButton($model, 'date_type', array(
                            'value' => 0,
                            'checked' => false,
                        ));
                    }
                    ?>  All
                </div>
                <div class = "col-md-12  form-group-sm">
                    <div class="row"/>
                    <div class="col-md-2">
                        <?php if ($date == 0) { ?>
                            <?php
                            echo $form->radioButton($model, 'date_type', array(
                                'value' => 1,
                                'checked' => false,
                            ));
                        } else {

                            echo $form->radioButton($model, 'date_type', array(
                                'value' => 1,
                                'checked' => true,
                            ));
                        }
                        ?>  From
                    </div>
                    <div class = "col-md-5">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'first_date',
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'datepickerOptions' => array('changeMonth' => true, 'changeYear' => true),
                                'minDate' => '',
                                'onSelect' => "js:function(dateText, inst) {
                                                var last_date=$('#SearchEnquiryForm_first_date').val();
                                                if(last_date!='')
                                                {
                                                   $('#SearchEnquiryForm_last_date').datepicker( 'option', 'minDate', last_date);
                                                }
                                                
                                            }"
                            ),
                            'htmlOptions' => array(
                                'style ' => " width: 68%; display: inline",
                                'readonly' => 'true',
                                'class' => 'form-control',
                            ),
                        ));
                        ?>

                        <img class = "ui-datepicker-trigger" src = "<?php echo Yii::app()->theme->baseUrl; ?>/img/icon_calendar_r.gif" alt = "..." title = "...">
                        <?php echo $form->error($model, 'first_date'); ?>
                    </div>
                    <div class = "col-md-5">
                        To 
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'last_date',
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'datepickerOptions' => array('changeMonth' => true, 'changeYear' => true),
                                'minDate' => '',
                            ),
                            'htmlOptions' => array(
                                'style ' => " width: 68%; display: inline",
                                'readonly' => 'true',
                                'class' => 'form-control',
                            ),
                        ));
                        ?>
                        <img class = "ui-datepicker-trigger" src = "<?php echo Yii::app()->theme->baseUrl; ?>/img/icon_calendar_r.gif" alt = "..." title = "..." style = " display: inline">
                        <?php echo $form->error($model, 'last_date'); ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <?php $this->endWidget(); ?>
    <?php if (!empty($result)): ?>
        
        <?php
        
       if($type==0){
           $columnArray = array();
            $columnArray = array_merge($columnArray, array(
            array(
                'header' => 'S/N',
                'type' => 'raw',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'headerHtmlOptions' => array('width' => '18%', 'style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
          
            array(
                'name' => 'item_name',
                'header' => 'Item',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width:18%')
            ),
            array(
                'name' => 'quantity',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 18%')
            ),
            array(
                'name' => 'discount',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 18%')
            ),
            array(
                'name' => 'created_date',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width: 18%')
            ),
                ));
       }
       else
       {
           $columnArray = array();
           $columnArray = array_merge($columnArray, array(
            array(
                'header' => 'S/N',
                'type' => 'raw',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'headerHtmlOptions' => array('width' => '18%', 'style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
             array(
                'name' => 'patient_id',
                'header' => 'Patient Name',
                 'value'=>'$data->patient_id?$data->patient->name:""',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width:18%')
            ),
            array(
                'name' => 'item_name',
                'header' => 'Drug Name',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width:18%')
            ),
            array(
                'name' => 'quantity',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 18%')
            ),
            array(
                'name' => 'discount',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:center; width: 18%')
            ),
            array(
                'name' => 'created_date',
                'htmlOptions' => array('class' => 'clickable', 'style' => 'text-align:left; width: 18%')
            ),
                ));
       }
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'patient-grid-bulk',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data')));

        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'patient-grid',
            'dataProvider' => $result,
            'pager' => array(
                'header' => '',
                'prevPageLabel' => 'Prev',
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last',
                'nextPageLabel' => 'Next',
            ),
            'selectableRows' => 2,
            'columns' => $columnArray,
        ));
        $this->endWidget();
    endif;
    ?>
</div>
</div>

</div>


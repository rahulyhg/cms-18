<?php
/* @var $this PatientController */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/form.css');

$this->breadcrumbs = array(
    Yii::t('static', 'Patients') => array('/patient'),
    Yii::t('static', 'Create'),
);

$this->menu = array(
    array('label' => Yii::t('static', 'Cancel and Return'), 'url' => array('/patient')),
);
$this->title = Yii::t('static', 'New Patient');
?>
    <div class="form-type">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'patient-form',
            'enableAjaxValidation' => true,
        )); ?>
        <div class="row">
            <?php echo $form->errorSummary($model, Yii::t('validation', 'Please fix the following input errors:')); ?>
            <div class="col-lg-4">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'salutation'); ?>
                    <?php echo $form->dropDownList($model, 'salutation', $salutation, array('class' => 'form-control', 'style' => 'width:200px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'name'); ?>
                    <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'style' => 'width:500px', 'placeholder' => Yii::t('static', 'name as in NRIC / Passport + No differentiation into first / last name'))); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'identity'); ?>
                    <?php echo $form->textField($model, 'identity', array('class' => 'form-control', 'style' => 'width:500px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'nationality'); ?>
                    <?php echo $form->dropDownList($model, 'nationality', CHtml::listData($nationalities, 'nationality', 'nationality'), array('empty'=>Yii::t('static','None'), 'class' => 'form-control', 'style' => 'width:200px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'dob'); ?>
                    <?php echo $form->textField($model, 'dob', array('class' => 'form-control dob', 'style' => 'width:200px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'race'); ?>
                    <?php echo $form->dropDownList($model, 'race', CHtml::listData($races, 'id', 'value'), array('class' => 'form-control', 'style' => 'width:200px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'religion'); ?>
                    <?php echo $form->dropDownList($model, 'religion', CHtml::listData($religions, 'id', 'value'), array('empty'=>Yii::t('static','None'), 'class' => 'form-control', 'style' => 'width:200px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'occupation'); ?>
                    <?php echo $form->textField($model, 'occupation', array('class' => 'form-control', 'style' => 'width:400px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'company'); ?>
                    <?php echo $form->textField($model, 'company', array('class' => 'form-control', 'style' => 'width:400px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'marital'); ?>
                    <?php echo $form->dropDownList($model, 'marital', $marital, array('class' => 'form-control', 'style' => 'width:200px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'gender'); ?>
                    <?php echo $form->dropDownList($model, 'gender', $gender, array('class' => 'form-control', 'style' => 'width:200px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'language'); ?>
                    <?php echo $form->dropDownList($model, 'language_id', CHtml::listData($languages, 'id', 'value'), array('class' => 'form-control', 'style' => 'width:200px')); ?>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'residential'); ?>
                    <?php echo $form->textField($model, 'residential', array('class' => 'form-control', 'style' => 'width:600px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'mailing'); ?>
                    <?php echo $form->textField($model, 'mailing', array('class' => 'form-control', 'style' => 'width:600px')); ?>
                </div>
                <div class="form-group">
                    <label><?php echo Yii::t('static', 'Preferred Contact') ?></label>

                    <div class="col-lg-10 col-md-9">
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <div class="row in-row">
                                    <div class="col-md-3 col">
                                        <?php echo $form->dropDownList($model, 'contact_type1', $contactTypes, array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="col-md-5 col">
                                        <?php echo $form->dropDownList($model, 'ccode1', CHtml::listData($countrycodes, 'phonecode', 'title'), array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="col-md-4 col">
                                        <?php echo $form->textField($model, 'contact1', array('class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <div class="row in-row">
                                    <div class="col-md-3 col">
                                        <?php echo $form->dropDownList($model, 'contact_type2', $contactTypes, array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="col-md-5 col">
                                        <?php echo $form->dropDownList($model, 'ccode2', CHtml::listData($countrycodes, 'phonecode', 'title'), array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="col-md-4 col">
                                        <?php echo $form->textField($model, 'contact2', array('class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label><?php echo Yii::t('static', 'Other Contact') ?></label>

                    <div class="col-lg-10 col-md-9">
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <div class="row in-row">
                                    <div class="col-md-3 col">
                                        <?php echo $form->dropDownList($model, 'contact_type3', $contactTypes, array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="col-md-5 col">
                                        <?php echo $form->dropDownList($model, 'ccode3', CHtml::listData($countrycodes, 'phonecode', 'title'), array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="col-md-4 col">
                                        <?php echo $form->textField($model, 'contact3', array('class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <div class="row in-row">
                                    <div class="col-md-3 col">
                                        <?php echo $form->dropDownList($model, 'contact_type4', $contactTypes, array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="col-md-5 col">
                                        <?php echo $form->dropDownList($model, 'ccode4', CHtml::listData($countrycodes, 'phonecode', 'title'), array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="col-md-4 col">
                                        <?php echo $form->textField($model, 'contact4', array('class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php foreach ($questions as $q): ?>
                    <div class="row check-wrap-1">
                        <div class="list-2 clearfix">
                            <div class="lb-1 col-lg-4 col-md-6"><?php echo $q->question ?></div>
                            <div class="col-lg-8 col-md-6">

                                <?php echo CHtml::radioButtonList('question[' . $q->id . ']', null,
                                    array('0' => Yii::t('static', 'No'), '1' => Yii::t('static', 'Yes')),
                                    array('class' => 'radio-type', 'separator' => false, 'encode' => false)); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="line-1">
            <p><strong><?php echo Yii::t('static','For foreigner not living in Singapore')?></strong></p>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'singapore_contact'); ?>
                        <?php echo $form->textField($model, 'singapore_contact', array('class' => 'form-control', 'style'=>'width: 400px')); ?>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'singapore_address'); ?>
                        <?php echo $form->textField($model, 'singapore_address', array('class' => 'form-control', 'style'=>'width:600px')); ?>
                    </div>
                </div>
            </div>
        </div>
        <h3><?php echo Yii::t('static','Particulars of Next of Kin')?></h3>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'nok_name'); ?>
                    <?php echo $form->textField($model, 'nok_name', array('class' => 'form-control', 'style'=>'width: 400px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'nok_relationship'); ?>
                    <?php echo $form->textField($model, 'nok_relationship', array('class' => 'form-control', 'style'=>'width: 400px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'nok_dob'); ?>
                    <?php echo $form->textField($model, 'nok_dob', array('class' => 'form-control dob', 'style' => 'width:200px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'nok_identity'); ?>
                    <?php echo $form->textField($model, 'nok_identity', array('class' => 'form-control', 'style' => 'width:500px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'nok_contact'); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row in-row">
                                <div class="col-md-3 col">
                                    <?php echo $form->dropDownList($model, 'nok_contact_type', $contactTypes, array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-md-5 col">
                                    <?php echo $form->dropDownList($model, 'nok_ccode', CHtml::listData($countrycodes, 'phonecode', 'title'), array('class' => 'form-control')); ?>
                                </div>
                                <div class="col-md-4 col">
                                    <?php echo $form->textField($model, 'nok_contact', array('class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'nok_occupation'); ?>
                    <?php echo $form->textField($model, 'nok_occupation', array('class' => 'form-control', 'style' => 'width:400px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'nok_company'); ?>
                    <?php echo $form->textField($model, 'nok_company', array('class' => 'form-control', 'style' => 'width:400px')); ?>
                </div>
                <div class="form-group clearfix">
                    <?php echo $form->labelEx($model, 'referring'); ?>
                    <div class="col-md-4" style="padding-left:0">
                        <?php echo $form->dropDownList($model, 'referring_id', CHtml::listData($referrings, 'id', 'value'), array('class' => 'form-control')); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo $form->textField($model, 'referring', array('class' => 'form-control', 'placeholder' => Yii::t('static', 'or type name of doctor'))); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="list-2 clearfix">
                        <?php echo $form->checkBox($model, 'allow_to_contact', array('value'=>1, 'class'=>'check-type')) ?>
                        <?php echo $form->labelEx($model, 'allow_to_contact'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'nok_date'); ?>
                    <?php echo $form->textField($model, 'nok_date', array('class' => 'form-control datepicker', 'style' => 'width:200px')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'remarks'); ?>
                    <?php echo $form->textArea($model, 'remarks', array('class' => 'form-control','rows'=>4)); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <?php echo CHtml::submitButton(Yii::t('static','Submit'), array('class'=>'btn btn-primary')); ?>
        </div>
        <?php $this->endWidget(); ?>
        <div class="clearfix"></div>
    </div>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/patient_create.js', CClientScript::POS_END);
?>
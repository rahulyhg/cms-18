<?php
/* @var $this PatientController */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/form.css');

$this->breadcrumbs = array(
    Yii::t('static', 'Patients') => array('/patient'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('static', 'Back to Home'), 'url' => array('/site')),
    array('label' => Yii::t('static', 'Back to List'), 'url' => array('/patient')),
);
$this->title = Yii::t('static', 'View Patient');
?>
    <div class="form-type">
        <div class="row">
            <div class="col-lg-4">
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['salutation']; ?></dt>
                    <dd><?php echo $model->salutation ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['name']; ?></dt>
                    <dd><?php echo $model->name ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['identity']; ?></dt>
                    <dd><?php echo $model->identity ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['nationality']; ?></dt>
                    <dd><?php echo $model->nationality ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['dob']; ?></dt>
                    <dd><?php echo Yii::app()->dateFormatter->format('MMM d, yyyy', $model->dob) ?></dd>
                </dl><dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['race']; ?></dt>
                    <dd><?php echo CHtml::listData($races, 'id', 'value')[$model->race] ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['religion']; ?></dt>
                    <dd><?php echo CHtml::listData($religions, 'id', 'value')[$model->religion] ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['occupation']; ?></dt>
                    <dd><?php echo $model->occupation ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['marital']; ?></dt>
                    <dd><?php echo $marital[$model->marital] ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['gender']; ?></dt>
                    <dd><?php echo $gender[$model->gender] ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['language']; ?></dt>
                    <dd><?php echo $model->language ?></dd>
                </dl>
            </div>
            <div class="col-lg-7">
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['company']; ?></dt>
                    <dd><?php echo $model->company ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['residential']; ?></dt>
                    <dd><?php echo $model->residential ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['mailing']; ?></dt>
                    <dd><?php echo $model->mailing ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php echo Yii::t('static', 'Preferred Contact') ?></dt>
                    <dd><?php echo $model->contact_type1.' : '.$model->contact1 ?><br/>
                        <?php echo $model->contact_type2.' : '.$model->contact2 ?>
                    </dd>
                </dl>
                <dl>
                    <dt class="row"><?php echo Yii::t('static', 'Other Contact') ?></dt>
                    <dd><?php echo $model->contact_type3.' : '.$model->contact3 ?><br/>
                        <?php echo $model->contact_type4.' : '.$model->contact4 ?>
                    </dd>
                </dl>
                <?php $answersList = CHtml::listData($answers, 'question_id','answer'); ?>
                <?php foreach ($questions as $q): ?>
                    <div class="row check-wrap-1">
                        <div class="list-2 clearfix">
                            <div class="lb-1 col-lg-4 col-md-6"><?php echo $q->question ?></div>
                            <div class="col-lg-8 col-md-6">
                                <?php echo $answersList[$q->id] ? Yii::t('static','Yes') : Yii::t('static','No') ?>
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
                    <dl>
                        <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['singapore_contact']; ?></dt>
                        <dd><?php echo $model->singapore_contact ?></dd>
                    </dl>
                </div>
                <div class="col-lg-7">
                    <dl>
                        <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['singapore_address']; ?></dt>
                        <dd><?php echo $model->singapore_address ?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <h3><?php echo Yii::t('static','Particulars of Next of Kin')?></h3>
        <div class="row">
            <div class="col-lg-4">
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['nok_name']; ?></dt>
                    <dd><?php echo $model->nok_name ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['nok_relationship']; ?></dt>
                    <dd><?php echo $model->nok_relationship ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['nok_dob']; ?></dt>
                    <dd><?php echo Yii::app()->dateFormatter->format('MMM d, yyyy', $model->nok_dob) ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['nok_identity']; ?></dt>
                    <dd><?php echo $model->nok_identity ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['nok_contact']; ?></dt>
                    <dd><?php echo $model->nok_contact_type.' : '.$model->nok_contact ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['nok_occupation']; ?></dt>
                    <dd><?php echo $model->nok_occupation ?></dd>
                </dl>
            </div>
            <div class="col-lg-6">
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['nok_company']; ?></dt>
                    <dd><?php echo $model->nok_company ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['referring']; ?></dt>
                    <dd><?php echo $model->referring ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['allow_to_contact']; ?></dt>
                    <dd><?php echo $model->allow_to_contact ? Yii::t('static','Yes') : Yii::t('static','No') ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['nok_date']; ?></dt>
                    <dd><?php echo Yii::app()->dateFormatter->format('MMM d, yyyy', $model->nok_date) ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php $arr=$model->attributeLabels();echo $arr['remarks']; ?></dt>
                    <dd><?php echo $model->remarks ?></dd>
                </dl>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/patient_create.js', CClientScript::POS_END);
?>
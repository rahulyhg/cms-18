<?php
/* @var $this DoctorController */
/* @var $model Doctor */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/form.css');

$this->breadcrumbs = array(
    Yii::t('static', 'Appointments') => array('appointment/calendar'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('static', 'Back to Home'), 'url' => array('/site'), 'class' => 'btn-1'),
    array('label' => Yii::t('static', 'Back to Calendar'), 'url' => array('appointment/calendar', 'dd' => Yii::app()->dateFormatter->format('yyyy-M-d', $model->event->start)), 'class' => 'btn-1'),
);

// $this->title = Yii::t('static', 'View ' . ($model->event->type == 'op' ? 'Operation' : ($model->event->type == 'appt' ? 'Appointment' : '')));
?>
<?php echo CHtml::link('&nbsp;', array('appointment/update', 'id' => $model->event_id), array('class' => 'btn-update')) ?>
&nbsp;
<?php echo CHtml::link('&nbsp;', array('appointment/delete', 'id' => $model->event_id), array('class' => 'btn-delete')) ?>

<div class="form-type">
    <div class="row">
        <div class="col-md-4 col-sm-12 row">
            <dl>
                <dt class="row"><?php
                $arr = $model->attributeLabels();
                echo $arr['name'];
                ?></dt>
                <dd><?php echo $model->name ?></dd>
            </dl>
            <dl>
                <dt class="row"><?php
                $arr = $model->attributeLabels();
                echo $arr['nric'];
                ?></dt>
                <dd><?php echo $model->nric ?></dd>
            </dl>
            <dl>
                <dt class="row"><?php
                $arr = $model->attributeLabels();
                echo $arr['contact'];
                ?></dt>
                <dd><?php echo $model->contact ?></dd>
            </dl>
            <dl>
                <dt class="row"><?php
                $arr = $model->attributeLabels();
                echo $arr['startTime'];
                ?></dt>
                <dd><?php echo Yii::app()->dateFormatter->format('MMM d, yyyy h:mm a', $model->event->start) ?></dd>
            </dl>
            <dl>
                <dt class="row"><?php
                $arr = $model->attributeLabels();
                echo $arr['endTime'];
                ?></dt>
                <dd><?php echo Yii::app()->dateFormatter->format('MMM d, yyyy h:mm a', $model->event->end) ?></dd>
            </dl>
            <dl>
                <dt class="row"><?php
                $arr = $model->attributeLabels();
                echo $arr['doctor_id'];
                ?></dt>
                <dd><?php echo CHtml::encode($model->event->doctor->fullName) ?></dd>
            </dl>
            <?php if (!empty($model->event->clinic->name)) : ?>
                <dl>
                    <dt class="row"><?php
                    $arr = $model->attributeLabels();
                    echo $arr['clinic_id'];
                    ?></dt>
                    <dd><?php echo CHtml::encode($model->event->clinic->name) ?></dd>
                </dl>
            <?php endif; ?>
            <dl>
                <dt class="row"><?php
                $arr = $model->attributeLabels();
                echo $arr['visit_reason'];
                ?></dt>
                <dd><?php echo CHtml::encode(Appointment::$visit_reason[$model->visit_reason]) ?></dd>
            </dl>
            <?php if ($model->visit_reason == 2) : ?>
                <dl>
                    <dt class="row"><?php
                    $arr = $model->attributeLabels();
                    echo $arr['visit_reason_text'];
                    ?></dt>
                    <dd><?php echo CHtml::encode($model->visit_reason_text) ?></dd>
                </dl>
            <?php endif; ?>
            <dl>
                <dt class="row"><?php
                $arr = $model->attributeLabels();
                echo $arr['is_new_patient'];
                ?></dt>
                <dd><?php echo CHtml::encode(Appointment::$is_new_patient[$model->is_new_patient]) ?></dd>
            </dl>
            <dl>
                <dt class="row"><?php
                $arr = $model->attributeLabels();
                echo $arr['comments'];
                ?></dt>
                <dd><?php echo CHtml::encode($model->comments) ?></dd>
            </dl>
        </div>
        <?php if ($model->event->type == 'op'): ?>
            <div class="col-md-4 col-sm-12">
                <dl>
                    <dt class="row"><?php
                    $arr = $model->attributeLabels();
                    echo $arr['admission_hospital'];
                    ?></dt>
                    <dd><?php echo $model->admission_hospital ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php
                    $arr = $model->attributeLabels();
                    echo $arr['where_in_hospital'];
                    ?></dt>
                    <dd><?php echo $model->where_in_hospital ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php
                    $arr = $model->attributeLabels();
                    echo $arr['bed_type'];
                    ?></dt>
                    <dd><?php echo $model->bed_type ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php
                    $arr = $model->attributeLabels();
                    echo $arr['anaesthesia_type'];
                    ?></dt>
                    <dd><?php echo $model->anaesthesia_type ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php
                    $arr = $model->attributeLabels();
                    echo $arr['anaesthetist'];
                    ?></dt>
                    <dd><?php echo $model->anaesthetist ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php
                    $arr = $model->attributeLabels();
                    echo $arr['preparation'];
                    ?></dt>
                    <dd><?php echo $model->preparation ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php
                    $arr = $model->attributeLabels();
                    echo $arr['surgical_assistant'];
                    ?></dt>
                    <dd><?php echo $model->surgical_assistant ?></dd>
                </dl>
                <dl>
                    <dt class="row"><?php echo $model->operation_type == 'in' ? Yii::t('model', 'In Patient') : Yii::t('model', 'Day Surgery') ?></dt>
                </dl>
            </div>
        <?php endif; ?>
        <div class="clearfix"></div>
    </div>

</div><!-- form -->
<?php$this->breadcrumbs = array(    Yii::t('static', 'Doctor\'s Time Table'),);$this->menu = array(    // array('label'=>Yii::t('static', 'Add Time Table'), 'url'=>'javascript:void(0)', 'class'=>'btn-1 add-time'),    // array('label' => Yii::t('static', 'Log out'), 'url' => array('/site/logout'), 'class' => 'btn-1'),    array('label' => Yii::t('static', 'Previous Page'), 'url' => 'javascript:history.go(-1)', 'class' => 'btn-1'),);$this->title = Yii::t('static', 'Doctor\'s Time Table');?><div class="row">    <div class="col-md-12">        <div class="box-1">            <div class="title-box clearfix">                <h2 class="title"><?php echo Yii::t('static', "Doctor's Time Table") ?></h2>                <?php echo CHtml::link(Yii::t('static', '<span class="glyphicon glyphicon-arrow-left"></span> Back to previous page'), 'javascript:history.go(-1)', array('class' => 'btn-1 pull-right')); ?>            </div>            <div class="form-type">                <div class="row">                    <div  class="col-md-2">                        <div class="btn-group-vertical" data-toggle="buttons">                            <?php                            $count = 1;                            foreach ($doctors as $d) :                                ?>                                <label class="btn btn-default" id="btn-<?php echo $d->id ?>">                                <?php echo CHtml::radioButton('doctorSelect', false, array('value' => $d->id, 'uncheckValue' => null, 'id' => 'doctor' . $d->id)) ?> <?php echo $d->fullName ?>                                </label>                            <?php endforeach; ?>                        </div>                    </div>                    <div class="col-md-10">                        <div class="clearfix" id="doctor-time-table">                            <?php $this->renderPartial('table_template', array('data' => $data)); ?>                        </div>                        <div class="form-type">                            <div class="error">                                <?php if ($model->hasErrors()) {                                    echo CHtml::errorSummary($model);                                } ?>                            </div>                            <form method="post" id="time-table-form" class="tmarg-sx-20" style="display: none;">                                <div class="col-md-8 col-sm-12 row">                                    <div class="row" style="display: none;">                                        <label>Day:</label>                                        <?php echo CHtml::dropDownList('DoctorTime[day]', $model->day, $daysWeek); ?>                                        <label>Time:</label>                                        <?php echo CHtml::dropDownList('DoctorTime[time]', $model->time, HDateTime::model()->getAMPM()); ?>                                        <?php echo CHtml::hiddenField('DoctorTime[doctor_id]', $model->doctor_id); ?>                                        <?php echo CHtml::hiddenField('doctor_time_is_update', 0); ?>                                    </div>                                    <div class="row">                                        <label>Clinic:</label>                                        <?php echo CHtml::dropDownList('DoctorTime[clinic_id]', $model->clinic_id, Clinic::model()->dropdownClinic()); ?>                                    </div>                                    <div class="row">                                        <label for="doctor-time-comment"><?php echo $model->getAttributeLabel('comment'); ?></label>                                        <?php echo CHtml::textArea('DoctorTime[comment]', $model->comment, array('class' => 'form-control', 'rows' => 3)); ?>                                    </div>                                    <div class="row clearfix"><input class="btn btn-primary" type="submit" value="<?php echo Yii::t('static', 'Save'); ?>"></div>                                </div>                            </form>                        </div>                    </div>                </div>            </div>            <div class="clearfix"></div>        </div>    </div></div><input type="hidden" id="ajaxGetTableTemplate" value="<?php echo Yii::app()->createUrl('doctor/ajaxGetTableTemplate/'); ?>" /><input type="hidden" id="ajaxGetDoctorTime" value="<?php echo Yii::app()->createUrl('doctor/ajaxGetDoctorTime/'); ?>" /><script type="text/javascript">    function reloadTableTime() {        $('#doctor-time-table').html('');        $('#time-table-form').hide();        url = $('#ajaxGetTableTemplate').val();        doctor_id = $('#DoctorTime_doctor_id').val();        $.ajax({            type: "POST",            url: url,            data: {doctor_id: doctor_id},            async: false,            cache: false,            timeout: 500,        })                .done(function (msg) {                    $('#DoctorTime_doctor_id').val(doctor_id);                    $('#doctor-time-table').html(msg);                    //alert(doctor_id);                });    }    $(document).ready(function () {        $('.btn').removeClass('active');        $('#btn-' + $('#DoctorTime_doctor_id').val()).addClass('active');        $('input[name=doctorSelect]').change(function () {            $('#DoctorTime_doctor_id').val($(this).val());            $('.error').html('');            reloadTableTime();        });        $('.add-time').click(function () {            $('#DoctorTime_time,#DoctorTime_day').removeAttr('disabled');            $('#time-table-form').trigger('reset');            $('#DoctorTime_comment').val('');            $('#doctor_time_is_update').val(0);            $('#time-table-form').show();        });        // reloadTableTime();    });</script><style type="text/css" media="screen">    select:disabled {        background: #dddddd;    }</style>
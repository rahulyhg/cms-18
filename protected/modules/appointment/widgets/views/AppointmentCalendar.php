<div class="col-md-2">    <div class="current-month clearfix">        <p id="small-month" class="month"><?php echo date('F Y') ?></p>        <a href="#" title="<?php echo Yii::t('static', 'Next') ?>" class="next" id="small-next">&rsaquo;</a>        <a href="#" title="<?php echo Yii::t('static', 'Prev') ?>" class="prev" id="small-prev">&lsaquo;</a>    </div>    <div class="calendar-content">        <table class="calendar-tb">            <thead>                <tr>                    <th><?php echo Yii::t('static', 'Sun') ?></th>                    <th><?php echo Yii::t('static', 'Mon') ?></th>                    <th><?php echo Yii::t('static', 'Tue') ?></th>                    <th><?php echo Yii::t('static', 'Wed') ?></th>                    <th><?php echo Yii::t('static', 'Thu') ?></th>                    <th><?php echo Yii::t('static', 'Fri') ?></th>                    <th><?php echo Yii::t('static', 'Sat') ?></th>                </tr>            </thead>            <tbody id="small-cal">            </tbody>        </table>    </div>    <div class="panel panel-default" id="noticeBoard">        <div class="panel-heading">Notice Board<br/>for <span id="noticeDate">23-03-2016</span></div>        <div class="panel-body"></div>    </div></div><div class="col-md-10 calendar-box">    <div id='calendar'></div></div><input type="hidden" id="commonData"       doctorId="<?php echo $doctors[0]->id ?>"       urlGetMonthEvent = "<?php echo Yii::app()->createAbsoluteUrl('appointment/ajax/getMonthEvent/'); ?>"       urlGetWeekEvent = "<?php echo Yii::app()->createAbsoluteUrl('appointment/ajax/getWeekEvent/'); ?>"       urlGetDayEvent = "<?php echo Yii::app()->createAbsoluteUrl('appointment/ajax/getDayEvent/'); ?>"       urlGetLeaveEvent = "<?php echo Yii::app()->createAbsoluteUrl('appointment/ajax/getDoctorLeaveByDoctor/'); ?>"       urlGetCommonBlackout = "<?php echo Yii::app()->createAbsoluteUrl('appointment/ajax/getCommonBlackout/'); ?>"       urlGetDoctorTime = "<?php echo Yii::app()->createAbsoluteUrl('appointment/ajax/getDoctorTimeByDay/'); ?>"       urlloadNoticeBoard = "<?php echo Yii::app()->createAbsoluteUrl('appointment/ajax/loadNoticeBoard/'); ?>"       /><a id="addAppointmentPopup" href="<?php echo Yii::app()->createAbsoluteUrl('/appointment/site/addAppointment/'); ?>"></a>
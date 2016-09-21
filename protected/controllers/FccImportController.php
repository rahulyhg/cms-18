<?php

class FccImportController extends CController
{

    public function actionIndex()
    {
//        $jobId1 = Yii::app()->background->start(array(
//            'fccimport/updatetimetable',
//            'backjobMethod' => 'POST',
//            'backjobPostdata' => array()
//        ));
//        $jobId2 = Yii::app()->background->start(array(
//            'fccimport/updatetimeslottemplate/',
//            'backjobMethod' => 'POST',
//            'backjobPostdata' => array()
//        ));
//        $jobId3 = Yii::app()->background->start(array(
//            'fccimport/updatedeletefccnotice/',
//            'backjobMethod' => 'POST',
//            'backjobPostdata' => array()
//        ));
//        $jobId4 = Yii::app()->background->start(array(
//            'fccimport/updatefccnotice/',
//            'backjobMethod' => 'POST',
//            'backjobPostdata' => array()
//        ));
//        $jobId5 = Yii::app()->background->start(array(
//            'fccimport/updatecancelfccbooking/',
//            'backjobMethod' => 'POST',
//            'backjobPostdata' => array()
//        ));
        $this->actionUpdateTimeTable();
        $this->actionUpdateTimeslotTemplate();
        $this->actionUpdateDeleteFccNotice();
        $this->actionUpdateFccNotice();
//        $this->actionUpdateCancelFccBooking();

    }

    public function actionUpdateTimeTable() {
        $apiRecord = new APIActiveRecord;
        $params    = array();
        $url = '/redbull/downloadTimeTable';
        $rs = $apiRecord->sentTo65doctor($params,$url);

        foreach ($rs as $t) {
            $c            = new CDbCriteria;
            $c->compare('uuid', $t->uuid);
            $model = FccTimetable::model()->find($c);
            if ($model === null) continue;
            $model->fcc_doctor_uuid = $t->fcc_doctor_uuid;
            $model->updated_date = $t->updated_date;
            $model->update();
        }
    }
    public function actionUpdateTimeslotTemplate() {
        $apiRecord = new APIActiveRecord;
        $params    = array();
        $url = '/redbull/downloadTimeslotTemplate';
        $rs = $apiRecord->sentTo65doctor($params,$url);

        foreach ($rs as $t) {
            $c            = new CDbCriteria;
            $c->compare('uuid', $t->uuid);
            $model = FccTimeslotTemplate::model()->find($c);
            if ($model === null) continue;
            $model->fcc_doctor_uuid = $t->fcc_doctor_uuid;
            $model->data = $t->data;
            $model->updated_date = $t->updated_date;
            $model->save();
        }
    }

    public function actionUpdateFccNotice() {
        $apiRecord = new APIActiveRecord;
        $params    = array();
        $url = '/redbull/downloadFccNotice';
        $rs = $apiRecord->sentTo65doctor($params,$url);

        foreach ($rs as $t) {
            $c            = new CDbCriteria;
            $c->compare('uuid', $t->uuid);
            $model = Notice::model()->find($c);
            if ($model === null) {
                $model = new Notice;
                $model->uuid = $t->uuid;
            }
            $model->title = $t->title;
            $model->content = $t->content;
            $model->start = $t->start;
            $model->end = $t->end;
            $model->user_id = 0;
            $model->updated_date = $t->updated_date;
            $model->from_office = 1;
            $model->save();
        }
    }

    public function actionUpdateDeleteFccNotice() {
        $apiRecord = new APIActiveRecord;
        $params    = array();
        $url = '/redbull/downloadDeleteFccNotice';
        $rs = $apiRecord->sentTo65doctor($params,$url);

        foreach ($rs as $t) {
            $c            = new CDbCriteria;
            $c->compare('uuid', $t->uuid);
            $model = Notice::model()->find($c);
            if ($model === null) {
               continue;
            }
            $model->delete();
        }
    }

    public function actionUpdateCancelFccBooking() {
        //Import FCC cancelled Appointment
        $apiRecord = new APIActiveRecord;
        $params    = array();
        $url = '/redbull/downloadFccBooking';
        $rs = $apiRecord->sentTo65doctor($params,$url);

        foreach ($rs as $fccBooking) {
            $c            = new CDbCriteria;
            $c->compare('uuid', $fccBooking->uuid);
            $model = FccBooking::model()->find($c);
            if ($model === null) continue;
            $model->is_deleted = $fccBooking->is_deleted;
            $model->save();
        }
    }
}

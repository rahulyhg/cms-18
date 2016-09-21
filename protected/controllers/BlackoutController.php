<?php
ob_start();
class BlackoutController extends FrontController {

    public function actionIndex() {
        $c = new CDbCriteria;
        $c->compare('type','holiday');
        $c->order = 'start asc';
        $modelHoliday = Blackout::model()->findAll($c);

        $c = new CDbCriteria;
        $c->compare('type','leave');
        $c->order = 'start asc';
        $modelLeave = Blackout::model()->findAll($c);

        $c = new CDbCriteria;
        $c->compare('type','time');
        $c->order = 'start asc';
        $modelTime = Blackout::model()->findAll($c);

        $c = new CDbCriteria;
        $c->compare('type','other');
        $c->order = 'start asc';
        $modelOther = Blackout::model()->findAll($c);

        $c = new CDbCriteria;
        $c->compare('type','covering');
        $c->order = 'start asc';
        $modelCovering = Blackout::model()->findAll($c);

        $this->render('index', array('modelHoliday' => $modelHoliday, 'modelLeave' => $modelLeave, 'modelTime' => $modelTime, 'modelOther' => $modelOther,'modelCovering' => $modelCovering));
    }

    public function actionDoctorLeave() {
        $c = new CDbCriteria;
        $c->compare('type','covering');
        $c->order = 'start asc';
        $modelCovering = Blackout::model()->findAll($c);

        $c = new CDbCriteria;
        $c->compare('type','leave');
        $c->order = 'start asc';
        $modelLeave = Blackout::model()->findAll($c);

        $this->render('doctorleave', array('modelCovering' => $modelCovering, 'modelLeave' => $modelLeave));
    }

    public function actionCreate() {
        $model = new Blackout;
        if (isset($_POST['Blackout'])) {
            $model->setAttributes($_POST['Blackout'], false);

            $model->startDate = $_POST['Blackout']['startDate'];
            $model->endDate = $_POST['Blackout']['endDate'];
            $model->startTime = !empty($_POST['Blackout']['startTime']) ? $_POST['Blackout']['startTime']:'00:00';
            $model->endTime = !empty($_POST['Blackout']['endTime']) ? $_POST['Blackout']['endTime']:'00:00';

            $model->start = date('Y-m-d', strtotime($model->startDate)). ' ' . $model->startTime;
            $model->end = date('Y-m-d', strtotime($model->endDate)). ' ' . $model->endTime;

            if ($model->type == 'holiday' || $model->type == 'other')
                $model->doctor_id = null;

            if ($model->save()) {
                $apiRecord = new APIActiveRecord;
                if ($model->type == 'holiday' || $model->type == 'leave' || $model->type == 'time') {
                    $doctors = Doctor::model()->findAll();
                    foreach ($doctors as $item) {
                        $params                       = array(
                            'doctor_id' => $item->_65doctor_id,
                            'start' => $model->start,
                            'end' => $model->end,
                            'comments' => $model->comments,
                            'type' => $model->type
                        );
                        $url = '/redbull/addBlackOut';
                        $rs = $apiRecord->sentTo65doctor($params,$url);
                        $_65bo = new Blackout65doctor;
                        $_65bo->bo_id = $model->id;
                        $_65bo->_65doctor_blackout_id = $rs->_65id;
                        $_65bo->save();
                    }
                }
                $this->redirect(array('blackout/index'));
            }
        } else {
            $model->type = 'holiday';
            if (isset($_GET['type'])) {
                $model->type = $_GET['type'];
            }
        }

        $c = new CDbCriteria;
        $c->order = 'is_default desc, name';
        $doctorList = Doctor::model()->findAll($c);
        $this->render('create', array('model' => $model, 'doctorList' => $doctorList));
    }

    public function actionUpdate($id, $leave_page = '0') {
        $model = Blackout::model()->findByPk($id);
        $model->startTime = date('H:i', strtotime($model->start));
        $model->endTime = date('H:i', strtotime($model->end));
        if (isset($_POST['Blackout'])) {
            $model->setAttributes($_POST['Blackout'], false);

            $model->startDate = $_POST['Blackout']['startDate'];
            $model->endDate = $_POST['Blackout']['endDate'];
            $model->startTime = !empty($_POST['Blackout']['startTime']) ? $_POST['Blackout']['startTime']:'00:00';
            $model->endTime = !empty($_POST['Blackout']['endTime']) ? $_POST['Blackout']['endTime']:'00:00';

            $model->start = date('Y-m-d', strtotime($model->startDate)). ' ' . $model->startTime;
            $model->end = date('Y-m-d', strtotime($model->endDate)). ' ' . $model->endTime;

            if ($model->type == 'holiday' || $model->type == 'other')
                $model->doctor_id = null;

            if ($model->save()) {
                $apiRecord = new APIActiveRecord;

                $criteria=new CDbCriteria;
                $criteria->compare('bo_id',$model->id);
                $_65bos = Blackout65doctor::model()->findAll($criteria);

                foreach ($_65bos as $bo) {
                    $params = array(
                        '_65doctor_blackout_id' => $bo->_65doctor_blackout_id
                    );
                    $url = '/redbull/deleteBlackOut';
                    $apiRecord->sentTo65doctor($params,$url); //Delete old blackout
                }
                Blackout65doctor::model()->deleteAll($criteria);

                $doctors = Doctor::model()->findAll();
                foreach ($doctors as $item) {
                    $params                       = array(
                        'doctor_id' => $item->_65doctor_id,
                        'start' => $model->start,
                        'end' => $model->end,
                        'comments' => $model->comments,
                        'type' => $model->type
                    );
                    $url = '/redbull/addBlackOut';
                    $rs = $apiRecord->sentTo65doctor($params,$url);
                    $_65bo = new Blackout65doctor;
                    $_65bo->bo_id = $model->id;
                    $_65bo->_65doctor_blackout_id = $rs->_65id;
                    $_65bo->save();
                }
                $this->redirect(array('blackout/index'));
            }
        } else {
            $model->startDate = date('l M j, Y', strtotime($model->start));
            $model->endDate = date('l M j, Y', strtotime($model->end));
        }

        $c = new CDbCriteria;
        $c->order = 'name';
        $doctorList = Doctor::model()->findAll($c);
        $this->render('update', array('model' => $model, 'doctorList' => $doctorList));
    }

    public function actionDelete($id) {
        $model = Blackout::model()->findByPk($id);
        $type = $model->type;
        if (!$model) {
            //throw new CHttpException(404);
        }
        else {
            $apiRecord = new APIActiveRecord;
            $criteria=new CDbCriteria;
            $criteria->compare('bo_id',$id);
            $_65bos = Blackout65doctor::model()->findAll($criteria);
            print_r($_65bos);
            foreach ($_65bos as $bo) {
                $params = array(
                    '_65doctor_blackout_id' => $bo->_65doctor_blackout_id,
                );
                $url = '/redbull/deleteBlackOut';
                $apiRecord->sentTo65doctor($params,$url); //Delete old blackout
            }
            Blackout65doctor::model()->deleteAll($criteria);
            $model->delete();
        }
        $this->redirect(array('blackout/index'));
    }
}

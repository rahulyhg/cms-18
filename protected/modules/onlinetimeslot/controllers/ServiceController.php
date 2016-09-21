<?php

class ServiceController extends OnlinetimeslotController
{

    public function actionInitDoctor()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        if (!empty($request)) {
            $doctor = Doctor::model()->findByPk($request->doctor_id);
            $_65_doctor_id = $doctor->_65doctor_id;
            $apiRecord = new APIActiveRecord;
            $params = array(
                'doctor_id' => $_65_doctor_id,
            );
            $url = '/redbull/initDoctor';
            $rs = $apiRecord->sentTo65doctor($params, $url);
            echo json_encode($rs);
            die;
        }
    }

    public function actionSaveBuffer()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        if (!empty($request)) {
            $doctor = Doctor::model()->findByPk($request->doctor_id);
            $_65_doctor_id = $doctor->_65doctor_id;
            $bufferTime = $request->bufferTime;

            $apiRecord = new APIActiveRecord;
            $params = array(
                'doctor_id' => $_65_doctor_id,
                'bufferTime' => $bufferTime,
            );
            $url = '/redbull/updateBuffer';
            $rs = $apiRecord->sentTo65doctor($params, $url);
            echo json_encode($rs);
            die;
        }
    }

    public function actionSaveTemplate() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        if (!empty($request)) {
            $doctor = Doctor::model()->findByPk($request->doctor_id);
            $_65_doctor_id = $doctor->_65doctor_id;
            $template = $request->template;

            $apiRecord = new APIActiveRecord;
            $params = array(
                'doctor_id' => $_65_doctor_id,
                'template' => json_encode($template),
            );
            $url = '/redbull/updateTemplate';
            $rs = $apiRecord->sentTo65doctor($params, $url);
//            echo json_encode($template);
            die;
        }
    }

}

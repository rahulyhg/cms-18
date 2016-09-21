<?php

class HeightWeightController extends FrontController {

    public $singleTitle = 'Height Weight';
    public $pluralTitle = 'Height Weight Information';
    public function actionPrintSelected(){
        $printItems = $_POST['heightweight-grid_c0'];
        $shouldPrint = implode(',', $printItems);
        if (!empty($shouldPrint))
        {
            $type = 'selected_heightweight';
            $link = Yii::app()->createAbsoluteUrl('mpdfprint/index', compact('shouldPrint', 'type'));
            echo json_encode(array(
                'link' => $link,
                'code' => true,
            ));
            die;
        }
    }
    
    public function actionCreate($patient_id=null){
        $this->pageTitle = 'Height weight  - '. Yii::app()->params['defaultPageTitle'];
        $model = new PatientHeightWeight();
        if(isset($_POST['PatientHeightWeight'])) {
             $model->attributes = $_POST['PatientHeightWeight'];
             $model->patient_id = $patient_id;
             $model->status = 1;
             if($model->save()) {
                  if ( Yii::app()->user->isAdmin ) {
                        $this->redirect(Yii::app()->createAbsoluteUrl('admin/patients/healthynotes', array('patient_id' => $patient_id, 'healthytype' => 'height_weight')));
                   }
                   else{
                     $this->redirect(Yii::app()->createAbsoluteUrl('patients/healthynotes', array('patient_id' => $patient_id, 'healthytype' => 'height_weight')));
                   }
             }
        }
        $this->render(
                'create',
                array('model'=>$model,
                       'patient_id' =>$patient_id
                    )
                );
    }
    
    
    public function actionUpdate($id){
        $this->pageTitle = 'Height weight  - '. Yii::app()->params['defaultPageTitle'];
        $model = $this->loadModel($id);
        if(isset($_POST['PatientHeightWeight'])) {
             $model->attributes = $_POST['PatientHeightWeight'];
             $model->status = 1;
             if($model->save()) {
                  if ( Yii::app()->user->isAdmin ) {
                        $this->redirect(Yii::app()->createAbsoluteUrl('admin/patients/healthynotes', array('patient_id' => $model->patient_id, 'healthytype' => 'height_weight')));
                   }
                   else{
                     $this->redirect(Yii::app()->createAbsoluteUrl('patients/healthynotes', array('patient_id' => $model->patient_id, 'healthytype' => 'height_weight')));
                   }
             }
        }
        $this->render(
                'update',
                array('model'=>$model,
                    )
                );
    }
    
    public function actionDelete(){
        $this->pageTitle = 'Delete - '.$this->singleTitle. ' - '. Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id',null);
        $deleteItems = $_POST['heightweight-grid_c0'];
        $shouldDelete = array_diff($deleteItems, array());
                
        if (!empty($shouldDelete))
        {
            PatientHeightWeight::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        }
        else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

       echo json_encode(array('status'=>1));
       Yii::app()->end();
        // if (!isset($_GET['ajax']))
            // $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('patients/drugalert', 'patient_id' => $patient_id));
    }
    
    public function loadModel($id) {
        $initMode = new  PatientHeightWeight();
        $model = $initMode->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}


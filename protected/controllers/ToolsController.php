<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ToolsController extends FrontController
{
    
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('captcha'),
                'users' => array('*'),
            ),
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    protected function performAjaxValidation($model) {
        try {
            if (isset($_POST['ajax'])) {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
  

   public function actionEdd()
   {
        $this->pageTitle = 'EDD  - '. Yii::app()->params['defaultPageTitle'];
        $this->render('edd');
   }
   public function actionExport()
   {
        $this->pageTitle = 'Export - '. Yii::app()->params['defaultPageTitle'];
        $this->render('export');
   }
   
   public function actionPrint()
   {
        $this->pageTitle = 'Print - '. Yii::app()->params['defaultPageTitle'];
        $this->render('print');
   }
   
   
}
?>

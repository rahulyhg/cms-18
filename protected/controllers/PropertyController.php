<?php

class PropertyController extends FrontController
{

    public $attempts = MAX_TIME_TO_SHOW_CAPTCHA;
    public $counter;
    /**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

        
    public function accessRules()
    {
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
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    protected function performAjaxValidation($model)
    {
        try
        {
            if(isset($_POST['ajax']))
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }
        catch (Exception $e)
        {
            Yii::log("Exception ".  print_r($e, true), 'error');
            throw  new CHttpException("Exception ".  print_r($e, true));
        }
    }
    

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
     public function actionIndex(){
        $model = new Properties();
		$this->pageTitle = 'Property Showcase - ' . Yii::app()->params['defaultPageTitle'];
        if(empty($model))
            $this->redirect(array('error'));
        $this->render('index', array(
            'model' => $model
        ));
    }
    public function actionDetail(){
        $model = new Properties();
        $slug = $_GET['slug'];
        $property = $model->getDetailBySlug($slug);

        if (isset($property)) {
            $this->pageTitle = $property->title .' - '. Yii::app()->params['defaultPageTitle'];
            $this->render('propertydetail', array(
                'model' => $property,
            ));
        }
        else{
            $this->redirect(array('error'));
        }
    }

    /**
     * <Jason>
     * <To tracking download file>
     */
    public function actionDownloadBrouchure() {
        try {
            $ebrouchure = Brouchures::findByPropertyId((int)$_GET['brouchure_id'], (int)$_GET['property_id']);
            $ebrouchuredownload = Brouchuredownloads::getLatestBrouchureDownload((int) $_GET['property_id'], $_GET['email']);
            
            if (is_null($ebrouchuredownload))
                throw new Exception('No Ebrouchure found.');
            
            //update latest date download + download mobile count for ebrouchure download
            $ebrouchuredownload->latest_download_date = date('Y-m-d H:i:s');
            $ebrouchuredownload->download_web_count = $ebrouchuredownload->download_web_count+1;
            $ebrouchuredownload->save();

            //download file
            MyFunctionCustom::forceDownload($ebrouchure, 'file_name');

        } catch (Exception $exc) {
            throw new CHttpException(403, $exc->getMessage());
        }
    }

    /**
     * <Jason>
     * <To tracking download file>
     */
    public function actionDownloadBrouchureFE() {
        // try {
            $ebrouchure = Brouchures::findByPropertyId((int)$_GET['brouchure_id'], (int)$_GET['property_id']);
            // $ebrouchuredownload = Brouchuredownloads::getLatestBrouchureDownload((int) $_GET['property_id'], $_GET['email']);
            
            if (is_null($ebrouchure))
                throw new Exception('No Ebrouchure found.');
            
            //update latest date download + download mobile count for ebrouchure download
            // $ebrouchuredownload->latest_download_date = date('Y-m-d H:i:s');
            // $ebrouchuredownload->download_web_count = $ebrouchuredownload->download_web_count+1;
            // $ebrouchuredownload->save();

            //download file
            MyFunctionCustom::forceDownload($ebrouchure, 'file_name');

        // } catch (Exception $exc) {
        //     throw new CHttpException(403, $exc->getMessage());
        // }
    }

}
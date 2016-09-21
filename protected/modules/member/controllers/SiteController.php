<?php

class SiteController extends MemberController
{
    /**
     * Declares class-based actions.
     */
    
    public function accessRules() {
        return array();
    }

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

	public function actionIndex()
	{
        $this->render('index');
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

    public function actionChangePassword(){
        $model = Users::model()->getInforUser(Yii::app()->user->id);
        $model->scenario = 'changeMyPassword';
		$this->pageTitle = "Change password - " . Yii::app()->params["defaultPageTitle"];
		$this->pageHeader = "Change Password";
        if(isset($_POST['Users']))
        {
            $model->attributes=$_POST['Users'];
            if($model->validate())
            {
                $model->password_hash = md5($model->newPassword);
                $model->temp_password = $model->newPassword;
                if($model->update(array('password_hash', 'temp_password'))) {
                    SendEmail::changePassMailToUser($model);
                    Yii::app()->user->setFlash('successChangeMyPassword', "Your password has been changed successfully.");
                }
            }
        }

        $this->render('changePassword',array(
            'model'=>$model,
        ));
    }

    public function actionUpdateProfile(){
        $model = Users::model()->getInforUser(Yii::app()->user->id);
        $model->scenario = 'updateMyProfile';
		$this->pageTitle = "My Account - " . Yii::app()->params["defaultPageTitle"];
		$this->pageHeader = "My Account";
        if(isset($_POST['Users']))
        {
            $model->attributes=$_POST['Users'];
            if($model->save())
            {
                Yii::app()->user->setFlash('success', "Your profile has been changed successfully.");
            }
        }
        $this->render('updateProfile',array(
            'model'=>$model,
        ));
    }
	
	public function actionDocuments()
	{
		$model = new Document();
		$model->unsetAttributes();
		$model->status = 1;
		$this->render('documents', array('model' => $model));
	}
    
    public function actionPrivateDocuments()
	{
		$model = new Document();
		$model->unsetAttributes();
		$model->status = 1;
		$this->render('privatedocuments', array('model' => $model));
	}
	
	public function actionDownloadDocument($id) {
        try {
            $model = Document::model()->findByPk((int)$id);
            
            if (is_null($model))
                throw new Exception('No document found.');
			MyFunctionCustom::forceDownload($model, 'document_file');
            
        } catch (Exception $exc) {
            throw new CHttpException(403, $exc->getMessage());
        }
    }

	
}

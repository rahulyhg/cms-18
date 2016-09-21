<?php

class UsersController extends FrontController
{
	public $attempts = MAX_TIME_TO_SHOW_CAPTCHA;
    public $counter;
	public function actions()
	{
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
	
	private function captchaRequired()
    {           
        return Yii::app()->session->itemAt('captchaRequired') >= $this->attempts;
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

	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error)
		{
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionRegister()
	{
		try
		{
			$this->pageTitle = 'Partner Register - ' . Yii::app()->params['defaultPageTitle'];
			$this->pageHeader = "Partner Registration";
			$model = new Users('createMemberFE');
			$model->area_code_id = 77; //set default for canada
			// Uncomment the following line if AJAX validation is needed
			//$this->performAjaxValidation($model);
			if (isset($_POST['Users']))
			{
				$model->attributes = $_POST['Users'];
				
//                 if ok validate then send sms or email
				if ($model->validate())
				{
					$model->status = STATUS_ACTIVE;
					$model->role_id = ROLE_MEMBER;
					$model->application_id = FE;
					$model->password_hash = md5($model->temp_password);
					$model->verify_code = Users::model()->checkVerifyCode(rand(100000, 1000000)); // Gen verify code and send qua mail or sms
					if ($model->save())
					{
//                      registering successfully, send email to User
						SendEmail::registerSucceedMailToUser($model);
//                      registering successfully, send email to Administrator
						SendEmail::registerSucceedMailToAdmin($model);
						$url = Yii::app()->createAbsoluteUrl('thank-you-for-you-registration');
						$this->redirect($url);
					}
				}
				//else {var_dump($model->getErrors());}
			}
			
			$this->render('register', array(
				'model' => $model
			));
		}
		catch (Exception $e)
		{
			Yii::log("Exception " . print_r($e, true), 'error');
			throw new CHttpException($e);
		}
	}

	public function actionLogin()
	{
		$this->pageTitle = 'Login - ' . Yii::app()->params['defaultPageTitle'];
		$this->pageHeader = "Partner Login";
		$model = $this->captchaRequired() ? new LoginForm('captchaRequired') : new LoginForm();
		$returnUrl = '';
		if (isset($_GET['returnUrl']))
		{
			$returnUrl = urldecode($_GET['returnUrl']);
		}
		// collect user input data
		if (isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];

			if ($returnUrl == 'forum')
			{
				$returnUrl = Yii::app()->createAbsoluteUrl('forum');
			}
			else
			{
				$returnUrl = str_replace('#', '', $returnUrl);
			}

			// validate user input and redirect to the previous page if valid
			//if($model->validate() && $model->login())
			if ($model->validate())
			{
				if (!empty($returnUrl))
				{
					$this->redirect(Yii::app()->createAbsoluteUrl($returnUrl));
				}
				switch (Yii::app()->user->role_id)
				{
					case ROLE_MEMBER:
						$this->redirect(Yii::app()->createAbsoluteUrl('member/site/updateProfile'));
						break;
					case ROLE_ADMIN:
						$this->redirect(Yii::app()->createAbsoluteUrl('admin/site/login'));
						break;

					default :$this->redirect(Yii::app()->createAbsoluteUrl('/'));
				}
				Yii::app()->session->add('captchaRequired', 0);
				Yii::app()->end();
			}
			else
			{
				$this->counter = Yii::app()->session->itemAt('captchaRequired') + 1;
				Yii::app()->session->add('captchaRequired', $this->counter);
			}
		}
		// display the login form
		$this->render('login', array('model' => $model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->createAbsoluteUrl(''));
	}

	/**
	 * This is the action reset password member
	 */
	public function actionForgotPassword()
	{
		$this->pageTitle = 'Forgot Password - ' . Yii::app()->params['defaultPageTitle'];
		$this->pageHeader = "Forgot Password";
		$model = new Users();
		$model->scenario = 'forgotPassword';
		if (isset($_POST['Users']))
		{
			$userM = Users::model()->find('email="' . trim($_POST['Users']['email']) . '"');
			if (!is_null($userM))
			{
				$newPassw = StringHelper::getRandomString(6);
				$userM->password_hash = md5($newPassw);
				$userM->temp_password = $newPassw;
				$userM->update();

				SendEmail::forgetPassMailToUser($userM);
			}
			else
			{
				$errorNotice = 'Your typed email does not existed. Please check it again.';
				$model->addError('email', $errorNotice);
			}
		}
		$this->render('forgot_password', array('model' => $model));
	}

	public function actionQuote()
	{
		$model = new Enquiry('create');
		$this->pageTitle = 'Quote request - ' . Yii::app()->params['defaultPageTitle'];
		$this->pageHeader = "Quote request";
		$model->country = 'Canada';
		if (isset($_POST['Enquiry'])) {
			$model->attributes = $_POST['Enquiry'];
			if($model->save())
			{
				$model->saveImage('blue_print_attached');
				$model->saveImage('picture_attached');
                SendEmail::quoteMailToAdmin($model);
                SendEmail::quoteMailToUser($model);
				$this->redirect(Yii::app()->createAbsoluteUrl("thank-you-for-your-quoted"));
			}
		
		}
		$this->render('quote', array('model' => $model));
	}
}

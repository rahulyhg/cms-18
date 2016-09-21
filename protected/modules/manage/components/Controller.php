<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	public $title;

    public $stats=array();

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public function filters()
    {
        return array(
            'authentication - login,logout',
        );
    }

    public function beforeRender($view) {
    	if (Yii::app()->user->role == 2) {throw new CHttpException(404,'The specified post cannot be found.');}
        $this->stats=Visit::model()->countData();
        $this->stats['appointment']=Appointment::model()->countFuture();
        $this->stats['message']=Notice::model()->countNew();
        return true;
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

	public function filterAuthentication($filterChain) {
    	if(Yii::app()->user->isGuest) {
    		$this->redirect(array('/admin/site/login'));
		}
		else {
			// check if current user is admin
			$user = User::model()->findByPk(Yii::app()->user->id);
			if (!$user || !isset(Yii::app()->user->username) || $user->username != Yii::app()->user->username) {
				$this->redirect(array('/admin/site/logout'));
			}
			$filterChain->run();
		}
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
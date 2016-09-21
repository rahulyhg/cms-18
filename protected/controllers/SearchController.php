<?php

class SearchController extends FrontController
{
	 /**
	 * Declares class-based actions.
	 */
    public $searchKey;

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


    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        $error=Yii::app()->errorHandler->error;

            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);

    }
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */

	public function actionIndex(){
        try {
            $model = new SearchForm('search');
            $searchValue = trim($_POST['searchkey']);
            $this->searchKey = $searchValue;
            if(isset($searchValue))
                {
                    $model->title = $searchValue ;
                    $model->description = $searchValue ;
                }
            $this->render('page',array(
                'model'=>$model
            ));
        }catch (Exception $exc){
            throw new Exception($exc->getMessage());
        }
	}
}
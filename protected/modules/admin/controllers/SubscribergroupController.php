<?php

class SubscriberGroupController extends AdminController
{
    public $pluralTitle = 'Subscriber Groups';
    public $singleTitle = 'Subscriber Group';
    public $cannotDetele = array();
    public function actionCreate(){
        try {
            $model = new SubscriberGroup('create');
            if (isset($_POST['SubscriberGroup'])) {
                $model->attributes = $_POST['SubscriberGroup'];
                if($model->save())
				{
										$this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
                    $this->redirect(array('view', 'id'=> $model->id));
				}
				else
					$this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
            }
            $this->render('create', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
            ));
        }catch (exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionDelete($id) {
        try {
            if(Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
				if (!in_array($id, $this->cannotDetele))
				{
					if($model = $this->loadModel($id)){
												if($model->delete())
							Yii::log("Delete record ".  print_r($model->attributes, true), 'info');
					}

					// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
					if(!isset($_GET['ajax']))
						$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
				}
            } else {
                Yii::log("Invalid request. Please do not repeat this request again.");
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            }
        } catch (Exception $e) {
            Yii::log("Exception ".  print_r($e, true), 'error');
            throw  new CHttpException($e);
        }
    }      
    
    public function actionIndex() {
        try {
            $model=new SubscriberGroup('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['SubscriberGroup']))
                $model->attributes=$_GET['SubscriberGroup'];

            $this->render('index',array(
                'model'=>$model, 'actions' => $this->listActionsCanAccess,
            ));
        } catch (Exception $e) {
            Yii::log("Exception ".  print_r($e, true), 'error');
            throw  new CHttpException($e);
        }
    }

    public function actionUpdate($id) {
        $model=$this->loadModel($id);
        if(isset($_POST['SubscriberGroup']))
        {
            $model->attributes=$_POST['SubscriberGroup'];
            if ($model->save())
			{
                $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
				$this->redirect(array('view', 'id'=> $model->id));
			}
			else
				$this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
        }
        //$model->beforeRender();
        $this->render('update',array(
            'model' => $model,
            'actions' => $this->listActionsCanAccess,
            'title_name' => $model->name        ));
    }

    
    public function actionView($id) {
        try {
            $model = $this->loadModel($id);
            $this->render('view', array(
                'model'=> $model,
                'actions' => $this->listActionsCanAccess,
                'title_name' => $model->name            ));
        } catch (Exception $exc) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

	/*
	* Bulk delete
	* If you don't want to delete some specified record please configure it in global $cannotDetele variable
	*/
	public function actionDeleteAll()
	{
		$deleteItems = $_POST['subscriber-group-grid_c0'];
		$shouldDelete = array_diff($deleteItems, $this->cannotDetele);

		if (!empty($shouldDelete))
		{
						SubscriberGroup::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
			$this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
		}
		else
			$this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
    
    public function actionSynchronize()
	{
        $groups = SubscriberGroup::model()->findAll();
        if(!empty($groups))
            foreach ($groups as $group) {
                $group->addMailchimp();
                $subscribers = Subscriber::model()->findAll("subscriber_group_id = $group->id");
                if(!empty($subscribers))
                    foreach ($subscribers as $subscriber) {
                        $subscriber->addMailchimp();
                    }
            }
        $this->redirect(array('index'));
	}
	
		
    public function loadModel($id){
		//need this define for inherit model case. Form will render parent model name in control if we don't have this line
		$initMode = new SubscriberGroup();
        $model=$initMode->findByPk($id);
        $model->oldObj = clone $model;
        if($model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
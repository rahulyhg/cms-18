<?php

class GalleriesController extends AdminController
{

	public $pluralTitle = 'Gallery';
	public $singleTitle = 'Gallery';
	public $cannotDetele = array();

	public function actionCreate()
	{
		try
		{
			$model = new Gallery('create');
			if (isset($_POST['Gallery']))
			{
				$model->attributes = $_POST['Gallery'];
				if ($model->save())
				{
                    $model->saveImage('fileurl');
					$this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
					$this->redirect(array('view', 'id' => $model->id));
				}
				else
					$this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
			}
			$this->render('create', array(
				'model' => $model,
				'actions' => $this->listActionsCanAccess,
			));
		}
		catch (exception $e)
		{
			Yii::log("Exception " . print_r($e, true), 'error');
			throw new CHttpException($e);
		}
	}

	public function actionDelete($id)
	{
		try
		{
			if (Yii::app()->request->isPostRequest)
			{
				// we only allow deletion via POST request
				if (!in_array($id, $this->cannotDetele))
				{
					if ($model = $this->loadModel($id))
					{
						//call delete image first
						$model->removeImage(array('fileurl'), true);
						if ($model->delete())
							Yii::log("Delete record " . print_r($model->attributes, true), 'info');
					}

					// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
					if (!isset($_GET['ajax']))
						$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
				}
			} else
			{
				Yii::log("Invalid request. Please do not repeat this request again.");
				throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
			}
		}
		catch (Exception $e)
		{
			Yii::log("Exception " . print_r($e, true), 'error');
			throw new CHttpException($e);
		}
	}

	public function actionPhotos()
	{
		try
		{
            $modelPhoto = new Gallery('photos');
            $modelPhoto->scenario = 'photos';
            if (isset($_POST['Gallery']))
            {
                $modelPhoto->attributes = $_POST['Gallery'];
                $modelPhoto->section = 0;
                if ($modelPhoto->save())
                {
                    $modelPhoto->saveImage('fileurl');
                    $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
                    $this->redirect(array('photos', 'id' => $modelPhoto->id));
                }
                else
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
            }


            $model = new Gallery('search');
			$model->unsetAttributes();  // clear any default values
			if (isset($_GET['Gallery']))
				$model->attributes = $_GET['Gallery'];
				$model->section = 0;

			$this->render('photos', array(
				'model' => $model,
				'modelPhoto' => $modelPhoto,
                'actions' => $this->listActionsCanAccess,
			));
		}
		catch (Exception $e)
		{
			Yii::log("Exception " . print_r($e, true), 'error');
			throw new CHttpException($e);
		}
	}

    public function actionVideos()
	{
		try
		{
            $modelVideo = new Gallery('videos');
            $modelVideo->scenario='videos';
            if (isset($_POST['Gallery']))
            {
                $modelVideo->attributes = $_POST['Gallery'];
                $modelVideo->section = 1;
                if ($modelVideo->save())
                {
                    $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
                    $this->redirect(array('videos'));
                }
                else
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
            }


            $model = new Gallery('search');
			$model->unsetAttributes();  // clear any default values
			if (isset($_GET['Gallery']))
				$model->attributes = $_GET['Gallery'];
				$model->section = 1;

			$this->render('videos', array(
				'model' => $model,
				'modelVideo' => $modelVideo,
                'actions' => $this->listActionsCanAccess,
			));
		}
		catch (Exception $e)
		{
			Yii::log("Exception " . print_r($e, true), 'error');
			throw new CHttpException($e);
		}
	}

	public function actionUpdateVideo($id)
	{
		$model = $this->loadModel($id);
        $model->scenario='updatevideo';
		if (isset($_POST['Gallery']))
		{
			$model->attributes = $_POST['Gallery'];
            $model->section = 1;
           // var_dump($model);
			if ($model->save())
			{
				$this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
				$this->redirect(array('videos'));
			}
			else
				$this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
		}
		//$model->beforeRender();
		$this->render('updatevideo', array(
			'model' => $model,
			'actions' => $this->listActionsCanAccess,
			'title_name' => $model->title));
	}
    public function actionUpdatePhoto($id)
    {
        $model = $this->loadModel($id);
        $model->scenario='updatephoto';
        if (isset($_POST['Gallery']))
        {
            $model->attributes = $_POST['Gallery'];
            $model->section = 0;
            // var_dump($model);
            if ($model->save())
            {
                $model->saveImage('fileurl');
                $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
                $this->redirect(array('photos'));
            }
            else
                $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
        }
        //$model->beforeRender();
        $this->render('updatephoto', array(
            'model' => $model,
            'actions' => $this->listActionsCanAccess,
            'title_name' => $model->title));
    }
	public function actionView($id)
	{
		try
		{
			$model = $this->loadModel($id);
			$this->render('view', array(
				'model' => $model,
				'actions' => $this->listActionsCanAccess,
				'title_name' => $model->title));
		}
		catch (Exception $exc)
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}
	}

	/*
	 * Bulk delete
	 * If you don't want to delete some specified record please configure it in global $cannotDetele variable
	 */

	public function actionDeleteAll()
	{
		$deleteItems = $_POST['gallery-grid_c0'];
		$shouldDelete = array_diff($deleteItems, $this->cannotDetele);

		if (!empty($shouldDelete))
		{
			$deleteImages = Page::model()->findAll('id in (' . implode(',', $shouldDelete) . ')');
			if (!empty($deleteImages))
			{
				foreach ($deleteImages as $item)
				{
					$item->removeImage(array('fileurl'), true);
				}
			} Gallery::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
			$this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
		}
		else
			$this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('photos'));
	}
    public function actionDeleteVideos()
    {
        $deleteItems = $_POST['gallery-grid_c0'];
        $shouldDelete = array_diff($deleteItems, $this->cannotDetele);

        if (!empty($shouldDelete))
        {
            Gallery::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        }
        else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('videos'));
    }
	/*
	 * Remove upload image 
	 * Only files are deleted not folder. Run in ajax mode. Can modify in custom.js admin theme
	 */

	public function actionRemoveImage($fieldName, $id)
	{
		try
		{
			$model = $this->loadModel((int) $id);
			$model->removeImage(array($fieldName));
			echo 'thumbnail-' . $id;
		}
		catch (Exception $exc)
		{
			echo '';
		}
	}

	public function loadModel($id)
	{
		//need this define for inherit model case. Form will render parent model name in control if we don't have this line
		$initMode = new Gallery();
		$model = $initMode->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

}

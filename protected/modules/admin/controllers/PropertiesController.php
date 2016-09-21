<?php

class PropertiesController extends AdminController {

    public $pluralTitle = 'Properties';
    public $singleTitle = 'Properties';
    public $cannotDetele = array();

    public function actionCreate() {
        try {
            $model = new Properties('create');



            $html_over_view = '<table class="project-info" style="margin: 0px 0px 30px; padding: 0px; outline: 0px; border: 1px solid rgb(89, 0, 0); font-size: 12px; vertical-align: baseline; list-style: none; border-collapse: collapse; border-spacing: 0px; width: 879px; position: relative; color: rgb(102, 102, 102); font-family: Arial, Helvetica, sans-serif; line-height: normal; clear: both !important; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">
                    <tbody style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Description</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Developer</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Design Architect</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Local Architect</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Landscape Architect</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Project Interior Designer</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Showflat Interior Designer</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Builder / Main Contractor</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Civil / Structrual Engineer</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Mechanical / Electrical Engineer</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Conveyance Solicitor</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Address</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Tenure</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Site Area</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Expected TOP</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Expected Legal Completion</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">No of Carpark Lots</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Plot Ratio</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Project Account<br style="margin: 0px; padding: 0px; outline: none;" />
			(By Cheque)</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Project Account<br style="margin: 0px; padding: 0px; outline: none;" />
			(By Telegraphic Transfer)</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Facilities</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
		<tr style="margin: 0px; padding: 0px; outline: 0px; border: 0px; vertical-align: baseline; list-style: none; background: transparent;">
			<th scope="row" style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; color: rgb(255, 255, 255); width: 150px; vertical-align: top !important; background: rgb(123, 0, 0);">Showflat Units</th>
			<td style="margin: 0px; padding: 10px 15px; outline: 0px; border: 1px solid rgb(89, 0, 0); list-style: none; line-height: 18px; vertical-align: top !important; background: transparent;">&nbsp;</td>
		</tr>
                </tbody>
            </table>
           ';


            $model->over_view = $html_over_view;
            if (isset($_POST['Properties'])) {
                $model->attributes = $_POST['Properties'];
                $model->posted_by = Yii::app()->user->id;
                if ($model->save()) {
                    $model->saveImage('featured_image');
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
        } catch (exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionDelete($id) {
        try {
            if (Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                if (!in_array($id, $this->cannotDetele)) {
                    if ($model = $this->loadModel($id)) {
                       
                        $deleteFile = Brouchures::model()->findAll('property_id='.$id.'');
                        if (!empty($deleteFile)){
                            foreach ($deleteFile as $item) {
                                $item->removeFile(array('file_name'), true);
                            }
                            $item->delete();
                        } 
                        
                        $deleteBanners = PropertyBanners::model()->findAll('property_id in (' . $id . ')');
                        if (!empty($deleteBanners)) {
                            foreach ($deleteBanners as $item) {
                                $item->removeImage(array('large_image'), true);
                            }
                            $item->delete();
                        }

                        $deleteTracking = Brouchuredownloads::model()->deleteAll('property_id in (' . $id . ')');
            
                        $model->removeImage(array('featured_image'), true);
                        
                        if ($model->delete())
                            Yii::log("Delete record " . print_r($model->attributes, true), 'info');
                        }

                    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//                    if (!isset($_GET['ajax']))
//                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
            } else {
                Yii::log("Invalid request. Please do not repeat this request again.");
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionIndex() {
        try {
            $model = new Properties('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Properties']))
                $model->attributes = $_GET['Properties'];

            $this->render('index', array(
                'model' => $model, 'actions' => $this->listActionsCanAccess,
            ));
       } catch (Exception $e) {
          Yii::log("Exception " . print_r($e, true), 'error');
          throw new CHttpException($e);
        }
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['Properties'])) {
            $model->attributes = $_POST['Properties'];
            if ($model->save()) {
                $model->saveImage('featured_image');
                $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
                $this->redirect(array('view', 'id' => $model->id));
            }
            else
                $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
        }
        //$model->beforeRender();
        $this->render('update', array(
            'model' => $model,
            'actions' => $this->listActionsCanAccess,
            'title_name' => $model->title));
    }

    public function actionView($id) {
        try {
            $model = $this->loadModel($id);
            $this->render('view', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
                'title_name' => $model->title));
        } catch (Exception $exc) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    /*
     * Bulk delete
     * If you don't want to delete some specified record please configure it in global $cannotDetele variable
     */

    public function actionDeleteAll() {
        $deleteItems = $_POST['Properties-grid_c0'];
        $shouldDelete = array_diff($deleteItems, $this->cannotDetele);
       
        if (!empty($shouldDelete)) {
            $deleteFile = Brouchures::model()->findAll('property_id in (' . implode(',', $shouldDelete) . ')');
            if (!empty($deleteFile)) {
                foreach ($deleteFile as $item) {
                    $item->removeFile(array('file_name'), true);
                }
                $item->delete();
            } 
            $deleteBanners = PropertyBanners::model()->findAll('property_id in (' . implode(',', $shouldDelete) . ')');
            if (!empty($deleteBanners)) {
                foreach ($deleteBanners as $item) {
                    $item->removeImage(array('large_image'), true);
                }
                $item->delete();
            }
            
            $deleteTracking = Brouchuredownloads::model()->deleteAll('property_id in (' . implode(',', $shouldDelete) . ')');
            
            $deleteImages =  Properties::model()->findAll('id in (' . implode(',', $shouldDelete) . ')');
            if (!empty($deleteImages)) {
                foreach ($deleteImages as $item) {
                    $item->removeImage(array('featured_image'), true);
                }
            } 
            Properties::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        }
        else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function loadModel($id) {
        //need this define for inherit model case. Form will render parent model name in control if we don't have this line
        $initMode = new Properties();
        $model = $initMode->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
<?php

class Services
{
    public function performSubmit($post)
    {
        try
        {
            if(isset($post))
            {
                if (isset($post['Valuationrequests'])) {
                    $model = new Valuationrequests();
                    $model->attributes = $post['Valuationrequests'];
                    //$model->resouce_type = 1;
                    CActiveForm::validate($model);
                    if (!$model->getErrors()) {
                        $model->save();
                        Yii::app()->user->setFlash('valuationrequest', 'Thanks you for your submitted on valuation request !');
                        SendEmail::noticeValuationRequestMailToAdmin($model);
                        SendEmail::confirmValuationRequestMailToUser($model);

                        //reset model
                        $model = new Valuationrequests();
                        $model->pes = 1;
                    } else {
                        Yii::log(print_r($model->getErrors(), true), 'error', 'ShowValuationRequestWidget.process');
                    }
                    return $model;
                }
                elseif(isset($post['Propertysearch'])) {
                    $model = new Propertysearch();
                    $model->attributes = $post['Propertysearch'];
                    //$model->resouce_type = 1;
                    CActiveForm::validate($model);
                    if (!$model->getErrors()) {
                        $model->save();
                        Yii::app()->user->setFlash('propertysearch', 'Thanks you for your submitted on property search !');
                        SendEmail::noticePropertySearchMailToAdmin($model);
                        SendEmail::confirmPropertySearchMailToUser($model);

                        //reset model
                        $model = new Propertysearch();
                        $model->ready = 1;
                    } else {
                        Yii::log(print_r($model->getErrors(), true), 'error', 'ShowPropertySearchWidget.process');
                    }
                    return $model;
                }
            }
        }
        catch (Exception $e)
        {
            Yii::log("Exception ".  print_r($e, true), 'error');
            throw  new CHttpException("Exception ".  print_r($e, true));
        }
    }

}
<?php

class SiteController extends OnlinetimeslotController
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionEdit($id)
    {
        $model = Doctor::model()->findByPk($id);
        $this->render('edit', array(
            'model' => $model,
        ));
    }
}
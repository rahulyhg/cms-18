<?php

class CmsController extends FrontController {

    /**
     * Declares class-based actions.
     */
    public function actions() {
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

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $error = Yii::app()->errorHandler->error;

        if (Yii::app()->request->isAjaxRequest)
            echo $error['message'];
        else
            $this->render('error', $error);
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex($slug) {
        try {
            
            $model = Page::model()->getDetailBySlug($slug);
            if (empty($model))
                $this->redirect(array('error'));
            Page::model()->getRoot($model->id, $rootPage);
            $this->pageTitle = $rootPage->title . ' - ' . Yii::app()->params['defaultPageTitle'];
            $this->pageHeader = $rootPage->title;
            $childPages = Page::model()->getPageTree(true, $rootPage->id);

            if ($model->meta_keywords != '')
                $this->setMetaKeywords($model->meta_keywords);

            if ($model->meta_desc != '')
                $this->setMetaDescription($model->meta_desc);

            $this->render('page', array(
                'model' => $model,
                'rootPage' => $rootPage,
                'childPages' => $childPages,
            ));
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }

}

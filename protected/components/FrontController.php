<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FrontController extends _BaseController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/site';
    public static $errorCss = 'has-error';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    public $stats = array();
    public $client;

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $_metaKeyword;
    public $pageHeader;
    public $_metaDescription;
    public static $activedPage;
    public $searchKey;
    public $featuredProperty;
    public $mBanner;
    public $propertyBanner;
    public $title;
    public $iconList = '<span class="glyphicon glyphicon-th-list"></span>';
    public $iconEdit = '<span class="glyphicon glyphicon-pencil"></span>';
    public $iconCancel = '<span class="glyphicon glyphicon-remove"></span>';
    public $iconSave = '<span class="glyphicon glyphicon-floppy-disk"></span>';
    public $iconCreate = '<span class="glyphicon glyphicon-plus"></span>';
    public $iconDelete = '<span class="glyphicon glyphicon-trash"></span>';
    public $iconSearch = '<span class="glyphicon glyphicon-search"></span>';
    public $iconBack = '<span class="glyphicon glyphicon-arrow-left"></span>';
    public $iconPrint = '<span class="glyphicon glyphicon-print"></span>';

    public function init() {
        //$this->googleAuthorization();
        Yii::$classMap = array_merge(Yii::$classMap, array(
            'CaptchaExtendedAction' => Yii::getPathOfAlias('ext.captchaExtended') . DIRECTORY_SEPARATOR . 'CaptchaExtendedAction.php',
            'CaptchaExtendedValidator' => Yii::getPathOfAlias('ext.captchaExtended') . DIRECTORY_SEPARATOR . 'CaptchaExtendedValidator.php'
        ));
    }

    protected function beforeAction($action) {
         if (Yii::app()->user->isGuest && !($action->controller->id == 'site' && $action->id == 'login')) {
             $this->redirect(array('site/login'));
         }
        return parent::beforeAction($action);
    }

    // public function filters() {
    //     return array(
    //         'authentication - login,logout',
    //     );
    // }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {

            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function showErrorCss($model, $attribute) {
        if ($model->hasErrors($attribute)) {
            echo ' ' . Controller::$errorCss;
        }
    }

    public function showErrorWarning($model) {
        if ($model->hasErrors()) {
            echo '<div class="alert alert-dismissable alert-danger"><strong>Oh Snap!</strong> You have created some errors...</div>';
        }
    }

    public function salutationList() {
        return array(
            'Mr' => Yii::t('static', 'Mr'),
            'Ms' => Yii::t('static', 'Ms'),
            'Mrs' => Yii::t('static', 'Mrs'),
            'Mdm' => Yii::t('static', 'Mdm'),
            'Dr' => Yii::t('static', 'Dr'),
            'Prof' => Yii::t('static', 'Prof'),
            'A/Prof' => Yii::t('static', 'A/Prof'),
            'Adjunct Prof' => Yii::t('static', 'Adjunct Prof'),
            'Adjunct A/Prof' => Yii::t('static', 'Adjunct A/Prof'),
        );
    }

    public function maritalList() {
        return array(
            'Single' => Yii::t('static', 'Single'),
            'Married' => Yii::t('static', 'Married'),
            'Divorced' => Yii::t('static', 'Divorced'),
            'Widow' => Yii::t('static', 'Widow'),
            'Widower' => Yii::t('static', 'Widower'),
        );
    }

    public function genderList() {
        return array(
            'Male' => Yii::t('static', 'Male'),
            'Female' => Yii::t('static', 'Female'),
        );
    }

    public function contactTypeList() {
        return array(
            'Mobile' => Yii::t('static', 'Mobile'),
            'Home' => Yii::t('static', 'Home'),
            'Work' => Yii::t('static', 'Work'),
            'Others' => Yii::t('static', 'Others'),
        );
    }

    public function importBooking() {
        $url = Yii::app()->createAbsoluteUrl('import/importBookingBG');
        Yii::app()->clientScript->registerScript('import', "
            $(function(){
                $.post('" . $url . "');
            });
        ");
    }

    public function syncGoogleCalendar() {
        $url = Yii::app()->createAbsoluteUrl('googleSync/syncall');
        Yii::app()->clientScript->registerScript('sync', "
            $(function(){
                $.post('" . $url . "');
            });
        ");
    }

    public function googleAuthorization() {

        if (empty(Yii::app()->params['googleClient']['id']) || empty(Yii::app()->params['googleClient']['secret']))
            throw new Exception("Please set 65doctor API Client authentication info, or contact to 65doctor.com");
        $this->client = new Google_Client();
        $this->client->setApplicationName("Client_Library_Examples");
        $this->client->setClientId(Yii::app()->params['googleClient']['id']);
        $this->client->setClientSecret(Yii::app()->params['googleClient']['secret']);
        $this->client->setRedirectUri(Yii::app()->params['googleClient']['redirect_uri']);
        $this->client->setAccessType('offline');   // Gets us our refreshtoken
        $this->client->setApprovalPrompt('force');
        $this->client->setScopes(array('https://www.googleapis.com/auth/calendar'));
        $mUser = User::model()->findByPk(Yii::app()->user->id);
        if (isset($_GET['code'])) {
            $this->client->authenticate($_GET['code']);
            $_SESSION['token'] = $this->client->getAccessToken();
            Yii::app()->settings->setDbItem('google_token', $_SESSION['token']);
            $this->redirect(array('/site/index'));
        }

        if (Yii::app()->settings->getItem('google_token') != '') {
            $_SESSION['token'] = Yii::app()->settings->getItem('google_token');
        }

        // Step 1:  The user has not authenticated we give them a link to login
        if (isset($_SESSION['token'])) {
            $this->client->setAccessToken($_SESSION['token']);
            if ($this->client->isAccessTokenExpired()) {
                if (Yii::app()->settings->getItem('google_token') != '') {
                    $refreshToken = json_decode(Yii::app()->settings->getItem('google_token'))->refresh_token;
                    $this->client->refreshToken($refreshToken);
                    $_SESSION['token'] = $this->client->getAccessToken();
                    $this->client->setAccessToken($_SESSION['token']);
                }
            }

            Yii::app()->settings->setDbItem('google_token', $_SESSION['token']);
            //Create new calendar to sync

            $service = new Google_Service_Calendar($this->client);
            $doctors = Doctor::model()->findAll();
            foreach ($doctors as $doctor) {
                if (empty($doctor->google_calendar_id)) {
                    try {
                        $calendar = new Google_Service_Calendar_Calendar();
                        $calendar->setSummary($doctor->name);
                        $createdCalendar = $service->calendars->insert($calendar);
                        $doctor->google_calendar_id = $createdCalendar->getId();
                        $doctor->update();
                    } catch (Google_ServiceException $e) {
                        var_dump($e);
                    }
                }
            }
        }

        if (isset($_GET['unlink'])) {//Unlink google calendar
            $service = new Google_Service_Calendar($this->client);
            $doctors = Doctor::model()->findAll();
            foreach ($doctors as $doctor) {
                try {
                    $service->calendars->delete($doctor->google_calendar_id); //remove calendar
                    $doctor->google_calendar_id = '';
                    $doctor->update();
                } catch (Google_ServiceException $e) {
                    var_dump($e);
                }
            }
            unset($_SESSION['token']);
            Yii::app()->settings->setDbItem('google_token', '');
            $synLog = GoogleSyncLog::model()->deleteAll();
            $this->redirect(array('site/index'));
        }
    }

    public function filterAuthentication($filterChain) {

        if (Yii::app()->user->isGuest) {
            if (Yii::app()->controller->action->id != 'login' && Yii::app()->controller->action->id != 'logout')
                Yii::app()->session['redirect'] = Yii::app()->controller->id . '/' . Yii::app()->controller->action->id;
            $this->redirect(array('site/login'), true);
        }
        else {
            $model = User::model()->findByPk(Yii::app()->user->id);
            if ($model->is_new) {
                if (Yii::app()->controller->action->id != 'termsAndConditions')
                    $this->redirect(array('site/termsAndConditions'), true);
            }
        }
        $filterChain->run();
    }

    public function getMetaKeywords() {
        if (!empty($this->_metaKeyword))
            return $this->_metaKeyword;
        else {
            return Yii::app()->params['meta_keywords'];
        }
    }

    public function setMetaKeywords($value) {
        $this->_metaKeyword = $value;
    }

    public function getMetaDescription() {
        if (!empty($this->_metaDescription))
            return $this->_metaDescription;
        else {
            return Yii::app()->params['meta_description'];
        }
    }

    public function setMetaDescription($value) {
        $this->_metaDescription = $value;
    }

    public function baseControllerIndexUrl($extendUrl = '') {

        if ($extendUrl != '')
            return Yii::app()->createAbsoluteUrl(Yii::app()->controller->id . '/' . $extendUrl);
        else {
            return Yii::app()->createAbsoluteUrl(Yii::app()->controller->id);
        }
    }

}

?>
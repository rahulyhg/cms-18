<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SettingForm extends CFormModel {

    //email
    public $transportType; //php or smtp
    public $smtpHost;
    public $smtpUsername;
    public $smtpPassword;
    public $smtpPort;
    public $encryption;
    public $adminEmail;
    public $autoEmail;
    public $mailSenderName;
    //general
    public $currencySign;
    public $dateFormat;
    public $timeFormat;
    public $loginLimitTimes;
    public $timeRefreshLogin;
    public $defaultPageSize;
    public $googleAnalytics;
    //contact info
    public $contactTitle;
    public $companyName;
    public $companyAddress;
    public $doctorName;
    public $file;
    //paypal
    public $paypalURL;
    public $paypalBusinessEmail;
    public $paypalMode;
    public $paypalMinimum;
    public $paypalCurrency;
    //page setting
    public $baseUrl;
    public $projectName;
    public $defaultPageTitle;
    public $metaDescription;
    public $metaKeywords;
    public $twitter;
    public $facebook;
    public $linkedin;
    public $googlePlus;
    public $rss;
    public $copyrightOnFooter;
    //mailchimp
    public $mailchimpOn;
    public $mailchimpApiKey;
    public $mailchimpListId;
    public $mailchimpTitleGroups;
    public static $smtpFields = array('host' => 'smtpHost', 'username' => 'smtpUsername', 'password' => 'smtpPassword',
        'port' => 'smtpPort', 'encryption' => 'encryption');

    /*
     * Austin added date 6/7/2014
     * First element of array is Group Name
     * Items inside are controls in each tab. You should put enough attributes as below to get rid errors
     * Now it just support control text, textarea, editor (add html class my-editor-basic or my-editor-full), image, dropdown
     * Feel free to add more 
     */
    public static $settingDefine = array(
        "pagesetting" => array(
            'label' => 'Website',
            'htmlOptions' => array(),
            'items' => array(
                array('name' => 'baseUrl', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'projectName', 'controlTyle' => 'text', 'notes' => 'For backend only', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'doctorName', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'defaultPageTitle', 'controlTyle' => 'text', 'notes' => 'For Front only', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'metaDescription', 'controlTyle' => 'textarea', 'notes' => '', 'unit' => '', 'htmlOptions' => array('cols' => 77, 'rows' => 4), 'rules' => ''),
                array('name' => 'metaKeywords', 'controlTyle' => 'textarea', 'notes' => '', 'unit' => '', 'htmlOptions' => array('cols' => 77, 'rows' => 4), 'rules' => ''),
                
            ),
        ),
        "generalsetting" => array(
            'label' => 'General',
            'htmlOptions' => array(),
            'items' => array(
                array('name' => 'currencySign', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
                array('name' => 'dateFormat', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'timeFormat', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'loginLimitTimes', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required,numerical'),
                array('name' => 'timeRefreshLogin', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required,numerical'),
                array('name' => 'defaultPageSize', 'controlTyle' => 'text', 'notes' => '', 'unit' => 'records per page', 'htmlOptions' => array('size' => 80), 'rules' => 'required,numerical'),
            ),
        ),
        "emailsetting" => array(
            'label' => 'Email',
            'htmlOptions' => array(),
            'items' => array(
                array('name' => 'mailSenderName', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'adminEmail', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required,email'),
                array('name' => 'autoEmail', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required,email'),
                array('name' => 'transportType', 'controlTyle' => 'dropdown', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('' => 'PHP', 'smtp' => 'Smtp'), 'rules' => ''),
                array('name' => 'smtpHost', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
                array('name' => 'smtpUsername', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
                array('name' => 'smtpPassword', 'controlTyle' => 'password', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
                array('name' => 'smtpPort', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
                array('name' => 'encryption', 'controlTyle' => 'dropdown', 'notes' => '', 'unit' => '', 'data' => array('' => 'None', 'ssl' => 'SSL', 'tls' => 'TLS'), 'rules' => ''),
            ),
        ),

    );

    public function rules() {
        $return = array();
        // for reuired attribute
        $requiredRule = self::getRules('required');
        if ($requiredRule != '')
            $return [] = array($requiredRule, 'required');

        // for numerical attribute
        $numerical = self::getRules('numerical');
        if ($numerical != '')
            $return [] = array($numerical, 'numerical', 'integerOnly' => true);

        // for email attribute
        $email = self::getRules('email');
        if ($email != '')
            $return [] = array($email, 'email');

        // for file attribute
//        $file = self::getRules('file');
//        if ($file != '') {
//            $return[] = array($file, 'file', 'on' => 'updateSettings',
//                'allowEmpty' => true,
//                'types' => 'jpg,gif,png,tiff',
//                'wrongType' => 'Only jpg,gif,png,tiff allowed',
//                'maxSize' => 1024 * 1024 * 3, // 8MB
//                'tooLarge' => 'The file was larger than 3MB. Please upload a smaller file.',
//            );
//            $return[] = array('$file', 'match', 'pattern' => '/^[^\\/?*:&;{}\\\\]+\\.[^\\/?*:&;{}\\\\]{3}$/', 'message' => 'Upload files name cannot include special characters: &%$#', 'on' => 'updateSettings');
//        }
        // for safe attribute
        $return[] = array(implode(',', self::getAllAttributes()), 'safe');
        return $return;
    }

    /*
     * Austin added date 6/7/2014
     * Override configurations.
     * This function is called in index.php and cron.php in root 
     */

    public static function applySettings() {
        $attributeList = self::getAllAttributes();
        if ($attributeList && is_array($attributeList)) {
            foreach ($attributeList as $item) {
                //check tranport type
                if ($item == 'transportType' && Yii::app()->setting->getItem($item)) {
                    Yii::app()->mail->transportType = Yii::app()->setting->getItem($item);
                }
                //get SMTP info
                if (Yii::app()->mail->transportType == 'smtp') {
                    if (in_array($item, self::$smtpFields)) {
                        if (Yii::app()->setting->getItem($item)) {
                            foreach (self::$smtpFields as $k => $v) {
                                if ($v == $item)
                                    Yii::app()->mail->transportOptions[$k] = Yii::app()->setting->getItem($item);
                            }
                        }
                    }
                }
                else {
                    Yii::app()->mail->transportOptions = '';
                }

                // none SMTP fields
                if (!in_array($item, self::$smtpFields) && Yii::app()->setting->getItem($item)) {
                    Yii::app()->params[$item] = Yii::app()->setting->getItem($item);
                }
            }
        }
    }

    /*
     * Austin added date 6/7/2014
     * get all attributes from setting array
     */

    public static function getAllAttributes() {
        $attributes = array();
        if (self::$settingDefine && is_array(self::$settingDefine)) {
            foreach (self::$settingDefine as $item) {
                $itemObj = (object) $item;
                if ($itemObj->items && is_array($itemObj->items)) {
                    foreach ($itemObj->items as $setItem) {
                        $setItem = (object) $setItem;
                        $attributes[] = $setItem->name;
                    }
                }
            }
        }
        return $attributes;
    }

    /*
     * Austin added date 7/7/2014
     * Build model validation rule
     */

    protected static function getRules($ruleName) {
        $attributes = array();
        if (self::$settingDefine && is_array(self::$settingDefine)) {
            foreach (self::$settingDefine as $item) {
                $itemObj = (object) $item;
                if ($itemObj->items && is_array($itemObj->items)) {
                    foreach ($itemObj->items as $setItem) {
                        $setItem = (object) $setItem;
                        if (strpos($setItem->rules, $ruleName) !== false)
                            $attributes[] = $setItem->name;
                    }
                }
            }
        }
        return $attributes;
    }

}

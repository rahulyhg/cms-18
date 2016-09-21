<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SettingPatientForm extends CFormModel {

    //general
    public $prefix_reference_no; 

    /*
     * Austin added date 6/7/2014
     * First element of array is Group Name
     * Items inside are controls in each tab. You should put enough attributes as below to get rid errors
     * Now it just support control text, textarea, editor (add html class my-editor-basic or my-editor-full), image, dropdown
     * Feel free to add more 
     */
    public static $settingDefine = array(
        "patientsetting" => array(
            'label' => 'Patient',
            'htmlOptions' => array(),
            'items' => array(
                array('name' => 'prefix_reference_no', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
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

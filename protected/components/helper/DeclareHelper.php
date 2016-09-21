<?php
class DeclareHelper
{
    public static $statusFormat = array(STATUS_ACTIVE =>'Active', STATUS_INACTIVE=>'Inactive');
    public static $yesNoFormat = array(TYPE_YES => 'Yes', TYPE_NO =>'No');
    public static $followFormat = array(TYPE_YES => 'Insurance List Price', TYPE_NO =>'Clinic Price');
    public static $referralFormat = array(1 => 'By Doctor', 2 =>'By Other', 3 => 'No');
    public static $toBillInsuranceFormat = array(1 => 'Yes', 0 =>'No', 3 => 'Patient to pay first and claim from insurance later');
    public static $yesNoDontKnowFormat = array(TYPE_YES => 'Yes', TYPE_NO =>'No', TYPE_DONTKNOW => 'Don\'t Know');
    public static $tilesFormat = array('Mr'=>'Mr', 'Mrs'=>'Mrs', 'Ms'=>'Ms', 'Miss'=>'Miss', 'Dr'=>'Dr', 'Prof' => 'Prof');
    public static $gendersFormat = array('Male'=>'Male', 'Female'=>'Female');
    public static $mobileFormat = array('Mobile'=>'Mobile', 'Home Phone'=>'Home Phone', 'Office Phone' => 'Office Phone', 'Fax' => 'Fax');
    public static $maritalFormat = array('Single'=>'Single', 'Married'=>'Married', 'Separated'=>'Separated', 'Divorced'=>'Divorced', 'Widowed'=>'Widowed');
    public static $allModule = array(null => 'Front End',
        'admin' => 'Admin',
        'member' => 'Member',
        'product' => 'Product',
        'auditTrail' => 'Audit Trail');

    public function getAjaxAction()
    {
        return array();
    }

    public static function getTiles($hasEmpty = true)
    {
        if($hasEmpty)
            $data = array(''=>'', 'Mr'=>'Mr.', 'Mrs'=>'Mrs.', 'Ms'=>'Ms.', 'Madam'=>'Madam', 'Dr'=>'Dr.');
        else
            $data = self::$tilesFormat;
        return $data;
    }

    public static function getAlphabet()
    {
        $data = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        return $data;
    }
    
    public static function getUserStatus($hasEmpty = false)
    {
        if($hasEmpty) return
            array(''=>'', '1' =>'Active','0' => 'Inactive');
    	return self::$statusFormat;
    }

    public static function getYesNo($emptyOption=false)
    {
        if($emptyOption)
            return array(''=>'',
                '1' =>	'Yes',
                '0'=>	'No');
        else
            return self::$yesNoFormat;
    }

    public static function getUserZone()
    {
    	return array("North" => "North", "South" => "South", "East" => "East", "West" => "West");
    }

    public static function getGenders($hasEmpty = true)
    {
        if($hasEmpty)
            $data = array(''=>'', 'Male'=>'Male', 'Female'=>'Female');
        else
            $data = self::$gendersFormat;
        return $data;
    }

}
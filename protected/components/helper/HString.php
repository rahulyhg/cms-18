<?php
/**
 * Class for handle string
 * @parent BaseClass
 */
class HString extends _BaseModel
{
    /**
     * constants
     */
    const ALL       = 0;
    const ALPHABET  = 1;
    const DIGIT     = 2;
    const UPPERCASE = 3;
    const LOWERCASE = 4;
    /**
     * Returns the static class of the specified class.
     * Please note that you should have this exact method in all your BaseClass descendants!
     * @param string $className class name.
     * @return the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    /**
     * get excerpt from begin of target text
     * @param string $text
     * @param int $length
     * @return string
     */
    public static function excerpt($text, $length = 50) {
        if(strlen($text) <= $length)
           return $text;
        return substr($text, 0 , $length - 3) . '...';
    }
    /**
     * get end excerpt of target text
     * @param string $text
     * @param int $length
     * @return string
     */
    public function excerptEnd($text, $length = 50) {
        if(strlen($text) <= $length)
           return $text;
        return '...' . substr($str, 0 , $length - 3);
    }
    /**
     * get segment of url by position
     * @param int $position
     * @example:
     * http://code.local/hansproperty/category/commercial
     * 1-> hansproperty
     */
    public function getSegmentOfUrl($position) {
        $aSegment = explode('/', str_replace(Yii::app()->baseUrl, '', Yii::app()->request->requestUri));
        if(isset($aSegment[$position]))
            return $aSegment[$position];
        return '';
    }
    /**
     * Add prefix to a string
     * @param mixed $text the target
     * @param string $prefix the prefix text
     * @param int $length total length of result string
     */
    public function addPrefix($text, $prefix = '0', $length = 6) {
        $text = (string)$text;
        $prefix = (string)$prefix;
        $totalRepeat = (int)(($length - strlen($text)) / strlen($prefix));
        if($totalRepeat > 0) {
            $text = $this->repeat($prefix, $totalRepeat) . $text;
        }
        return $text;
    }
    /**
     * Add random prefix before given string
     * 99 -> LKCUA99
     *
     * @param mixed $text
     * @param int $length default 8
     * @param int $type: HString::ALL, HString::ALPHABET, HString::UPPERCASE, HString::LOWERCASE, HString::DIGIT
     * @return string random string end with $text
     */
    public function addRandomPrefix($text, $length = 8, $type = self::UPPERCASE)
    {
        $text = (string)$text;
        $textLength = strlen($text);
        if($textLength < $length)
            $text = $this->randomize($length - $textLength, $type).$text;
        return $text;
    }
    /**
     * repeat a string
     * @param string $text string need to be repeat
     * @param int $length
     * @return string
     */
    public function repeat($text, $length)
    {
        $result = '';
        for($i = 0;  $i< $length; $i++) {
            $result .= $text;
        }
        return $result;
    }
    /**
     * Format and sensor mobile number
     * example from 0902244581 to 090-224-xxxx
     * @param string $mobile from mobile string
     * @param string $format mobile format eg xxx-xxx-xxxx
     * @param boolean $isSensor sensor at the end or not
     */
    public static function formatMobile($mobile, $format = null, $isSensor = false) {
        if (empty($mobile))
            return '';
        $digits = str_split($mobile);
        $mobileLength = strlen($mobile);
        $char = '-';
        if (!empty($format)) {
        } else {
            $subLength = $mobileLength <= 9 ? 3 : 4;
            for ($i = $mobileLength - $subLength; $i > 0; $i -= $subLength) {
                $mobile = substr_replace($mobile, $char, $i, 1);
            }
        }
        return $mobile;
    }
    /**
     * Generate random string
     * @param int $length
     * @param int $type: HString::ALL, HString::ALPHABET, HString::UPPERCASE, HString::LOWERCASE, HString::DIGIT
     * @return string
     */
    public function randomize($length = 8, $type = self::ALL) {
        switch ($type) {
            case self::ALPHABET:
               $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case self::UPPERCASE:
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case self::LOWERCASE:
                $characters = 'abcdefghijklmnopqrstuvwxyz';
                break;
            case self::DIGIT:
                $characters = '0123456789';
                break;
            case self::ALL:
            default:
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
        }
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }
    /**
     * correct spaces
     * @param string $text
     * @return string
     */
    public function correctSpaces($text) {
        return preg_replace('/\s*(&nbsp;)*\s+/', ' ', trim($text));
    }
    
    public static function correctCalendarText($text) {
        return preg_replace('/[^a-zA-Z0-9_ -,.\:]/s', '', $text);
    }
    
    public function breakLineForText($text) {//When there is a full stop or next sentence, need to break text 
        $text = preg_replace('/[^a-zA-Z0-9_ -,.:]/s', '', $text);
    }
}

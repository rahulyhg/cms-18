<?php
/**
 * bb
 * Class for handle string
 */
class StringHelper
{
    /**
     * bb
   * TEMP
   * need to code more
   */

    /**
     * trims text to a space then adds ellipses if desired
     * @param string $str text to trim
     * @param int $length in characters to trim to
     * @param bool $ellipses if ellipses (...) are to be added
     * @param bool $strip_html if html tags are to be stripped
     * @return string
     */
    public static function createShort($str, $length, $ellipses = true, $strip_html = true)
    {
        //strip tags, if desired
        if ($strip_html) {
            $str = strip_tags($str);
        }

        if(strlen($str) <= $length) return $str;

        $shortStr = trim(substr($str, 0 , $length - 3));

        //add ellipses (...)
        if ($ellipses) {
            $shortStr = trim($shortStr).'...';
        }

        return $shortStr;
    }
    
    public static function createShortEnd($str, $length)
    {
        if(strlen($str) <= $length) return $str;

        $shortStr = substr($str, -$length , $length);        
        return '..'.$shortStr;
    }
    
    /*
     * bb
     * get segment of url by position
     * example:
     * http://code.local/hansproperty/category/commercial
     * 1-> hansproperty
     */
    
    public static function getSegmentOfUrl($position)
    {
        $aSegment = explode('/', str_replace(Yii::app()->baseUrl, '', Yii::app()->request->requestUri));
        if(isset($aSegment[$position]))
            return $aSegment[$position];
        return '';
    }
    
    /**
     * 
     * @param int $id id in table
     * @param char $char
     * @param int $length length of generated string
     * @param string $prefix prefix add to first of generated string
     * @return string
     * 
     * @example  
     *          Input   : genId(789, '0', 6)
     *          Output  : 000789
     * 
     *          Input   : genId(789, '0', 8, 'S-')
     *          Output  : S-000789
     * 
     * 
     * @author bb  <quocbao1087@gmail.com>
     * @copyright (c) 26/6/2013, bb Verz Design
     */
    public static function genId($id, $char = '0', $length = 8, $prefix = '')
    {
        $result = $id;
        $idLength = strlen($id);
        if($idLength < $length)
        {
            $result = $prefix.self::genNumberOfCharacters($char, $length - $idLength).$id;           
        }
        return $result;
    }
    
    /**
     * Add random string before given id
     * 99 -> LKCUA99
     * 
     * @param int $id
     * @param int $length
     * @param string $type: all, alphabet, uppercase, lowercase, number
     * @return string random string end with $id
     * @copyright (c) 9/6/2013, bb 
     * @author bb  <quocbao1087@gmail.com>
     */
    public static function genRandomWithId($id, $length = 8, $type = 'uppercase')
    {
        $result = $id;
        $strLength = strlen($id);
        if($strLength < $length)
            $result = self::getRandomString($length - $strLength, $type).$result;
        return $result;
    }
    
    public function genNumberOfCharacters($char, $length)
    {
        $result = '';
        for($i = 0;  $i< $length; $i ++)
        {
            $result .= $char;
        }
        return $result;
    }
    /*
     * bb
     */
    //additional function, 
    public static function genPhoneFormat($str) //from 0902244581 to 090-224-xxxx
    {
        $aNumbers = str_split($str);
        
        $result = '';
        $index = 0;
        for($i = count($aNumbers) - 1 ; $i >= 0; $i--)
        {
           $index++;
            
           if($index <= 4)
           {
                $result = 'x'.$result; 
                if($index == 4)
                    $result = '-'.$result;
                           
           }else
           {
               $result = $aNumbers[$i].$result;
               if($index == 7)
                  $result = '-'.$result; 
           }
        }
        return $result;
    }
    
    /**
     * 
     * @param int $length
     * @param string $type: all, alphabet, uppercase, lowercase, number
     * @return string random
     * @copyright (c) 9/6/2013, bb
     * @author bb  <quocbao1087@gmail.com>
     */
    public static function getRandomString($length = 8, $type = 'all') 
    {
        if($type == 'all')
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        elseif($type == 'alphabet')
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        elseif($type == 'uppercase')
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        elseif($type == 'lowercase')
            $characters = 'abcdefghijklmnopqrstuvwxyz';
        elseif($type == 'number')
            $characters = '0123456789';
        
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }
	
	/**
     * 
     * @param string $sString
     * @param int $iLength
     * @param boolean $bReturnArray
     * @return string OR array
     * @copyright (c) 9/10/2013, bb
     */
    public static function limitStringLength($sString, $iLength = 500, $bReturnArray = false)
    {
        $aResult = array('sContent'=>$sString,
                        'bShowMore'=>false
            );
        $sString = strip_tags($sString);
        if (strlen($sString) > $iLength) 
        {
            // truncate string
            $stringCut = substr($sString, 0, $iLength);

            // make sure it ends in a word so assassinate doesn't become ass...
            $sString = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
            $aResult['sContent'] = $sString;
            $aResult['bShowMore'] = true;
        }
        if($bReturnArray)
            return $aResult;
        return $sString;
    }

    // validate a string before insert to database
    public static function toRegularString($string)
    {
        if (!is_string($string))
            return null;
        return mysql_real_escape_string($string);
    }

    public static function replaceInputValue($strInput)
    {
        $result = '';
        if(empty($strInput)){
            $result = '';
            return $result;
        } else
        {
            $badWords = array("/delete/", "/update/","/union/","/insert/","/drop/","/http/","/--/");
            $result = preg_replace($badWords, "", $strInput);
            $result = addslashes($result);
            $result = preg_replace('/\s\s+/', ' ', trim($result));  //Strip off multiple spaces between the sentence, making it like "Hello Ms Van"
            $result = preg_replace('%(#|;|{}=(//)).*%','',$result);
            $result = preg_replace('%/\*(?:(?!\*/).)*\*/%s','',$result); // google for negative lookahead
            $result = preg_replace('/^[\-]+/','',$result); // Strip off the starting hyphens
            $result = preg_replace('/[\-]+$/','',$result); // // Strip off the ending hyphens
            $result = strtolower($result);

            return $result;
        }
    }

    /*
    * to make slug (url string)
    */
    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        {
            return 'n-a';
        }
        return $text;
    }

}

<?php

/**
 * @copyright (c) 2013, bb
 */
class AutoInvoiceNoHelper{
    
    /**
     * param string
     * @return string
     * @copyright (c) 2015, HH 
     */
    public  function strDate($str='')
    {
        $year=date('y');
        $month=date('m');
        $strResult= $str.''.$year.''.$month; 
        return $strResult;
    }
    /**
     * @param nullS
     * @return string
     * @copyright (c) 2015, HH 
     */
    public static function getInvoiceNo()
    {
        $number=1;
        $dispense= Dispense::model()->findAll(array('order' => 'id DESC'));
        if(!empty($dispense))
        {
            $i=0;
            foreach ($dispense as $data)
            {   
                if($i==0)
                {
                    $number=$data->id+1;
                }
                $i++;
            }
        }
        $obj=new AutoInvoiceNoHelper();
        $strFist=$obj->strDate('IV');
        $strDefault='00000';
        $length= strlen((string)$number);
        if($length<5)
        {
              $strLast= substr($strDefault,$length);
              return $strFist.'-'.$strLast.''.$number;
        }
        else {
            $strLast=$number;
             return $strFist.'-'.$strLast;
        }
       
       
        
    }
    
    
    /**
     * @param nullS
     * @return string
     * @copyright (c) 2015, HH 
     */
    public static function getReceptNo()
    {
        $number=1;
        $dispense= Dispense::model()->findAll(array('order' => 'id DESC'));
        if(!empty($dispense))
        {
            $i=0;
            foreach ($dispense as $data)
            {   
                if($i==0)
                {
                    $number=$data->id+1;
                }
                $i++;
            }
        }
        $obj=new AutoInvoiceNoHelper();
        $strFist=$obj->strDate('RC');
        $strDefault='00000';
        $length= strlen((string)$number);
        if($length<5)
        {
              $strLast= substr($strDefault,$length);
              return $strFist.'-'.$strLast.''.$number;
        }
        else {
            $strLast=$number;
             return $strFist.'-'.$strLast;
        }
       
       
        
    }
    
   
            
}
?>

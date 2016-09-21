<?php

class BaseFormatter extends CFormatter {

    public function formatContactNo($data){
        $string = '';
        if ($data->referred_contact_1 == 1) {
            $country = AreaCode::model()->getAreaCodeSpecific($data->contact_country_1);
            if(!empty($data->contact_mobile_1) && !empty($country) && !empty($data->contact_number_1))
                $string .= $data->contact_mobile_1.' - '.$country.' - '.$data->contact_number_1;
        }
        else if($data->referred_contact_2 == 1) {
            $country = AreaCode::model()->getAreaCodeSpecific($data->contact_country_2);
            if(!empty($data->contact_mobile_2) && !empty($country) && !empty($data->contact_number_2))
                $string .= $data->contact_mobile_2.' - '.$country.' - '.$data->contact_number_2;
        }
        else{
            $country = AreaCode::model()->getAreaCodeSpecific($data->contact_country_3);
            if(!empty($data->contact_mobile_3) && !empty($country) && !empty($data->contact_number_3))
                $string .= $data->contact_mobile_3.' - '.$country.' - '.$data->contact_number_3;
        }
        return $string;
    }

    public function formatAddress($data){
        $string = '';
        $country = AreaCode::model()->getAreaCodeSpecific($data->residential_country, true);
        
        if (!empty($data->residential_block_house)) {
            $string .= 'Block '.ucwords(trim($data->residential_block_house)).', ';
        }
        if (!empty($data->residential_unit_from)) {
            $string .= 'Unit '.ucwords(trim($data->residential_unit_from));
        }
        if (!empty($data->residential_unit_to)) {
            if (empty($data->residential_unit_from)) {
                $string .= 'Unit '.ucwords(trim($data->residential_unit_to));
            }
            else{
                $string .= "-".ucwords(trim($data->residential_unit_to));
            }
        }
        $string .= "<br>";
        $string .= ucwords(trim($data->residential_street))."<br>";
        $string .= ucwords(trim($data->residential_building_name))."<br>";
        $string .= $country;
        $string .= ucwords(trim($data->residential_postal_code));

        return $string;
    }
    
    public function formatModel($value) {
        $model = PaymentAmount::model()->findByPk($value);
        return $model->getType();
    }
    
    public function formatInvoice($id) {
        $model = PaymentAmount::model()->findByPk($id);
        return isset($model->Payments->invoice_no) ? $model->Payments->invoice_no : "";
    }
    // Jason
    // To format language name
    public function formatLanguageName($data){
        $string = '';
        //get all patient language
        $patientLanguages = PatientLanguage::model()->getAllPatientLanguages($data);
        foreach ($patientLanguages as $item) {
            if (isset($item->language)) 
                $string .= '+ '.ucwords($item->language->name)."<br>";
        }
        return $string;
    }

    public function formatStatus($value) {
        if (is_array($value)) {
            return (($value['status'] == STATUS_INACTIVE) ?
                            CHtml::link(
                                    "Inactive", array("ajaxActivate", "id" => $value['id']), array(
                                "class" => "ajaxupdate",
                                "title" => "Click here to " . DeclareHelper::$statusFormat[STATUS_ACTIVE],
                                    )
                            ) :
                            CHtml::link(
                                    "Active", array("ajaxDeactivate", "id" => $value['id']), array(
                                "class" => "ajaxupdate",
                                "title" => "Click here to " . DeclareHelper::$statusFormat[STATUS_INACTIVE],
                                    )
                            )
                    );
        } else
            return $value == 0 ? DeclareHelper::$statusFormat[STATUS_INACTIVE] : DeclareHelper::$statusFormat[STATUS_ACTIVE];
    }

    
    
    public function formatDate($value, $formatF = 'd F Y') {
        if (empty($formatF))
            $formatF = Yii::app()->params['dateFormat'];
        if ((int) strtotime($value) != 0 && $value == '0000-00-00' || $value == '0000-00-00 00:00:00' || is_null($value))
            return '';
        if (is_string($value)) {
            $date = strtotime($value);
            return date($formatF, $date);
        }
        return parent::formatDate($value);
    }

    public function formatTime($value, $formatF = '') {
        if (empty($formatF))
            $formatF = Yii::app()->params['timeFormat'];
        if ($value == '0000-00-00' || $value == '0000-00-00 00:00:00' || is_null($value))
            return '';
        if (is_string($value)) {
            $date = new DateTime($value);
            return $date->format($formatF);
        }
        return parent::formatDate($value);
    }

    public function formatDateTime($value, $formatF = '') {
        if (empty($formatF))
            $formatF = Yii::app()->params['dateFormat'] . ' ' . Yii::app()->params['timeFormat'];
        if ($value == '0000-00-00' || $value == '0000-00-00 00:00:00' || is_null($value))
            return '';
        if (is_string($value)) {
            $date = new DateTime($value);
            return $date->format($formatF);
        }
        return parent::formatDate($value);
    }
    public function formatDateTimeFull($value, $formatF = '') {
        if (empty($formatF))
            $formatF = Yii::app()->params['dateFormat'] . ' ' . Yii::app()->params['timeFormat'];
        if ($value == '0000-00-00' || $value == '0000-00-00 00:00:00' || is_null($value))
            return '';
        if (is_string($value)) {
            $date = new DateTime($value);
            return $date->format("l d F Y");
        }
        return parent::formatDate($value);
    }
    
    public function formatTimeFull($value, $formatF = '') {
        if (empty($formatF))
            $formatF = Yii::app()->params['dateFormat'] . ' ' . Yii::app()->params['timeFormat'];
        if ($value == '0000-00-00' || $value == '0000-00-00 00:00:00' || is_null($value))
            return '';
        if (is_string($value)) {
            $date = new DateTime($value);
            return $date->format("h:ia");
        }
        return parent::formatDate($value);
    }

    /* formatYNStatus use for Yes/No */

    public static function formatYNStatus($value) {
        $return = DeclareHelper::$yesNoFormat;
        return isset($return[(int)$value]) ? $return[(int)$value] : "";
    }

    public function formatPrice($value, $country = 'sg') {
        // if ($country == 'sg') {
            // return number_format($value).' SGD';
            return '$'.number_format($value, 2);
        // }
        // return $value;
    }

    public function formatNumberCurrency($value, $country = 'sg') {
        if (is_array($value)) {
            if (empty($value['currencyType']))
                $currencyType = 'SGD';
            else
                $currencyType = $value['currencyType'];
            return number_format((float) $value['number'], 2) . " (" . $currencyType . ")";
        } else
            return $value = "";
    }
    
    public function formatStatusNewletters($value) {
        if(is_array($value)) {
            return (($value['status'] == STATUS_INACTIVE) ?
                CHtml::link(
                    "Draft",
                    array("ajaxActivate", "id"=>$value['id']),
                    array(
                        "class"=>"ajaxupdate",
                        "title"=>"Click here to ".DeclareHelper::$statusFormat[STATUS_ACTIVE],
                    )
                )
                :
                CHtml::link(
                    "Active",
                    array("ajaxDeactivate", "id"=>$value['id']),
                    array(
                        "class"=>"ajaxupdate",
                        "title"=>"Click here to draft ",
                    )
                )
            );
        }
        else
            return $value == 0 ? 'Draft' : DeclareHelper::$statusFormat[STATUS_ACTIVE];
    }
    
    public function formatStatusSubScriber($value) {
        if(is_array($value)) {
            return (($value['status'] == STATUS_INACTIVE) ?
                CHtml::link(
                    "Unsubscribed",
                    array("ajaxActivate", "id"=>$value['id']),
                    array(
                        "class"=>"ajaxupdate",
                        "title"=>"Click here to ".DeclareHelper::$statusFormat[STATUS_ACTIVE],
                    )
                )
                :
                CHtml::link(
                    "Active",
                    array("ajaxDeactivate", "id"=>$value['id']),
                    array(
                        "class"=>"ajaxupdate",
                        "title"=>"Click here to Unsubscribed",
                    )
                )
            );
        }
        else
            return $value == 0 ? DeclareHelper::$statusFormat[STATUS_INACTIVE] : DeclareHelper::$statusFormat[STATUS_ACTIVE];
    }    

    public function formatDocumentDownload($data) {
        $str = '';
        if (is_array($data)) {
            if ($data['type'] == 'insurrance_card') {
                //get medical insurrance card file
                $list = PatientInsurranceCard::model()->getDataBaseOnPatientInsurrance($data['patient_id'], $data['patient_medical_insurrance_id']);
            }
            elseif($data['type'] == 'referral_letter') {
                $list = PatientReferralLetter::model()->getDataBaseOnPatient($data['patient_id']); 
            }
            else{   //report
                $list = PatientReport::model()->getDataBaseOnPatient($data['patient_id']); 
            }
            foreach ($list as $value) {
                if ( Yii::app()->user->isAdmin ) {
                    $link = Yii::app()->createAbsoluteUrl('admin/patients/downloadDocument', array('id' => $value->id, 'type' => $data['type']));
                }
                else{
                    $link = Yii::app()->createAbsoluteUrl('site/downloadDocument', array('id' => $value->id, 'type' => $data['type']));    
                }
                $str .= "<a href='$link'><img style='width:30px;' src='" . Yii::app()->theme->baseUrl . "/img/download_button.png'> ".$value->name."</a><br>";
            }
        }
        return $str;
    }   
    
    public function formatDocumentDelete($data) {
        $str = '';
        if (is_array($data)) {
            $type = $data['type'];
            if ($type == 'insurrance_card') {
                //get medical insurrance card file
                $list = PatientInsurranceCard::model()->getDataBaseOnPatientInsurrance($data['patient_id'], $data['patient_medical_insurrance_id']);
            }
            elseif($type == 'referral_letter') {
                $list = PatientReferralLetter::model()->getDataBaseOnPatient($data['patient_id']); 
            }
            else{   //report
                $list = PatientReport::model()->getDataBaseOnPatient($data['patient_id']); 
            }

            $tmp_type = $type;
            $type = "'".$type."'";
            foreach ($list as $value) {
                $cla = $tmp_type.'_'.$value->id;
                $str .= '<span style="cursor:pointer" title="Click here to delete this item" onclick="deleteDocument('.$value->id.', '.$type.')" class="'.$cla.'"><img style="width:15px;height:15px" src="'. Yii::app()->theme->baseUrl.'/img/delete.png"> '.$value->name.'<br></span>';
            }
        }
        return $str;
    }    
    
     public function formatDrugName($value) {
        
         //dispense_id
         $model=  DispenseItems::model()->findAll('dispense_id='.$value.'');
         $table='';
         if(!empty($model))
         {
             foreach ($model  as $item)
             {
                 $table.= '<li>'.$item->item_name.'</li>';
                              
                                
                          
             }
         }
         return '<ol>'.$table.'</ol>';
        
          
    }
    public function formatQuantity($value) {
        
         //dispense_id
         $model=  DispenseItems::model()->findAll('dispense_id='.$value.'');
         $table='';
         if(!empty($model))
         {
             foreach ($model  as $item)
             {
                 $table.= '<li>'.$item->quantity.'</li>';
                              
                                
                          
             }
         }
         return '<ul style="list-style-type:none">'.$table.'</ul>';
        
          
    }
    
    public function formatCheckQueueType($queueItem)
    {
        if ($queueItem->seen == 0)
        {
            return 'class=""';
        }
        elseif ($queueItem->seen == 1 && $queueItem->paid <= 0)
            return 'class="bg-primary"';
        else if ($queueItem->seen == 1 && $queueItem->paid >=0 && $queueItem->paid - $queueItem->bill >= 0)
            return 'class="bg-success"';
        else if ($queueItem->paid >=0 && $queueItem->paid - $queueItem->bill <= 0)
            return 'class="bg-danger"';
        
    }
    
    public function formatCheckPaymentType($queueItem)
    {
        if($queueItem->bill ==0  && $queueItem -> paid == 0)
             return '';
        elseif ($queueItem->seen == 1 && $queueItem->paid <= 0)
            return 'class="bg-primary"';
        else if ($queueItem->seen == 1 && $queueItem->paid >=0 && $queueItem->paid - $queueItem->bill >= 0)
            return 'class="bg-success"';
        else if (($queueItem->paid >= $queueItem->bill || $queueItem->paid - $queueItem->bill <= 0 )&& $queueItem->paid !=0)
            return 'class="bg-danger"';
           
    }
    
    public function formatPrices($value) 
    {
        return '$'.  number_format($value, 2);
          
    }
    
    public function formatDiscount($value) 
    {
        return $value.'%';
          
    }
    
    public function formatDiscountType($value) 
    {
        $data = Dispense::model()->findByPk($value);
        if($data->discount_type ==1){
            return $data->discount.'%';
        }
        return '$'.$data->discount;  
    }
    
    public function formatStatusPriceList($value) {
        $pricelist = PriceList::model()->findByPk($value);
        if((int)$pricelist->status == 0) {
            $status = 'Inactive';
        }
        else
            $status = 'Active'; 
        
        if((int)$pricelist->status == -1) {
            return 'Deleted';
        }
        return '<a class="btn-status" data-status="'.$pricelist->status.'" href="'.Yii::app()->createAbsoluteUrl('/serviceList/status/'.$value).'">'.$status.'</a>';
    }
    
    public function formatStatusInventory($value) {
       $inventory = Inventory::model()->findByPk($value);
        $status = 'Active'; 
        if((int)$inventory->status == 0) {
            $status = 'Inactive';
        }
        
        if((int)$inventory->status == -1) {
            return 'Deleted';
        }
        return '<a data-id="'.$inventory->id.'" class="btn-status" data-status="'.$inventory->status.'" href="'.Yii::app()->createAbsoluteUrl('/inventories/status/'.$value).'">'.$status.'</a>';
    }
}

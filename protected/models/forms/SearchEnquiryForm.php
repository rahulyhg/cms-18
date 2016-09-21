<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class SearchEnquiryForm extends CFormModel
{
        public $patient_id;
	public $drug_name;
	public $first_date;
	public $last_date;
	public $check_type;
	public $date_type ;
        public $name;


        /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
       return array(
            array('patient_id', 'required', 'on' => 'search_patient_name'),
            array('name', 'required', 'on' => 'search_drug_name'),
            array('name,first_date,last_date', 'required', 'on' => 'search_drug_name_date'),
            array('patient_id,first_date,last_date', 'required', 'on' => 'search_patient_name_date'),
            //array('patient_id, price, quantity', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            array(' created_data, patient_id, name, first_date, last_date, check_type,date_type', 'safe'),
            // @todo Please remove those attributes that should not be searched.
            array(' created_data,first_date,last_date patient_id, name', 'safe', 'on' => 'search'),
        );
	}
	
  
    public function checkPhone($attribute,$params)
    {
        if($this->$attribute != ''){
            $pattern ='/^[\(]?(\+)?(\d{0,3})[\)]?[\s]?[\-]?(\d{0,9})[\s]?[\-]?(\d{0,9})[\s]?[x]?(\d*)$/';
            $containsDigit = preg_match($pattern,$this->$attribute);
            $lb = $this->getAttributeLabel($attribute);
            if(!$containsDigit)
                $this->addError($attribute,"$lb must be numerical and  allow input (),+,-");
        }
    }

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	 public function attributeLabels() {
        return array(
           // 'id' => Yii::t('translation', 'ID'),
            'created_data' => Yii::t('translation', 'Created Data'),
            'patient_id' => Yii::t('translation', 'Patient'),
            'name' => Yii::t('translation', 'Name'),
            'first_date' => Yii::t('translation', 'First Date'),
            'last_date' => Yii::t('translation', 'Last Date'),
        );
    }
    
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('created_data', $this->created_data, true);
        $criteria->compare('patient_id', $this->patient_id);
        $criteria->compare('name', $this->name, true);
         $criteria->compare('first_date', $this->first_date);
        $criteria->compare('last_date', $this->last_date);
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['defaultPageSize'],
                    ),
                ));
    }
}
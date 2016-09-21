<?php

/**
 * PrintForm class.
 * PrintForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class PrintForm extends CFormModel
{
    public $from_date;
    public $to_date;
    public $registration_date;
    public $doctor_id;
    public $alpha_from;
    public $alpha_to;

    public static $alphabet = array(
        'a' => 'A',
        'b' => 'B',
        'c' => 'C',
        'd' => 'D',
        'e' => 'E',
        'f' => 'F',
        'g' => 'G',
        'h' => 'H',
        'i' => 'I',
        'j' => 'J',
        'k' => 'K',
        'l' => 'L',
        'm' => 'M',
        'n' => 'N',
        'o' => 'O',
        'p' => 'P',
        'q' => 'Q',
        'r' => 'R',
        's' => 'S',
        't' => 'T',
        'u' => 'U',
        'v' => 'V',
        'w' => 'W',
        'x' => 'X',
        'y' => 'Y',
        'z' => 'Z',
    );

    public static $listPrintWidth = array(
        'doctor_name' => 25,
        'name' => 25,
        'identity' => 15,
        'contact_no' => 30,
        'speaks' => 30,
        'dob' => 15,
        'gender' => 10,
        'address' => 30,
        'important_comment_to_notes' => 30,
    );

    public static $listPrintName = array(
        'doctor_name' => 'Doctor Name',
        'name' => 'Patient Name',
        'identity' => 'ID',
        'contact_no' => 'Contact No',
        'speaks' => 'Speaks',
        'dob' => 'Date of Birth',
        'gender' => 'Gender',
        'address' => 'Address',
        'important_comment_to_notes' => 'Comments',
    );

        /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
       return array(
            array('from_date, to_date', 'required', 'on' => 'export_patient_by_visit'),
            array('registration_date', 'required', 'on' => 'export_patient_by_registration_date'),
            array('doctor_id', 'required', 'on' => 'export_patient_by_doctor_name'),
            array('alpha_from, alpha_to', 'required', 'on' => 'export_patient_by_doctor_name'),
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
            'doctor_id' => Yii::t('translation', 'Doctor Name'),
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
<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class DispenseForm extends CFormModel
{
        public $patient_name;
	public $drug_name;
	public $first_date;
	public $last_date;
	public $check_type;
	public $date_type ;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
                // name, email, subject and body are required
                array('patient_name','required','on'=>'search_patient_name'),
                array('drug_name', 'required','on'=>'search_drug_name'),
                array('drug_name,first_date,last_date', 'required','on'=>'search_drug_name_date'),
                array('patient_name,first_date,last_date', 'required','on'=>'search_patient_name_date'),
                // array('verifyCode','captcha','message'=>'Verify Code is incorrect'),
          
            array('id, patient_name,drug_name, first_date, last_date, check_type,date_type', 'safe'),
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
	public function attributeLabels()
	{
		return array(
            'email'=>'Email Address',
            'name'=>'Name',
            'contact_no'=>'Contact No',
            'phone'=>'Phone Number',
            'message'=>'Message',
            'company_name'=>'Company Name',
		);
	}
}
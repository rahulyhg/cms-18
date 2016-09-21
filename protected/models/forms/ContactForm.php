<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $name;
	public $contact_no;
	public $phone;
	public $email;
	public $message;
	public $company_name ;
	public $verifyCode;
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name,contact_no, email, message', 'required'),
			// array('verifyCode','captcha','message'=>'Verify Code is incorrect'),
            array('name, email', 'length', 'max'=>200),
			array('email', 'email'),
            array('phone','checkPhone'),
            array('id, name,contact_no, email, message, verify_code', 'safe'),
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
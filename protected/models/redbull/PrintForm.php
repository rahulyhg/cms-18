<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class PrintForm extends CFormModel
{
	public $patient_name;
        public $print_type;

	/**
	 * Declares the validation rules.
	 * The rules state that nick_name and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
                    // nick_name and password are required
                    array('patient_name', 'required'),
                    array('print_type', 'safe'),
                );
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'patient_name'=>'Patient Name',
                        'print_date' => 'Date'
		);
	}

       
}

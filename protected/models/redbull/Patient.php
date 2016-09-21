<?php

/**
 * This is the model class for table "{{_patient}}".
 *
 * The followings are the available columns in table '{{_patient}}':
 * @property integer $id
 * @property string $salutation
 * @property string $name
 * @property string $identity
 * @property string $nationality
 * @property string $dob
 * @property string $gender
 * @property string $marital
 * @property string $race
 * @property string $religion
 * @property string $registration_date
 * @property string $reference_no
 * @property string $occupation
 * @property string $company
 * @property integer $doctor_id
 * @property string $important_comment_to_notes
 * @property integer $residential_country
 * @property string $residential_block_house
 * @property string $residential_unit_from
 * @property string $residential_unit_to
 * @property string $residential_street
 * @property string $residential_building_name
 * @property string $residential_postal_code
 * @property integer $mailling_country
 * @property string $mailling_block_house
 * @property string $mailling_unit_from
 * @property string $mailling_unit_to
 * @property string $mailling_street
 * @property string $mailling_building_name
 * @property string $mailling_postal_code
 * @property string $contact_mobile_1
 * @property integer $contact_country_1
 * @property string $contact_number_1
 * @property integer $referred_contact_1
 * @property string $contact_mobile_2
 * @property integer $contact_country_2
 * @property string $contact_number_2
 * @property integer $referred_contact_2
 * @property string $contact_mobile_3
 * @property integer $contact_country_3
 * @property string $contact_number_3
 * @property integer $referred_contact_3
 * @property string $contact_email
 * @property string $singapore_contact_number
 * @property string $singapore_address
 * @property string $person_contact_singapore
 * @property integer $allergy
 * @property string $comment_allergy
 * @property integer $g6pd_deficiency
 * @property string $comment_g6pd_deficiency
 * @property integer $had_any_medical_illness
 * @property string $comment_had_any_medical_illness
 * @property integer $had_any_surgery
 * @property string $comment_had_any_surgery
 * @property integer $referral
 * @property string $comment_referral
 * @property string $attach_referral_letter
 * @property string $attach_report
 * @property string $spouse_name
 * @property string $spouse_mobile
 * @property integer $spouse_country
 * @property string $spouse_number
 * @property string $spouse_dob
 * @property string $spouse_identity
 * @property string $nok_number_1
 * @property string $nok_occupation_1
 * @property string $nok_company_1
 * @property string $nok_comment_1
 * @property string $nok_relationship_2
 * @property string $spouse_occupation
 * @property string $spouse_company
 * @property string $spouse_comment
 * @property string $nok_relationship_1
 * @property string $nok_name_1
 * @property string $nok_mobile_1
 * @property integer $nok_country_1
 * @property string $nok_name_2
 * @property string $nok_mobile_2
 * @property integer $nok_country_2
 * @property string $nok_number_2
 * @property string $nok_occupation_2
 * @property string $nok_company_2
 * @property string $nok_comment_2
 * @property string $medical_company_name
 * @property string $medical_department
 * @property string $medical_staff_no
 * @property string $medical_entitlement_from
 * @property string $medical_entitlement_to
 * @property integer $medical_bill_insurance
 * @property string $medical_insurance_name
 * @property integer $medical_follow
 * @property integer $medical_copayment
 * @property string $medical_copayment_amount_from
 * @property string $medical_copayment_amount_to
 * @property string $medical_attachment
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Appointment[] $appointments
 * @property Question[] $redbullQuestions
 * @property Visit[] $visits
 */
class Patient extends _BaseModel {

    // public $same_resedential_address;
    public $preferred_contact;
    public $speaks;
    public $address;
    public $doctor_name;
    public $contact_no;
    public $is_popup = false;
    public $attach_referral_letter_file;
    public $attach_report_file;
    public $attach_referral_letter_description;
    public $attach_referral_letter_id;
    public $attach_report_description;
    public $attach_report_file_id;
    public $attach_insurance_file;
    public $attach_insurance_file_id;
    public $attach_insurance_description;



    public function afterFind() {
        parent::afterFind();
        $cms = new BaseFormatter();
        $this->address = $cms->formatAddress($this);
        $this->speaks = $cms->formatLanguageName($this->id);
        //  $this->doctor_name = $this->doctor->name;
        $this->contact_no = $cms->formatContactNo($this);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{_patient}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('doctor_id, residential_country, mailling_country, contact_country_1, referred_contact_1, contact_country_2, referred_contact_2, contact_country_3, referred_contact_3, allergy, g6pd_deficiency, had_any_medical_illness, had_any_surgery, referral, spouse_country, nok_country_1, nok_country_2, medical_bill_insurance, medical_follow, medical_copayment, status', 'numerical', 'integerOnly' => true),
            array('salutation', 'length', 'max' => 10),
            array('name, company, residential_block_house, residential_postal_code, mailling_block_house, mailling_postal_code, contact_mobile_1, contact_number_1, contact_mobile_2, contact_number_2, contact_mobile_3, contact_number_3, singapore_contact_number, spouse_name, spouse_mobile, spouse_number, spouse_identity, nok_number_1, nok_mobile_1, nok_mobile_2, nok_number_2', 'length', 'max' => 100),
            array('identity, nationality, gender, marital, race', 'length', 'max' => 45),
            array('religion, reference_no, residential_unit_from, residential_unit_to, residential_street, residential_building_name, mailling_unit_from, mailling_unit_to, mailling_street, mailling_building_name, contact_email, singapore_address, person_contact_singapore, comment_allergy, comment_g6pd_deficiency, comment_had_any_medical_illness, comment_had_any_surgery, comment_referral, attach_referral_letter, attach_report, nok_occupation_1, nok_company_1, nok_comment_1, nok_relationship_2, spouse_occupation, spouse_company, spouse_comment, nok_relationship_1, nok_name_1, nok_name_2, nok_occupation_2, nok_company_2, nok_comment_2, medical_company_name, medical_department, medical_staff_no, medical_entitlement_from, medical_entitlement_to, medical_insurance_name, medical_attachment', 'length', 'max' => 255),
            array('occupation', 'length', 'max' => 200),
            array('medical_copayment_amount_from, medical_copayment_amount_to', 'length', 'max' => 16),
            array('contact_email', 'email'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('first_char, contact_country_1, turn_up, id, age, relationship, spouse_age, salutation, name, identity, nationality, dob, gender, marital, race, religion, registration_date, reference_no, occupation, company, doctor_id, important_comment_to_notes, residential_country, residential_block_house, residential_unit_from, residential_unit_to, residential_street, residential_building_name, residential_postal_code, residential_geo_name, mailling_country, mailling_block_house, mailling_unit_from, mailling_unit_to, mailling_street, mailling_building_name, mailling_postal_code, mailling_geo_name, contact_mobile_1, contact_country_1, contact_number_1, referred_contact_1, contact_mobile_2, contact_country_2, contact_number_2, referred_contact_2, contact_mobile_3, contact_country_3, contact_number_3, referred_contact_3, contact_email, singapore_contact_number, singapore_address, person_contact_singapore, allergy, comment_allergy, g6pd_deficiency, comment_g6pd_deficiency, had_any_medical_illness, comment_had_any_medical_illness, had_any_surgery, comment_had_any_surgery, referral, comment_referral, attach_referral_letter, attach_report, spouse_name, spouse_mobile, spouse_country, spouse_number, spouse_dob, spouse_identity, nok_number_1, nok_occupation_1, nok_company_1, nok_comment_1, nok_relationship_2, spouse_occupation, spouse_company, spouse_comment, nok_relationship_1, nok_name_1, nok_mobile_1, nok_country_1, nok_name_2, nok_mobile_2, nok_country_2, nok_number_2, nok_occupation_2, nok_company_2, nok_comment_2, medical_company_name, medical_department, medical_staff_no, medical_entitlement_from, medical_entitlement_to, medical_bill_insurance, medical_insurance_name, medical_follow, medical_copayment, medical_copayment_amount_from, medical_copayment_amount_to, medical_attachment, same_resedential_address, status, text_race, text_religion', 'safe'),
            array('attach_insurance_description,attach_insurance_file_id,attach_insurance_file,attach_report_file_id,attach_report_description,attach_referral_letter_file,attach_referral_letter_description,attach_report_file,attach_referral_letter_id','safe'),
        ); 
    }
           

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'appointments' => array(self::HAS_MANY, 'Appointment', 'patientId'),
            'redbullQuestions' => array(self::MANY_MANY, 'Question', '{{_patient_question}}(patient_id, question_id)'),
            'visits' => array(self::HAS_MANY, 'Visit', 'patient_id'),
            // 'nationality' => array(self::BELONGS_TO, 'AreaCode', 'nationality'),
            'languages' => array(self::MANY_MANY, 'Language',
                Yii::app()->db->tablePrefix . '_patient_language(patient_id, language_id)',
                'order' => 'languages.id DESC',
            ),
            'doctor' => array(self::BELONGS_TO, 'Doctor', 'doctor_id'),
            'patientmedicalinsurrance' => array(self::HAS_ONE, 'PatientMedicalInsurrance', 'patient_id', 'on' => 'patientmedicalinsurrance.default= 1'),
            'race' => array(self::BELONGS_TO, 'Race', 'race_id'),
            'religion' => array(self::BELONGS_TO, 'Religion', 'religion_id'),
        );
    }

    public function defaultScope() {
        $alias = $this->getTableAlias(false, false);
//        return array(
//            'condition' => "`$alias`.`is_deleted` = 0 OR `$alias`.`is_deleted` is NULL",
//        );
    }

    public function beforeDelete() {
        if (!empty($this->languages))
            PatientLanguage::model()->deleteAllPatientLanguages($this);
        if (!empty($this->visits))
            Visit::model()->deleteAllPatientVisits($this);
        if (!empty($this->redbullQuestions))
            PatientQuestion::model()->clear($this);
        if (!empty($this->appointments))
            Appointment::model()->clear($this);

        //redbull_patient_appointment_history
        PatientAppointmentHistory::model()->clear($this);
        //redbull_patient_blood_pressure
        PatientBloodPressure::model()->clear($this);
        //redbull_patient_depensing
        PatientDepensing::model()->clear($this);
        //redbull_patient_drug_alert
        PatientDrugAlert::model()->clear($this);
        //redbull_patient_glucose
        PatientGlucose::model()->clear($this);
        //redbull_patient_height_weight
        PatientHeightWeight::model()->clear($this);
        //redbull_patient_insurrance_card
        PatientInsurranceCard::model()->clear($this);
        //redbull_patient_medical_insurrance
        PatientMedicalInsurrance::model()->clear($this);
        //redbull_patient_medical_record
        PatientMedicalRecord::model()->clear($this);
        //redbull_patient_payment_history
        PatientPaymentHistory::model()->clear($this);
        //redbull_patient_referral_letter
        PatientReferralLetter::model()->clear($this);
        //redbull_patient_report
        PatientReport::model()->clear($this);

        return parent::beforeDelete();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translation', 'ID'),
            'salutation' => Yii::t('translation', 'Salutation'),
            'name' => Yii::t('translation', 'Name'),
            'identity' => Yii::t('translation', 'ID'),
            'nationality' => Yii::t('translation', 'Nationality'),
            'dob' => Yii::t('translation', 'Dob'),
            'gender' => Yii::t('translation', 'Gender'),
            'marital' => Yii::t('translation', 'Marital'),
            'race' => Yii::t('translation', 'Race'),
            'religion' => Yii::t('translation', 'Religion'),
            'registration_date' => Yii::t('translation', 'Registration Date'),
            'reference_no' => Yii::t('translation', 'Reference No'),
            'occupation' => Yii::t('translation', 'Occupation'),
            'company' => Yii::t('translation', 'Company'),
            'doctor_id' => Yii::t('translation', 'Doctor'),
            'important_comment_to_notes' => Yii::t('translation', 'Important Comment To Notes'),
            'residential_country' => Yii::t('translation', 'Country'),
            'residential_block_house' => Yii::t('translation', 'Residential Block House'),
            'residential_unit_from' => Yii::t('translation', 'Residential Unit From'),
            'residential_unit_to' => Yii::t('translation', 'Residential Unit To'),
            'residential_street' => Yii::t('translation', 'Residential Street'),
            'residential_building_name' => Yii::t('translation', 'Residential Building Name'),
            'residential_postal_code' => Yii::t('translation', 'Residential Postal Code'),
            'mailling_country' => Yii::t('translation', 'Mailling Country'),
            'mailling_block_house' => Yii::t('translation', 'Mailling Block House'),
            'mailling_unit_from' => Yii::t('translation', 'Mailling Unit From'),
            'mailling_unit_to' => Yii::t('translation', 'Mailling Unit To'),
            'mailling_street' => Yii::t('translation', 'Mailling Street'),
            'mailling_building_name' => Yii::t('translation', 'Mailling Building Name'),
            'mailling_postal_code' => Yii::t('translation', 'Mailling Postal Code'),
            'contact_mobile_1' => Yii::t('translation', 'Contact Mobile 1'),
            'contact_country_1' => Yii::t('translation', 'Contact Country 1'),
            'contact_number_1' => Yii::t('translation', 'Contact Number 1'),
            'referred_contact_1' => Yii::t('translation', 'Referred Contact 1'),
            'contact_mobile_2' => Yii::t('translation', 'Contact Mobile 2'),
            'contact_country_2' => Yii::t('translation', 'Contact Country 2'),
            'contact_number_2' => Yii::t('translation', 'Contact Number 2'),
            'referred_contact_2' => Yii::t('translation', 'Referred Contact 2'),
            'contact_mobile_3' => Yii::t('translation', 'Contact Mobile 3'),
            'contact_country_3' => Yii::t('translation', 'Contact Country 3'),
            'contact_number_3' => Yii::t('translation', 'Contact Number 3'),
            'referred_contact_3' => Yii::t('translation', 'Referred Contact 3'),
            'contact_email' => Yii::t('translation', 'Contact Email'),
            'singapore_contact_number' => Yii::t('translation', 'Singapore Contact Number'),
            'singapore_address' => Yii::t('translation', 'Singapore Address'),
            'person_contact_singapore' => Yii::t('translation', 'Person Contact Singapore'),
            'allergy' => Yii::t('translation', 'Allergy'),
            'comment_allergy' => Yii::t('translation', 'Comment Allergy'),
            'g6pd_deficiency' => Yii::t('translation', 'G6PD Deficiency'),
            'comment_g6pd_deficiency' => Yii::t('translation', 'Comment G6pd Deficiency'),
            'had_any_medical_illness' => Yii::t('translation', 'Have you ever had any medical illness?'),
            'comment_had_any_medical_illness' => Yii::t('translation', 'Comment Had Any Medical Illness'),
            'had_any_surgery' => Yii::t('translation', 'Have you ever had any surgery? '),
            'comment_had_any_surgery' => Yii::t('translation', 'Comment Had Any Surgery'),
            'referral' => Yii::t('translation', 'Referral'),
            'comment_referral' => Yii::t('translation', 'Referral'),
            'attach_referral_letter' => Yii::t('translation', 'Attach Referral Letter'),
            'attach_report' => Yii::t('translation', 'Attach Report'),
            'spouse_name' => Yii::t('translation', 'Spouse Name'),
            'spouse_mobile' => Yii::t('translation', 'Spouse Mobile'),
            'spouse_country' => Yii::t('translation', 'Spouse Country'),
            'spouse_number' => Yii::t('translation', 'Spouse Number'),
            'spouse_dob' => Yii::t('translation', 'Spouse Dob'),
            'spouse_identity' => Yii::t('translation', 'Spouse Identity'),
            'nok_number_1' => Yii::t('translation', 'Nok Number 1'),
            'nok_occupation_1' => Yii::t('translation', 'Nok Occupation 1'),
            'nok_company_1' => Yii::t('translation', 'Nok Company 1'),
            'nok_comment_1' => Yii::t('translation', 'Nok Comment 1'),
            'nok_relationship_2' => Yii::t('translation', 'Nok Relationship 2'),
            'spouse_occupation' => Yii::t('translation', 'Spouse Occupation'),
            'spouse_company' => Yii::t('translation', 'Spouse Company'),
            'spouse_comment' => Yii::t('translation', 'Spouse Comment'),
            'nok_relationship_1' => Yii::t('translation', 'Nok Relationship 1'),
            'nok_name_1' => Yii::t('translation', 'Nok Name 1'),
            'nok_mobile_1' => Yii::t('translation', 'Nok Mobile 1'),
            'nok_country_1' => Yii::t('translation', 'Nok Country 1'),
            'nok_name_2' => Yii::t('translation', 'Nok Name 2'),
            'nok_mobile_2' => Yii::t('translation', 'Nok Mobile 2'),
            'nok_country_2' => Yii::t('translation', 'Nok Country 2'),
            'nok_number_2' => Yii::t('translation', 'Nok Number 2'),
            'nok_occupation_2' => Yii::t('translation', 'Nok Occupation 2'),
            'nok_company_2' => Yii::t('translation', 'Nok Company 2'),
            'nok_comment_2' => Yii::t('translation', 'Nok Comment 2'),
            'medical_company_name' => Yii::t('translation', 'Company Name'),
            'medical_department' => Yii::t('translation', 'Department'),
            'medical_staff_no' => Yii::t('translation', 'Staff No'),
            'medical_entitlement_from' => Yii::t('translation', 'Entitlement From'),
            'medical_entitlement_to' => Yii::t('translation', 'Entitlement To'),
            'medical_bill_insurance' => Yii::t('translation', 'To Bill Insurance'),
            'medical_insurance_name' => Yii::t('translation', 'Insurance Name'),
            'medical_follow' => Yii::t('translation', 'Follow'),
            'medical_copayment' => Yii::t('translation', 'Copayment'),
            'medical_copayment_amount_from' => Yii::t('translation', 'Copayment Amount From'),
            'medical_copayment_amount_to' => Yii::t('translation', 'Copayment Amount To'),
            'medical_attachment' => Yii::t('translation', 'Attachment'),
            'status' => Yii::t('translation', 'Status'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($return = false) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        // $criteria->compare('salutation',$this->salutation,true);
        // $criteria->compare('first_char',$this->first_char,true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('name', $this->name, true);
        if ($this->is_deleted == 1)
        {
            $criteria->compare('is_deleted', $this->is_deleted);
        }
        else
            $criteria->addCondition('t.`is_deleted` = 0 OR t.`is_deleted` is NULL');
        
        // $criteria->compare('nationality',$this->nationality,true);
        // $criteria->compare('dob',$this->dob,true);
        // $criteria->compare('gender',$this->gender,true);
        // $criteria->compare('marital',$this->marital,true);
        // $criteria->compare('race',$this->race,true);
        // $criteria->compare('religion',$this->religion,true);
        // $criteria->compare('registration_date',$this->registration_date,true);
        $criteria->compare('reference_no', $this->reference_no, true);
        $criteria->compare('contact_number_1', $this->contact_number_1, true);
        $criteria->compare('contact_country_1', $this->contact_country_1, true);
        $criteria->compare('first_char', $this->first_char, true);
        // $criteria->compare('doctor_id',$this->doctor_id);
        $criteria->compare('status', STATUS_ACTIVE);

        $criteria->order = 'first_char ASC';

        $_SESSION['data-excel-patient'] = new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
        ));

        if ($return) {
            return $this->findAll($criteria);
        } else {
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->params['defaultPageSize'],
                ),
            ));
        }
    }

    public function activate() {
        $this->status = 1;
        $this->update();
    }

    public function deactivate() {
        $this->status = 0;
        $this->update();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Patient the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function nextOrderNumber() {
        return Patient::model()->count() + 1;
    }

    public function getPatientID($id) {
        $model = Patient::model()->find('id=' . $id . '');
        if (!empty($model)) {
            return $model;
        }
        return null;
    }

    public function getDropDownListPatientName() {
        $model = Patient::model()->findAll();
        $list = array();

        foreach ($model as $item) {

            $list[] = $item->name;
        }

        return $list;
    }

    /**
     * <Jason>
     * <To save all language match with attributes has been selected>
     */
    public function saveLanguage($list) {
        //Delete all CategoriesAttributes base with category id
        $this->removeLanguageAttributes();
        //Add new
        foreach ($list as $key => $value) {
            $model = new PatientLanguage();
            $model->language_id = $value;
            $model->patient_id = $this->id;
            $model->save();
        }
    }

    public function removeLanguageAttributes() {
        PatientLanguage::model()->deleteAll('patient_id=:cId', array(':cId' => $this->id));
    }

    public function getPatientName($id) {
        $model = Patient::model()->findByPk($id);
        if (isset($model)) {
            return $model->name;
        }
        return null;
    }

    public function getPatientInforMation($id, $doctor_id = null) {
        $model = Patient::model()->findByPk($id);
        $infor = array();
        if (!empty($model)) {

            $doctor = null;
            if (!empty($doctor_id)) {
                $doctor = Doctor::model()->getDoctorById($doctor_id);
            }
            $infor['name'] = $model->name;
            $infor['age'] = $model->age;
            $infor['identity'] = $model->identity;
            $infor['gender'] = $model->gender;
            $infor['doctor_name'] = '';

            if (!empty($doctor) && isset($doctor->name)) {

                $infor['doctor_name'] = $doctor->name;
            }
        }
        return $infor;
    }

    public function searchName($name) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $name, true);
        $criteria->compare('identity', $this->identity, true);
        $criteria->compare('status', STATUS_ACTIVE);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
        ));
    }

    public function setAttributesMedicalInsurrance($attributes) {
        $this->medical_company_name = $attributes->company_name;
        $this->medical_department = $attributes->department;
        $this->medical_staff_no = $attributes->staff_no;
        $this->medical_entitlement_from = $attributes->entitlement_from;
        $this->medical_entitlement_to = $attributes->entitlement_to;
        $this->medical_bill_insurance = $attributes->to_bill_insurrance;
        $this->medical_insurance_name = $attributes->insurrance_name;
        $this->medical_follow = $attributes->follow;
        $this->medical_copayment = $attributes->copayment;
        $this->medical_copayment_amount_from = $attributes->copayment_amount_from;
        $this->medical_copayment_amount_to = $attributes->copayment_amount_to;
    }

    public function updateAttributesMedicalInsurrance() {
        $patientMedicalInsurrance = PatientMedicalInsurrance::model()->getDefaultInsurrance($this->id);
        if (isset($patientMedicalInsurrance)) {
            $patientMedicalInsurrance->company_name = $this->medical_company_name;
            $patientMedicalInsurrance->department = $this->medical_department;
            $patientMedicalInsurrance->staff_no = $this->medical_staff_no;
            $patientMedicalInsurrance->entitlement_from = $this->medical_entitlement_from;
            $patientMedicalInsurrance->entitlement_to = $this->medical_entitlement_to;
            $patientMedicalInsurrance->to_bill_insurrance = $this->medical_bill_insurance;
            $patientMedicalInsurrance->insurrance_name = $this->medical_insurance_name;
            $patientMedicalInsurrance->follow = $this->medical_follow;
            $patientMedicalInsurrance->copayment = $this->medical_copayment;
            $patientMedicalInsurrance->copayment_amount_from = $this->medical_copayment_amount_from;
            $patientMedicalInsurrance->copayment_amount_to = $this->medical_copayment_amount_to;
            $patientMedicalInsurrance->update();
        } else {
            $patientMedicalInsurrance = new PatientMedicalInsurrance;
            $patientMedicalInsurrance->company_name = $this->medical_company_name;
            $patientMedicalInsurrance->department = $this->medical_department;
            $patientMedicalInsurrance->staff_no = $this->medical_staff_no;
            $patientMedicalInsurrance->entitlement_from = $this->medical_entitlement_from;
            $patientMedicalInsurrance->entitlement_to = $this->medical_entitlement_to;
            $patientMedicalInsurrance->to_bill_insurrance = $this->medical_bill_insurance;
            $patientMedicalInsurrance->insurrance_name = $this->medical_insurance_name;
            $patientMedicalInsurrance->follow = $this->medical_follow;
            $patientMedicalInsurrance->copayment = $this->medical_copayment;
            $patientMedicalInsurrance->copayment_amount_from = $this->medical_copayment_amount_from;
            $patientMedicalInsurrance->copayment_amount_to = $this->medical_copayment_amount_to;
            $patientMedicalInsurrance->patient_id = $this->id;
            $patientMedicalInsurrance->default = 1;
            $patientMedicalInsurrance->save();
        }
    }

    public function updateAttributesPatientDrugAlert() {
        if ($this->allergy && !empty($this->comment_allergy)) {
            
            $allergyComment = explode('-', trim(htmlspecialchars($this->comment_allergy)));
//            $name = isset($allergyComment[0]) ? $allergyComment[0] : '';
//            $comment = isset($allergyComment[1]) ? $allergyComment[1] : '';
//            echo $name . ' - ' . $comment;die;
            PatientDrugAlert::addDrug($this->id, $this->comment_allergy, $this->comment_allergy);
        }
    }

    public function getListByVisit($post) {
        $fromDate = DateHelper::toDbDateFormat($post['from_date']);
        $toDate = DateHelper::toDbDateFormat($post['to_date']);

        $prefix = Yii::app()->db->tablePrefix;
        $sql = "select p.id from " . $prefix . "_patient as p join " . $prefix . "_appointment as ap on p.id = ap.patient_id
         join " . $prefix . "_event as e on ap.event_id = e.id where DATE(e.start) >= '" . $fromDate . "' and DATE(e.end) <= '" . $toDate . "'";

        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getListByRegistrationDate($post) {
        $date = DateHelper::toDbDateFormat($post['registration_date']);
        $prefix = Yii::app()->db->tablePrefix;
        $sql = "select p.id from " . $prefix . "_patient as p where DATE(p.registration_date) = '" . $date . "'";

        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getListByDoctorName($post) {
        $prefix = Yii::app()->db->tablePrefix;
        $sql = "select p.id from " . $prefix . "_patient as p join " . $prefix . "_queue as q on p.id = q.patient_id where q.doctor_id = '" . $post['doctor_id'] . "'";

        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getListByAlphabet($post) {
        $prefix = Yii::app()->db->tablePrefix;
        $sql = "select p.id from " . $prefix . "_patient as p where p.first_char >= '" . $post['alpha_from'] . "' and p.first_char <= '" . $post['alpha_to'] . "'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getListByAllentry() {
        $prefix = Yii::app()->db->tablePrefix;
        $sql = "select p.id from " . $prefix . "_patient as p where p.status = 1";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getListByChecked($post) {
        $arr = '(' . $post . ')';
        $prefix = Yii::app()->db->tablePrefix;
        $sql = "select p.id from " . $prefix . "_patient as p where p.status = 1 and p.id in " . $arr;
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getListPatients() {
        $criteria = new CDbCriteria;
        $criteria->compare('status', STATUS_ACTIVE);
        $criteria->order = 'name ASC';
        $model = Patient::model()->findAll($criteria);
        $list = array();

        foreach ($model as $item) {

            $list[$item->id] = $item->name;
        }

        return $list;
    }

    public static function generatePatientOnSearch($name = '') {
        $model = new Patient();
        $model->registration_date = date('Y-m-d');
        $model->reference_no = MyFunctionCustom::genUniqueCode('P');
        $model->nationality = 'Singaporean';
        $model->residential_country = DEFAULT_COUNTRY;
        $model->mailling_country = DEFAULT_COUNTRY;
        $model->contact_country_1 = DEFAULT_COUNTRY;
        $model->contact_country_2 = DEFAULT_COUNTRY;
        $model->contact_country_3 = DEFAULT_COUNTRY;
        $model->spouse_country = DEFAULT_COUNTRY;
        $model->nok_country_1 = DEFAULT_COUNTRY;
        $model->nok_country_2 = DEFAULT_COUNTRY;
        $model->name = $name;
        $model->dob = null;
        $model->spouse_dob = null;
        $model->first_char = strtolower(@$model->name[0]);
        if ($model->save()) {
            return $model->id;
        } else {
            return 0;
        }
    }

    public static function isExist($patientName = '') {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->addCondition('LOWER(`name`) like "%' . $patientName . '%"');
        $criteria->limit = '1';
        $model = self::model()->find($criteria);
        return isset($model);
    }
    
    public function saveFile($fieldName,$fieldId, $description = array(), $type, $update=false) 
    {
        $this->$fieldName = CUploadedFile::getInstances($this, $fieldName);
        if($update == true) {
            
            $Attachfile = PatientAttachFile::model()->findAll('patient_id = :patient_id and type = 1',array(':patient_id'=>$this->id));
            if($type == 'report') {
                $Attachfile = PatientAttachFile::model()->findAll('patient_id = :patient_id and type = 2',array(':patient_id'=>$this->id));
            }
            
            if($type == 'insurrance_card') {
                 $Attachfile = PatientAttachFile::model()->findAll('patient_id = :patient_id and type = 3',array(':patient_id'=>$this->id));
            }
            $listKey = array();
            foreach ($Attachfile as $key => $file) {
                if( !empty($this->$fieldId) && in_array($file->id ,$this->$fieldId)) {
                        $file->description = $description[$key ];
                        $listKey[] = $key;
                        $file->save();
                }
                else
                {
                    $listKey[] = $key;
                    $this->deleteFiles($fieldName,$file->file,$type);
                    $file->delete();
                }
            }
           $decriptionU = array();
           
           if(!empty($description)) {
                foreach ($description as $key=> $value) {
                    if(!in_array($key, $listKey)) {
                        $decriptionU[] = $value;
                    }
                }
           }
           
           $description = $decriptionU;
        }
        if (!empty($this->$fieldName)) {

            foreach ($this->$fieldName as $key => $item) {

                $name = time() . '_' . $this->id . '_' . rand() . '.' .$item->extensionName;
                self::createDirectoryByPath('upload/patient/'.$this->id.'/'.$type);
                $item->saveAs('upload/patient/'.$this->id.'/'.$type.'/'. $name);
             
                $File = new PatientAttachFile();
               
                $File->file = $name;
                $File->name = $item->name;
                $File->patient_id = $this->id;
                $File->description = $description[$key];
                $File->created = time();
                if($type == 'referral_letter') {
                    $File->type = 1;
                }
                elseif($type == 'report') {
                    $File->type = 2;
                }
                else {
                     $File->type = 3;
                }
                $File->save();
            }

            return $this;
        }
    }

    public function deleteFiles($fieldName, $oldFile,$type) {
        if (!empty($oldFile))
            ImageHelper::deleteFile('upload/patient/' . '/' . $this->id .'/'.$type. '/' . $oldFile);
    }
    
    public static function createDirectoryByPath($path) {
        $aFolder = explode('/', $path);
        if (is_array($aFolder)) {
            self::removeEmptyItemFromArray($aFolder);
            $root = Yii::getPathOfAlias('webroot');
            $currentPath = $root;
            foreach ($aFolder as $key => $folder) {
                $currentPath = $currentPath . '/' . $folder;
                if (!is_dir($currentPath)) {
                    mkdir($currentPath);
                    chmod($currentPath, 0755);
                }
            }
        }
    }
    
     public static function removeEmptyItemFromArray(&$arr) {
        foreach ($arr as $key => $value)
            if (is_null($value)) {
                unset($arr[$key]);
            }
    }

}

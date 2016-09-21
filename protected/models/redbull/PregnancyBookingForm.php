<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class PregnancyBookingForm extends CFormModel
{
    public $doctor_id;
    public $bookingDate;
    public $bookingTime;
    public $bookingTime_show;
    public $startDate;
    public $endDate;
    public $time;
    public $datetime_type;
    public $patient_name;
    public $patient_ncic;
    public $pregnancy_type;
    public $area_code_id;
    public $patient_contact;
    public $timeslot_id;
    public $created_date;
    public $dob;
    public $scan_type;
    public $g;
    public $p;
    public $turn_up;
    public $ultrasound_type;
    public $is_virggo_intacta;
    public $procedure;
    public $lmp;
    public $edd;
    public $medical_history;
    public $note;
    public $previous_scan;
    public $comments;

    public static $scanType = array(
        '0' => 'XYZ',
        '1' => 'RST',
    );
    public static $pregnancyType = array(
        '0' => 'Patient is not pregnant',
        '1' => 'Singleton pregnancy',
        '2' => 'Multiple pregnancy',
    );
    public static $ultrasoundType = array(
        '0' => 'Early FA scan (16 – 20 weeks)',
        '1' => 'FA scan (21 – 23 weeks)',
        '2' => 'Growth scan',
        '3' => 'AFI + doppler',
        '4' => 'Dating / Viability scan',
        '5' => 'Gynae Scan',
        '5' => 'NT + 1st Trimester Screening (11 – 13 +6 weeks)',
        '5' => 'Cervical length',
    );
    public static $procedureType = array(
        '0' => 'Amniocentesis (15 – 20 weeks)',
        '1' => 'FBS',
        '2' => 'CVS (10 +3 – 12 +3 weeks)',
        '3' => 'IAPG (16 – 24 weeks)',
        '4' => 'Fetal reduction',
    );
    public static $datetimeType = array(
        '0' => 'No date and time preference',
        '1' => 'Earliest available appointment',
        '2' => 'Prefres date and time',
    );

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(

        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array();
    }
}

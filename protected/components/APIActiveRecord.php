<?php

define('SFDOCTOR_HOST', Yii::app()->params['api65Client']['_65host']);
define("SFDOCTOR_OAUTH_HOST", Yii::app()->params['api65Client']['_65host']."/api");
define("SFDOCTOR_REQUEST_TOKEN_URL", SFDOCTOR_OAUTH_HOST . "/oauth/request_token");
define("SFDOCTOR_AUTHORIZE_URL", SFDOCTOR_OAUTH_HOST . "/oauth/authorize");
define("SFDOCTOR_ACCESS_TOKEN_URL", SFDOCTOR_OAUTH_HOST . "/oauth/access_token");
define('OAUTH_TMP_DIR', function_exists('sys_get_temp_dir') ? sys_get_temp_dir() : realpath($_ENV["TMP"]));

class APIActiveRecord extends CActiveRecord
{

    private $uriProfile;
    private $uriMyAppointmentBookings;
    private $uriMyDoctorAppoitment;
    private $uriCancelMyDoctorAppoitment;
    private $uriMyTimeslots;
    private $uriBookAppointment;
    private $uriRequestAppointment;
    private $uriGetDoctorInfo;
    private $consumer_key; // fill with your public key
    private $consumer_secret; // fill with your secret key(array)
    private $email = 'enquiry@65doctor.com';
    private $password = 'EURC7Z';
    private $host = '';

    public function __construct()
    {
        if (empty(Yii::app()->params['api65Client']['key']) || empty(Yii::app()->params['api65Client']['secret']))
            throw new Exception("Please set 65doctor API Client authentication info, or contact to 65doctor.com");
        $this->host                        = !empty(Yii::app()->params['api65Client']['host']) ? Yii::app()->params['api65Client']['host'] : SFDOCTOR_OAUTH_HOST;
        $this->consumer_key                = Yii::app()->params['api65Client']['key'];
        $this->consumer_secret             = Yii::app()->params['api65Client']['secret'];
        $this->uriProfile                  = $this->host . "/user/";
        $this->uriMyAppointmentBookings    = $this->host . "/user/myAppointmentBookings/";
        $this->uriMyDoctorAppoitment       = $this->host . "/user/myDoctorAppoitment/";
        $this->uriCancelMyDoctorAppoitment = $this->host . "/user/myDoctorAppoitment/";
        $this->uriMyTimeslots              = $this->host . "/myTimeslot/index/";
        $this->uriBookAppointment          = $this->host . "/appointment/book/";
        $this->uriRequestAppointment       = $this->host . "/appointment/request/";
        $this->uriGetDoctorInfo            = $this->host . "/doctor/";
    }

    
    public function test($params)
    {
        $uri       = $this->host . '/redbull/index';
        $options   = array(
            'consumer_key' => $this->consumer_key,
            'consumer_secret' => $this->consumer_secret
        );
        $oinstance = OAuthStore::instance("2Leg", $options);
        $method    = 'POST';
        //For specialities=================
        try {
            $request = new OAuthRequester($uri, $method, $params);
            $result  = $request->doRequest();
            $result  = json_decode($result['body']);
        }
        catch (OAuthException2 $e) {
            //var_dump($e);
        }
        return $result;
    }

    public function sentTo65doctor($params,$url) {
        $url       = $this->host . $url;
        $options   = array(
            'consumer_key' => $this->consumer_key,
            'consumer_secret' => $this->consumer_secret
        );
        $oinstance = OAuthStore::instance("2Leg", $options);
        $method    = 'POST';
        //For specialities=================
        try {
            $request = new OAuthRequester($url, $method, $params);
            $result  = $request->doRequest();
            $result  = json_decode($result['body']);
        }
        catch (OAuthException2 $e) {
            var_dump($e);
        }
        return $result;
    }

}

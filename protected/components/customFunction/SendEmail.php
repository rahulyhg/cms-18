<?php

//mail
define('MAIL_REGISTER_SUCCEED_TO_MEMBER', 1);
define('MAIL_REGISTER_SUCCEED_TO_ADMIN', 2);
define('MAIL_FORGET_PASSWORD', 3);
define('MAIL_CONTACT_US_TO_ADMIN', 4);
define('MAIL_CONTACT_US_TO_USER', 5);
define('MAIL_CHANGE_PASSWORD_TO_USER', 6);
define('MAIL_VERIFY_TO_RESET_PASSWORD_TO_ADMIN', 7);
define('MAIL_RESET_PASSWORD_TO_ADMIN', 8);
define('MAIL_CHANGE_PASSWORD_TO_ADMIN', 9);
// define('MAIL_QUOTE_TO_ADMIN',10);
// define('MAIL_QUOTE_TO_USER',11);

define('MAIL_PROPERTY_TO_ADMIN', 10);
define('MAIL_PROPERTY_TO_USER', 11);
define('MAIL_VALUATION_TO_ADMIN', 12);
define('MAIL_VALUATION_TO_USER', 13);
define('MAIL_EBROUCHURE_TO_ADMIN', 14);
define('MAIL_EBROUCHURE_TO_USER', 15);

class SendEmail {

    //registering successfully, send email to User

        //send email to User for forgetting password
    public static function forgetPassMailToUser($userM) {
        $link = '<a href="' . Yii::app()->createAbsoluteUrl("site/login") . '">' . Yii::app()->createAbsoluteUrl("site/login") . '</a>';
        $aBody = array(
            '{NAME}' => $userM->full_name,
            '{EMAIL}' => $userM->email,
            '{PASSWORD}' => $userM->temp_password,
            '{LINK_LOGIN}' => $link,
        );

        $aSubject = array(
            '{NAME}' => $userM->full_name,
        );

        if (CmsEmail::sendmail(MAIL_FORGET_PASSWORD, $aSubject, $aBody, $userM->email)) {
            
        } else
            $userM->addError('status', 'Can not send email');
    }

    //send email to User for changing password
    public static function changePassMailToUser($userM) {
        $name = $userM->full_name;
        $login_link = '<a href="' . Yii::app()->createAbsoluteUrl("admin/site/login") . '">' . Yii::app()->createAbsoluteUrl("admin/site/login") . '</a>';
        $aBody = array(
            '{FULL_NAME}' => $name,
            '{PASSWORD}' => $userM->temp_password,
            '{LINK_LOGIN}' => $login_link,
        );

        $aSubject = array(
            '{FULL_NAME}' => $name,
            '{PASSWORD}' => $userM->temp_password,
            '{LINK_LOGIN}' => $login_link,
        );

        if (CmsEmail::sendmail(MAIL_CHANGE_PASSWORD_TO_USER, $aSubject, $aBody, $userM->email))
            Yii::app()->user->setFlash("success", "An email has sent to: $userM->email. Please check email to get new password.");
        else
            $userM->addError('email', 'Can not send email to: ' . $userM->email);
    }

    //Submitting contact form successfully, send email to confirm User
    public static function confirmContactMailToUser($contactM) {
        $aBody = array(
            '{NAME}' => $contactM->name,
            '{EMAIL}' => $contactM->email,
            '{PHONE}' => $contactM->contact_no,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $contactM->email,
            '{MESSAGE}' => $contactM->message,
        );

        $aSubject = array(
            '{NAME}' => $contactM->name,
            '{EMAIL}' => $contactM->email,
            '{PHONE}' => $contactM->contact_no,
            '{MESSAGE}' => $contactM->message,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $contactM->email,
        );

        if (EmailHelper::send(MAIL_CONTACT_US_TO_USER, $aSubject, $contactM->email)) {
            
        } else
            $contactM->addError('email', 'Can not send email to: ' . $contactM->email);
    }

    //Submitting contact form successfully, send email to Administrator
    public static function noticeContactMailToAdmin($contactM) {
        $aBody = array(
            '{NAME}' => $contactM->name,
            '{EMAIL}' => $contactM->email,
            '{PHONE}' => $contactM->contact_no,
            '{MESSAGE}' => $contactM->message,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $contactM->email,
        );

        $aSubject = array(
            '{NAME}' => $contactM->name,
            '{EMAIL}' => $contactM->email,
            '{PHONE}' => $contactM->contact_no,
            '{MESSAGE}' => $contactM->message,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $contactM->email,
        );

        if (EmailHelper::send(MAIL_CONTACT_US_TO_ADMIN, $aSubject, Yii::app()->params['adminEmail'])) {
            
        } else
            $contactM->addError('email', 'Can not send email to: ' . $contactM->email);
    }

    //mail from Forgot Password at BE
    public static function verifyResetPasswordToAdmin($userM) {
        $name = $userM->full_name;
        $key = ForgotPasswordForm::generateKey($userM);
        $forgot_link = '<a href="' . Yii::app()->createAbsoluteUrl('/admin/site/resetPassword', array('id' => $userM->id, 'key' => $key)) . '">' . Yii::app()->createAbsoluteUrl('/admin/site/ResetPassword', array('id' => $userM->id, 'key' => $key)) . '</a>';

        $aBody = array(
            '{NAME}' => $name,
            '{USERNAME}' => $userM->username,
            '{EMAIL}' => $userM->email,
            '{LINK}' => $forgot_link,
        );
        $aSubject = array(
            '{NAME}' => $name,
            '{USERNAME}' => $userM->username,
            '{EMAIL}' => $userM->email,
            '{LINK}' => $forgot_link,
        );

        if (CmsEmail::sendmail(MAIL_VERIFY_TO_RESET_PASSWORD_TO_ADMIN, $aSubject, $aBody, Yii::app()->params['adminEmail']))
            Yii::app()->user->setFlash("success", "An email has sent to: $userM->email. Please check email to verify this action.");
        else
            $userM->addError('email', 'Can not send email.');
    }

    //mail to reset password after admin agreed verify email at BE
    public static function resetPasswordToAdmin($userM) {
        $name = $userM->full_name;
        $login_link = '<a href="' . Yii::app()->createAbsoluteUrl("admin/site/login") . '">' . Yii::app()->createAbsoluteUrl("admin/site/login") . '</a>';
        $aBody = array(
            '{NAME}' => $name,
            '{PASSWORD}' => $userM->temp_password,
            '{LINK_LOGIN}' => $login_link,
        );

        $aSubject = array(
            '{NAME}' => $name,
            '{PASSWORD}' => $userM->temp_password,
            '{LINK_LOGIN}' => $login_link,
        );

        if (CmsEmail::sendmail(MAIL_RESET_PASSWORD_TO_ADMIN, $aSubject, $aBody, Yii::app()->params['autoEmail']))
            Yii::app()->user->setFlash("success", "An email has sent to: $userM->email. Please check email to get new password.");
        else
            $userM->addError('email', 'Can not send email to: ' . $userM->email);
    }

    //mail to change password successfully from "Change password form" at BE
    public static function noticeChangPasswordSucceedToAdmin($userM) {
        $name = $userM->full_name;
        $login_link = '<a href="' . Yii::app()->createAbsoluteUrl("admin/site/login") . '">' . Yii::app()->createAbsoluteUrl("admin/site/login") . '</a>';
        $aBody = array(
            '{NAME}' => $name,
            '{PASSWORD}' => $userM->temp_password,
            '{LINK_LOGIN}' => $login_link,
        );

        $aSubject = array(
            '{NAME}' => $name,
            '{PASSWORD}' => $userM->temp_password,
            '{LINK_LOGIN}' => $login_link,
        );

        if (CmsEmail::sendmail(MAIL_CHANGE_PASSWORD_TO_ADMIN, $aSubject, $aBody, Yii::app()->params['adminEmail']))
            Yii::app()->user->setFlash("success", "An email has sent to: $userM->email. Please check email to get new password.");
        else
            $userM->addError('email', 'Can not send email to: ' . $userM->email);
    }

    //Submitting property search form successfully, send email to confirm User
    public static function confirmPropertySearchMailToUser($propertysearch) {
        $aBody = array(
            '{NAME}' => $propertysearch->name,
            '{EMAIL}' => $propertysearch->email,
            '{PHONE}' => $propertysearch->mobile,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $propertysearch->email,
        );

        $aSubject = array(
            '{NAME}' => $propertysearch->name,
            '{EMAIL}' => $propertysearch->email,
            '{PHONE}' => $propertysearch->mobile,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $propertysearch->email,
        );

        if (EmailHelper::send(MAIL_PROPERTY_TO_USER, $aSubject, $propertysearch->email)) {
            
        } else
            $propertysearch->addError('email', 'Can not send email to: ' . $propertysearch->email);
    }

    //Submitting contact form successfully, send email to Administrator
    public static function noticePropertySearchMailToAdmin($propertysearch) {
        $aBody = array(
            '{NAME}' => $propertysearch->name,
            '{EMAIL}' => $propertysearch->email,
            '{PHONE}' => $propertysearch->mobile,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $propertysearch->email,
        );

        $aSubject = array(
            '{NAME}' => $propertysearch->name,
            '{EMAIL}' => $propertysearch->email,
            '{PHONE}' => $propertysearch->mobile,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $propertysearch->email,
        );

        if (EmailHelper::send(MAIL_PROPERTY_TO_ADMIN, $aSubject, Yii::app()->params['adminEmail'])) {
            
        } else
            $propertysearch->addError('email', 'Can not send email to: ' . $propertysearch->email);
    }

    //Submitting property search form successfully, send email to confirm User
    public static function confirmValuationRequestMailToUser($valuationrequest) {
        $aBody = array(
            '{NAME}' => $valuationrequest->owner_name,
            '{EMAIL}' => $valuationrequest->owner_email,
            '{PHONE}' => $valuationrequest->owner_mobile,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $valuationrequest->owner_email,
        );

        $aSubject = array(
            '{NAME}' => $valuationrequest->owner_name,
            '{EMAIL}' => $valuationrequest->owner_email,
            '{PHONE}' => $valuationrequest->owner_mobile,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $valuationrequest->owner_email,
        );

        if (EmailHelper::send(MAIL_VALUATION_TO_USER, $aSubject, $valuationrequest->owner_email)) {
            
        } else
            $valuationrequest->addError('email', 'Can not send email to: ' . $valuationrequest->owner_email);
    }

    //Submitting contact form successfully, send email to Administrator
    public static function noticeValuationRequestMailToAdmin($valuationrequest) {
        $aBody = array(
            '{NAME}' => $valuationrequest->owner_name,
            '{EMAIL}' => $valuationrequest->owner_email,
            '{PHONE}' => $valuationrequest->owner_mobile,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $valuationrequest->owner_email,
        );

        $aSubject = array(
            '{NAME}' => $valuationrequest->owner_name,
            '{EMAIL}' => $valuationrequest->owner_email,
            '{PHONE}' => $valuationrequest->owner_mobile,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $valuationrequest->owner_email,
        );

        if (EmailHelper::send(MAIL_VALUATION_TO_ADMIN, $aSubject, Yii::app()->params['adminEmail'])) {
            
        } else
            $valuationrequest->addError('email', 'Can not send email to: ' . $valuationrequest->owner_email);
    }

    //Submitting contact form successfully, send email to Administrator
    public static function noticeEbrouchureMailToAdmin($ebrouchure) {
        $aBody = array(
            '{NAME}' => $ebrouchure->name,
            '{EMAIL}' => $ebrouchure->email,
            '{PHONE}' => $ebrouchure->mobile,
            '{REMARK}' => $ebrouchure->remark,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $ebrouchure->email,
        );

        $aSubject = array(
            '{NAME}' => $ebrouchure->name,
            '{EMAIL}' => $ebrouchure->email,
            '{PHONE}' => $ebrouchure->mobile,
            '{REMARK}' => $ebrouchure->remark,
            '{SUBJECT}' => 'Property Cottage: contact from ' . $ebrouchure->email,
        );
        if (EmailHelper::send(MAIL_EBROUCHURE_TO_ADMIN, $aSubject, Yii::app()->params['adminEmail'])) {
            
        } else
            $ebrouchure->addError('email', 'Can not send email to: ' . $ebrouchure->email);
    }

    //Submitting contact form successfully, send email to Administrator
    public static function confirmEbrouchureMailToUser($ebrouchure) {
        $aBody = array(
            '{NAME}' => $ebrouchure->name,
            '{EMAIL}' => $ebrouchure->email,
            '{PHONE}' => $ebrouchure->mobile,
            '{REMARK}' => $ebrouchure->remark,
            // '{URL}' => MyFunctionCustom::buildListPropertyDownload($ebrouchure->property_id, $ebrouchure->email),
            '{SUBJECT}' => 'Property Cottage: contact from ' . $ebrouchure->email,
        );

        $aSubject = array(
            '{NAME}' => $ebrouchure->name,
            '{EMAIL}' => $ebrouchure->email,
            '{PHONE}' => $ebrouchure->mobile,
            '{REMARK}' => $ebrouchure->remark,
            // '{URL}' => MyfunctionCustom::buildListPropertyDownload($ebrouchure->property_id, $ebrouchure->email),
            '{SUBJECT}' => 'Property Cottage: contact from ' . $ebrouchure->email,
        );

        if (EmailHelper::send(MAIL_EBROUCHURE_TO_USER, $aSubject, $ebrouchure->email)) {
            
        } else
            $ebrouchure->addError('email', 'Can not send email to: ' . $ebrouchure->email);
    }

}

?>

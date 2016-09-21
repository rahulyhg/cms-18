<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EmailHelper {

    public static function sendMail($data) {
        try {
            $message = new YiiMailMessage($data['subject']);
            $message->setBody($data['message'], 'text/html');
            if (is_array($data['to'])) {
                foreach ($data['to'] as $t) {
                    $message->addTo($t);
                }
            } else
                $message->addTo($data['to']);

            if (isset($data['cc']))
                $message->setCc($data['cc']);

            $message->from = $data['from'];
            $message->setFrom(array($data['from'] => Yii::app()->setting->getItem('title_all_mail')));
            return Yii::app()->mail->send($message);
        } catch (exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    /*     * *
     * $emailTemplateId: Email template id in database
     * $param: supported param in template with array key=>value. Key is param {key} in template
     */

    public static function bindEmailContent($emailTemplateId, $param, $to, $cc = null) {
        $modelEmailTemplate = EmailTemplates::model()->findByPk($emailTemplateId);
        if (!empty($modelEmailTemplate)) {
            $message = $modelEmailTemplate->email_body;
            $subject = $modelEmailTemplate->email_subject;
            if (!empty($param)) {
                foreach ($param as $key => $value) {
                    $message = str_replace('{' . strtoupper($key) . '}', $value, $message);
                    $subject = str_replace('{' . strtoupper($key) . '}', $value, $subject);
                }
            }

            // Send a email to patient     
            $data = array(
                'subject' => $subject,
                'message' => $message,
                'to' => $to,
                'cc' => $cc,
                'from' => Yii::app()->params['autoEmail'],
            );
            return self::sendMail($data);
        }
        return false;
    }

    public static function send($emailTemplateId, $param, $to, $cc = null) {
        $mEmailTemplates = EmailTemplates::model()->findByPk($emailTemplateId);
        if ($mEmailTemplates) {
            if (!empty($param)) {
                $message = strtr($mEmailTemplates->email_body, $param);
                $subject = strtr($mEmailTemplates->email_subject, $param);
            }
            $data = array(
                'subject' => $subject,
                'message' => $message,
                'to' => $to,
                'cc' => $cc,
                'from' => Yii::app()->params['autoEmail'],
            );
            return self::sendMail($data);
        }
        return false;
    }

}

?>

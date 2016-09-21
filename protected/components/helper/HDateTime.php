<?php

class HDateTime extends _BaseModel {
    /**
     * Returns the static class of the specified class.
     * Please note that you should have this exact method in all your BaseClass descendants!
     * @param string $className class name.
     * @return the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * get a list of months
     * @param boolean $startZero Is array keys from 1 - 12 or 0 - 11
     * @return array list of months
     */
    public function months($startZero = false) {
        $startZero = (int)$startZero;
        return array(
            1 - $startZero   => Yii::t('static', 'January'),
            2 - $startZero   => Yii::t('static', 'February'),
            3 - $startZero   => Yii::t('static', 'March'),
            4 - $startZero   => Yii::t('static', 'April'),
            5 - $startZero   => Yii::t('static', 'May'),
            6 - $startZero   => Yii::t('static', 'June'),
            7 - $startZero   => Yii::t('static', 'July'),
            8 - $startZero   => Yii::t('static', 'August'),
            9 - $startZero   => Yii::t('static', 'September'),
            10 - $startZero  => Yii::t('static', 'October'),
            11 - $startZero  => Yii::t('static', 'November'),
            12 - $startZero  => Yii::t('static', 'December'),
        );
    }

    /**
     * get a list of short months
     * @param boolean $startZero Is array keys from 1 - 12 or 0 - 11
     * @return array list of short months
     */
    public function shortMonths($startZero = false) {
        $startZero = (int)$startZero;
        return array(
            1 - $startZero   => Yii::t('static', 'Jan'),
            2 - $startZero   => Yii::t('static', 'Feb'),
            3 - $startZero   => Yii::t('static', 'Mar'),
            4 - $startZero   => Yii::t('static', 'Apr'),
            5 - $startZero   => Yii::t('static', 'May'),
            6 - $startZero   => Yii::t('static', 'Jun'),
            7 - $startZero   => Yii::t('static', 'Jul'),
            8 - $startZero   => Yii::t('static', 'Aug'),
            9 - $startZero   => Yii::t('static', 'Sep'),
            10 - $startZero  => Yii::t('static', 'Oct'),
            11 - $startZero  => Yii::t('static', 'Nov'),
            12 - $startZero  => Yii::t('static', 'Dec'),
        );
    }

    /**
     * get a list of days in a month
     * @return array of days
     */
    public function days() {
        return HNumber::model()->numbers(1, 31);
    }

    /**
     * get a list of years
     * @param int $start start year optional, default last 100 year
     * @param int $end end year optional default current year
     * @return array of years
     */
    public function years($start = null, $end = null) {
        if (empty($end))
            $end = (int)date('Y');
        if (empty($start))
            $start = $end - 100;
        return HNumber::model()->numbers($start, $end);
    }

    /**
     * get a list of hours
     * @param int $from From hour, default 0
     * @param int $to To Hour, default 23
     * @param int $span add this number for each loop
     * @return array of hours
     */
    public function hours($from = 0, $to = 23, $span = 1) {
        return HNumber::model()->numbers($from, $to, $span, true);
    }

    /**
     * get a list of minutes
     * @param int $from From Minute, default 0
     * @param int $to To Minute, default 59
     * @param int $span add this number for each loop, default 5
     * @return array of minutes
     */
    public function minutes($from = 0, $to = 59, $span = 5) {
        return HNumber::model()->numbers($from, $to, $span, true);
    }

    /**
     * get a list days of week
     * full strings
     * @return array list days of week
     */
    public function dayOfWeeks() {
        return array(
            'Monday' => Yii::t('static', 'Monday'),
            'Tuesday' => Yii::t('static', 'Tuesday'),
            'Wednesday' => Yii::t('static', 'Wednesday'),
            'Thursday' => Yii::t('static', 'Thursday'),
            'Friday' => Yii::t('static', 'Friday'),
            'Saturday' => Yii::t('static', 'Saturday'),
            'Sunday' => Yii::t('static', 'Sunday'),
            );
    }

    /**
     * get a list days of week
     * short string
     * @return array list days of week
     */
    public function shortDayOfWeeks() {
        return array(
            'Mon' => Yii::t('static', 'Mon'),
            'Tue' => Yii::t('static', 'Tue'),
            'Wed' => Yii::t('static', 'Wed'),
            'Thu' => Yii::t('static', 'Thu'),
            'Fri' => Yii::t('static', 'Fri'),
            'Sat' => Yii::t('static', 'Sat'),
            'Sun' => Yii::t('static', 'Sun'),
            );
    }

    /**
     * get a list date intervals
     * @return array of date intervals
     */
    public function getDateIntervals() {
        return array(
                'Day' => Yii::t('static', 'Day'),
                'Month' => Yii::t('static', 'Month'),
                'Year' => Yii::t('static', 'Year'),
            );
    }

    /**
     * get a list of Uppercase Ante meridiem and Post meridiem
     * @return array of AM PM options
     */
    public function getAMPM() {
        return array(
            'AM'    => Yii::t('static', 'AM'),
            'PM'    => Yii::t('static', 'PM'),
        );
    }

    /**
     * populate DateTime value from parameter
     * @param mixed $value
     * @return DateTime
     */
    public function populate($value) {
        if (empty($value)) {
            return new DateTime();
        } elseif (is_string($value)) {
            return new DateTime($value);
        } elseif ($value instanceof DateTime) {
            return $value;
        } elseif (is_int($value)) {
            DateTime::setTimestamp( $value );

        } else
            throw new Exception("Invalid DateTime format.", 1);
    }

    /**
     * get value of time
     * @param mixed $time
     * @param int $limit (1: hour, 2: minute, 3: second)
     * @return int
     */
    public function getValue($time, $limit = 2) {
        if (empty($time))
            throw new Exception("Invalid time parameter", 1);
        elseif (is_string($time)) {
            $time = explode(':', $time);
            if (empty($time)) {
                throw new Exception("Invalid time parameter", 1);
            }
        }
        $length = count($time);
        if ($length > $limit) {
            $length = $limit;
        }
        $result = 0;
        for ( $i = 0, $j = $length-1; $i < $length; $i++, $j--) {
            $result += (int)$time[$i]*pow(60, $j);
        }
        return (int)$result;
    }

    /**
     * Compare two date time is equal
     * @param mixed $date1
     * @param mixed $date2
     * @return boolean
     */
    public function equalDate($date1, $date2) {
       $date1 = $this->populate($date1);
       $date2 = $this->populate($date2);
       return $date1->format('Y-m-d') === $date2->format('Y-m-d');
    }

    /**
     * format date time
     * @param string $datetime a date time string
     * @param string $format date time format
     */
    public function format($datetime, $format) {
        if (empty($datetime))
            return '';

        $dateObj = new DateTime($datetime);
        return $dateObj->format($format);
    }

    public static function formatDate($dates){
        if($dates == ""){
            return $dates;
        }else{
            $date_arr = explode('-',$dates);
            $dates = $date_arr[2].'-'.$date_arr[1].'-'.$date_arr[0];
            return $dates;
        }

    }
}
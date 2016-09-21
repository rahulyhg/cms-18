<?php
class ExportAppointment extends Appointment
{

    public function attributeLabels() {
        $alabels = parent::attributeLabels();
        $aNewLabels = array(
            'DoctorName' => 'Doctor Name',
            // 'Clinic' => 'Clinic',
            'Contact' => 'Contact',
            'name' => 'Patient',
            'VisitReason' => 'Visit Reason',
            'VisitReasonText' => 'Visit Reason Text',
            'turnup' => 'Turn up',
            'Phone' => 'Phone',
            'NewPatient' => 'New Patient',
        );
        $alabels = array_merge($alabels, $aNewLabels);
        return $alabels;
    }

    public function getDoctorName()
    {
        $doctor = Doctor::model()->findByPk($this->event->doctor_id);
        return $doctor->salutation.' '.$doctor->name;
    }

    public function getTime()
    {
        return date("h:ia", strtotime($this->timeslot->end));
    }

    public function getDate() {
        return date("l d F Y", strtotime($this->timeslot->start));
    }

    public function getPhone() {
        return '(+'. AreaCode::model()->findByPk($this->area_code_id)->area_code.') '.HString::correctCalendarText($this->patient_mobile);
    }

    public function getVisitReason()
    {
        if ($this->is_operation) return 'Operation';
        return parent::$visit_reason[$this->visit_reason].($this->visit_reason == 2 ? ": ".$this->visit_reason_text:"");
    }

    public function getVisitReasonText()
    {
        return $this->visit_reason_text;
    }

    public function getClinic()
    {
        return Clinic::model()->findByPk($this->event->clinic_id)->name;
    }

    public function getTurnUp()
    {
       return $this->turn_up == 1 ? 'Yes':'No';
    }
    public function getNewPatient()
    {
       return $this->is_new_patient == 1 ? 'Yes':'No';
    }

    public function searchAppointment ($modelSearch) {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'timeslot'
        );
        $criteria->compare('t.patient_name',$modelSearch->patient_name,true);
        $criteria->compare('t.patientId',$modelSearch->patientId,true);
        $criteria->compare('t.patient_mobile',$modelSearch->patient_mobile,true);
        $criteria->compare('t.patient_email',$modelSearch->patient_email,true);
        $criteria->compare('t.from_api', 0);
        $criteria->compare('t.doctor_id', $modelSearch->doctor_id, true);
        if ($modelSearch->turn_up > 0)
            $criteria->compare('t.turn_up', $modelSearch->turn_up);
        if ($modelSearch->time != '')
            $criteria->addCondition("RIGHT(DATE_FORMAT(timeslot.start,'%r'),2) = '" . $modelSearch->time . "'");

        if ($modelSearch->startDate != "" && $modelSearch->endDate != "") {
            $criteria->addBetweenCondition('timeslot.start', $modelSearch->startDate . ' ' . '00:00:00', $modelSearch->endDate . ' ' . '23:59:59');
        } elseif ($modelSearch->startDate == "" && $modelSearch->endDate != "") {
            $criteria->addBetweenCondition('timeslot.start', '1990-01-01 00:00:00', $modelSearch->endDate . ' ' . '23:59:59');
        } elseif ($modelSearch->startDate != "" && $modelSearch->endDate == "") {
            $criteria->addBetweenCondition('timeslot.start', $modelSearch->startDate . ' ' . '00:00:00', '2200-01-01 00:00:00');
        } else {
            $criteria->addBetweenCondition('timeslot.start', '1990-01-01 00:00:00', '2200-01-01 00:00:00');
        }
        $criteria->order = 'timeslot.start asc';
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'Pagination' => false,
        ));
    }
}
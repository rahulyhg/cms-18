<?php

/**
 * This is the model class for table "{{_patient_drug_alert}}".
 *
 * The followings are the available columns in table '{{_patient_drug_alert}}':
 * @property integer $id
 * @property integer $patient_id
 * @property string $name
 * @property string $comment
 * @property string $entry_date
 * @property string $edit_date
 * @property string $delete_date
 * @property integer $status
 * @property integer $is_deleted
 */
class PatientDrugAlert extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_patient_drug_alert}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, comment', 'required'),
			array('patient_id, status, is_deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('comment, entry_date, edit_date, delete_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, patient_id, name, comment, entry_date, edit_date, delete_date, status, is_deleted', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
	
																						);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translation','ID'),
			'patient_id' => Yii::t('translation','Patient'),
			'name' => Yii::t('translation','Name'),
			'comment' => Yii::t('translation','Comments'),
			'entry_date' => Yii::t('translation','Entry Date'),
			'edit_date' => Yii::t('translation','Edit Date'),
			'delete_date' => Yii::t('translation','Delete Date'),
			'status' => Yii::t('translation','Status'),
			'is_deleted' => Yii::t('translation','Is Deleted'),
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('patient_id',$this->patient_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('entry_date',$this->entry_date,true);
		$criteria->compare('edit_date',$this->edit_date,true);
		$criteria->compare('delete_date',$this->delete_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('is_deleted',$this->is_deleted);
					
		 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize'=> Yii::app()->params['defaultPageSize'],
            ),
		));
	}

	
	public function activate()
    {
        $this->status = 1;
        $this->update();
    }



    public function deactivate()
    {
        $this->status = 0;
        $this->update();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PatientDrugAlert the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return PatientDrugAlert::model()->count() + 1;
	}

    public  function getDrugAlertPatientID($id)
    {
        $model= PatientDrugAlert::model()->findAll('patient_id='.$id.' and is_deleted =0');
        
        if(!empty($model))
        {
            return $model;
        }
        return null;
    }


	public function getListBaseOnPatient($patient_id, $return = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('patient_id',$patient_id);
		$criteria->compare('status', STATUS_ACTIVE);
		// $criteria->compare('is_deleted', STATUS_INACTIVE);
		 
		 if ($return) {
		 	return $this->findAll($criteria);
		 }
		 else{
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
	                'pageSize'=> Yii::app()->params['defaultPageSize'],
	            ),
			));
		}
	}

    public function clear($patient) {
        $criteria=new CDbCriteria;
        $criteria->compare('patient_id',$patient->id);
        $this->deleteAll($criteria);
    }

    public static function addDrug($patient_id, $name, $comment) {
    	$criteria=new CDbCriteria;
		$criteria->compare('patient_id',$patient_id);
		$criteria->compare('name', $name);
		$criteria->compare('comment', $comment);
		$model = PatientDrugAlert::model()->find($criteria);
		if ( isset( $model ) ) {
	        $model->name 		= $name;
	        $model->comment 	= $comment;
	        $model->edit_date	= date('Y-m-d');
	        $model->update();
		}
		else{
	        $model = new PatientDrugAlert();
	        $model->patient_id 	= $patient_id;
	        $model->name 		= $name;
	        $model->comment 	= $comment;
	        $model->status 		= STATUS_ACTIVE;
	        $model->entry_date	= date('Y-m-d');
	        $model->save();
	    }
    }
}

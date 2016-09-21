<?php

/**
 * This is the model class for table "search_enquiry".
 *
 * The followings are the available columns in table 'search_enquiry':
 * @property integer $id
 * @property string $created_data
 * @property integer $patient_id
 * @property string $name
 * @property integer $price
 * @property integer $quantity
 */
class SearchEnquiry extends _BaseModel {

    /**
     * @return string the associated database table name
     */
    public $first_date;
    public $last_date;
    public $check_type;
    public $date_type;

    public function tableName() {
        return 'search_enquiry';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('patient_id', 'required', 'on' => 'search_patient_name'),
            array('name', 'required', 'on' => 'search_drug_name'),
            array('name,first_date,last_date', 'required', 'on' => 'search_drug_name_date'),
            array('patient_id,first_date,last_date', 'required', 'on' => 'search_patient_name_date'),
            array('id, patient_id, price, quantity', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            array('id, created_data, patient_id, name, first_date, last_date, check_type,date_type', 'safe'),
            // @todo Please remove those attributes that should not be searched.
            array('id, created_data, patient_id, name, price, quantity', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translation', 'ID'),
            'created_data' => Yii::t('translation', 'Created Data'),
            'patient_id' => Yii::t('translation', 'Patient'),
            'name' => Yii::t('translation', 'Name'),
            'price' => Yii::t('translation', 'Price'),
            'quantity' => Yii::t('translation', 'Quantity'),
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('created_data', $this->created_data, true);
        $criteria->compare('patient_id', $this->patient_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('quantity', $this->quantity);


        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['defaultPageSize'],
                    ),
                ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SearchEnquiry the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function nextOrderNumber() {
        return SearchEnquiry::model()->count() + 1;
    }

}

<?php

/**
 * This is the model class for table "{{_dispense_item}}".
 *
 * The followings are the available columns in table '{{_dispense_item}}':
 * @property integer $id
 * @property string $item_name
 * @property double $price
 * @property double $discount
 * @property integer $patient_id
 * @property integer $quantity
 */
class DispenseItems extends _BaseModel {

    public $discount_type;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{_dispense_item}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('item_name, price, discount, dispense_id, quantity, service_type', 'required'),
            array('dispense_id, quantity,service_id', 'numerical', 'integerOnly' => true),
            array('price, discount', 'numerical'),
            array('discount', 'numerical', 'min' => 0),
            array('item_name', 'length', 'max' => 255),
            array('price_quantity', 'checkValidDiscount'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('discount_type,id,service_id, item_name,price_quantity, price,price_after_discount,total, discount, dispense_id,patient_id,created_date, quantity,queue_id,service_type', 'safe'),
            array('id, queue_id, item_name, price,price_quantity,price_after_discount,total, discount ,dispense_id, patient_id,created_date,quantity', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'patient' => array(self::BELONGS_TO, 'Patient', 'patient_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translation', 'ID'),
            'comment' => Yii::t('translation', 'Comments'),
            'item_name' => Yii::t('translation', 'Item Name'),
            'price' => Yii::t('translation', 'Price'),
            'discount' => Yii::t('translation', 'Discount'),
            'dispense_id' => Yii::t('translation', 'Dispense'),
            'quantity' => Yii::t('translation', 'Quantity'),
            'type' => Yii::t('translation', 'Type'),
            'patient_id' => Yii::t('translation', 'Patient'),
            'created_date' => Yii::t('translation', 'Created Date'),
            'total' => Yii::t('translation', 'Total'),
            'price_after_discount' => Yii::t('translation', 'Price After Discount'),
            'price_quantity' => Yii::t('translation', 'Price Quantity')
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
        $criteria->compare('item_name', $this->item_name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('dispense_id', $this->dispense_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('patient_id', $this->patient_id);
        $criteria->compare('created_date', $this->created_date);
        $criteria->compare('total', $this->total);
        $criteria->compare('price_after_discount', $this->price_after_discount);
        $criteria->compare('price_quantity', $this->price_quantity);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
        ));
    }

    public function searchEnquiry($list) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('item_name', $this->item_name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('dispense_id', $this->dispense_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('patient_id', $this->patient_id);
        $criteria->compare('created_date', $this->created_date);
        $criteria->compare('total', $this->total);
        $criteria->compare('price_after_discount', $this->price_after_discount);
        $criteria->compare('price_quantity', $this->price_quantity);
        $criteria->addCondition('dispense_id in(' . implode(',', $list) . ')');


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
        ));
    }

    public function searchPatientName($patient) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('item_name', $this->item_name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('dispense_id', $this->dispense_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('created_date', $this->created_date);
        $criteria->compare('total', $this->total);
        $criteria->compare('price_after_discount', $this->price_after_discount);
        $criteria->compare('price_quantity', $this->price_quantity);
        if (is_array($patient)) {
            $criteria->addCondition('patient_id in(' . implode(',', $patient) . ')');
        } else {
            $criteria->compare('patient_id', $patient, true);
        }



        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
        ));
    }

    public function searchDrugName($DrugNam) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('item_name', $DrugNam, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('dispense_id', $this->dispense_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('patient_id', $this->patient_id);
        $criteria->compare('created_date', $this->created_date);
        $criteria->compare('total', $this->total);
        $criteria->compare('price_after_discount', $this->price_after_discount);
        $criteria->compare('price_quantity', $this->price_quantity);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
        ));
    }

    public function searchTypeNameDate($name, $firstName, $lastName) {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('item_name', $this->item_name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('dispense_id', $this->dispense_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('created_date', $this->created_date);
        $criteria->compare('total', $this->total);
        $criteria->compare('price_after_discount', $this->price_after_discount);
        $criteria->compare('price_quantity', $this->price_quantity);
        if (is_array($name)) {
            $criteria->addCondition('patient_id in(' . implode(',', $name) . ')');
        } else {
            $criteria->compare('patient_id', $name, true);
        }

        $criteria->addCondition('created_date  BETWEEN "' . $firstName . '" AND "' . $lastName . '"');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
        ));
    }

    /**
     * Drug date
     */
    public function searchTypeDrugDate($DrugName, $firstName, $lastName) {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('item_name', $DrugName, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('dispense_id', $this->dispense_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('created_date', $this->created_date);
        $criteria->compare('total', $this->total);
        $criteria->compare('price_after_discount', $this->price_after_discount);
        $criteria->compare('price_quantity', $this->price_quantity);
        $criteria->compare('patient_id', $this->patient_id, true);
        $criteria->addCondition('created_date  BETWEEN "' . $firstName . '" AND "' . $lastName . '"');

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
     * @return DispenseItems the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function nextOrderNumber() {
        return DispenseItems::model()->count() + 1;
    }

    public function getAll($dispense_id) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('dispense_id', $dispense_id);
        return DispenseItems::model()->findAll($criteria);
    }

    public function checkValidDiscount($attribute, $params) {
        if ($this->$attribute != '' && $this->discount) {
            if ($this->$attribute - $this->discount < 0) {
                $this->addError($attribute, 'Price must be greater than discount.');
            }
        }
    }
    
    public function getDispenseItemByQueue($queueId, $type = 0)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('queue_id', (int)$queueId); 
        if($type !=0) {
            $criteria->compare('service_type', $type); 
        }
        return DispenseItems::model()->findAll($criteria);
    }

}

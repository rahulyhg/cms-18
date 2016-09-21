<?php

/**
 * This is the model class for table "price_list".
 *
 * The followings are the available columns in table 'price_list':
 * @property integer $id
 * @property string $clinic_price
 * @property string $insurance_price
 * @property string $new_price
 * @property string $ctr_price
 * @property string $name
 * @property integer $created
 * @property integer $updated
 * @property integer $status
 */
class PriceList extends _BaseModel {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{_price_list}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,clinic_price', 'required'),
            //array('name', 'unique'),
            array('created, updated, status', 'numerical', 'integerOnly' => true),
            array('clinic_price, insurance_price, new_price, ctr_price', 'length', 'max' => 100),
            array('clinic_price, insurance_price, new_price, ctr_price', 'numerical', 'min' => 0, 'tooSmall' => 'Price cannot be in negative'),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, clinic_price, insurance_price, new_price, ctr_price, name, created, updated, status', 'safe', 'on' => 'search'),
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
            'clinic_price' => Yii::t('translation', 'Clinic Price'),
            'insurance_price' => Yii::t('translation', 'Insurance Price'),
            'new_price' => Yii::t('translation', 'XYZ Price'),
            'ctr_price' => Yii::t('translation', 'Contract A  Price'),
            'name' => Yii::t('translation', 'Name'),
            'created' => Yii::t('translation', 'Created'),
            'updated' => Yii::t('translation', 'Updated'),
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
    public function search($status = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('clinic_price', $this->clinic_price, true);
        $criteria->compare('insurance_price', $this->insurance_price, true);
        $criteria->compare('new_price', $this->new_price, true);
        $criteria->compare('ctr_price', $this->ctr_price, true);
        $criteria->compare('name', $this->name, true);


        if ($status == 1) {
            $criteria->addCondition(array('status = 1'));
        }

        if ($status == 0) {
            $criteria->addCondition(array('status = 0'));
        }

        if ($status == -1) {
            $criteria->addCondition(array('status = -1'));
        }


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
            'sort' => array(
                'defaultOrder' => 'name ASC',
            )
        ));
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
     * @return PriceList the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function nextOrderNumber() {
        return PriceList::model()->count() + 1;
    }

    public function getAll() {
        $criteria = new CDbCriteria;
        $criteria->compare('status', 1);
        $criteria->order = 'id desc, name';
        $List = PriceList::model()->findAll($criteria);
        return $List;
    }

    protected function beforeSave() {

        if ($this->isNewRecord) {
            $this->created = time();
        }
        $this->updated = time();

        return parent::beforeSave();
    }

}

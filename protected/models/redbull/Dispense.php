<?php

/**
 * This is the model class for table "{{_dispense}}".
 *
 * The followings are the available columns in table '{{_dispense}}':
 * @property integer $id
 * @property integer $patient_id
 * @property string $created_date
 */
class Dispense extends _BaseModel {

    public $discount_type;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{_dispense}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('patient_id, created_date,queue_id', 'required'),
            array('patient_id', 'numerical', 'integerOnly' => true),
            array('subtotal', 'checkValidDiscount'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('discount, queue_id, patient_id,amount_after_discount,add_gst,total_with_gst, total_with_gst, subtotal, created_date,invoice_no,total_receive,amount_due', 'safe', 'on' => 'search'),
            array('discount,discount_type,amount_after_discount,add_gst,total_with_gst, queue_id, patient_id, total_with_gst, subtotal, created_date,invoice_no,total_receive,amount_due', 'safe')
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
            'patient_id' => Yii::t('translation', 'Patient'),
            'created_date' => Yii::t('translation', 'Created Date'),
            'discount' => Yii::t('translation', 'Discount'),
            'total_without_gst' => Yii::t('translation', 'Total Without GST'),
            'total_with_gst' => Yii::t('translation', 'Total With GST'),
            'subtotal' => Yii::t('translation', 'Subtotal'),
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
    public function search($patient_id = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $sql = 'SELECT D.id,D.patient_id, D.invoice_no,D.subtotal,D.discount,D.total_with_gst,D.amount_after_discount,D.add_gst,D.amount_due,D.total_receive,D.created_date
                        FROM ' . Dispense::model()->tableName() . ' as D 
                        INNER JOIN ' . Queue::model()->tableName() . ' as Q ON Q.id = D.queue_id ';
                      //  WHERE  Q.doctor_id = "' . Yii::app()->user->id . '"';
        
        if(!empty($this->invoice_no)) {
            $sql.= 'AND invoice_no like "%'.$this->invoice_no.'%"';
        }
        
        if(!empty($patient_id )) {
            $sql.= 'AND D.patient_id = "'.$patient_id.'"';
        }
        if(!empty($this->subtotal)) {
            $sql.= 'AND subtotal="'.$this->subtotal.'"';
        }
        
        if(!empty($this->amount_after_discount)) {
            $sql.= 'AND amount_after_discount="'.$this->amount_after_discount.'"';
        }
        
        if(!empty($this->amount_due)) {
            $sql.= 'AND amount_due="'.$this->amount_due.'"';
        }
        
        if(!empty($this->total_receive)) {
            $sql.= 'AND total_receive="'.$this->total_receive.'"';
        }
        
        $sql.='GROUP BY D.id';

        $count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar();
        $dataProvider = new CSqlDataProvider($sql, array(
            'totalItemCount' => $count,
            'sort' => array(
                'attributes' => array(
                    'id,invoice_no,subtotal,discount,total_with_gst,amount_after_discount,add_gst,amount_due,total_receive,created_date',
                ),
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
        ));

        return $dataProvider;
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
    public function searchBE() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('patient_id', $this->patient_id);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('subtotal', $this->subtotal);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('subtotal', $this->invoice_no);



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
     * @return Dispense the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function nextOrderNumber() {
        return Dispense::model()->count() + 1;
    }

    public function getAll($patient_id, $return = false) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('patient_id', $patient_id);

        if ($return) {
            return $this->findAll($criteria);
        } else {
            return new CActiveDataProvider('Dispense', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->params['defaultPageSize'],
                ),
            ));
        }
    }
    
    public function checkValidDiscount($attribute, $params)
    {
            if ($this->$attribute != '' && $this->discount)
            {
                if($this->$attribute - $this->discount < 0) {
                   $this->addError($attribute, 'Subtotal must be greater than discount.');
                }

            }
    }

}

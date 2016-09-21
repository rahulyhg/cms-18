<?php

/**
 * This is the model class for table "{{_pay_item}}".
 *
 * The followings are the available columns in table '{{_pay_item}}':
 * @property integer $id
 * @property string $item_name
 * @property double $price
 * @property integer $quantity
 * @property integer $discount
 */
class PayItems extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_pay_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_name, price, pay_id,quantity, discount', 'required'),
			array('quantity, discount', 'numerical', 'integerOnly'=>true),
                        array('discount', 'numerical', 'integerOnly'=>true,'min'=>0,'max'=>100),
			array('price', 'numerical'),
			array('item_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item_name,pay_id, price, quantity,payment_date,patient_id discount', 'safe', 'on'=>'search'),
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
			'rPay' => array(self::BELONGS_TO, 'Pay', 'pay_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translation','ID'),
			'comment' => Yii::t('translation','Comments'),
			'item_name' => Yii::t('translation','Item Name'),
			'price' => Yii::t('translation','Price'),
			'quantity' => Yii::t('translation','Quantity'),
			'discount' => Yii::t('translation','Discount'),
                        'pay_id'=>Yii::t('translation','Payment'),
                        'patient_id' => Yii::t('translation','Patient'),
                        'payment_date'=>Yii::t('translation','Payment Date'),
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
		$criteria->compare('item_name',$this->item_name,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('discount',$this->discount);
                $criteria->compare('pay_id',$this->pay_id);
                $criteria->compare('patient_id',$this->patient_id);
                $criteria->compare('payment_date',$this->payment_date);
					
		 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize'=> Yii::app()->params['defaultPageSize'],
            ),
		));
	}
        
        public function searchPayID($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('item_name',$this->item_name,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('discount',$this->discount);
                $criteria->compare('pay_id',$id);
                $criteria->compare('patient_id',$this->patient_id);
                $criteria->compare('payment_date',$this->payment_date);
					
		 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize'=> Yii::app()->params['defaultPageSize'],
            ),
		));
	}

	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PayItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return PayItems::model()->count() + 1;
	}

	public function getAll($patient_id, $return = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->with = array('rPay');
		$criteria->together = true;

		$criteria->compare('t.patient_id', $patient_id);
					
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

	public function getAllBaseOnArray($shouldPrint)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->addCondition('id in ('.$shouldPrint.')');
		// $criteria->compare('status', STATUS_ACTIVE);
					
	 	return $this->findAll($criteria);
	}
        
        public function getListPayment($patient,$pay)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->addCondition('patient_id',$patient);
                $criteria->compare('pay_id', $pay);
	 	return $this->findAll($criteria);
	}
        
        
}

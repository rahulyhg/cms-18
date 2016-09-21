<?php

/**
 * This is the model class for table "{{_payment_amount}}".
 *
 * The followings are the available columns in table '{{_payment_amount}}':
 * @property integer $id
 * @property string $american_express
 * @property string $cash
 * @property string $cheque
 * @property string $credit_card
 * @property string $nets
 * @property string $amount_pay
 * @property string $change
 * @property string $no_receipt
 */
class PaymentAmount extends _BaseModel {
	
       public $amount ;
       public $total_received;
       public $total;
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_payment_amount}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_receipt,pay_type,amount,total', 'required'),
			array('amount_pay', 'length', 'max'=>16),
			array('no_receipt', 'length', 'max'=>50),
                        array('amount', 'amountPayment', 'compareAttribute'=>'total'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id,payment_id,total,total_received,amount,amount_pay,no_receipt,created,updated,pay_type', 'safe', 'on'=>'search'),
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
			'Payments' => array(self::BELONGS_TO, 'Dispense', 'payment_id'),
			//'Country' => array(self::BELONGS_TO, 'AreaCode', 'release_in_country')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translation','ID'),
			'american_express' => Yii::t('translation','American Express'),
			'cash' => Yii::t('translation','Cash'),
			'cheque' => Yii::t('translation','Cheque'),
			'credit_card' => Yii::t('translation','Credit Card'),
			'nets' => Yii::t('translation','Nets'),
			'amount_pay' => Yii::t('translation','Amount due'),
			'change' => Yii::t('translation','Change'),
			'no_receipt' => Yii::t('translation','No Receipt'),
                        'payment_id' => Yii::t('translation','Payment'),
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
	public function search($payment_id = null)
	{
           
		// @todo Please modify the following code to remove attributes that should not be searched.

		$sql = 'SELECT PA.id,amount_pay,no_receipt,payment_id,pay_type,created
                        FROM '. PaymentAmount::model()->tableName().' as PA 
                        INNER JOIN '. Dispense::model()->tableName().' as D ON D.id = PA.payment_id 
                        INNER JOIN '. Queue::model()->tableName().' as Q ON Q.id = D.queue_id 
                        WHERE  Q.doctor_id = "'.Yii::app()->user->id.'"  AND PA.payment_id = '.$payment_id.'
                       ';
                if(!empty($this->no_receipt)) {
                    $sql .= 'AND no_receipt ="'.$this->no_receipt.'"'; 
                }
                
                
                if(!empty($this->amount_pay)) {
                    $sql .= 'AND amount_pay = "'.$this->amount_pay.'"'; 
                }
                
               
                $count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar();
                $dataProvider=new CSqlDataProvider($sql, array(
                                'totalItemCount'=>$count,
                                'sort'=>array( 
                                        'attributes'=>array(
                                             'id,amount_pay,no_receipt,payment_id,pay_type,created',
                                        ),
                                ),
                                'pagination'=>array(
                                                'pageSize'=>Yii::app()->params['defaultPageSize'],
                                ),
                ));
            
                return $dataProvider;
					
		 
		
	}

	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PaymentAmount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return PaymentAmount::model()->count() + 1;
	}
        
        public function getListPayment($payment_id=NULL){
           
            // @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
                if(!empty($payment_id)) {
                        $criteria->compare('payment_id',$payment_id);
                        return $model = $this->findAll($criteria);
                }
                return null;
                
        }
        
        public function getDropDownlistPayType() {
            return array(
                1 => 'Cash',
                2 => 'Nets',
                3 => 'Visa',
                4 => 'Master Card',
                5 => 'Amex',
            );
        }
        
        public function getType() {
             $data = array(
                1 => 'Cash',
                2 => 'Nets',
                3 => 'Visa',
                4 => 'Master Card',
                5 => 'Amex',
            );
             
             $arr = explode(',', $this->pay_type);
             $r= array();
             foreach ($arr as $item)
                $r[] = $data[$item];
             
             return implode(', ', $r);
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
	public function searchBE()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('no_receipt',$this->no_receipt);
                $criteria->compare('payment_id',$this->payment_id);
		$criteria->compare('amount_pay',$this->amount_pay);
                $criteria->compare('pay_type',$this->pay_type);
                
					
		 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                         'pageSize'=>12,// Yii::app()->params['defaultPageSize'],
            ),
		));
	}
        
        public function AmountPayment($attribute) {
           
            if((int)$this->$attribute == 0) {
                  $this->addError($attribute, "Amount must be numeric and greater than 0");
                  return false;
            }
            if($this->$attribute > $this->total) {
                $this->addError($attribute, "Amount must be numeric and less than or equal total payment.");
                return false;
            }
            
            return true;
            
           
           
        }
        
        
}

<?php

/**
 * This is the model class for table "{{_districts}}".
 *
 * The followings are the available columns in table '{{_districts}}':
 * @property integer $id
 * @property string $district_name
 * @property integer $display_order
 * @property string $created_date
 */
class District extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_districts}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('display_order', 'numerical', 'integerOnly'=>true),
			array('district_name', 'length', 'max'=>255),
			array('created_date', 'safe'),
		 array('district_name', 'required', 'on' => 'create, update'), 
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, district_name, display_order, created_date', 'safe', 'on'=>'search'),
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
			'district_name' => Yii::t('translation','District Name'),
			'display_order' => Yii::t('translation','Display Order'),
			'created_date' => Yii::t('translation','Created Date'),
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
		$criteria->compare('district_name',$this->district_name,true);
		$criteria->compare('display_order',$this->display_order);
		$criteria->compare('created_date',$this->created_date,true);
				$sort = new CSort();

        $sort->attributes = array(
            'name' => array(
                'asc' => 't.district_name',
                'desc' => 't.district_name desc',
                'default' => 'asc',
            ),
        );
		$sort->defaultOrder = 't.district_name asc';
					
		 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize'=> Yii::app()->params['defaultPageSize'],
            ),
		));
	}

	
	public function behaviors() {
        return array('sluggable' => array(
                'class' => 'application.extensions.mintao-yii-behavior-sluggable.SluggableBehavior',
                'columns' => array('district_name'),
                'unique' => true,
                'update' => true,
            ),);
    }
    protected function beforeSave() {
            if ($this->isNewRecord)
                $this->created_date = date('Y-m-d H:i:s');
           
        return true;
    }

	
	public function getDetailBySlug($slug)
	{
		$criteria = new CDbCriteria;
        $criteria->compare('t.slug', $slug);
        return District::model()->find($criteria);
	}
	
         public static function getDropDownDistrict() {
        $model = District::model()->findAll();
        $list = CHtml::listData($model, 'id', 'district_name');
        return $list;
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return District the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return District::model()->count() + 1;
	}
}

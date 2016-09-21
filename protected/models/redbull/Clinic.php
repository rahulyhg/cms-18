<?php

/**
 * This is the model class for table "{{clinic}}".
 *
 * The followings are the available columns in table '{{clinic}}':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $active
 * @property string $salt
 */
class Clinic extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_clinic}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('active', 'numerical', 'integerOnly'=>true),
			array('code, name, salt', 'length', 'max'=>45),
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
			'code' => Yii::t('model','Code'),
			'name' => Yii::t('model','Name'),
			'active' => Yii::t('model','Active'),
			'salt' => Yii::t('model','Security Salt'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function dropdownClinic() {
		$array = array();
		$array[0] = 'Not working';
		foreach(self::model()->findAll() as $clinic){
                $array[$clinic->id] = $clinic->name;
        }
        return $array;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Clinic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "{{country_code}}".
 *
 * The followings are the available columns in table '{{country_code}}':
 * @property integer $id
 * @property string $iso
 * @property string $name
 * @property string $nicename
 * @property string $iso3
 * @property integer $numcode
 * @property integer $phonecode
 */
class CountryCode extends CActiveRecord
{
    public $title;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{country_code}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iso, name, nicename, phonecode', 'required'),
			array('numcode, phonecode', 'numerical', 'integerOnly'=>true),
			array('iso', 'length', 'max'=>2),
			array('name, nicename', 'length', 'max'=>80),
			array('iso3', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, iso, name, nicename, iso3, numcode, phonecode', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'iso' => 'Iso',
			'name' => 'Name',
			'nicename' => 'Nicename',
			'iso3' => 'Iso3',
			'numcode' => 'Numcode',
			'phonecode' => 'Phonecode',
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
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('nicename',$this->nicename,true);
		$criteria->compare('iso3',$this->iso3,true);
		$criteria->compare('numcode',$this->numcode);
		$criteria->compare('phonecode',$this->phonecode);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getList() {
        $criteria=new CDbCriteria;
        $criteria->select=array(new CDbExpression('concat(nicename," (+",phonecode,")") AS `title`'),'phonecode');
        return $this->findAll($criteria);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CountryCode the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

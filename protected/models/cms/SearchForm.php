<?php

/**
 * This is the model class for table "{{_seos}}".
 *
 * The followings are the available columns in table '{{_seos}}':
 * @property integer $id
 * @property string $title_tag
 * @property string $url
 * @property string $meta_keyword
 * @property string $meta_desc
 */
class SearchForm extends _BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_search}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, slug, description', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'slug' => 'Slug',
			'description' => 'Description',
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

		$criteria->compare('title',$this->title,true,'OR','LIKE');
		$criteria->compare('description',$this->description,true,'OR','LIKE');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Seos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function fsearch()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria();
        $criteria->addCondition("t.title LIKE '%".$this->title."t%' OR t.description LIKE '%".$this->description."d%'");
//        $criteria->params[':t'] = $this->title;
//        $criteria->params[':d'] = $this->description;
        return new CActiveDataProvider(SearchForm, array(
            'criteria'=>$criteria,
        ));
    }
}

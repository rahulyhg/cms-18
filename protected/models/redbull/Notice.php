<?php

/**
 * This is the model class for table "{{notice}}".
 *
 * The followings are the available columns in table '{{notice}}':
 * @property integer $id
 * @property integer $created
 * @property string $title
 * @property string $content
 * @property integer $completed
 */
class Notice extends CActiveRecord
{
	public $startDate;
	public $endDate;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_notice}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created, completed', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			// array('start, end', 'date', 'allowEmpty' => false, 'format' => 'yyyy-MM-dd H:m', 'message' => Yii::t('validation', 'Invalid date time value')),
            array('title','required'),
			//array('content', 'length', 'max'=>200),
			array('title, content', 'safe'),
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
			'created' => Yii::t('model', 'Created'),
			'title' => Yii::t('model', 'Title'),
			'content' => Yii::t('model', 'Content'),
			'completed' => Yii::t('model', 'Completed'),
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
	public function listData()
	{
		$criteria=new CDbCriteria;
        $criteria->order='completed, created desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function countNew() {
        $criteria=new CDbCriteria;
        $criteria->compare('completed',0);

        return $this->count($criteria);
    }

    public function deleteCompleted() {
        $criteria=new CDbCriteria;
        $criteria->compare('completed',1);
        $this->deleteAll($criteria);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getNoticeTimeslot($date) {
		$criteria=new CDbCriteria;
        $criteria->addCondition('from_office = :fromOffice');
        $criteria->addCondition('(:date >= date(start) and :date <= date(end))');
        $criteria->params = array(
            ':date'=> date('Y-m-d', strtotime($date)),
            ':fromOffice' => 1,
        );
        return self::model()->findAll($criteria);
	}
}

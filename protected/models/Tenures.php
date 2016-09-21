<?php

/**
 * This is the model class for table "{{_tenures}}".
 *
 * The followings are the available columns in table '{{_tenures}}':
 * @property integer $id
 * @property string $name
 * @property integer $display_order
 */
class Tenures extends _BaseModel {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{_tenures}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('display_order', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('name', 'required', 'on' => 'create, update'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, display_order', 'safe', 'on' => 'search'),
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
            'name' => Yii::t('translation', 'Name'),
            'display_order' => Yii::t('translation', 'Display Order'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('display_order', $this->display_order);
        $sort = new CSort();

        $sort->attributes = array(
            'name' => array(
                'asc' => 't.display_order',
                'desc' => 't.display_order desc',
                'default' => 'asc',
            ),
        );
        $sort->defaultOrder = 't.display_order asc';


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
        ));
    }

//	public function behaviors() {
//        return array('sluggable' => array(
//                'class' => 'application.extensions.mintao-yii-behavior-sluggable.SluggableBehavior',
//                'columns' => array('name'),
//                'unique' => true,
//                'update' => true,
//            ),);
//    }

    public function getDetailBySlug($slug) {
        $criteria = new CDbCriteria;
        $criteria->compare('t.slug', $slug);
        return Tenures::model()->find($criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Tenures the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function nextOrderNumber() {
        return Tenures::model()->count() + 1;
    }

    public static function getDropDownTenures() {
        $criteria = new CDbCriteria;
        $criteria->order = "display_order asc";
        $model = Tenures::model()->findAll($criteria);
        $list = CHtml::listData($model, 'id', 'name');
        return $list;
    }

}

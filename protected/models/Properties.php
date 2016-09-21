<?php

/**
 * This is the model class for table "{{_Properties}}".
 *
 * The followings are the available columns in table '{{_Properties}}':
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $brief_description
 * @property integer $type_id
 * @property string $address
 * @property integer $district_id
 * @property integer $status
 * @property string $over_view
 * @property string $location
 * @property string $est_top
 * @property string $created_date
 * @property integer $posted_by
 * @property string $modified_date
 */
class Properties extends _BaseModel {

    /**
     * @return string the associated database table name
     */
    public $maxImageFileSize = 3145728; //3MB
    public $allowImageType = 'jpg,gif,png';
    public $uploadImageFolder = 'upload/Properties'; //remember remove ending slash
    public $defineImageSize = array(
        'featured_image' => array(array('alias' => 'thumb1', 'size' => '233x105'),
        ),
    );

    public function tableName() {
        return '{{_properties}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, brief_description, type_id, address, district_id, over_view,', 'required'),
            array('type_id, district_id, status, posted_by', 'numerical', 'integerOnly' => true),
            array('title, slug, address', 'length', 'max' => 300),
            array('location,featured_image, est_top', 'length', 'max' => 255),
            array('title,brief_description,type_id,address,district_id,status,over_view', 'required', 'on' => 'create, update'),
            array('featured_image', 'file', 'on' => 'create,update',
                'allowEmpty' => true,
                'types' => $this->allowImageType,
                'wrongType' => 'Only jpg,gif,png are allowed.',
                'maxSize' => $this->maxImageFileSize, // 3MB
                'tooLarge' => 'The file was larger than' . ($this->maxImageFileSize / 1024) / 1024 . 'MB. Please upload a smaller file.',
            ),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,featured_image,is_featured,contact_enquiry, title, slug, brief_description, type_id, address, district_id, status, over_view, location, est_top, created_date, posted_by, modified_date', 'safe'),
            array('id,featured_image,is_featured, title, slug, brief_description, type_id, address, district_id, status, over_view, location, est_top, created_date, posted_by, modified_date', 'safe', 'on' => 'search'),
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
                        'users' => array(self::BELONGS_TO, 'Users','posted_by'),	
			'district' => array(self::BELONGS_TO, 'District', 'district_id', 'order' => 'district.display_order ASC,  district.district_name ASC'),	
			'propertytype' => array(self::BELONGS_TO, 'Propertytype', 'type_id', 'order' => 'propertytype.display_order ASC,  propertytype.property_type ASC'),	
		);
	}

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translation', 'ID'),
            'title' => Yii::t('translation', 'Title'),
            'slug' => Yii::t('translation', 'Slug'),
            'brief_description' => Yii::t('translation', 'Brief Description'),
            'type_id' => Yii::t('translation', 'Type'),
            'address' => Yii::t('translation', 'Address'),
            'district_id' => Yii::t('translation', 'District'),
            'status' => Yii::t('translation', 'Status'),
            'over_view' => Yii::t('translation', 'Over View'),
            'location' => Yii::t('translation', 'Location'),
            'est_top' => Yii::t('translation', 'Est Top'),
            'created_date' => Yii::t('translation', 'Created Date'),
            'posted_by' => Yii::t('translation', 'Posted By'),
            'modified_date' => Yii::t('translation', 'Modified Date'),
            'featured_image' => Yii::t('translation', 'Featured Image'),
            'is_featured' => Yii::t('translation', 'Is Featured'),
             'is_featured' => Yii::t('translation', 'Is Featured'),
             'contact_enquiry' => Yii::t('translation', 'Contact Enquiry'),
           
            
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('brief_description', $this->brief_description, true);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('district_id', $this->district_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('over_view', $this->over_view, true);
        $criteria->compare('location', $this->location, true);
        $criteria->compare('est_top', $this->est_top, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('posted_by', $this->posted_by);
        $criteria->compare('modified_date', $this->modified_date, true);
        $criteria->compare('featured_image', $this->featured_image, true);
        $criteria->compare('is_featured', $this->is_featured, true);
        $criteria->compare('contact_enquiry', $this->contact_enquiry, true);
        $sort = new CSort();

        $sort->attributes = array(
            'name' => array(
                'asc' => 't.title',
                'desc' => 't.title desc',
                'default' => 'asc',
            ),
        );
        $sort->defaultOrder = 't.title asc';


        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['defaultPageSize'],
                    ),
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

    public function behaviors(){
        
        return array('sluggable' => array(
                'class' => 'application.extensions.mintao-yii-behavior-sluggable.SluggableBehavior',
                'columns' => array('title'),
                'unique' => true,
                'update' => true,
            ),);
    }
    

    public function getDetailBySlug($slug) {
        $criteria = new CDbCriteria;
        $criteria->compare('t.slug', $slug);
        return Properties::model()->find($criteria);
    }

    public function findActivePropertyShowcase() {
        $criteria = new CDbCriteria;
        $criteria->compare('t.status', STATUS_ACTIVE);
        return new CActiveDataProvider('Properties', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 6,
                    ),
                ));
    }

    protected function beforeSave() {
        if ($this->isNewRecord)
            $this->created_date = date('Y-m-d H:i:s');
        else
            $this->modified_date = date('Y-m-d H:i:s');
        $this->posted_by = Yii::app()->user->id;

      return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Properties the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function nextOrderNumber() {
        return Properties::model()->count() + 1;
    }

	public function findFeaturedPropertyShowcase()
	{
		$criteria = new CDbCriteria;
        $criteria->compare('t.status', STATUS_ACTIVE);
        $criteria->compare('t.is_featured', STATUS_ACTIVE);
        return Properties::model()->findAll($criteria);
	}
}

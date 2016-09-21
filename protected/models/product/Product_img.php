<?php


class Product_img extends _BaseModel
{

	public $maxImageFileSize = 3145728; //3MB
	public $allowImageType = 'jpg,gif,png';
	public $uploadImageFolder = 'upload/products/moreimg'; //remember remove ending slash
	public $defineImageSize = array(
            'product_image' => array(array('alias' => 'thumb1', 'size' => '107x90'),
									array('alias' => 'thumb2', 'size' => '353x330')
				),
					
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_products_img}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, posted_by', 'numerical', 'integerOnly' => true),
			array('product_image', 'length', 'max' => 300),
			array('product_id, product_image', 'required', 'on' => 'create, update'),
			array('product_image', 'file', 'on' => 'create,update',
				'allowEmpty' => true,
				'types' => $this->allowImageType,
				'wrongType' => 'Only jpg,gif,png are allowed.',
				'maxSize' => $this->maxImageFileSize, // 3MB
				'tooLarge' => 'The file was larger than' . ($this->maxImageFileSize / 1024) / 1024 . 'MB. Please upload a smaller file.',
			),
//			array(
//				'product_image', 'match',
//				'pattern' => '/^[^\/?*:&;{}\\]+\.[^\/?*:;{}\\]{3}$/',
//				'message' => 'Image files name cannot be included special characters: &%$#',
//			),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id,  product_image, created_date, posted_by', 'safe', 'on' => 'search'),
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
			'Product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translation', 'ID'),
			'product_id' => Yii::t('translation', 'Product'),
			'product_image' => Yii::t('translation', 'Product Image'),
			'created_date' => Yii::t('translation', 'Created Date'),
			'posted_by' => Yii::t('translation', 'Posted By'),
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

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('product_id', $this->product_id);
		$criteria->compare('product_image', $this->product_image, true);
		$criteria->compare('created_date', $this->created_date, true);
		$criteria->compare('posted_by', $this->posted_by);
              
		$sort = new CSort();

		$sort->attributes = array(
			'name' => array(
				'asc' => 't.created_date',
				'desc' => 't.created_date desc',
				'default' => 'asc',
			),
		);
		$sort->defaultOrder = 't.created_date asc';


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => Yii::app()->params['defaultPageSize'],
			),
		));
	}

	public function activate()
	{
		$this->status = 1;
		$this->update();
	}

	public function deactivate()
	{
		$this->status = 0;
		$this->update();
	}

//	public function behaviors()
//	{
//		return array('sluggable' => array(
//				'class' => 'application.extensions.mintao-yii-behavior-sluggable.SluggableBehavior',
//				'columns' => array('title'),
//				'unique' => true,
//				'update' => true,
//			),);
//	}

//	public function getDetailBySlug($slug)
//	{
//		$criteria = new CDbCriteria;
//		$criteria->compare('t.slug', $slug);
//		return Product::model()->find($criteria);
//	}
	
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord)
				$this->created_date = date('Y-m-d H:i:s');
			else
				$this->modified_date = date('Y-m-d H:i:s');
			$this->posted_by = Yii::app()->user->id;
		}
		return true;

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function nextOrderNumber()
	{
		return Product::model()->count() + 1;
	}
    public function findImg(){
        $criteria=new CDbCriteria;
        $criteria->compare('t.product_id', $this->product_id);

        $sort = new CSort();
        $attSort = array(
            'created_date' => 'created_date'
        );

        $sort->attributes = $attSort;
        $sort->defaultOrder = 'created_date asc';

        return new CActiveDataProvider('Product_img', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=> 12,
            ),
            'sort' => $sort,
        ));

    }
    public static function getModelByProductID($product_id){
        $c = new CDbCriteria();
        $c->compare('t.product_id', $product_id);

        $model = Product::model()->findAll($c);

        if($model)
            return $model[0];
        return '';
    }
}

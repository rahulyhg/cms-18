<?php

/**
 * This is the model class for table "{{_inventory}}".
 *
 * The followings are the available columns in table '{{_inventory}}':
 * @property integer $id
 * @property string $brand_name
 * @property string $per_unit_dosage
 * @property string $generic_name
 * @property integer $packing
 * @property string $sold_by
 * @property string $price_to_patient_gst
 * @property string $price_bought_gst_amount
 * @property string $bonus
 * @property integer $expiry_Date
 * @property integer $stock_amount_bought
 * @property integer $stock_amount_used
 * @property integer $stock_amount_remainder
 * @property integer $warning
 * @property string $comments
 * @property integer $status
 * @property integer $created
 */
class Inventory extends _BaseModel {

    public $patient_name;
    public $drug_name;
    public $old_stock;
    public $type = 1;
    public $from_date;
    public $to_date;
    public $date_type = 1;
    public $file;
    public $file_description;
    public $file_id;
    public $maxUploadFileSize = 3145728;
    public $allowUploadType = 'doc,docx,xls,xlsx,pdf';
    public $uploadFileFolder = 'upload/files/inventory'; //remember remove ending slash;

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return '{{_inventory}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('price_to_patient_gst, price_bought_amount_gst,price_to_patient, price_bought_amount,stock_amount_bought, stock_amount_used, stock_amount_remainder, packing', 'numerical', 'integerOnly' => false),
            array('expiry_date, warning, status, created', 'numerical', 'integerOnly' => true),
            array('brand_name, per_unit_dosage, generic_name, sold_by', 'length', 'max' => 255),
            array('price_to_patient, price_bought_amount', 'length', 'max' => 19),
            array('status', 'required', 'on' => 'delete'),
            array('expiry_date', 'checkValidExpiredDate', 'on' => 'update, create'),
            array('bought_date', 'checkValidBoughtDate', 'on' => 'create'),
            array('price_to_patient_gst, price_bought_amount_gst,price_to_patient, price_bought_amount,stock_amount_bought, stock_amount_used, stock_amount_remainder, packing', 'numerical', 'min' => 0, 'tooSmall' => 'The value cannot be in negative'),
            array('bonus, comments', 'safe'),
            //array('brand_name', 'unique'),
            array('phone', 'checkPhone', 'on' => 'create,update'),
            array('brand_name,per_unit_dosage,price_to_patient,packing,price_bought_amount', 'required', 'on' => 'create,update'),
            array('patient_name,bought_date,phone,contact,price_after_bonus, drug_name,brand_name, from_date,file_id,file_description, to_date,packing_total, insurance_price', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, to_date, from_date, brand_name, per_unit_dosage, generic_name, packing, sold_by, price_to_patient_gst, price_bought_amount, bonus, expiry_date, stock_amount_bought, stock_amount_used, stock_amount_remainder, warning, comments, status, created', 'safe', 'on' => 'search'),
        );
    }

    public function checkValidStock($attribute, $params) {
        if ($this->$attribute != '' && $this->old_stock) {
            if ($this->$attribute - $this->old_stock < 0) {
                $this->addError($attribute, 'New stock must be greater than current stock.');
            }
        }
    }

    public function checkValidExpiredDate($attribute, $params) {
        if (!empty($this->$attribute)) {

            if ($this->$attribute < strtotime(date('Y/m/d'))) {
                $this->addError($attribute, 'Expired date must be greater than current date.');
            }
        }
    }
    
    public function checkValidBoughtDate($attribute, $params) {
        if (!empty($this->$attribute)) {

            if ($this->$attribute < strtotime(date('Y/m/d'))) {
                $this->addError($attribute, 'Bought date must be greater than current date.');
            }
        }
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
            'brand_name' => Yii::t('translation', 'Brand Name'),
            'per_unit_dosage' => Yii::t('translation', 'Per Unit Dosage'),
            'generic_name' => Yii::t('translation', 'Generic Name'),
            'packing' => Yii::t('translation', 'Packing'),
            'sold_by' => Yii::t('translation', 'Sold By'),
            'price_to_patient' => Yii::t('translation', 'Price To Patient'),
            'price_bought_amount' => Yii::t('translation', 'Price Bought Amount'),
            'price_to_patient_gst' => Yii::t('translation', 'GST'),
            'price_bought_amount_gst' => Yii::t('translation', 'GST'),
            'bonus' => Yii::t('translation', 'Bonus'),
            'expiry_date' => Yii::t('translation', 'Expiry Date'),
            'stock_amount_bought' => Yii::t('translation', 'Stock Amount Bought'),
            'stock_amount_used' => Yii::t('translation', 'Stock Amount Used'),
            'stock_amount_remainder' => Yii::t('translation', 'Stock Amount Remainder'),
            'warning' => Yii::t('translation', 'Warning'),
            'comments' => Yii::t('translation', 'Comments'),
            'status' => Yii::t('translation', 'Status'),
            'created' => Yii::t('translation', 'Created'),
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
    public function search($status = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);

        if (isset($this->drug_name) && !empty($this->drug_name)) {

            $criteria->compare('brand_name', $this->drug_name, true);
        }
        $criteria->compare('per_unit_dosage', $this->per_unit_dosage, true);
        $criteria->compare('generic_name', $this->generic_name, true);
        $criteria->compare('packing', $this->packing);
        $criteria->compare('sold_by', $this->sold_by, true);
        $criteria->compare('price_to_patient', $this->price_to_patient, true);
        $criteria->compare('price_bought_amount', $this->price_bought_amount, true);
        $criteria->compare('bonus', $this->bonus, true);
        $criteria->compare('expiry_date', $this->expiry_date);
        $criteria->compare('stock_amount_bought', $this->stock_amount_bought);
        $criteria->compare('stock_amount_used', $this->stock_amount_used);
        $criteria->compare('stock_amount_remainder', $this->stock_amount_remainder);
        $criteria->compare('warning', $this->warning);
        $criteria->compare('comments', $this->comments, true);
        if (!empty($this->from_date) && empty($this->to_date)) {
            $criteria->addCondition(array('created >= ' . strtotime($this->from_date)));
        }

        if (!empty($this->to_date) && empty($this->from_date)) {
            $criteria->addCondition(array('created <= ' . strtotime($this->to_date)));
        }

        if (!empty($this->to_date) && !empty($this->from_date)) {
            $criteria->addCondition(array('created <' . strtotime($this->to_date) + 8639));
            $criteria->addCondition(array('created >= ' . strtotime($this->from_date)));
        }
        if ($status != null && $status == 1) {
            $criteria->addCondition(array('status = 1'));
        }

        if ($status != null && $status == 0) {
            $criteria->addCondition(array('status = 0'));
        }

        if ($status != null && $status == -1) {

            $criteria->addCondition(array('status = -1'));
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
        ));
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
    public function searchByPatient() {

        $sql = 'SELECT P.name,I.id, I.brand_name,I.per_unit_dosage,I.generic_name,I.sold_by,I.price_to_patient,I.created, I.warning
                         FROM ' . Inventory::model()->tableName() . ' as I 
                         LEFT JOIN ' . DispenseItems::model()->tableName() . ' as DI ON I.id = DI.service_id 
                         LEFT JOIN ' . Patient::model()->tableName() . ' as P ON P.id = DI.patient_id 
                         WHERE  P.name like "%' . $this->patient_name . '%"';
        if ($this->date_type == 1)
        {
            if ($this->from_date != '' && $this->to_date == '') {

                $sql .= 'AND ( DI.created_date >= "' . date('Y-m-d', strtotime($this->from_date)) . '")';
            }
            elseif ($this->from_date == '' && $this->to_date != '') {

                $sql .= 'AND ( DI.created_date <= "' . date('Y-m-d', strtotime($this->to_date)) . '")';
            }
            elseif ($this->from_date != '' && $this->to_date != '') {

                $sql .= 'AND ( DI.created_date between "' . date('Y-m-d', strtotime($this->from_date)) . '" AND "' . date('Y-m-d', strtotime($this->to_date)) . '")';
            }
                
        }
        $sql .= ' GROUP BY I.id';



        $count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar();
        $dataProvider = new CSqlDataProvider($sql, array(
            'totalItemCount' => $count,
            'sort' => array(
                'attributes' => array(
                    'id,brand_name,per_unit_dosage,generic_name,sold_by,price_to_patient,created, warning,status',
                ),
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));


        return $dataProvider;
    }

    public function activate() {
        $this->status = 1;
        $this->update();
    }

    public function deactivate() {
        $this->status = 0;
        $this->update();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Inventory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function nextOrderNumber() {
        return Inventory::model()->count() + 1;
    }

    public function saveFile($fieldName, $description = array()) {
        $this->$fieldName = CUploadedFile::getInstances($this, $fieldName);
        if (!empty($this->$fieldName)) {

            foreach ($this->$fieldName as $key => $item) {

                $name = time() . '_' . $this->id . '_' . rand() . '.' . $item->extensionName;
                $item->saveAs($this->uploadFileFolder . '/' . $name);
                $File = new InventoryFile();
                $File->file = $name;
                $File->name = $item->name;
                $File->inventory_id = $this->id;
                $File->description = $description[$key];
                $File->save();
            }

            return $this;
        }
    }

    public function deleteFiles($fieldName, $oldFile) {
        if (!empty($oldFile))
            ImageHelper::deleteFile($this->uploadFileFolder . '/' . $this->id . '/' . $oldFile);
    }

    public function getWarning() {
        $criteria = new CDbCriteria;
        $criteria->compare('status', 1);
        $criteria->compare('warning', 1);
        $model = Inventory::model()->findAll($criteria);

        return $model;
    }
    
     public function getStockLow() {
        $criteria = new CDbCriteria;
        $criteria->compare('status', 1);
        $criteria->compare('warning', 0);
        $minimum_stock = Yii::app()->setting->getItem('minimum_stock');
        $criteria->addCondition('stock_amount_remainder <='.$minimum_stock.'');
        $model = Inventory::model()->findAll($criteria);

        return $model;
    }

    protected function beforeSave() {

        if ($this->isNewRecord) {
            $this->packing_total = $this->packing;
            //$this->stock_amount_bought = $this->packing_total * $this->price_bought_amount;
        } else {
            $dataD = DispenseItems::model()->findAll('service_type =2 and service_id =' . $this->id . '');
            $quantity = 0;
            foreach ($dataD as $item) {
                $quantity+= $item->quantity;
            }
            //$this->stock_amount_bought = $this->packing_total * $this->price_bought_amount;
            //$this->stock_amount_used = $quantity * $this->price_to_patient;
            //$this->stock_amount_remainder = $this->stock_amount_bought - $this->stock_amount_used;
        }


//        $minimum_stock = Yii::app()->setting->getItem('minimum_stock');
//        if ($this->stock_amount_remainder <= (int) $minimum_stock && $this->warning == 0) {
//            $this->warning = 1;
//        }

        return parent::beforeSave();
    }

    public function checkPhone($attribute, $params) {
        if ($this->$attribute != '') {
            $pattern = '/^[\(]?(\+)?(\d{0,3})[\)]?[\s]?[\-]?(\d{0,9})[\s]?[\-]?(\d{0,9})[\s]?[x]?(\d*)$/';
            $containsDigit = preg_match($pattern, $this->$attribute);
            $lb = $this->getAttributeLabel($attribute);
            if (!$containsDigit)
                $this->addError($attribute, "$lb must be numerical and  allow input (),+,-");
        }
    }

}

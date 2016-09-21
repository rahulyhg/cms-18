<?php

class _BaseModel extends CActiveRecord {

    public $optionYesNo = array('1' => 'Yes', '0' => 'No');
    public $optionActive = array('1' => 'Active', '0' => 'Inactive');
    public $optionPublish = array('1' => 'Publish', '0' => 'Un-Publish');
    public $optionGender = array('1' => 'Male', '0' => 'Female');
    //for image upload 
    public $maxImageFileSize = 3145728; //3MB
    public $uploadImageFolder = 'upload/cms'; //remember remove ending slash
    public $defineImageSize = array();
    public $allowImageType = 'jpg, png, gif';
    //for file upload
    public $maxUploadFileSize = 3145728;
    public $uploadFileFolder = 'upload/files'; //remember remove ending slash\n";
    public $uploadFileFields = array();
    public $allowUploadType = 'doc,docx,xls,xlsx,pdf';
    public $fileType = 'jpg|jpeg|jpe, png, doc,docx,xls,xlsx,pdf';

    public function saveImage($fieldName) {
        $this->$fieldName = CUploadedFile::getInstance($this, $fieldName);
        $oldImge = $this->oldInformation();

        if (is_null($this->$fieldName) || !is_object($this->$fieldName)) {
            if (!empty($oldImge->$fieldName)) {
                $this->$fieldName = $oldImge->$fieldName;
                $this->update(array($fieldName));
            }
            return false;
        }

        if (!empty($this->$fieldName))
            $this->deleteImages($fieldName, $oldImge->$fieldName);

        $ext = strtolower($this->$fieldName->getExtensionName());
        $fileName = time() . '_' . $this->id . '_' . $this->$fieldName->getName();
        $imageHelper = new ImageHelper();
        $imageHelper->createDirectoryByPath($this->uploadImageFolder . "/" . $this->id);
        $this->$fieldName->saveAs($this->uploadImageFolder . '/' . $this->id . '/' . $fileName);
        $this->$fieldName = $fileName;
        $this->update(array($fieldName));

        if (array_key_exists($fieldName, $this->defineImageSize) && is_array($this->defineImageSize[$fieldName])) {
            $this->resizeImage($fieldName, $this->uploadImageFolder . '/' . $this->id . '/');
        }
    }

    /*
     * For upload file 
     */

    public function saveFile($fieldName) {
        $this->$fieldName = CUploadedFile::getInstance($this, $fieldName);
        $oldFile = $this->oldInformation();

        if (is_null($this->$fieldName) || !is_object($this->$fieldName)) {
            if (!empty($oldFile->$fieldName)) {
                $this->$fieldName = $oldFile->$fieldName;
                $this->update(array($fieldName));
            }
            return false;
        }
        if (!empty($this->$fieldName))
            $this->deleteFiles($fieldName, $oldFile->$fieldName);

        if (is_object($this->$fieldName)) {
            $imageHelper = new ImageHelper();
            $imageHelper->createDirectoryByPath($this->uploadFileFolder . "/" . $this->id);
            $this->$fieldName->saveAs($this->uploadFileFolder . '/' . $this->id . '/' . $this->$fieldName->getName());
            $this->$fieldName = $this->$fieldName->getName();
            $this->update(array($fieldName));
        }
    }

    //bb
    public function resizeImage($fieldName) {
        $sizeRefactory = array();
        foreach ($this->defineImageSize[$fieldName] as $item) {
            $sizeExplode = explode('x', $item['size']);
            $sizeRefactory[$item['alias']] = array('width' => $sizeExplode[0], 'height' => $sizeExplode[1]);
        }
        $ImageHelper = new ImageHelper();
        $ImageHelper->folder = $this->uploadImageFolder . '/' . $this->id;
        $ImageHelper->file = $this->$fieldName;
        $ImageHelper->thumbs = $sizeRefactory;
        $ImageHelper->createThumbs();
    }

    public function deleteFiles($fieldName, $oldFile) {
        if (!empty($oldFile))
            ImageHelper::deleteFile($this->uploadFileFolder . '/' . $this->id . '/' . $oldFile);
    }

    //bb
    public function deleteImages($fieldName, $oldImage) {
        if (!empty($oldImage)) {
            ImageHelper::deleteFile($this->uploadImageFolder . '/' . $this->id . '/' . $oldImage);
            if (array_key_exists($fieldName, $this->defineImageSize) && is_array($this->defineImageSize[$fieldName])) {
                $imageSize = $this->defineImageSize[$fieldName];
                foreach ($imageSize as $item) {
                    ImageHelper::deleteFile($this->uploadImageFolder . '/' . $this->id . '/' . $item['alias'] . '/' . $oldImage);
                }
            }
        }
    }

    public function removeImage($fieldName = array(), $deleteFolder = false) {
        $updateField = array();
        if (!empty($fieldName) && is_array($fieldName)) {
            foreach ($fieldName as $fieldItem) {
                ImageHelper::deleteFile($this->uploadImageFolder . '/' . $this->id . '/' . $this->$fieldItem);
                if (array_key_exists($fieldItem, $this->defineImageSize) && is_array($this->defineImageSize[$fieldItem])) {
                    $imageSize = $this->defineImageSize[$fieldItem];
                    foreach ($imageSize as $item) {
                        ImageHelper::deleteFile($this->uploadImageFolder . '/' . $this->id . '/' . $item['alias'] . '/' . $this->$fieldItem);
                        $imgDir = $this->uploadImageFolder . '/' . $this->id . '/' . $item['alias'];
                        if ($deleteFolder == true && file_exists($imgDir) && $this->is_dir_empty($imgDir))
                            rmdir($this->uploadImageFolder . '/' . $this->id . '/' . $item['alias']);
                    }
                    $this->$fieldItem = '';
                    $updateField[] = $fieldItem;
                }
            }
            if ($deleteFolder == true && file_exists($this->uploadImageFolder . '/' . $this->id))
                rmdir($this->uploadImageFolder . '/' . $this->id);
            $this->update($updateField);
        }
    }

    public function removeFile($fieldName = array(), $deleteFolder = false) {
        $updateField = array();
        if (!empty($fieldName) && is_array($fieldName)) {
            foreach ($fieldName as $fieldItem) {
                ImageHelper::deleteFile($this->uploadFileFolder . '/' . $this->id . '/' . $this->$fieldItem);
                $this->$fieldItem = '';
                $updateField[] = $fieldItem;
            }
            if ($deleteFolder == true && file_exists($this->uploadFileFolder . '/' . $this->id))
                rmdir($this->uploadFileFolder . '/' . $this->id);
            $this->update($updateField);
        }
    }

    private function is_dir_empty($dir) {
        if (!is_readable($dir))
            return NULL;
        return (count(scandir($dir)) == 2);
    }

    public function oldInformation() {
        $beforeSaveObj = array();
        if (!$this->isNewRecord) {
            $model = call_user_func(array(get_class($this), 'model'));
            $beforeSaveObj = $model->findByPk($this->id);
        }

        return $beforeSaveObj;
    }

    protected function beforeValidate() {
        $imageField = $this->defineImageSize;
        if (is_array($imageField) && !empty($imageField)) {
            foreach ($imageField as $fieldName => $Size) {
                $this->$fieldName = CUploadedFile::getInstance($this, $fieldName);
                if (!is_object($this->$fieldName)) {
                    $oldImge = $this->oldInformation();
                    if (!empty($oldImge->$fieldName) && $oldImge && $oldImge->$fieldName !== '')
                        $this->$fieldName = $oldImge->$fieldName;
                }
            }
        }

        $fileFields = $this->uploadFileFields;

        if (is_array($fileFields) && !empty($fileFields)) {
            foreach ($fileFields as $item) {
                $this->$item = CUploadedFile::getInstance($this, $item);
                if (!is_object($this->$item)) {
                    $oldFile = $this->oldInformation();
                    if (!empty($oldFile->$item))
                        $this->$item = $oldFile->$item;
                }
            }
        }
        return parent::beforeValidate();
    }

    public function tablePrefix() {
        return $tablePrefix = Yii::app()->db->tablePrefix;
    }

    public function getCurrentUrlWithoutParam() {
        $uriWithoutParam = $_SERVER['REQUEST_URI'];
        if (strpos($uriWithoutParam, '?') !== false)
            $uriWithoutParam = substr($uriWithoutParam, 0, strpos($uriWithoutParam, '?'));
        return 'http://' . $_SERVER['SERVER_NAME'] . $uriWithoutParam;
    }

    public function escapeInput($value) {
        $value = str_replace('"', '""', $value);
        $value = str_replace("'", "''", $value);
        return $value;
    }

    public function saveReferralLetter($id, $list) {
        $type = 'referral_letter';
        MyFunctionCustom::saveFile($id, $list, $type);
    }

    public function saveReport($id, $list) {
        $type = 'report';
        MyFunctionCustom::saveFile($id, $list, $type);
    }

    public function saveInsurranceCard($id, $list) {
        $type = 'insurrance_card';
        MyFunctionCustom::saveFile($id, $list, $type);
    }
}

?>

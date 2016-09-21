<?php

class GActiveRecord extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * Before validate event
	 * Generate a GUID for id
	 */
	

	protected function beforeSave() {
		$this->updated_date = date('Y-m-d H:i:s');
		return parent::beforeSave();
	}
}

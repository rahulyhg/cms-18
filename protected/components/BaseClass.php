<?php

class BaseClass {
	protected static $_models;

	public static function model($className=__CLASS__)
	{
	    if(isset(self::$_models[$className]))
	        return self::$_models[$className];
	    else {
	        $model=self::$_models[$className]= new $className(null);
	        return $model;
	    }
	}
}
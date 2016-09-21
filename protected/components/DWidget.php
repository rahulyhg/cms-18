<?php

/**
 * The derived class from CWidget
 * With some modified functions
 *
 * @category PHP
 * @package  Doctor65.System
 * @author   Toanp Nguyen <hgiasac@gmail.com>
 * @license  65doctor team
 * @version  0.1
 * @link     http://65doctor.com
 */

/**
 * The derived class from CWidget Class
 *
 * @category PHP
 * @package  Doctor65.System
 * @author   Toanp Nguyen <hgiasac@gmail.com>
 * @license  65doctor team
 * @version  0.1
 * @link     http://65doctor.com
 */
class DWidget extends CWidget
{
    /**
     * Publish asset and return asset directory
     *
     * @param string  $path       The path directory, default ../assets
     * @param boolean $hashByName whether the published directory should be named
     *                            as the hashed basename. If false, the name will be the hash taken
     *                            from dirname of the path being published and path mtime.
     *                            Defaults to false. Set true if the path being published is shared among different extensions.
     * @param integer $level      level of recursive copying when the asset is a directory.
     *                            Level -1 means publishing all subdirectories and files;
     *                            Level 0 means publishing only the files DIRECTLY under the directory;
     *                            Level N means copying those directories that are within N levels.
     *
     * @return string  asset published path
     */
    public function getAssets($path = '', $hashByName = false, $level = -1)
    {
        $class_name = get_class($this);
        $class = new ReflectionClass($class_name);
        $path = dirname(dirname($class->getFileName())) . '/assets/' . $path;
        $force_copy = YII_DEBUG;

        return Yii::app()->getAssetManager()->publish($path, $hashByName, $level, $force_copy);
    }
}

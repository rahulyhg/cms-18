<?php

include_once 'config.local.php';

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => $THEME_NAME,
    'defaultController' => 'site',
    'theme' => $THEME,
    'language' => 'en',
    // preloading 'log' component
    'preload' => array('log', 'ELangHandler'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.models.core.*',
        'application.models.forms.*',
        'application.models.menus.*',
        'application.models.cms.*',
        'application.models.base.*',
        'application.models.lookup.*',
        'application.models.newsletter.*',
        'application.models.product.*',
        'application.models.gallery.*',
        'application.components.*',
        'application.components.customFunction.*',
        'application.components.format.*',
        'application.components.helper.*',
        'application.models.redbull.*',
        'application.components.widget.*',
        'application.extensions.yii-mail.*',
        'application.extensions.EUploadedImage.*',
        'application.extensions.EPhpThumb.*',
        'application.extensions.MyDebug.*',
        //'application.extensions.editMe.*',
        'application.extensions.mpdf50.*',
        'application.extensions.ControllerActionsName.*',
        'application.modules.auditTrail.models.AuditTrail',
        'application.extensions.toSlug.*',
        'application.extensions.CJuiDateTimePicker.*',
        'application.extensions.phpWord.*',
		'application.extensions.eexcelView.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'application.modules.gii.GiiModule',
            'password' => 'admin1234',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'application.modules.gii', // a path alias
            ),
        ),
        'admin',
        //'appointments',
        'member',
        'auditTrail' => array(
            'userClass' => 'Users', // the class name for the user object
            'userIdColumn' => 'id', // the column name of the primary key for the user
            'userNameColumn' => 'username', // the column name of the primary key for the user
        ),
        'appointment'
    ),
    // application components
    'components' => array(
        'session' => array(
            'class' => 'CDbHttpSession',
            'timeout' => 11800,
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'class' => 'WebUser',
            'loginUrl' => array('/admin/site/login'),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<action:(error|unsubscribe|applicationForm|login|logout|register)>' => 'site/<action>',
                'forgot-password' => 'site/forgotPassword',
                'admin' => array('admin/site'),
                'admin/<action:(login|logout|error|changePassword)>' => 'admin/site/<action>',
                'contact-us' => 'site/contactus',

                '<slug:[a-zA-Z0-9-]+>' => 'cms/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<url:(admin|member)>' => '<url>/site/',
            // '<url>' => '<url>/site/index',
            ),
            'showScriptName' => false,
        ),
        'db' => array(
            'connectionString' => "mysql:host=$MYSQL_HOSTNAME;dbname=$MYSQL_DATABASE",
            'emulatePrepare' => true,
            'username' => $MYSQL_USERNAME,
            'password' => $MYSQL_PASSWORD,
            'tablePrefix' => $TABLE_PREFIX,
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                //'levels'=>'error, warning',
                ),
                array(
                    'class' => 'DbLogRoute',
                    'connectionID' => 'db',
                    'autoCreateLogTable' => false,
                    'logTableName' => $TABLE_PREFIX . "_logger",
                    'levels' => 'info, error'
                ),
                array(
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => array(isset($_COOKIE['debug']) ? '127.0.0.1' : '0.0.0.0'),
                ),
            ),
        ),
        'mail' => array(
            'class' => 'application.extensions.yii-mail.YiiMail',
            'transportType' => '', /// case sensitive!
            'transportOptions' => array(
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => '',
                'encryption' => '',
                'timeout' => '',
            ),
            'viewPath' => 'application.mail',
            'logging' => true,
            'dryRun' => false
        ),
        'setting' => array(
            'class' => 'application.extensions.MyConfig.MyConfig',
            'cacheId' => null,
            'useCache' => false,
            'cacheTime' => 0,
            'tableName' => $TABLE_PREFIX . '_settings',
            'createTable' => false,
            'loadDbItems' => true,
            'serializeValues' => true,
            'configFile' => '',
        ),
        'format' => array(
            'class' => 'BaseFormatter',
        ),
        'ELangHandler' => array(
            'class' => 'application.extensions.langhandler.ELangHandler',
            'languages' => array('en', 'cn'),
            'strict' => true,
        ),
        'events' => array(
            'class' => 'CmsEventList'
        ),
        'helper' => array(
            'class' => 'application.components.helper.HelperComponent'
        ),
        'ePdf' => array(
            'class'   => 'ext.yii-pdf.EYiiPdf',
            'params'  => array(
                        'mpdf'    => array(
                         'librarySourcePath' => 'application.vendors.mpdf.*',
                         'constants'   => array(
                          '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                         ),
                        'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder.
                        /*'defaultParams'   => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                         'mode'    => '', //  This parameter specifies the mode of the new document.
                         'format'   => 'A4', // format A4, A5, ...
                         'default_font_size' => 0, // Sets the default document font size in points (pt)
                         'default_font'  => '', // Sets the default font-family for the new document.
                         'mgl'    => 15, // margin_left. Sets the page margins for the new document.
                         'mgr'    => 15, // margin_right
                         'mgt'    => 16, // margin_top
                         'mgb'    => 16, // margin_bottom
                         'mgh'    => 9, // margin_header
                         'mgf'    => 9, // margin_footer
                         'orientation'  => 'P', // landscape or portrait orientation
                        )*/
                       ),
                        'HTML2PDF' => array(
                         'librarySourcePath' => 'application.vendors.html2pdf.*',
                         'classFile'   => 'html2pdf.class.php', // For adding to Yii::$classMap
                        /*'defaultParams'   => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                         'orientation' => 'P', // landscape or portrait orientation
                         'format'   => 'A4', // format A4, A5, ...
                         'language'   => 'en', // language: fr, en, it ...
                         'unicode'   => true, // TRUE means clustering the input text IS unicode (default = true)
                         'encoding'   => 'UTF-8', // charset encoding; Default is UTF-8
                         'marges'   => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                        )*/
                       )
                    ),
        ),

//        'widgetFactory' => array(
//            'widgets' => array(
//                'CGridView' => array(
//                   'cssFile'=> Yii::app()->request->baseUrl.'/redbull/css/main.css',
//                ),
//            ),
//        ),
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
        'metadata' => array('class' => 'Metadata'),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'ckeditor_full' => "[['Source', 'Bold', 'Italic', 'Underline', 'RemoveFormat', 'PasteText', 'PasteFromWord'],['NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],['Link', 'Unlink', 'Image'],['Styles', 'Format', 'Font', 'FontSize'],['TextColor', 'BGColor']]",
        'ckeditor_basic' => "[
                            [ 'Bold', 'Italic','Underline', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight','JustifyBlock', 'RemoveFormat', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],
                            [ 'FontSize', 'TextColor', 'BGColor' ]
                    ]",
        'niceditor' => array('bold', 'italic', 'underline', 'ol', 'ul'),
        'niceditor_v_1' => array('bold', 'italic', 'underline', 'ol', 'ul', 'fontSize', 'left', 'center', 'right', 'justify', 'forecolor', 'bgcolor', 'image', 'upload', 'link', 'unlink'),
        'adminEmail' => '',
        'autoEmail' => '',
        'dateFormat' => 'd/m/Y',
        'timeFormat' => 'H:i:s',
        'paypalURL' => '',
        'paypalURL_sandbox' => '',
        'paypal_email_address' => '',
        'is_paypal_sandbox' => 1,
        'image_watermark' => '',
        'defaultPageSize' => 20,
        'twitter' => '',
        'facebook' => '',
        'linkedin' => '',
        'rss' => '',
        'meta_description' => '',
        'meta_keywords' => '',
        'reCaptcha' => array(
            'publicKey' => '6Lfmj9ASAAAAAM2b4ePzdByLBIrX6bSU32ZnLgIR',
            'privateKey' => '6Lfmj9ASAAAAAAiZVwboS55FW1sKY1QWm-lGEEAV',
        ),
    ),
);

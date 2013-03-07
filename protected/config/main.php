<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'yii shop',
    'sourceLanguage' => 'en',
    'language' => 'ru',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.components.*',
        'application.widgets.*',
        // yii-user module
        'application.modules.user.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        // yii-rights module
        'application.modules.rights.*',
        'application.modules.rights.models.*',
        'application.modules.rights.components.*',
        // подключить модели из модулей
        'application.modules.category.models.Category',
        'application.modules.product.models.Product',
        'application.modules.page.models.Page',
        'application.modules.configuration.models.Configuration',
        'application.modules.wordform.models.Wordform',
        'application.modules.hint.models.Hint',
        'application.modules.sphinx.models.Sphinx',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'password',
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        // yii-user module
        'user' => array(
            // названия таблиц взяты по умолчанию, их можно изменить
            'tableUsers' => 'users',
            'tableProfiles' => 'profiles',
            'tableProfileFields' => 'profiles_fields',
        ),
        // модули
        'rights',
        'category',
        'product',
        'page',
        'index',
        'configuration',
        'contacts',
        'wordform',
        'hint',
        'sphinx',
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'class' => 'RWebUser',
            'loginUrl' => array('/user/login'),
        ),
        'authManager' => array(
            'class' => 'RDbAuthManager',
            'defaultRoles' => array('Guest'), // дефолтная роль
        ),
        'request' => array(
            'class' => 'application.components.HttpRequest',
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'noCsrfValidationRoutes' => array('social', 'contacts/contacts/test'),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'class' => 'application.components.MyDbUrlManager',
        ),
        'cache' => array(
//            'class' => 'system.caching.CFileCache',
            'class' => 'system.caching.CMemCache',
//            'useMemcached' => true,
            'servers' => array(
                array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 100)
            ),
        ),
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=yiishop',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableProfiling' => true,
            // Значение 1000 означает, что полученные данные схемы базы данных могут 
            // оставаться валидными в кэше в течении 1000 секунд
            // Чтобы выключить кэширование запросов на структуру данных
            'schemaCachingDuration' => 1000,
            'enableParamLogging' => true,
        ),
        'errorHandler' => array(
            'errorAction' => 'index/index/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                //array('class'=>'CWebLogRoute'), // раском-ть чтобы увидеть лиги на стр-е
            ),
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                "host" => "smtp.gmail.com",
                "username" => "zlodeyzld@gmail.com",
                "password" => "zlodey87",
                "port" => "465",
                "encryption" => "ssl"
            ),
            'viewPath' => 'application.views.mail',
            'logging' => false,
            'dryRun' => false
        ),
        // minScript
        'clientScript' => array('class' => 'ext.minScript.components.ExtMinScript'),
    ),
    // для использования расширения контроллера необходимо настроить свойство 'controllerMap'
    'controllerMap' => array(
        'min' => array('class' => 'ext.minScript.controllers.ExtMinScriptController'),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'pageSize' => 20,
        'pageSize2' => 5,
        'pageSizePr' => 6,
        'languages' => array('ru' => 'Русский', 'en' => 'English'),
    ),
);
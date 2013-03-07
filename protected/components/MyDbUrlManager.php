<?php

/*
 * класс для получения маршрутов из бд
 */
class MyDbUrlManager extends CUrlManager
{

    public $dbRules = array(
        '<language:(ru|en)>/' => 'index/index/index',
        '<language:(ru|en)>/contacts' => 'contacts/contacts/index',
        '<language:(ru|en)>/search' => 'sphinx/sphinx/search',
        '<language:(ru|en)>/social' => 'index/index/social',
        '<language:(ru|en)>/product/<alias:[a-zA-Z0-9-]+>' => 'product/index/view',
        '<language:(ru|en)>/catalog' => 'category/index/index/alias/all/page/1',
        '<language:(ru|en)>/catalog/page/<page:\d+>' => 'category/index/index/alias/all',
        '<language:(ru|en)>/catalog/<alias:\w+>' => 'category/index/index',
        '<language:(ru|en)>/catalog/<alias:\w+>/page/<page:\d+>' => 'category/index/index',
        'admin/subpage/<id:\d+>/create' => 'page/admin/subpage',
        'admin/subcat/<id:\d+>/create' => 'category/admin/subcat',
        'admin/users' => 'user/user',
        'user/login' => 'user/login/login',
        'admin' => 'index/admin/index',
        'admin/<module:\w+>' => '<module>/admin/index',
        'admin/<module:\w+>/<id:\d+>' => '<module>/admin/update',
        'admin/<module:\w+>/delete/<id:\d+>' => '<module>/admin/delete',
        'admin/<module:\w+>/<action:(create|search)>' => '<module>/admin/<action>',
        '<language:(ru|en)>/<controller:\w+>/<id:\d+>' => '<controller>/view',
        '<language:(ru|en)>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '<language:(ru|en)>/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    );

    protected function processRules()
    {
        // создать все маршруты
        foreach ($this->dbRules as $pattern => $route) {
            $this->rules[$pattern] = $route;
        }
        parent::processRules();
    }

    public function createUrl($route, $params = array(), $ampersand = '&')
    {
        if (!isset($params['language'])) {
            if (Yii::app()->user->hasState('language'))
                Yii::app()->language = Yii::app()->user->getState('language');
            else if (isset(Yii::app()->request->cookies['language']))
                Yii::app()->language = Yii::app()->request->cookies['language']->value;
            $params['language'] = Yii::app()->language;
        }
        return parent::createUrl($route, $params, $ampersand);
    }

}

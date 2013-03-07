<?php

// общие действия front'а
class IndexController extends Controller
{

    public function filters()
    {
        return array('rights');
    }

    // разрешенные действия
    public function allowedActions()
    {
        return 'index';
    }

    // главная стр-а сайта
    public function actionIndex($alias = 'all', $page = 1)
    {
        $criteria = new CDbCriteria();
        if ($alias == 'all') {
            $this->headTitle = 'Каталог';
            $criteria->condition = 'status = 1';
        } else {
            $data = Category::getByAlias($alias);
            $this->headTitle = $data->title;
            $criteria->condition = 'status = 1 and cat_id = :cat_id';
            $criteria->params = array(':cat_id' => $data->id);
        }
        $count = Product::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = Yii::app()->params['pageSizePr'];
        $pages->setCurrentPage($page - 1);
        $pages->applyLimit($criteria);
        $products = Product::model()->findAll($criteria);
        $this->render('index', array('alias' => $alias, 'count' => $count, 'pages' => $pages, 'products' => $products));
    }

}
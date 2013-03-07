<?php

class IndexController extends Controller
{

    public function filters()
    {
        return array('rights');
    }

    // разрешенные действия
    public function allowedActions()
    {
        return 'view';
    }

    // страница товара
    public function actionView($alias)
    {
        $product = Product::getByAlias($alias);
        $this->render('view', array('product' => $product));
    }

}
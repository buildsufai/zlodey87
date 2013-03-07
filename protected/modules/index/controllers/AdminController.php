<?php

// админ-й контр-р
class AdminController extends AController
{

    // показать меню
    public function actionIndex()
    {
        $this->render('index');
    }

}
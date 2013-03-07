<?php

class LogoutController extends Controller
{

    public $defaultAction = 'logout';

    /**
     * Выход текущего пользователя и перенаправить на 
     * гл-ю стр-у сайта если $_GET['part'] == 'front' 
     * или на стр-у автор-и для админки = returnLogoutUrl
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $r = (isset($_GET['part']) && $_GET['part'] == 'front') ? '/' : Yii::app()->controller->module->returnLogoutUrl;
        $this->redirect($r);
    }

}
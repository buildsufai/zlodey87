<?php

class AdminController extends AController
{

    // настройки сайта
    public function actionIndex()
    {
        $model = Configuration::model()->findByPk(1);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        if (isset($_POST['Configuration'])) {
            $model->attributes = $_POST['Configuration'];
            if ($model->save()) {
                $model->img = CUploadedFile::getInstance($model, 'img');
                if ($model->img != null) {
                    Configuration::saveImages($model);
                }
                $this->redirect('/admin');
            }
        }

        $this->render('index', array('model' => $model));
    }

    // ajax удаление изобр-я
    public function actionDeleteImage()
    {
        Helper::cleanDirectory('./images/config');
        $key = array(1);
        $data = array('img' => '');
        Configuration::model()->updateByPk($key, $data);
    }

}
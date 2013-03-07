<?php

class AdminController extends AController
{
    
    // список подсказок
    public function actionIndex()
    {
        $model = new Hint;
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Hint'])) {
            $model->attributes = $_GET['Hint'];
        }
        $this->render('index', array('model' => $model));
    }

    // создать новую подсказку
    public function actionCreate()
    {
        $model = new Hint;

        if (isset($_POST['Hint'])) {
            $model->attributes = $_POST['Hint'];
            if ($model->save()) {
                $this->redirect('/admin/hint');
            }
        }

        $this->render('form', array('model' => $model));
    }

    // ред-ть подсказку
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if (isset($_POST['Hint'])) {
            $model->attributes = $_POST['Hint'];
            if ($model->save()) {
                $this->redirect('/admin/hint');
            }
        }
        $this->render('form', array('model' => $model));
    }

    // удалить подсказку
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '/admin/hint');
        }
    }

    // загрузить модель
    public function loadModel($id)
    {
        $model = Hint::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404);
        }
        return $model;
    }
    
}
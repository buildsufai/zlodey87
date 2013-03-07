<?php

class AdminController extends AController
{
    
    // список товаров
    public function actionIndex()
    {
        $model = new Product;
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $model->attributes = $_GET['Product'];

        $this->render('index', array('model' => $model));
    }

    // создать новый товар
    public function actionCreate()
    {
        $model = new Product;

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            if ($model->save()) {
                $model->image = CUploadedFile::getInstance($model, 'image');
                if ($model->image != null) {
                    Product::saveImages($model);
                }
                $this->redirect('/admin/product');
            }
        }

        $this->render('create', array('model' => $model));
    }

    // ред-ть товар
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            if ($model->save()) {
                $model->image = CUploadedFile::getInstance($model, 'image');
                if ($model->image != null) {
                    Product::saveImages($model, 'update');
                }

                $this->redirect('/admin/product');
            }
        }

        $this->render('update', array('model' => $model));
    }

    // удалить товар
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '/admin/product');
    }

    // загрузить модель
    public function loadModel($id)
    {
        $model = Product::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404);
        return $model;
    }

    // ajax удаление изобр-я
    public function actionDeleteImage()
    {
        $id = Yii::app()->request->getQuery('id', 0);
        if (!empty($id)) {
            Helper::cleanDirectory('./images/product/' . $id);
            $key = array($id);
            $data = array('image' => '');
            Product::model()->updateByPk($key, $data);
        }
    }
    
    // ajax сохр-я изм-й
    public function actionConfig()
    {
        $idValue = Helper::dataToConfig(Yii::app()->request->getQuery('status', ''));
        $idValue2 = Helper::dataToConfig(Yii::app()->request->getQuery('status2', ''));

        $sql = 'UPDATE products SET ';
        $sql = Helper::update($sql, 'status', $idValue, $idValue2);

        if ($sql != 'UPDATE products SET ') {
            Helper::execute($sql);
            Yii::app()->cache->delete('products');
        }
    }

    // поиск
    public function actionSearch()
    {
        
        $model = new Product('search');
        $model->unsetAttributes();
        $data = array();
        if (isset($_POST['Product'])) {
            $model->cat_id = $_SESSION['searchProductId'] = !empty($_POST['Product']['cat_id']) ? $_POST['Product']['cat_id'] : '';
            $model->title = $_SESSION['searchProductTitle'] = !empty($_POST['Product']['title']) ? trim($_POST['Product']['title']) : '';
        } else {
            if (isset($_SESSION['searchProductTitle'])) {
                $model->cat_id = $_SESSION['searchProductId'];
                $model->title = $_SESSION['searchProductTitle'];
            }
        }
        $data['id'] = $_SESSION['searchProductId'];
        $data['title'] = $_SESSION['searchProductTitle'];
        $data['model'] = $model;
        $this->render('search', $data);
        
    }
    
}
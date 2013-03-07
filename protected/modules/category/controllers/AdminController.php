<?php

class AdminController extends AController
{
    
    // список категорий
    public function actionIndex()
    {
        $categories = Category::model()->findAll();
        $model = Category::model();
        $itemsByParent = count($categories) ? Helper::getItemsByParent($categories) : array();       
        $this->render('index', array('itemsByParent' => $itemsByParent, 'model' => $model));
    }

    // создать новую категорию
    public function actionCreate()
    {
        $model = new Category;
        if (isset($_POST['Category'])) {
            $model->attributes = $_POST['Category'];
            if ($model->save())
                $this->redirect('/admin/category');
        }
        $this->render('create', array('model' => $model));
    }

    // создать новую подрубрику
    public function actionSubcat($id)
    {
        $id = intval($id);
        $model = new Category;
        if (isset($_POST['Category'])) {
            $model->attributes = $_POST['Category'];
            $model->parent_id = intval($_POST['parent_id_cat']);
            if ($model->save()) {
                $this->redirect('/admin/category');
            }
        }
        $this->render('subcat', array('model' => $model, 'id' => $id));
    }

    // ред-ть категорию
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if (isset($_POST['Category'])) {
            $model->attributes = $_POST['Category'];
            if ($model->save())
                $this->redirect('/admin/category');
        }
        $this->render('update', array('model' => $model));
    }

    // удалить категорию
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '/admin/category');
    }

    // загрузить модель кат-и
    public function loadModel($id)
    {
        $model = Category::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404);
        return $model;
    }
    
    // ajax сохр-я изм-й для menu и sort
    public function actionConfig()
    {
        $idValue = Helper::dataToConfig(Yii::app()->request->getQuery('status', ''));
        $idValue2 = Helper::dataToConfig(Yii::app()->request->getQuery('status2', ''));
        $idValue3 = Helper::dataToConfig(Yii::app()->request->getQuery('sort', ''));

        $sql = 'UPDATE categories SET ';
        $sql = Helper::update($sql, 'status', $idValue, $idValue2);
        $sql = Helper::update2($sql, 'sort', $idValue3);

        if ($sql != 'UPDATE categories SET ') {
            Helper::execute($sql);
            
            // сбросить кэш
            Yii::app()->cache->delete('all.cat.title');
            Yii::app()->cache->delete('all.cat.title2');
        }
    }

    // поиск
    public function actionSearch()
    {
        $q = urldecode(trim(Yii::app()->request->getQuery('q', '')));
        $categories = Category::model()->findAll('title like "%' . $q . '%"');
        $response = 'jQuery(".list-table tr").hide();';
        foreach ($categories as $category) {
            $response .= 'jQuery(".list-table tr[id=' . $category['id'] . ']").show();';
        }
        echo $response;
    }
    
}
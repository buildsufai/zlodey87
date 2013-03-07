<?php

class AdminController extends AController
{
    
	// список стат-х стр-ц
    public function actionIndex()
    {
        $pages = Page::model()->findAll();
        $model = Page::model();
        $itemsByParent = count($pages) ? Helper::getItemsByParent($pages) : array();
        $this->render('index', array('itemsByParent' => $itemsByParent, 'model' => $model));
    }

    // создать новую стат-ю стр-цу
    public function actionCreate()
    {
        $model = new Page;

        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];
            if ($model->save()) {
                $model->image = CUploadedFile::getInstance($model, 'image');
                if ($model->image != null) {
                    Page::saveImages($model);
                }
                $this->redirect('/admin/page');
            }
        }

        $this->render('create', array('model' => $model));
    }

    // создать новую подрубрику
    public function actionSubpage($id)
    {
        $id = intval($id);
        $model = new Page;

        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];
            $model->parent_id = intval($_POST['parent_id_page']);
            if ($model->save()) {
                $model->image = CUploadedFile::getInstance($model, 'image');
                if ($model->image != null) {
                    Page::saveImages($model);
                }
                $this->redirect('/admin/page');
            }
        }

        $this->render('subpage', array('model' => $model, 'id' => $id));
    }

    // ред-ть стат-ю стр-цу
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];
            if ($model->save()) {
                $model->image = CUploadedFile::getInstance($model, 'image');
                if ($model->image != null) {
                    Page::saveImages($model, 'update');
                }
                $this->redirect('/admin/page');
            }
        }

        $this->render('update', array('model' => $model));
    }

    // удалить стат-ю стр-цу
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '/admin/page');
    }

    // загрузить модель кат-и
    public function loadModel($id)
    {
        $model = Page::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404);
        return $model;
    }

    // ajax удаление изобр-я
    public function actionDeletePageImage()
    {
        $id = Yii::app()->request->getQuery('id', 0);
        if (!empty($id)) {
            Helper::cleanDirectory('./images/page/' . $id);
            $key = array($id);
            $data = array('image' => '');
            Page::model()->updateByPk($key, $data);
        }
    }

    // ajax сохр-я изм-й для menu и sort
    public function actionConfig()
    {
        $idValue = Helper::dataToConfig(Yii::app()->request->getQuery('menu', ''));
        $idValue2 = Helper::dataToConfig(Yii::app()->request->getQuery('menu2', ''));
        $idValue3 = Helper::dataToConfig(Yii::app()->request->getQuery('sort', ''));

        $sql = 'UPDATE pages SET ';
        $sql = Helper::update($sql, 'menu', $idValue, $idValue2);
        $sql = Helper::update2($sql, 'sort', $idValue3);

        if ($sql != 'UPDATE pages SET ') {
            Helper::execute($sql);
            // сбросить кэш
            Yii::app()->cache->delete('all.page.title');
        }
    }

    // поиск
    public function actionSearch()
    {        
        $q = urldecode(trim(Yii::app()->request->getQuery('q', '')));
        $pages = Page::model()->findAll('title like "%' . $q . '%"');
        $response = 'jQuery(".list-table tr").hide();';
        foreach ($pages as $page) {
            $response .= 'jQuery(".list-table tr[id=' . $page['id'] . ']").show();';
        }
        echo $response;
    }
    
}
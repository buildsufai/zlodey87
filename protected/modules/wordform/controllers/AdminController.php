<?php

class AdminController extends AController
{
    
    // список словоформ
    public function actionIndex()
    {
        $wordform = new Wordform;
        $this->render('index', array('wordforms' => $wordform));
    }

    // создать новую словоформу
    public function actionCreate()
    {
        $this->render('form');
    }

    // ред-ть словоформу
    public function actionUpdate($id)
    {
        $wfModel = new Wordform;
        $this->render('form', array('wf' => $wfModel->getWordform($id)));
    }

    // удалить словоформу
    public function actionDelete($id)
    {
        $wfModel = new Wordform;
        $wfModel->deleteWF($id);
        $this->redirect('/admin/wordform');
    }

    // проверка формы поиска
    public function actionAjax()
    {
        $bw = Helper::ajaxClear(Yii::app()->request->getQuery('bw'));
        $rw = Helper::ajaxClear(Yii::app()->request->getQuery('rw'));
        $id = Yii::app()->request->getQuery('id', '');
        $html = '';
        $wfModel = new Wordform;
        if (mb_strlen($bw) < 3) {
            $html .= "jQuery('#bw').parent().next().children('.s_e').text('минимум 3 символа!!!').css('display', 'block');";
        }
        if (mb_strlen($rw) < 3) {
            $html .= "jQuery('#rw').parent().next().children('.s_e').text('минимум 3 символа!!!').css('display', 'block');";
        }
        if ($wfModel->checkBW($bw)) {
            $html .= "jQuery('#bw').parent().next().children('.s_e').text('эта фраза не может повторно использоваться!!!').css('display', 'block');";
        }
        if ($wfModel->checkRW($rw)) {
            $html .= "jQuery('#rw').parent().next().children('.s_e').text('эта фраза не может повторно использоваться!!!').css('display', 'block');";
        }
        if ($bw == $rw && !empty($bw) && !empty($rw)) {
            $html .= "jQuery('#rw').parent().next().children('.s_e').text('фразы идентичны!!!').css('display', 'block');";
        }
        if ($wfModel->checkWF($bw, $rw, $id)) {
            $html .= "jQuery('#rw').parent().next().children('.s_e').text('такая пара уже существует!!!').css('display', 'block');";
        }
        if (!empty($html)) {
            echo $html;
        } else {
            if ($id != '') {
                $wfModel->updateWF($bw, $rw, Yii::app()->request->getQuery('id'));
            } else {
                $wfModel->addWF($bw, $rw);
            }
            echo '/admin/wordform';
        }
    }
    
}
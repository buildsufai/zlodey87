<?php

class SphinxController extends Controller
{
    
    public function filters()
    {
        return array('rights');
    }

    // разрешенные действия
    public function allowedActions()
    {
        return 'search, ajaxsearch, ajaxautocomplete';
    }

    // проверка формы поиска
    public function actionAjaxSearch()
    {
        $title = Helper::ajaxClear(Yii::app()->request->getQuery('title'));
        $catId = Yii::app()->request->getQuery('catId');
        $prF = Yii::app()->request->getQuery('prF');
        $prT = Yii::app()->request->getQuery('prT');
        $html = '';
        if (mb_strlen($title) < 3) {
            $html .= "jQuery('.s_e').css('display', 'block');";
        }
        if (!empty($prF) && !empty($prT) && $prF >= $prT) {
            $html .= "jQuery('.s_e2').css('display', 'block');";
        }
        if (!empty($html)) {
            echo $html;
        } else {
            $url = '/search?title=' . $title;
            $url .= !empty($catId) ? '&catId=' . $catId : '';
            $url .= !empty($prF) ? '&prF=' . $prF : '';
            $url .= !empty($prT) ? '&prT=' . $prT : '';
            echo $url;
        }
    }

    // autocomplite из поля title 
    public function actionAjaxAutocomplete()
    {
        $q = Helper::ajaxClear(Yii::app()->request->getQuery('query'));
        $catId = Yii::app()->request->getQuery('catId');
        $prF = Yii::app()->request->getQuery('prF');
        $prT = Yii::app()->request->getQuery('prT');
        $cl = Sphinx::getSphinxClient();
        $cl->SetRankingMode(SPH_RANK_WORDCOUNT);
        $cl->SetMatchMode(SPH_MATCH_EXTENDED2);
        $cl->SetLimits(0, 50);
        // фильтровать по категории
        if ($catId) {
            $cl->SetFilter('cat_id', array($catId));
        }
        // SetFilterRange - фильтровать по цене
        // если 4-й пар-р = false, то включительно, иначе нет
        if (!empty($prF) && !empty($prT)) {
            $cl->SetFilterRange('price', $prF, $prT, false);
        } elseif (!empty($prF)) {
            $cl->SetFilterRange('price', $prF, 100000000, false);
        } elseif (!empty($prT)) {
            $cl->SetFilterRange('price', 0, $prT, false);
        }
        $result = $cl->Query("@title ^{$q}* | ^{$q}$ | *{$q}* | ^{$q} | {$q} | {$q}* | *{$q}*");
        if (!empty($result['matches'])) {
            $data = array();
            foreach ($result['matches'] as $info) {
                $data[] = $info['attrs']['t'];
            }
        } else {
            $data = array('status' => 'error', 'msg' => 'поиск не дал результатов', 'debug' => $result);
        }
        $response = array('query' => $q, 'suggestions' => $data);
        exit(json_encode($response));
    }

    // sphinx search
    public function actionSearch()
    {
        $q = Helper::ajaxClear(Yii::app()->request->getQuery('title'));
        $this->headTitle = 'Поиск по запросу: ' . $q;
        $products = Sphinx::Query($q);
//        Helper::dbg($products);
        $matches = count($products);
        $options = array(
            'id' => 'id',
            'sort' => array('attributes' => array('id', 'title', 'price')),
            'pagination' => array('pageSize' => 1, 'pageVar' => 'page'),
            'totalItemCount' => $matches
            );
        $data = new CArrayDataProvider($products, $options);
        $this->render('search', array('matches' => $matches, 'q' => $q, 'data' => $data));
    }
    
}
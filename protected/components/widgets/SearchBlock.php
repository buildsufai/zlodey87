<?php

Yii::import('zii.widgets.CPortlet');

class SearchBlock extends CPortlet
{

//    public $title = Yii::t('search', 'Search');
//    public $title = 'Search';

    protected function renderContent()
    {
        echo CHtml::beginForm(array('search/index'), 'get', array('style' => 'inline')) .
        CHtml::textField('q', '', array('placeholder' => Yii::t('search', 'search...'), 'style' => 'width:90px;')) .
        CHtml::submitButton(Yii::t('search', 'search'), array('style' => 'width:55px;')) .
        CHtml::endForm('');
    }

}
<?php

class SearchForm extends CFormModel
{

    public $title;
    public $catId;
    public $prF;
    public $prT;

    public function rules()
    {
        return array(
            array('title', 'required'),
            array('title', 'length', 'min' => 3),
            array('title', 'length', 'max' => 100),
            array('catId, prF, prT', 'numerical', 'integerOnly' => true)
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'title' => 'Ключевое слово',
            'catId' => 'Категория',
            'prF' => 'Цена',
            'prT' => 'до:'
        );
    }

}
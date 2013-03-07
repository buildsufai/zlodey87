<?php

class AController extends RController
{
    
    public $layout = '//layouts/puzzleAdmin';

    public function filters()
    {
        return array('rights');
    }
    
    // выполняется после создания контроллера
    public function init()
    {
        parent::init();
    }

}
<?php

class Controller extends RController
{
    
    public $layout = '//layouts/puzzleFront';
    public $headTitle;
    public $config;
    
    // выполняется после создания контроллера
    public function init()
    {
        parent::init();
        $this->config = Configuration::getConfig();
    }

}
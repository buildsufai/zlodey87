<?php

class SphinxModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            'sphinx.models.*',
            'sphinx.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else {
            return false;
        }
    }

}

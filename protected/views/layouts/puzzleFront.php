<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo !empty($this->headTitle) ? $this->headTitle : 'интернет магазин'; ?></title>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <!--[if lte IE 6]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" /><![endif]-->
        <meta name="keywwords" content="интернет магазин" />
        <meta name="description" content="интернет магазин" />
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->clientScript->minScriptCreateGroup(array('css/style.css', 'css/autocomplete.css', 'css/uitooltip.css')); ?>" />
        <script src="//ulogin.ru/js/ulogin.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->clientScript->minScriptCreateGroup(array('js/jquery.js', 'js/autocomplete.js', 'js/jcarousel.js', 'js/easyTooltip.js', 'js/uitooltip.js', 'js/script.js')); ?>"></script>
    </head>
    <body>
        <div class="shell">
            <div id="header">
                <?php $this->widget('Header'); ?>
                <?php $this->widget('application.components.widgets.LanguageSelector'); ?>
            </div>
            <div id="main">
                <div class="cl">&nbsp;</div>
                <div id="content"><?php echo $content; ?></div>
                <div id="sidebar">
                    <?php $this->widget('Login'); ?>
                    <?php $this->widget('Sidebar'); ?>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
            <?php $this->widget('SideFull'); ?>
            <?php $this->widget('Footer'); ?>
        </div>
    </body>
</html>
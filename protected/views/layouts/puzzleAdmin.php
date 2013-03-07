<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Yii CMS</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!--[if lte IE 6]>
            <link href="/puzzleAdmin/ie6.css" rel="stylesheet" type="text/css" />
        <![endif]-->
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->clientScript->minScriptCreateGroup(array('puzzleAdmin/style.css', 'puzzleAdmin/ui.css')); ?>" />
        <script type="text/javascript" src="<?php echo Yii::app()->clientScript->minScriptCreateGroup(array('puzzleAdmin/js/jquery.js', 'puzzleAdmin/js/ui.js', 'puzzleAdmin/js/script.js', 'puzzleAdmin/js/timepicker.js')); ?>"></script>
        <script type="text/javascript" src="/puzzleAdmin/ckfinder/ckfinder.js"></script>
        <script type="text/javascript" src="/puzzleAdmin/ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <div id="page">
            <div id="wrapper">
                <div id="content">
                    <div class="header">
                        <a href="<?php echo Yii::app()->createUrl('admin'); ?>" class="logo">&nbsp;</a>
                        <p class="site-enter-info">Вход в панель управления<br />сайтом <a href="/"><?php echo $_SERVER['HTTP_HOST']; ?></a></p>
                        <ul class="usernav">
                            <li class="user">Вы &mdash; &nbsp; <a href="#"><?php echo Yii::app()->user->name; ?></a></li>
                            <li>|</li>
                            <li class="logout"><a href="<?php echo Yii::app()->createUrl('user/logout'); ?>" class="red">Выйти</a></li>
                        </ul>
                    </div>
                    <table class="main-grid">
                        <tr>
                            <td class="left-collumn">
                                <ul class="left-menu">
                                    <li><a href="<?php echo Yii::app()->createUrl('admin/product'); ?>" 
                                        <?php if (Yii::app()->createUrl('admin/product') == $_SERVER['REQUEST_URI']) { echo ' class = "active" '; } ?>>Товары</a></li>
                                    <li><a href="<?php echo Yii::app()->createUrl('admin/page'); ?>" 
                                        <?php if (Yii::app()->createUrl('admin/page') == $_SERVER['REQUEST_URI']) { echo ' class = "active" '; } ?>>Записи</a></li>
                                    <li><a href="<?php echo Yii::app()->createUrl('admin/wordform'); ?>" 
                                        <?php if (Yii::app()->createUrl('admin/wordform') == $_SERVER['REQUEST_URI']) { echo ' class = "active" '; } ?>>Словоформы</a></li>
                                    <li><a href="<?php echo Yii::app()->createUrl('admin/hint'); ?>" 
                                        <?php if (Yii::app()->createUrl('admin/hint') == $_SERVER['REQUEST_URI']) { echo ' class = "active" '; } ?>>Подсказки</a></li>
                                    <li><a href="<?php echo Yii::app()->createUrl('admin/configuration'); ?>" 
                                        <?php if (Yii::app()->createUrl('admin/configuration') == $_SERVER['REQUEST_URI']) { echo ' class = "active" '; } ?>>Настройки</a></li>
                                    <li><a href="<?php echo Yii::app()->createUrl('admin/users'); ?>" 
                                        <?php if (Yii::app()->createUrl('admin/users') == $_SERVER['REQUEST_URI']) { echo ' class = "active" '; } ?>>Пользователи</a></li>
                                </ul>
                            </td>
                            <td class="center-collumn">
                                <div class="languages">
                                    <p>Языковые версии:</p>
                                    <ul>
                                        <li class="active"><span class="l"></span><a href="#">русская</a><span class="r"></span></li>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                                <div class="main-container">
                                    <?php echo $content; ?>
                                    <div class="clear"></div>
                                </div>
                                <div class="footer">
                                    <div class="copyright">
                                    <p>
                                        &copy; 2012&mdash;2013 &nbsp;
                                        <span title="Система усправления сайтом">YiiCMS&trade;</span>
                                    </p>
                                    </div>
                                    <p class="makers">&copy; Разработано yii</p>
                                </div>
                            </td>
                        </tr>
                    </table><div style="clear: both;"></div>
                </div><!-- CONTENT -->
            </div><!-- WRAPPER -->
        </div><!-- PAGE --> 
    </body>
</html>
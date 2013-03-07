<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Yii CMS</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->clientScript->minScriptCreateGroup(array('puzzleAdmin/style.css')); ?>" />
        <!--[if lte IE 6]>
            <link href="/puzzleAdmin/ie6.css" rel="stylesheet" type="text/css" />
        <![endif]-->
    </head>
    <body class="login">
        <div id="page">
            <div id="wrapper">
                <div id="content">
                    <div class="login-block">
                        <div class="header">
                            <a href="/" class="logo">&nbsp;</a>
                            <p class="site-enter-info">Вход в панель управления<br />сайтом <a href="#"><?php echo $_SERVER['HTTP_HOST']; ?></a></p>
                        </div>
                        <div class="box">
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div><!-- CONTENT -->
            </div><!-- WRAPPER -->
        </div><!-- PAGE -->
        <!-- markup by Stadnikov [lobster] Veniamin -->
    </body>
</html>
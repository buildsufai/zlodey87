<div class="box">
    <h2>Авторизация <span></span></h2>
    <?php if (Yii::app()->user->isGuest) : ?>
        <?php echo CHtml::beginForm(); ?>
            <div><?php echo CHtml::errorSummary($model); ?></div>
            <dl>
                <dt><?php echo CHtml::activeLabelEx($model, 'username'); ?></dt>
                <dd>
                    <?php echo CHtml::activeTextField($model, 'username', array('class' => 'inputbox')) ?>
                </dd>
                <dt><?php echo CHtml::activeLabelEx($model, 'password'); ?></dt>
                <dd>
                    <?php echo CHtml::activePasswordField($model, 'password', array('class' => 'inputbox')) ?>
                </dd>
                <dd class="button-block">
                    <div class="rel">
                        <?php echo CHtml::imageButton(Yii::app()->request->baseUrl . '/puzzleAdmin/images/button/enter.gif'); ?>
                    </div>
                    <table class="tableBorderNone">
                        <tr>
                            <td><?php echo CHtml::activeCheckBox($model,'rememberMe'); ?></td>
                            <td><?php echo CHtml::activeLabelEx($model,'rememberMe'); ?></td>
                        </tr>
                    </table>
                </dd>
            </dl>
        <?php echo CHtml::endForm(); ?>
        <a href="<?php echo Yii::app()->urlManager->createUrl('/user/registration'); ?>">регистрация</a>
        <div id="uLogin" data-ulogin="display=small;fields=first_name,last_name,email,nickname,phone,photo;providers=vkontakte,facebook,twitter,google,mailru,yandex,odnoklassniki;redirect_uri=http%3A%2F%2Fyii.shop%2Fsocial%2F"></div>
    <?php else : ?>
        <?php echo Yii::app()->user->name; ?>
        <a href="<?php echo Yii::app()->createUrl('user/logout/', array('part' => 'front')); ?>">Выйти</a>
    <?php endif; ?>
</div>
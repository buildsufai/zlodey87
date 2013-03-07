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
            <table>
                <tr>
                    <td><?php echo CHtml::activeCheckBox($model,'rememberMe'); ?></td>
                    <td><?php echo CHtml::activeLabelEx($model,'rememberMe'); ?></td>
                </tr>
            </table>
        </dd>
    </dl>
<?php echo CHtml::endForm(); ?>
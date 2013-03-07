<div class="page-title">
    <h2 class="title"><?php if (Yii::app()->controller->action->id == 'update') { echo 'Редактировать подсказку'; } else { echo 'Создать новую подсказку'; } ?></h2>
</div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'hint-form',
    'enableAjaxValidation' => false,
    ));
?>
<dl class="edit-page">
    <dt><?php echo $form->labelEx($model, 'q'); ?></dt>
    <dd><?php echo $form->textField($model, 'q', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'q'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'hint'); ?></dt>
    <dd><?php echo $form->textArea($model, 'hint', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'hint'); ?></dt>
</dl>
<div class="button-box">
    <table class="field-statistics">
        <tr>
            <td class="l"><a href="<?php echo Yii::app()->createUrl('admin/hint'); ?>">Закрыть без сохранения</a></td>
            <td class="r"><input type="submit" value="Сохранить" id="hintSubmit"  /></td>
        </tr>
    </table>
</div>
<?php $this->endWidget(); ?>
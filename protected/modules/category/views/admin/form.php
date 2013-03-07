<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'category-form',
    'enableAjaxValidation' => false,
    ));
?>
<dl class="edit-page">
    <dt><?php echo $form->labelEx($model, 'parent_id'); ?></dt>
    <dd>
        <?php
        echo $form->dropDownList($model, 'parent_id',
            // список всех записей
            Category::getAll(),
            // зн-е по ум-ю
            array('empty' => 'Выберите родительскую запись'));
        ?>
    </dd>
    <dt><?php echo $form->error($model, 'parent_id'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'title'); ?></dt>
    <dd><?php echo $form->textField($model, 'title', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'title'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'alias'); ?></dt>
    <dd><?php echo $form->textField($model, 'alias', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'alias'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'status'); ?></dt>
    <dd><?php echo $form->dropDownList($model, 'status', array('1' => 'да', '0' => 'нет')); ?></dd>
    <dt><?php echo $form->error($model, 'status'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'sort'); ?></dt>
    <dd><?php echo $form->textField($model, 'sort', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'sort'); ?></dt>
</dl>
<div class="button-box">
    <table class="field-statistics">
        <tr>
            <td class="l"><a href="<?php echo Yii::app()->createUrl('admin/category'); ?>">Закрыть без сохранения</a></td>
            <td class="r"><?php echo CHtml::submitButton('Сохранить изменения'); ?></td>
        </tr>
    </table>
</div>
<?php $this->endWidget(); ?>
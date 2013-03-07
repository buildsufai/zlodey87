<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("input[type=text]").attr('class', 'inputbox').removeAttr('size');
    });
</script>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
?>

<dl class="edit-page">
    <dt><?php echo $form->labelEx($model, 'username'); ?></dt>
    <dd><?php echo $form->textField($model, 'username', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'username'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'password'); ?></dt>
    <dd><?php echo $form->passwordField($model, 'password', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'password'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'email'); ?></dt>
    <dd><?php echo $form->textField($model, 'email', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'email'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'superuser'); ?></dt>
    <dd><?php echo $form->dropDownList($model, 'superuser', User::itemAlias('AdminStatus')); ?></dd>
    <dt><?php echo $form->error($model, 'superuser'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'status'); ?></dt>
    <dd><?php echo $form->dropDownList($model, 'status', User::itemAlias('UserStatus')); ?></dd>
    <dt><?php echo $form->error($model, 'status'); ?></dt>

    <?php
    $profileFields = $profile->getFields();
    if ($profileFields) {
        foreach ($profileFields as $field) {
            ?>
            <dt><?php echo $form->labelEx($profile, $field->varname); ?></dt>
            <dd>
                <?php
                if ($widgetEdit = $field->widgetEdit($profile)) {
                    echo $widgetEdit;
                } elseif ($field->range) {
                    echo $form->dropDownList($profile, $field->varname, Profile::range($field->range));
                } elseif ($field->field_type == "TEXT") {
                    echo CHtml::activeTextArea($profile, $field->varname, array('rows' => 6, 'cols' => 50));
                } else {
                    echo $form->textField($profile, $field->varname, array('size' => 60, 'maxlength' => (($field->field_size) ? $field->field_size : 255)));
                }
                ?>
            </dd>
            <dt><?php echo $form->error($profile, $field->varname); ?></dt>
            <?php
        }
    }
    ?>
</dl>
<div class="button-box">
    <table class="field-statistics">
        <tr>
            <td class="l"><a href="<?php echo Yii::app()->createUrl('admin/users'); ?>">Закрыть без сохранения</a></td>
            <td class="r"><?php echo CHtml::submitButton('Сохранить изменения'); ?></td>
        </tr>
    </table>
</div>

<?php $this->endWidget(); ?>
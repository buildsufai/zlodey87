<div class="page-title">
    <h2 class="title">Создать новую категорию товаров</h2>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // уст-ть значение род-й записи
        jQuery('#Category_parent_id').val(<?php echo $id; ?>).attr('disabled', 'disabled');
        // отметить и снять выд-е всех checkbox
        jQuery('.a_subcat').live('click', function() {
            jQuery('.a_subcat').toggle(function() {
                jQuery(this).text('Выбрать начальную родительскую запись');
                jQuery('#Category_parent_id').removeAttr('disabled');
                return false;
            }, function(){
                jQuery(this).text('Выбрать другую родительскую запись');
                jQuery('#Category_parent_id').val(<?php echo $id; ?>).attr('disabled', 'disabled');
                return false;
            }).trigger('click');
        });
        // перед отправкой формы
        jQuery('input[type=submit]').click(function() {
            var parent_id = jQuery('#Category_parent_id').val();
            jQuery('#parent_id_cat').val(parent_id);
            // отправить форму
            jQuery('#subcat-form').submit();
        });
    });
</script>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'subcat-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
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
        <a href="#" class="a_subcat">Выбрать другую родительскую запись</a>
    </dd>
    <dt><?php echo $form->error($model, 'parent_id'); ?></dt>
    <input type="hidden" value="" name="parent_id_cat" id="parent_id_cat" />

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
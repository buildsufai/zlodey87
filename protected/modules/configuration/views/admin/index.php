<div class="page-title">
    <h2 class="title">Редактировать настройки сайта</h2>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // заменить textarea на текст-й редактор
        var header_info = CKEDITOR.replace( 'Configuration_header_info' );
        CKFinder.setupCKEditor( header_info, '/puzzleAdmin/js/ckfinder/' );
        var footer_info = CKEDITOR.replace( 'Configuration_footer_info' );
        CKFinder.setupCKEditor( footer_info, '/puzzleAdmin/js/ckfinder/' );
        // удалить изобр-е
        jQuery('#deleteImg').click(function() {
            if(confirm("Действительно хотите удалить изображение?")) {
                jQuery.ajax({
                    type: 'GET',
                    url: '/configuration/configuration/deleteimage',
                    success: function(){
                        jQuery('.tableImage').remove();
                    }
                });
            }
            return false;
        });
    });
</script>
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'configuration-form',
	'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<dl class="edit-page">
    <dt><?php echo $form->labelEx($model, 'header_info'); ?></dt>
    <dd><?php echo $form->textArea($model, 'header_info'); ?></dd>
    <dt><?php echo $form->error($model, 'header_info'); ?></dt>
    <dt><?php echo $form->labelEx($model, 'footer_info'); ?></dt>
    <dd><?php echo $form->textArea($model, 'footer_info'); ?></dd>
    <dt><?php echo $form->error($model, 'footer_info'); ?></dt>
    <dt><?php echo $form->labelEx($model, 'email'); ?></dt>
    <dd><?php echo $form->textField($model, 'email', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'email'); ?></dt>
</dl>
<div class="greenbox">
    <fieldset>
        <legend>картинки и фотографии</legend>
        <div class="box">
            <dl class="edit-page">
                <dt><?php echo $form->labelEx($model, 'img'); ?></dt>
                <dd>
                    <?php echo $form->fileField($model, 'img'); ?>
                </dd>
                <dt><?php echo $form->error($model, 'img'); ?></dt>
                <dt>
                <?php if ($model->isNewRecord == false && !empty($model->img)): ?>
                    <table class="tableImage">
                        <tr>
                            <td><img src="/images/config/center/150_original.<?php echo $model->img; ?>" class="thumbImg" /></td>
                            <td>
                                <p>150_original.<?php echo $model->img; ?></p>
                                <p><a href="#" id="deleteImg" class="del">удалить</a></p>
                            </td>
                        </tr>
                    </table>
                <?php endif; ?>
                </dt>
            </dl>
        </div>
    </fieldset>
</div>
<div class="button-box">
    <table class="field-statistics">
        <tr>
            <td class="l"><a href="<?php echo Yii::app()->createUrl('admin'); ?>">Закрыть без сохранения</a></td>
            <td class="r"><?php echo CHtml::submitButton('Сохранить изменения'); ?></td>
        </tr>
    </table>
</div>
<?php $this->endWidget(); ?>
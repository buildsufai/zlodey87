<div class="page-title">
    <h2 class="title">Создать новую запись</h2>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // заменить textarea на текст-й редактор
        var text = CKEDITOR.replace( 'Page_text' );
        CKFinder.setupCKEditor( text, '/puzzleAdmin/js/ckfinder/' );
        var announce = CKEDITOR.replace( 'Page_announce' );
        CKFinder.setupCKEditor( announce, '/puzzleAdmin/js/ckfinder/' );
        
        // удалить изобр-е
        jQuery('#deleteImg').click(function() {
            if(confirm("Действительно хотите удалить изображение?")) {
                jQuery.ajax({
                    type: 'GET',
                    url: '/page/admin/deletepageimage',
                    data: 'id=' + jQuery(this).attr('pageId'),
                    success: function(){
                        jQuery('.tableImage').remove();
                    }
                });
            }
            return false;
        });
        /**/
        jQuery('#seoToggle').toggle(function() 
        { 
            jQuery('#seo').hide();
            jQuery(this).text('показать');
            return false;
        }, 
        function() 
        { 
            jQuery('#seo').show();
            jQuery(this).text('скрыть');
            return false;
        });
        // уст-ть значение род-й записи
        jQuery('#Page_parent_id').val(<?php echo $id; ?>).attr('disabled', 'disabled');
        // отметить и снять выд-е всех checkbox
        jQuery('.a_subcat').live('click', function() {
            jQuery('.a_subcat').toggle(function() {
                jQuery(this).text('Выбрать начальную родительскую запись');
                jQuery('#Page_parent_id').removeAttr('disabled');
                return false;
            }, function(){
                jQuery(this).text('Выбрать другую родительскую запись');
                jQuery('#Page_parent_id').val(<?php echo $id; ?>).attr('disabled', 'disabled');
                return false;
            }).trigger('click');
        });
        
        // перед отправкой формы
        jQuery('input[type=submit]').click(function() {
            var parent_id = jQuery('#Page_parent_id').val();
            jQuery('#parent_id_page').val(parent_id);
            // отправить форму
            jQuery('#subpage-form').submit();
        });
    });
</script>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'subpage-form',
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
            Page::getAll(),
            // зн-е по ум-ю
            array('empty' => 'Выберите родительскую запись'));
        ?>
        <a href="#" class="a_subcat">Выбрать другую родительскую запись</a>
    </dd>
    <dt><?php echo $form->error($model, 'parent_id'); ?></dt>
    <input type="hidden" value="" name="parent_id_page" id="parent_id_page" />

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

    <dt><?php echo $form->labelEx($model, 'announce'); ?></dt>
    <dd><?php echo $form->textArea($model, 'announce'); ?></dd>
    <dt><?php echo $form->error($model, 'announce'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'text'); ?></dt>
    <dd><?php echo $form->textArea($model, 'text'); ?></dd>
    <dt><?php echo $form->error($model, 'text'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'menu_t'); ?></dt>
    <dd><?php echo $form->textField($model, 'menu_t', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'menu_t'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'menu'); ?></dt>
    <dd><?php echo $form->dropDownList($model, 'menu', array('1' => 'да', '0' => 'нет')); ?></dd>
    <dt><?php echo $form->error($model, 'menu'); ?></dt>
</dl>

<div class="sub-page-title">
    <h2 class="title">SEO-блок</h2><a href="#" id="seoToggle">скрыть</a>
    <div style="clear: both;"></div>
</div>
<dl class="edit-page" id="seo">
    <dt><?php echo $form->labelEx($model, 'title_a'); ?></dt>
    <dd><?php echo $form->textField($model, 'title_a', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'title_a'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'title_h'); ?></dt>
    <dd><?php echo $form->textField($model, 'title_h', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'title_h'); ?></dt>

    <dt>
    <table class="field-statistics">
        <tr>
            <td class="l"><?php echo $form->labelEx($model, 'meta_k'); ?></td>
            <td class="r"></td>
        </tr>
    </table>
    </dt>
    <dd><?php echo $form->textArea($model, 'meta_k', array('class' => 'keywords inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'meta_k'); ?></dt>

    <dt>
    <table class="field-statistics">
        <tr>
            <td class="l"><?php echo $form->labelEx($model, 'meta_d'); ?></td>
            <td class="r"></td>
        </tr>
    </table>
    </dt>
    <dd><?php echo $form->textArea($model, 'meta_d', array('class' => 'keywords inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'meta_d'); ?></dt>
</dl>

<div class="greenbox">
    <fieldset>
        <legend>картинки и фотографии</legend>
        <div class="box">
            <dl class="edit-page">
                <dt><?php echo $form->labelEx($model, 'image'); ?></dt>
                <dd>
                    <?php echo $form->fileField($model, 'image'); ?>
                </dd>
                <dt><?php echo $form->error($model, 'image'); ?></dt>
                <dt>
                <?php if ($model->isNewRecord == false && !empty($model->image)): ?>
                    <table class="tableImage">
                        <tr>
                            <td><img src="/images/page/<?php echo $model->id; ?>/150_original.<?php echo $model->image; ?>" class="thumbImg" /></td>
                            <td>
                                <p>150_original.<?php echo $model->image; ?></p>
                                <p><a href="#" id="deleteImg" class="del" pageId="<?php echo CHtml::encode($model->id); ?>">удалить</a></p>
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
            <td class="l"><a href="<?php echo Yii::app()->createUrl('admin/page'); ?>">Закрыть без сохранения</a></td>
            <td class="r"><?php echo CHtml::submitButton('Сохранить изменения'); ?></td>
        </tr>
    </table>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // календарь у поля 'Дата создания'
        jQuery("#Product_created_at").datetimepicker({
            dateFormat: 'yy-mm-dd',
            monthNames:["Январь","Февраль","Март","Апрель","Май","Июнь","Июль",
                "Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],
            dayNamesMin: ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"],
            timeFormat: 'hh:mm:ss',
            showSecond: true
        });

        // заменить textarea на текст-й редактор
        var text = CKEDITOR.replace( 'Product_text' );
        CKFinder.setupCKEditor( text, '/puzzleAdmin/js/ckfinder/' );
        var note = CKEDITOR.replace( 'Product_note' );
        CKFinder.setupCKEditor( note, '/puzzleAdmin/js/ckfinder/' );
        
        // удалить изобр-е
        jQuery('#deleteImg').click(function() {
            if(confirm("Действительно хотите удалить изображение?")) {
                jQuery.ajax({
                    type: 'GET',
                    url: '/product/admin/deleteimage',
                    data: 'id=' + jQuery(this).attr('productId'),
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
    });
</script>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'product-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
?>
<dl class="edit-page">
    <dt><?php echo $form->labelEx($model, 'cat_id'); ?></dt>
    <dd>
        <?php
        echo $form->dropDownList($model, 'cat_id',
            // список всех категорий
            Category::getAll(),
            // зн-е по ум-ю
            array('empty' => 'Выберите категорию товара'));
        ?>
    </dd>
    <dt><?php echo $form->error($model, 'cat_id'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'title'); ?></dt>
    <dd><?php echo $form->textField($model, 'title', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'title'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'alias'); ?></dt>
    <dd><?php echo $form->textField($model, 'alias', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'alias'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'price'); ?></dt>
    <dd><?php echo $form->textField($model, 'price', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'price'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'old_price'); ?></dt>
    <dd><?php echo $form->textField($model, 'old_price', array('class' => 'inputbox')); ?></dd>
    <dt><?php echo $form->error($model, 'old_price'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'status'); ?></dt>
    <dd><?php echo $form->dropDownList($model, 'status', array('1' => 'да', '0' => 'нет')); ?></dd>
    <dt><?php echo $form->error($model, 'status'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'state'); ?></dt>
    <dd><?php echo $form->dropDownList($model, 'state', array('simple' => 'простой', 'hit' => 'хит', 'discount' => 'скидка', 'bestprice' => 'супер цена', 'new' => 'новинка')); ?></dd>
    <dt><?php echo $form->error($model, 'state'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'stock'); ?></dt>
    <dd><?php echo $form->textField($model, 'stock'); ?></dd>
    <dt><?php echo $form->error($model, 'stock'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'note'); ?></dt>
    <dd><?php echo $form->textArea($model, 'note'); ?></dd>
    <dt><?php echo $form->error($model, 'note'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'text'); ?></dt>
    <dd><?php echo $form->textArea($model, 'text'); ?></dd>
    <dt><?php echo $form->error($model, 'text'); ?></dt>

    <dt><?php echo $form->labelEx($model, 'created_at'); ?></dt>
    <dd><?php echo $form->textField($model, 'created_at', array('class' => 'inputbox', 'style' => 'width: 200px')); ?></dd>
    <dt><?php echo $form->error($model, 'created_at'); ?></dt>

    <?php if ($model->isNewRecord == false): ?>
        <dt><?php echo $form->labelEx($model, 'views'); ?></dt>
        <dd><?php echo $form->textField($model, 'views', array('class' => 'inputbox', 'style' => 'width: 100px')); ?></dd>
        <dt><?php echo $form->error($model, 'views'); ?></dt>
    <?php endif; ?>
</dl>

<div class="sub-page-title">
    <h2 class="title">SEO-блок</h2><a href="#" id="seoToggle">скрыть</a>
    <div style="clear: both;"></div>
</div>
<dl class="edit-page" id="seo">
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
                            <td><img src="/images/product/<?php echo $model->id; ?>/150_original.<?php echo $model->image; ?>" class="thumbImg" /></td>
                            <td>
                                <p>150_original.<?php echo $model->image; ?></p>
                                <p><a href="#" id="deleteImg" class="del" productId="<?php echo CHtml::encode($model->id); ?>">удалить</a></p>
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
            <td class="l"><a href="<?php echo Yii::app()->createUrl('admin/product'); ?>">Закрыть без сохранения</a></td>
            <td class="r"><?php echo CHtml::submitButton('Сохранить изменения'); ?></td>
        </tr>
    </table>
</div>
<?php $this->endWidget(); ?>
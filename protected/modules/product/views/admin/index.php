<div class="page-title">
    <h2 class="title_with_button">Товары&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2>
    <span class="grenn-button"><b class="l"></b><a href="<?php echo Yii::app()->createUrl('admin/product/create'); ?>">+ добавить</a><b class="r"></b></span>
    <a href="<?php echo Yii::app()->createUrl('admin/category'); ?>" style="position: relative; top: 9px; right: 256px;">категории товаров</a>
    <div style="float: right;">
        <?php
        $form = $this->beginWidget('CActiveForm', array('method' => 'post', 'action' => '/admin/product/search'));
        echo $form->textField($model, 'title') . '&nbsp;&nbsp;';
        echo $form->dropDownList($model, 'cat_id', Category::getAll(), array('empty' => '')) . '&nbsp;&nbsp;';
        echo CHtml::submitButton('поиск');
        $this->endWidget();
        ?>
    </div>
    <div style="clear: both;"></div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.r input[type=submit]').live('click', function(e){
            var status = '', status2 = '';
            jQuery(':checkbox:checked').each(function(){
                status += jQuery(this).parent('td').parent('tr').attr('class') + '=1,';
            });
            jQuery(':checkbox:not(:checked)').each(function(){
                status2 += jQuery(this).parent('td').parent('tr').attr('class') + '=0,';
            });
            jQuery.ajax({
                type: 'GET',
                url: '/product/admin/config',
                data: 'status=' + status + '&status2='+status2,
                success: function(){
                    alert('изменения успешно сохранены!');
                }
            });
            e.preventDefault();
        });
        // отметить и снять выд-е всех checkbox
        jQuery('.selectedAllDiv').live('click', function() {
            jQuery('.selectedAllDiv').toggle(function() {
                jQuery('.status').each(function() {
                    jQuery(this).attr('checked', true);
                });
                jQuery(this).text('снять выделение');
            }, function(){
                jQuery('.status').each(function(){
                    jQuery(this).attr('checked', false);
                });
                jQuery(this).text('выделить все');
            }).trigger('click');
        });
    });
</script>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'product-grid',
    'dataProvider' => $model->search(),
    'enablePagination' => true, // + передать постр-ю навигацию в методе search модели
    'columns' => array(
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}{update}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("admin/product/delete/$data->id")',
                    'label' => 'удалить товар',
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/gridview/delete.png',
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("admin/product/$data->id")',
                    'label' => 'редактировать товар',
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/gridview/update.png',
                )
            ),
        ),
        array(
            'name' => 'created_at',
            'header' => 'дата создания',
            'value' => 'Helper::ruDate($data->created_at)',
            'htmlOptions' => array("width" => "200px"),
        ),
        'title',
        array(
            'name' => '',
            'value' => 'CHtml::checkBox("status[]", $data->status, array("value" => $data->id, "class" => "status"))',
            'type' => 'raw',
            'header' => 'Вывод на сайте',
            'htmlOptions' => array('width' => 5),
        ),
    ),
    'cssFile' => '/css/gridview/styles.css',
    'rowCssClassExpression' => '$data->id'
));
?>
<span class="selectedAllDiv">выделить все</span>
<div class="clearboth"></div>
<div class="button-box">
    <table class="field-statistics">
        <tr>
            <td class="l">
            </td>
            <td class="r"><?php echo CHtml::submitButton('Сохранить изменения'); ?></td>
        </tr>
    </table>
</div>
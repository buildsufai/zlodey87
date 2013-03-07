<div class="page-title">
    <h2 class="title_with_button">Подсказки</h2>
    <span class="grenn-button"><b class="l"></b><a href="<?php echo Yii::app()->createUrl('admin/hint/create'); ?>">+ добавить</a><b class="r"></b></span>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'hint-grid',
    'dataProvider' => $model->search(),
    'enablePagination' => true, // + передать постр-ю навигацию в методе search модели
    'columns' => array(
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}{update}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("admin/hint/delete/$data->id")',
                    'label' => 'удалить товар',
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/gridview/delete.png',
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("admin/hint/$data->id")',
                    'label' => 'редактировать товар',
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/gridview/update.png',
                )
            ),
        ),
        array(
            'name' => 'q',
            'header' => 'Не понятный термин',
            'value' => '$data->q',
            'htmlOptions' => array("width" => "200px")
        ),
        array(
            'name' => 'hint',
            'header' => 'Подсказка',
            'value' => '$data->hint'
        )
    ),
    'cssFile' => '/css/gridview/styles.css',
    'rowCssClassExpression' => '$data->id'
));
?>
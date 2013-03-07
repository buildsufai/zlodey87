<div class="category-title">
    <h2 class="title_with_button">Словоформы</h2>
    <span class="grenn-button"><b class="l"></b><a href="<?php echo Yii::app()->createUrl('admin/wordform/create'); ?>">+ добавить</a><b class="r"></b></span>
    <div style="clear: both;"></div>
</div>
    <?php 
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'wordform',
    'dataProvider' => $wordforms->getWordforms(),
    'columns' => array(
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}{update}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("admin/wordform/delete/{$data["id"]}")',
                    'label' => 'удалить товар',
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/gridview/delete.png',
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("admin/wordform/{$data["id"]}")',
                    'label' => 'редактировать товар',
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/gridview/update.png',
                )
            ),
        ),
        array(
            'name' => 'id',
            'header' => 'ID',
            'value' => '$data["id"]',
            'htmlOptions' => array("width" => "100px"),
        ),
        array(
            'name' => 'bw',
            'header' => 'не правильный вариант',
            'value' => '$data["bw"]',
        ),
        array(
            'name' => 'rw',
            'header' => 'правильный вариант',
            'value' => '$data["rw"]',
        ),
    ),
    'cssFile' => '/css/gridview/styles.css',
    'rowCssClassExpression' => '$data["id"]'
));
?>
<?php
if(UserModule::isAdmin()) {
	$this->layout='//layouts/puzzleAdmin';
//	$this->menu=array(
//	    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
//	    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
//	);
}
?>
<div class="page-title">
    <h2 class="title_with_button">Пользователи</h2>
    <span class="grenn-button"><b class="l"></b><a href="<?php echo Yii::app()->createUrl('admin/user/create'); ?>">+ добавить</a><b class="r"></b></span>
</div>

<?php 
//$this->widget('zii.widgets.grid.CGridView', array(
//	'dataProvider'=>$dataProvider,
//	'columns'=>array(
//		array(
//			'name' => 'username',
//			'type'=>'raw',
//			'value' => 'CHtml::link(CHtml::encode($data->username),array("/admin/user/$data->id"))',
//		),
//		'create_at',
//		'lastvisit_at',
//	),
//)); 
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}{update}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("admin/user/delete/$data->id")',
                    'label' => 'удалить категорию',
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/gridview/delete.png',
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("admin/user/$data->id")',
                    'label' => 'редактировать категорию',
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/gridview/update.png',
                )
            ),
        ),
		array(
			'name' => 'username',
			'value' => '$data->username',
		),
    ),
    'cssFile' => '/css/gridview/styles.css'
));
?>
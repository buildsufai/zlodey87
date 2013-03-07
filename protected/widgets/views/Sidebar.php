<div class="box search">
    <h2>Поиск <span></span></h2>
    <div class="box-content">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => '/',
            'id' => 'searchForm',
            'enableAjaxValidation' => false,
            ));
        ?>
            <label><?php echo $form->labelEx($searchForm, 'title'); ?></label>
            <?php echo $form->textField($searchForm, 'title', array('class' => 'field')); ?>
            <?php echo $form->error($searchForm, 'title'); ?>
            <div class='s_e' style="display: none;">минимум 3 символа!!!</div>
            <label><?php echo $form->labelEx($searchForm, 'catId'); ?></label>
            <?php
            echo $form->dropDownList($searchForm, 'catId', Category::getAll(), array('empty' => '-- Выберите категорию товара --', 'class' => 'field')); ?>
            <?php echo $form->error($searchForm, 'catId'); ?>
            <div class="inline-field">
                <label><?php echo $form->labelEx($searchForm, 'prF'); ?></label>
                <?php echo $form->textField($searchForm, 'prF', array('class' => 'small-field', 'onkeyup' => 'digInput(this);')); ?>
                <?php echo $form->error($searchForm, 'prF'); ?>
                <label><?php echo $form->labelEx($searchForm, 'prT'); ?></label>
                <?php echo $form->textField($searchForm, 'prT', array('class' => 'small-field', 'onkeyup' => 'digInput(this);')); ?>
                <?php echo $form->error($searchForm, 'prT'); ?>
            </div>
            <div class='s_e2' style="display: none;">первая цена не может быть равной или превышать вторую!!!</div>
            <?php echo CHtml::submitButton('Поиск', array('class'=>'search-submit')); ?>
            <p><a href="#" class="bul">Расширенный поиск</a><br /></p>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php if (count($itemsByParent)) : ?>
    <div class="box categories">
        <h2>Категории товаров<span></span></h2>
        <div class="box-content">
            <ul>
                <?php Helper::printCatListF($itemsByParent); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
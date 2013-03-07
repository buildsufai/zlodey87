<?php if($this->beginCache('mainMenu' . Yii::app()->language, array('duration' => 300))) : ?>
    <h1 id="logo" <?php if (Yii::app()->language == 'en') { ?> style="width: 391px; text-indent: 20px;" <?php } ?>>
        <a href="<?php echo Yii::app()->createUrl('index/index/index'); ?>">
            <?php echo Yii::t('header', 'INTERNET MAGAZIN'); ?>
        </a>
    </h1>
    <div id="navigation">
        <ul>
            <li>
                <a href="<?php echo Yii::app()->createUrl('support'); ?>" <?php if ($_SERVER['REQUEST_URI'] == Yii::app()->createUrl('support')) { echo ' class = "active" '; } ?>>
                    <?php echo Yii::t('header', 'Support'); ?>
                </a>
            </li>
            <li>
                <a href="#">
                    <?php echo Yii::t('header', 'My profile'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl('category/index/index/alias/all/page/1'); ?>" <?php if ($_SERVER['REQUEST_URI'] == Yii::app()->createUrl('category/index/index/alias/all/page/1')) { echo ' class = "active" '; } ?>>
                    <?php echo Yii::t('header', 'Catalog'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl('contacts/contacts/index'); ?>" <?php if ($_SERVER['REQUEST_URI'] == Yii::app()->createUrl('contacts/contacts/index')) { echo ' class = "active" '; } ?>>
                    <?php echo Yii::t('header', 'Contacts'); ?>
                </a>
            </li>
        </ul>
    </div>
<?php $this->endCache(); ?>
<?php endif; ?>
<div id="cart">
    <a href="#" class="cart-link"><?php echo Yii::t('header', 'Your cart'); ?></a>
    <div class="cl">&nbsp;</div>
    <span><?php echo Yii::t('header', 'Products'); ?>: <strong>4</strong></span>
    &nbsp;&nbsp;
    <span><?php echo Yii::t('header', 'Total'); ?>: <strong>$250.99</strong></span>
</div>
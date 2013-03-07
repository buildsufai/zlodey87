<div id="language-select">
<?php foreach($languages as $key => $lang) : ?>
    <?php if($key != $currentLang) : ?>
        <?php echo CHtml::link( '<img src="/images/flags/'.$key.'.png" title="'.$lang.'" />', 
                     $this->getOwner()->createMultilanguageReturnUrl($key)); ?>
    <?php endif; ?>
<?php endforeach; ?>
</div>
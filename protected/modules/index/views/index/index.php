<?php if ($ci > 0) : ?>
    <div id="slider" class="box">
        <div class="hit" title="Хит продаж Интернет Магазина!!!"></div>
        <div id="slider-holder">
            <ul>
                <?php foreach ($items as $item) : ?>
                    <li>
                        <a href="<?php $item->getUrl(); ?>">
                            <img src="<?php $item->getImage(720, 252); ?>" alt="<?php $item->getTitle(); ?>" />
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div id="slider-nav">
            <?php for ($i = 1; $i <= $ci; ++$i) : ?>
                <?php if ($i == 1) : ?>
                    <a href="#" class="active"><?php echo $i; ?></a>
                <?php else : ?>
                    <a href="#"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
<?php endif; ?>
<?php if ($ck > 0) : ?>
    <div class="products">
        <div class="cl">&nbsp;</div>
        <ul>
            <?php $k = 1; ?>
            <?php foreach ($items2 as $item2) : ?>
                <li<?php if ($k % 3 == 0) { echo ' class="last"'; } ?>>
                    <div class="bestprice" title="Скидка от Интернет Магазина!!!"></div>
                    <a href="<?php $item2->getUrl(); ?>"><img src="<?php $item2->getImage(231, 383); ?>" alt="<?php $item2->getTitle(); ?>" /></a>
                    <div class="product-info">
                        <h3><?php $item2->getTitle(); ?></h3>
                        <div class="product-desc">
                            <?php $item2->getNote(); ?>
                            <?php if (!empty($item2->old_price)) : ?>
                                <strong class="oldprice"><?php $item2->getOldPrice(); ?></strong>
                            <?php endif; ?>
                            <strong class="price"><?php $item2->getPrice(); ?></strong>
                        </div>
                    </div>
                </li>
                <?php ++$k; ?>
            <?php endforeach; ?>
        </ul>
        <div class="cl">&nbsp;</div>
    </div>
<?php endif; ?>
 <?php if ($count): ?>
    <div class="products">
        <div class="cl">&nbsp;</div>
        <ul>
            <?php $i = 1; ?>
            <?php foreach ($products as $product) : ?>
                <li<?php if ($i % 3 == 0) { echo ' class="last"'; } ?>>
                    <div class="bestprice" title="Скидка от Интернет Магазина!!!"></div>
                    <a href="<?php $product->getUrl(); ?>"><img src="<?php $product->getImage(231, 383); ?>" alt="<?php $product->getTitle(); ?>" /></a>
                    <div class="product-info">
                        <h3><?php $product->getTitle(); ?></h3>
                        <div class="product-desc">
                            <?php $product->getNote(); ?>
                            <?php if (!empty($product->old_price)) : ?>
                                <strong class="oldprice"><?php $product->getOldPrice(); ?></strong>
                            <?php endif; ?>
                            <strong class="price"><?php $product->getPrice(); ?></strong>
                        </div>
                    </div>
                </li>
                <?php ++$i; ?>
            <?php endforeach; ?>
        </ul>
        <div class="cl">&nbsp;</div>
    </div>
    <div class="pagination">
        <?php
        $this->widget('CLinkPager', array(
            'pages' => $pages,
            'header' => '',
            'prevPageLabel' => 'Предыдущая страница',
            'nextPageLabel' => 'Следующая страница',
            'cssFile' => false
        ));
        ?>
    </div>
    <?php if ($alias != 'all') : ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('.box.categories ul li a[href$=<?php echo $alias; ?>]').parent('li').addClass('active');
                jQuery('.pagination ul li a').each(function(){
                    var val = jQuery(this).attr('href');
                    jQuery(this).attr('href', val.replace('/catalog/<?php echo $alias; ?>?page=', '/catalog/<?php echo $alias; ?>/page/'));
                });
            });
        </script>
    <?php else : ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('.pagination ul li a').each(function(){
                    var val = jQuery(this).attr('href');
                    jQuery(this).attr('href', val.replace('/catalog/all?page=', '/catalog/page/'));
                    var val = jQuery(this).attr('href');
                    jQuery(this).attr('href', val.replace('/all', ''));
                });
            });
        </script>
    <?php endif; ?>
<?php else: ?>
    нет товаров в данной категории
<?php endif; ?>
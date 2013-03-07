<h1><?php $product->getTitle('replace'); ?></h1>
<div><?php $product->getText('replace'); ?></div>
<div>Количество просмотров: <?php $product->realViews($product['id']); ?></div>
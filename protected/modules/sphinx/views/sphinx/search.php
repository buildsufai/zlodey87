<script type="text/javascript">
    jQuery(document).ready(function() {
        var regExpr = /%25/gi;
       jQuery('.yiiPager li a').each(function() {
          var href = jQuery(this).attr('href'); 
          jQuery(this).attr('href', href.replace(regExpr, '%'));
       });
    });
</script>
<h3 class="sQ"">Поиск по запросу: <?php echo $q; ?></h3>
<div class="matches">
    <span>Найдено:</span> <?php echo $matches . ' совпадени' . Helper::ruEnding($matches, 'е', 'я', 'й'); ?>
</div>
<?php $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $data,
        'itemView' => '_view',
        //'template'=>'{pager}<br />{items}<br />{pager}',
        'sortableAttributes'=>array('t', 'price'), 
        'template' => '{pager} {sorter} {items} {sorter} {pager}',
        'ajaxUpdate' => true,
        'enableHistory' => true,
        'id' => 'pages_list',
)); ?>
<div class="page-title">
    <h2 class="title_with_button">Записи</h2>
    <span class="grenn-button"><b class="l"></b><a href="<?php echo Yii::app()->createUrl('admin/page/create'); ?>">+ добавить</a><b class="r"></b></span>
    <div style="float: right;">
        <?php
        $form = $this->beginWidget('CActiveForm', array('method' => 'post', 'action' => '/admin/page/search'));
        echo $form->textField($model, 'title') . '&nbsp;&nbsp;';
        echo CHtml::submitButton('поиск');
        $this->endWidget();
        ?>
    </div>
    <div style="clear: both;"></div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.page-title input[type=submit]').live('click', function(e){
            jQuery.ajax({
                type: 'GET',
                url: '/admin/page/search',
                data: 'q=' + jQuery('#Page_title').val(),
                success: function(response){
                    eval(response);
                }
            });
            e.preventDefault();
        });
        jQuery('.delete img').hover(function() 
        { 
            jQuery(this).attr('src', '/css/gridview/delete2.png');
        }, 
        function() 
        { 
            jQuery(this).attr('src', '/css/gridview/delete.png');
        });
        jQuery('.update img').hover(function() 
        { 
            jQuery(this).attr('src', '/css/gridview/update2.png');
        }, 
        function() 
        { 
            jQuery(this).attr('src', '/css/gridview/update.png');
        });
        jQuery('.del img').hover(function() 
        { 
            jQuery(this).attr('src', '/css/gridview/del_red.gif');
        }, 
        function() 
        { 
            jQuery(this).attr('src', '/css/gridview/del.gif');
        });
        jQuery('.subcat img').hover(function() 
        { 
            jQuery(this).attr('src', '/css/gridview/subcat2.png');
        }, 
        function() 
        { 
            jQuery(this).attr('src', '/css/gridview/subcat.png');
        });
        
        jQuery('.r input[type=submit]').live('click', function(e){
            var menu = '', menu2 = '', sort = '';
            jQuery(':checkbox:checked').each(function(){
                menu += jQuery(this).attr('id') + '=1,';
            });
            jQuery(':checkbox:not(:checked)').each(function(){
                menu2 += jQuery(this).attr('id') + '=0,';
            });
            jQuery('.sort').each(function(){
                sort += jQuery(this).attr('id') + '=' + jQuery(this).val() + ',';
            });
            jQuery.ajax({
                type: 'GET',
                url: '/page/admin/config',
                data: 'menu=' + menu + '&menu2='+menu2 + '&sort='+sort,
                success: function(){
                    alert('изменения успешно сохранены!');
                }
            });
            e.preventDefault();
        });
        // отметить и снять выд-е всех checkbox
        jQuery('.selectedAllDiv').live('click', function() {
            jQuery('.selectedAllDiv').toggle(function() {
                jQuery('.menu').each(function() {
                    jQuery(this).attr('checked', true);
                });
                jQuery(this).text('снять выделение');
            }, function(){
                jQuery('.menu').each(function(){
                    jQuery(this).attr('checked', false);
                });
                jQuery(this).text('выделить все');
            }).trigger('click');
        });
    });
</script>
<table class="list-table">
    <tr>
        <th>&nbsp;</th>
        <th></th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>Сортировка</th>
        <th>Вывод<br />в меню</th>
    </tr>
<?php Helper::printList($itemsByParent); ?>
</table>
<span class="selectedAllDiv">выделить все</span>
<div class="clearboth"></div>
<div class="button-box">
    <table class="field-statistics">
        <tr>
            <td class="l"></td>
            <td class="r"><?php echo CHtml::submitButton('Сохранить изменения'); ?></td>
        </tr>
    </table>
</div>
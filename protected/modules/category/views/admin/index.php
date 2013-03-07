<div class="category-title">
    <h2 class="title_with_button">Категории товаров</h2>
    <span class="grenn-button"><b class="l"></b><a href="<?php echo Yii::app()->createUrl('admin/category/create'); ?>">+ добавить</a><b class="r"></b></span>
    <div style="float: right;">
        <?php
        $form = $this->beginWidget('CActiveForm', array('method' => 'post', 'action' => '/admin/category/search'));
        echo $form->textField($model, 'title') . '&nbsp;&nbsp;';
        echo CHtml::submitButton('поиск');
        $this->endWidget();
        ?>
    </div>
    <div style="clear: both;"></div>
</div>
<?php if (count($itemsByParent)) : ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.category-title input[type=submit]').bind('click', function(e){
                jQuery.ajax({
                    type: 'GET',
                    url: '/admin/category/search',
                    data: 'q=' + jQuery('#Category_title').val(),
                    success: function(response){
                        eval(response);
                        console.log(response);
                    },
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

            jQuery('.button-box input[type=submit]').bind('click', function(e){
                var status = '', status2 = '', sort = '';
                jQuery(':checkbox:checked').each(function(){
                    status += jQuery(this).parent('td').parent('tr').attr('class') + '=1,';
                });
                jQuery(':checkbox:not(:checked)').each(function(){
                    status2 += jQuery(this).parent('td').parent('tr').attr('class') + '=0,';
                });
                jQuery('.sort').each(function(){
                    sort += jQuery(this).parent('td').parent('tr').attr('class') + '=' + jQuery(this).val() + ',';
                });
                jQuery.ajax({
                    type: 'GET',
                    url: '/category/admin/config',
                    data: 'status=' + status + '&status2='+status2 + '&sort='+sort,
                    success: function(){
                        alert('изменения успешно сохранены!');
                    }
                });
                e.preventDefault();
            });
            // отметить и снять выд-е всех checkbox
            jQuery('.selectedAllDiv').live('click', function() {
                jQuery('.selectedAllDiv').toggle(function() {
                    jQuery('.status').each(function() {
                        jQuery(this).attr('checked', true);
                    });
                    jQuery(this).text('снять выделение');
                }, function(){
                    jQuery('.status').each(function(){
                        jQuery(this).attr('checked', false);
                    });
                    jQuery(this).text('выделить все');
                }).trigger('click');
            });
        });
    </script>
    <br />
    <table class="list-table">
        <tr>
            <th>&nbsp;</th>
            <th></th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>Сортировка</th>
            <th>Вывод<br />на сайте</th>
        </tr>
        <?php Helper::printCatList($itemsByParent); ?>
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
<?php else: ?>
    <br /><b>нет записей</b>
<?php endif; ?>

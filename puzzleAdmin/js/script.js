jQuery(document).ready(function(){
    jQuery('#content-grid .summary').remove();
    jQuery('table.items a.delete img').hover(
        function() {
            jQuery(this).attr('src', '/css/gridview/delete2.png');
        },
        function() {
            jQuery(this).attr('src', '/css/gridview/delete.png');
        }
    );
    jQuery('table.items a.update img').hover(
        function() {
            jQuery(this).attr('src', '/css/gridview/update2.png');
        },
        function() {
            jQuery(this).attr('src', '/css/gridview/update.png');
        }
    );
    jQuery('.pager').after('<div class="clearboth"></div>');
    //
    function strpos (haystack, needle, offset) 
    {
        var i = (haystack + '').indexOf(needle, (offset || 0));
        return i === -1 ? false : i;
    }
    jQuery('#wfSubmit').bind('click', function(e){
        var bw = jQuery('#bw').val();
        var rw = jQuery('#rw').val();
        var id = jQuery('#wf').val();
        jQuery.ajax({
            type: 'GET',
            url: '/wordform/admin/ajax',
            data: 'bw=' + bw + '&rw=' + rw + '&id=' + id,
            success: function(response){
                if (strpos(response, 'wordform') > 0) {
                    window.location.href = response;
                } else {
                    jQuery('.s_e').css('display', 'none');
                    eval(response);
                }
            }
        });
        e.preventDefault();
    });
});
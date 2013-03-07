function _init_slider(carousel) {
	$('#slider-nav a').bind('click', function() {
		var index = $(this).parent().find('a').index(this);
		carousel.scroll( index + 1);
		return false;
	});
};

function _active_slide(carousel, item, idx, state) {
	var index = idx-1;
	$('#slider-nav a').removeClass('active');
	$('#slider-nav a').eq(index).addClass('active');
};

function _init_more_products(carousel) {
	$('.more-nav .next').bind('click', function() {
		carousel.next();
		return false;
	});
	
	$('.more-nav .prev').bind('click', function() {
		carousel.prev();
		return false;
	});
};

$(document).ready(function() {
	$("#slider-holder ul").jcarousel({
		scroll: 1,
		auto: 6,
		wrap: 'both',
		initCallback: _init_slider,
		itemFirstInCallback: _active_slide,
		buttonNextHTML: null,
		buttonPrevHTML: null
	});
	
	$(".more-products-holder ul").jcarousel({
		scroll: 2,
		auto: 5,
		wrap: 'both',
		initCallback: _init_more_products,
		buttonNextHTML: null,
		buttonPrevHTML: null
	});
    /**/
    $(".box.categories li:last").addClass('last');
    
    // всплывающие подсказки
    jQuery('.replaceTooltip').tooltip();
    jQuery('.hit').easyTooltip();
    jQuery('.bestprice').easyTooltip({tooltipId: 'easyTooltip2'});
    jQuery('.new').easyTooltip({tooltipId: 'easyTooltip3'});
    jQuery('.discount').easyTooltip({tooltipId: 'easyTooltip4'});
    
    // постр-я навиг-я
    jQuery('.yiiPager li.previous a').addClass('prev');
    jQuery('.yiiPager li.next a').addClass('next');
    jQuery('.yiiPager li.selected a').addClass('active');
    
    // проверка и затем поиск sphinx
    jQuery('.search-submit').bind('click', function(e){
        var title = jQuery('#SearchForm_title').val();
        var catId = jQuery('#SearchForm_catId').val();
        var prF = jQuery('#SearchForm_prF').val();
        var prT = jQuery('#SearchForm_prT').val();
        jQuery.ajax({
            type: 'GET',
            url: '/sphinx/sphinx/ajaxsearch',
            data: 'title=' + title + '&catId=' + catId + '&prF=' + prF + '&prT=' + prT,
            success: function(response){
                // если слэш яв-ся первым символом, то следовательно
                // ошибок нет и происходит перенаправление на стр-у поиска
                if (response.indexOf('/') == 0) {
                    window.location.href = response;
                } else {
                    jQuery('.s_e, .s_e2').css('display', 'none');
                    eval(response);
                }
            }
        });
        e.preventDefault();
    });
    
    /*
     * подсказки в поле поиска - автозавершение с пом-ю ajax и sphinx
     * http://www.devbridge.com/projects/autocomplete/jquery/
     * https://github.com/devbridge/jQuery-Autocomplete
     **/
    jQuery('#SearchForm_title').keyup(function() {
        var catId = jQuery('#SearchForm_catId').val();
        var prF = jQuery('#SearchForm_prF').val();
        var prT = jQuery('#SearchForm_prT').val();
        jQuery(this).autocomplete({
            serviceUrl: '/sphinx/sphinx/ajaxautocomplete',
            minChars: 3,
            width: 300,
            zIndex: 9999,
            deferRequestBy: 0,
            noCache: true,
            params: {catId:catId, prF:prF, prT:prT}
        });
    });
});

// распечатка сод-го эл-та с указ-м в аргументе id
function printContent(id){
    var data = document.getElementById(id).innerHTML;
    var popupWindow = window.open('','printwin',
        'left=100,top=100,width=400,height=400');
    popupWindow.document.write('<HTML>\n<HEAD>\n');
    popupWindow.document.write('<TITLE></TITLE>\n');
    popupWindow.document.write('<URL></URL>\n');
    popupWindow.document.write("<link href='/css/ncMedia.css' media='print' rel='stylesheet' type='text/css' />\n");
    popupWindow.document.write("<link href='/css/nc.css' media='screen' rel='stylesheet' type='text/css' />\n");
    popupWindow.document.write('<script>\n');
    popupWindow.document.write('function print_win(){\n');
    popupWindow.document.write('\nwindow.print();\n');
    popupWindow.document.write('\nwindow.close();\n');
    popupWindow.document.write('}\n');
    popupWindow.document.write('<\/script>\n');
    popupWindow.document.write('</HEAD>\n');
    popupWindow.document.write('<BODY onload="print_win()">\n');
    popupWindow.document.write(data);
    popupWindow.document.write('</BODY>\n');
    popupWindow.document.write('</HTML>\n');
    popupWindow.document.close();
}

$(function () {
    // распечатать счет для оплаты при клике
    $('.ncPrintA').bind('click', function() {
        printContent('ncPrint');
    });
});

// разрешаются только числа
function digInput(input) {
    $(input).val($(input).val().replace(/[^\d,]/g, ''));
}
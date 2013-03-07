<div id="ncPrint">
    <div class="ncH">
        Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате обязательно,
        в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту прихода денег на р/с
        Поставщика, самовывозом, при наличии доверенности и документов удостоверяющих личность
    </div>
    <b>Образец платежного поручения</b><br />
    <table>
        <tr>
            <td><b>Бенефициар:</b><br /><b>Товарищество с ограниченной ответственностью "Качественные Технологии"</b><br />БИН: 120640013473</td>
            <td style="text-align: center;"><b>ИИК</b><br /><b>KZ289261802164154000</b></td>
            <td style="text-align: center;"><b>Kбе</b><br /><b>17</b></td>
        </tr>
        <tr>
            <td>Банк бенефициара:<br />АО «Казкоммерцбанк» в г. Алматы</td>
            <td style="text-align: center;"><b>БИК</b><br /><b>KZKOKZKX</b></td>
            <td style="text-align: center;"><b>КНП</b><br /><b>710</b></td>
        </tr>
    </table>
    <div class="ncScore">Счет на оплату № <?php echo $score; ?> от <?php echo $date; ?></div>
    <table class="ncTWB">
        <tr>
            <td>Поставщик:</td>
            <td><b>Товарищество с ограниченной ответственностью "Качественные Технологии", БИН: 120640013473,
                    Адрес: Республика Казахстан, г. Алматы, мкр Мамыр, ул. Кассина, д. 14, оф. 11</b></td>
        </tr>
        <tr>
            <td>Покупатель:</td>
            <td><b><?php echo $customer; ?></b></td>
        </tr>
        <tr>
            <td>Основание:</td>
            <td><b>Без договора</b></td>
        </tr>
    </table>
    <table>
        <tr>
            <th>№</th>
            <th>Артикул</th>
            <th>Наименование товаров(работ,услуг)</th>
            <th>Кол-во</th>
            <th>Ед.</th>
            <th>Цена</th>
            <th>Сумма</th>
        </tr>
        {foreach ($items as $item)}
        <tr>
            <td>{$item.id}</td>
            <td>{$item.artikul}</td>
            <td>{$item.name}</td>
            <td>{$item.count}</td>
            <td>шт.</td>
            <td>{$item.price}</td>
            <td>{$item.summa}</td>
        </tr>
        {/foreach}
    </table>
    <div class="ncSumma">Итого: <?php echo $price; ?></div>
    Всего <?php echo $itemsCount; ?>, на сумму <?php echo $price; ?> KZT<br />
    <b><?php echo $summa; ?></b><br />
    <div class="ncF">
        <b>Исполнитель</b>
        <span></span> /Администратор/
    </div>
</div>
<a href="#" class="ncPrintA" title="распечатать"><img src="/images/printer.png"></a>
<a href="#" title="pdf file"><img src="/images/pdf.png"></a>
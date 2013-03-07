<div class="side-full">
    <?php if ($ci > 0) : ?>
        <div class="more-products">
            <div class="more-products-holder">
                <ul>
                    <?php $last = ''; $i = 1; ?>
                    <?php foreach ($items as $item) : ?>
                        <li>
                            <a href="<?php $item->getUrl(); ?>">
                                <img src="<?php $item->getImage(94, 94); ?>" alt="<?php $item->getTitle(); ?>" />
                            </a>
                            <div class="<?php $item->getState(); ?>" title="<?php echo ($item->getState('r') == 'new') ? 'Новинка' : 'Скидка'; ?> Интернет Магазина!!!"></div>
                        </li>
                        <?php if ($i == 7) { $last .= '<li class="last"><a href="' . $item->getUrl('r') . '"><img src="' . $item->getImage(94, 94, 'r') . '" alt="' . $item->getTitle('r') . '" /></a></li>'; } ?>
                        <?php ++$i; ?>
                    <?php endforeach; ?>
                    <?php echo $last; ?>
                </ul>
            </div>
            <div class="more-nav">
                <a href="#" class="prev">previous</a>
                <a href="#" class="next">next</a>
            </div>
        </div>
    <?php endif; ?>
    <!-- Text Cols -->
    <div class="cols">
        <div class="cl">&nbsp;</div>
        <div class="col">
            <h3 class="ico ico1">Donec imperdiet</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec imperdiet, metus ac cursus auctor, arcu felis ornare dui.</p>
            <p class="more"><a href="#" class="bul">Lorem ipsum</a></p>
        </div>
        <div class="col">
            <h3 class="ico ico2">Donec imperdiet</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec imperdiet, metus ac cursus auctor, arcu felis ornare dui.</p>
            <p class="more"><a href="#" class="bul">Lorem ipsum</a></p>
        </div>
        <div class="col">
            <h3 class="ico ico3">Donec imperdiet</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec imperdiet, metus ac cursus auctor, arcu felis ornare dui.</p>
            <p class="more"><a href="#" class="bul">Lorem ipsum</a></p>
        </div>
        <div class="col col-last">
            <h3 class="ico ico4">Donec imperdiet</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec imperdiet, metus ac cursus auctor, arcu felis ornare dui.</p>
            <p class="more"><a href="#" class="bul">Lorem ipsum</a></p>
        </div>
        <div class="cl">&nbsp;</div>
    </div>
    <!-- End Text Cols -->
</div>
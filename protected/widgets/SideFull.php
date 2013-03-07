<?php

class SideFull extends CWidget
{

    public function run()
    {
        $items = array();
        $products = Product::getAll();
        $i = 0;
        foreach ($products as $product) {
            if ($product['state'] == 'discount' || $product['state'] == 'new') {
                $items[] = $product;
                ++$i;
            }
        }
        $this->render('SideFull', array('items' => $items, 'ci' => $i));
    }

}

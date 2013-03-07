<?php

class Sidebar extends CWidget
{

    public function run()
    {
        $searchForm = new SearchForm;
        $categories = Category::getAll2();
        $itemsByParent = Helper::getItemsByParent($categories);       
        $this->render('Sidebar', array('itemsByParent' => $itemsByParent, 'searchForm' => $searchForm));
    }

}

<?php
$categories = array(
    1 => array('id' => 1, 'name' => 'name1', 'parent_id' => 0, 'catalogs' => array(
            0 => array('id' => 2, 'name' => 'name2', 'parent_id' => 1, 'catalogs' => array(
                    'id' => 3, 'name' => 'name3', 'parent_id' => 2, 'catalogs' => null),
                1 => array('id' => 4, 'name' => 'name4', 'parent_id' => 1, 'catalogs' => null))
        )
    ),
    2 => array('id' => 5, 'name' => 'name5', 'parent_id' => 0, 'catalogs' => array(
            0 => array('id' => 6, 'name' => 'name6', 'parent_id' => 5, 'catalogs' => array(
                    'id' => 7, 'name' => 'name7', 'parent_id' => 6, 'catalogs' => null),
                1 => array('id' => 8, 'name' => 'name8', 'parent_id' => 5, 'catalogs' => null))
        )
    ),
    3 => array('id' => 9, 'name' => 'name9', 'parent_id' => 0, 'catalogs' => null)
);
foreach ($categories as $category) {
    if ($category['parent_id'] == 0) {
        echo 'categories id="' . $category['id'] . '"' . $category['name'] . '<br />';
    } else {
        echo 'categories id="' . $category['id'] . '" parent_id="' . $category['parent_id'] . '"' . $category['name'] . '<br />';
    }
    if (!empty($category['catalogs'])) {
        foreach ($category['catalogs'] as $catalogs) {
            echo 'categories id="' . $catalogs['id'] . '" parent_id="' . $catalogs['parent_id'] . '"' . $catalogs['name'] . '<br />';
        }
    }
}
echo '<br /><br />';
$recArray = new RecursiveIteratorIterator(new RecursiveArrayIterator($categories));
foreach ($recArray as $key => $value) {
    echo $key . ' — ' . $value . "<br />";
}
Helper::dbg($categories);
?>
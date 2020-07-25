<?php

if (Request::isPost()) {
    $category = Category::getDataFromPost();
    $inserted = Category::add($category);

    if ($inserted) {
        Response::redirect('/categories/list');
    } else {
        die("some insert error");
    }
}

$smarty->display('categories/add.tpl');
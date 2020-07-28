<?php

use App\ProductImage;
use App\Request;

$productImageId = Request::getIntFromPost('product_image_id', false);

if (!$productImageId) {
    die("error with id");
}

$deleted = ProductImage::deleteById($productImageId);
die('ok');

//if ($deleted) {
//    Response::redirect('/products/list');
//} else {
//    die("some error with delete row");
//}


/**
 * Нам нужно поле по которому мы идентифицируем удаляемую запись
 * Отправим запрос на удаление
 * Сделаем редирект на главную
 */
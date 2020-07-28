<?php

use App\Product;
use App\Request;
use App\Response;

$id = Request::getIntFromPost('id', false);

if (!$id) {
    die("Error with id");
}

$deleted = Product::deleteById($id);

if ($deleted) {
    Response::redirect('/products/list');
} else {
    die("some error with delete row");
}


/**
 * Нам нужно поле по которому мы идентифицируем удаляемую запись
 * Отправим запрос на удаление
 * Сделаем редирект на главную
 */
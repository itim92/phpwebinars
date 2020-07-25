<?php

$category_id = Request::getIntFromPost('id');

if (!$productId) {
    die("Error with id");
}

$deleted = Category::deleteById($productId);

if ($deleted) {
    Response::redirect('/categories/list');
} else {
    die("some error with delete row");
}


/**
 * Нам нужно поле по которому мы идентифицируем удаляемую запись
 * Отправим запрос на удаление
 * Сделаем редирект на главную
 */
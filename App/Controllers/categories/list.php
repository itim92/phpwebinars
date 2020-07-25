<?php

$categories = Category::getList();

$smarty->assign('categories', $categories);
$smarty->display('categories/index.tpl');

/**
 * Холодильники
 * Телевизоры
 * Стиральные машины
 * Пылесосы
 * Кондиционеры
 * Духовые шкафы
 * Микроволновые печи
 * Утюги
 */
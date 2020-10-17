<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Каталог товаров</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>

<div class="container site-wrapper">
    <div class="header">
        <div class="row">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link" href="/products/">Товары</a></li>
                <li class="nav-item"><a class="nav-link" href="/categories/">Категории</a></li>
                <li class="nav-item"><a class="nav-link" href="/import/index">Импорт товаров</a></li>
                <li class="nav-item">
                    {if $user}
                        <span class="nav-link">{$user.name}</span>
                        {else}
                        <a class="nav-link" href="/user/register">Регистрация</a>
                    {/if}
                </li>
            </ul>
        </div>
    </div>


    <div class="row">
        <div class="col-3">
            <form method="post" action="/user/login">
                <div class="form-group">
                    <label for="userEmail">Email:</label>
                    <input type="email" name="email" class="form-control" id="userEmail">
                </div>
                <div class="form-group">
                    <label for="userPassword">Пароль</label>
                    <input type="password" name="password" class="form-control" id="userPassword">
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>

            <nav class="nav flex-column nav-pills">
                {foreach from=$categories_shared item=category}
                <a class="nav-link {if $current_category.id == $category.id} active{/if}" href="/categories/view?id={$category.id}">{$category.name}</a>
                {/foreach}
            </nav>
        </div>
        <div class="col-9">
            <div class="content">
                {if $h1}<h1>{$h1}</h1>{/if}
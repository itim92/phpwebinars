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
            </ul>
        </div>
    </div>


    <div class="row">
        <div class="col-3">
            <nav class="nav flex-column nav-pills">
                <a class="nav-link active" href="#">Категория 1</a>
                <a class="nav-link" href="#">Категория 2</a>
                <a class="nav-link" href="#">Категория 3</a>
            </nav>
        </div>
        <div class="col-9">
            <div class="content">
            {if $h1}<h1>{$h1}</h1>{/if}

                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>First</th>
                        <th>Last</th>
                        <th width="1">Handle</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th>3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">Редактировать</a>
                            <form action="#" class="d-inline">
                                <input type="hidden" name="">
                                <button class="btn btn-danger btn-sm">Удалить</button>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>


</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>
{include file="header.tpl" h1=$current_category.name}
{*<p>*}
{*    <a href="/products/add">Добавить</a>*}
{*</p>*}
<p>
<table class="table">
    <thead class="thead-light">
    <tr>
        <th>#</th>
        <th>Название товара</th>
        <th>Категория</th>
        <th>Артикул</th>
        <th>Цена</th>
        <th>Количество на складе</th>
        <th width="1">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$products item=product}
        <tr>
            <td>{$product.id}</td>
            <td width="200">{$product.name}</td>
            <td>{$product.category_name}</td>
            <td>{$product.article}</td>
            <td>{$product.price}</td>
            <td>{$product.amount}</td>
            <td class="nobr">
                <a href='/products/edit?id={$product.id}' class="btn btn-primary btn-sm">Ред</a>
                <form action="/products/delete" method="post" class="d-inline"><input type="hidden" name="id" value="{$product.id}"><input type="submit" value="Уд" class="btn btn-danger btn-sm"></form>
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>
</p>

{include file="bottom.tpl"}

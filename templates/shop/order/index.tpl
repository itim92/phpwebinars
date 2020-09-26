{include file="header.tpl" h1="Список заказов"}
<p><a href='/order/create' class="btn btn-success btn-sm">Создать заказ</a></p>
<p>
<table class="table">
    <thead class="thead-light">
    <tr>
        <th>#</th>
        <th>Дата создания</th>
        <th>Сумма заказа</th>
        <th width="1"></th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$orders item=order}
        <tr>
            <td>{$order.id}</td>
            <td>{$order.createdAt}</td>
            <td>{$order.totalSum}</td>
            <td class="nobr">
                <a href='/order/view/{$order.id}' class="btn btn-primary btn-sm">Подробнее</a>
                <form action="/order/delete" method="post" class="d-inline"><input type="hidden" name="id" value="{$order.id}"><input type="submit" value="Уд" class="btn btn-danger btn-sm"></form>
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>
</p>

{include file="bottom.tpl"}

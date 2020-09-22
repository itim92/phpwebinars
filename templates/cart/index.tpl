{include file="header.tpl" h1="Корзина"}
<p>
<table class="table">
    <thead class="thead-light">
    <tr>
        <th>#</th>
        <th>Название</th>
        <th>Цена</th>
        <th>Кол-во</th>
        <th>Сумма</th>
        <th width="1"></th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$cart->getItems() item=cartItem}
        <tr>
            {assign var=product value=$cartItem->getProductModel()}
            <td>{$product->getId()}</td>
            <td>{$product->getName()}</td>
            <td>{$product->getPrice()}</td>
            <td>{$cartItem->getAmount()}</td>
            <td>{$cartItem->getTotal()}</td>
            <td class="nobr">
                <form action="/cart/product/delete" method="post" class="d-inline"><input type="hidden" name="id" value="{$product->getId()}"><input type="submit" value="Уд" class="btn btn-danger btn-sm"></form>
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>
</p>

{include file="bottom.tpl"}

{include file="header.tpl" h1="Список товаров"}
    <p>
        <a href="/products/add">Добавить</a>
    </p>
    <p>
        <nav>
            <ul class="pagination">
                {section loop=$pages_count name=pagination}
                    <li class="page-item {if $smarty.get.p == $smarty.section.pagination.iteration}active{/if}"><a class="page-link" href="{$smarty.server.PATH_INFO}?p={$smarty.section.pagination.iteration}">{$smarty.section.pagination.iteration}</a></li>
                {/section}
            </ul>
        </nav>
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
            <td width="200">
                {$product.name}
                {if $product.images}
                <br>
                {foreach from=$product.images item=image}
                    <img width="30" src="{$image.path}" alt="{$image.name}">
                {/foreach}
                {/if}
            </td>
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

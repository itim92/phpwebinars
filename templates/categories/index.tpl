{include file="header.tpl" h1="Список категорий"}
    <p>
        <a href="/categories/add">Добавить</a>
    </p>
    <p>
    <table class="table">
       <thead class="thead-light">
       <tr>
           <th>#</th>
           <th>Название категории</th>
           <th width="1"></th>
       </tr>
       </thead>
        <tbody>
        {foreach from=$categories item=category}
        <tr>
            <td>{$category.id}</td>
            <td>{$category.name}</td>
            <td class="nobr">
                <a href='/categories/edit?id={$category.id}' class="btn btn-primary btn-sm">Ред</a>
                <form action="/categories/delete" method="post" class="d-inline"><input type="hidden" name="id" value="{$category.id}"><input type="submit" value="Уд" class="btn btn-danger btn-sm"></form>
            </td>
        </tr>
        {/foreach}
        </tbody>
    </table>
    </p>

{include file="bottom.tpl"}

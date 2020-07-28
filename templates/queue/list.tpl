{include file="header.tpl" h1="Список задач"}
<p>
<table class="table">
    <thead class="thead-light">
    <tr>
        <th>#</th>
        <th>Название</th>
        <th>Статус</th>
        <th width="1"></th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$tasks item=task}
        <tr>
            <td>{$task.id}</td>
            <td>{$task.name}</td>
            <td>{$task.status}</td>
            <td class="nobr">
                <a href='/queue/run?id={$task.id}' class="btn btn-primary btn-sm">Зап</a>
                <form action="/queue/delete" method="post" class="d-inline"><input type="hidden" name="id" value="{$task.id}"><input type="submit" value="Уд" class="btn btn-danger btn-sm"></form>
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>
</p>

{include file="bottom.tpl"}

{include file="header.tpl" h1="Загрузка файла импорта"}

<p>
<form method="post" class="form f400p" enctype="multipart/form-data" action="/import/upload">
    <div class="form-group">
        <label>Файл импорта (csv):</label>
        <input class="form-control" multiple type="file" name="import_file">
    </div>
    <button class="btn btn-primary" type="submit">{$submit_name|default:'Импортировать'}</button>
</form>
</p>


{include file="bottom.tpl"}

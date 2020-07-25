<form method="post" class="form f400p">
    <input type="hidden" name="id" value="{$category.id}">
    <div class="form-group">
        <label>Название категории:</label>
        <input class="form-control" type="text" name="name" required value="{$category.name}">
    </div>
    <button class="btn btn-primary" type="submit">{$submit_name|default:'Сохранить'}</button>
</form>


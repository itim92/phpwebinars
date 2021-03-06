<form method="post" class="form f400p" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{$product->getId()}">
    <div class="form-group">
        <label>Название товара:</label>
        <input class="form-control" type="text" name="name" required value="{$product->getName()}">
    </div>
    <div class="form-group">
        <label>Категория товара:</label>
        <select name="category_id" class="form-control">
            <option value="0">Не выбрано</option>

            {assign var=productCategory value=$product->getCategory()}
            {foreach from=$categories item=category}
                <option {if $productCategory->getId() == $category.id}selected{/if}
                        value="{$category.id}">{$category.name}</option>
            {/foreach}
        </select>
        {*            <input type="text" name="name" required value="{$product.name}">*}
    </div>
    <div class="form-group">
        <label>Ссылка на изображение:</label>
        <input class="form-control" type="text" name="image_url">
    </div>
    <div class="form-group">
        <label>Фото товара:</label>
        <input class="form-control" multiple type="file" name="images[]">
    </div>
    {if $product->getImages()}
        <div class="form-group d-flex">
            {foreach from=$product->getImages() item=image}
            <div class="card" style="width: 90px;">
                <div class="card-body">
                    <button class="btn btn-danger btn-sm" data-image-id="{$image->getId()}"  onclick="return deleteImage(this)">Удалить</button>

{*                    <form action="/products/delete_image" method="POST">*}
{*                        <input type="hidden" name="product_image_id" value="{$image.id}">*}
{*                    </form>*}
                </div>
                <img src="{$image->getPath()}" class="card-img-top" alt="{$image->getName()}">
            </div>
            {/foreach}
        </div>
    {literal}
        <script>
            function deleteImage(button) {
                let imageId = $(button).attr('data-image-id');
                imageId = parseInt(imageId);

                if (!imageId) {
                    alert('Проблема с image_id');
                    return false;
                }

                let url = '/products/delete_image'

                const formData = new FormData();
                formData.append('product_image_id', imageId);

                fetch(url, {
                    method: 'POST',
                    body: formData
                })
                .then((response) => {
                    response.text()
                    .then((text) => {
                        if (text.indexOf('error') > -1) {
                            alert('Ошибка при удалении');
                        } else {
                            document.location.reload();
                        }
                    })
                });

                return false;
            }
        </script>
    {/literal}
    {/if}
    <div class="form-group">
        <label>Артикул:</label>
        <input class="form-control" type="text" name="article" required value="{$product->getArticle()}">
    </div>
    <div class="form-group">
        <label>Цена:</label>
        <input class="form-control" type="number" name="price" required value="{$product->getPrice()}">
    </div>
    <div class="form-group">
        <label>Количество на складе:</label>
        <input class="form-control" type="number" name="amount" required value="{$product->getAmount()}">
    </div>
    <div class="form-group">
        <label>Описание:</label>
        <textarea class="form-control" name="description" rows="6">{$product->getDescription()}</textarea>
    </div>
    <button class="btn btn-primary" type="submit">{$submit_name|default:'Сохранить'}</button>
</form>

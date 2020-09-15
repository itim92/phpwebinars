{include file="header.tpl" h1="Регистрация пользователя"}

<p>
{if $error.message}
<div class="alert alert-danger" role="alert">{$error.message}</div>
{/if}
<form action="" method="post">
    <div class="form-group">
        <label for="user-name">Имя</label>
        <input name="name" {if $smarty.post.name}value="{$smarty.post.name}"{/if} type="text" class="form-control {if $error.requiredFields.name}is-invalid{/if}" id="user-name" placeholder="Введите ваше имя">
        {if $error.requiredFields.name}<div class="invalid-feedback">Заполните обязательное поле</div>{/if}
    </div>
    <div class="form-group">
        <label for="user-email">Email</label>
        <input name="email" {if $smarty.post.email}value="{$smarty.post.email}"{/if} type="email" class="form-control {if $error.requiredFields.email}is-invalid{/if}" id="user-email" placeholder="name@example.com">
        {if $error.requiredFields.email}<div class="invalid-feedback">Заполните обязательное поле</div>{/if}
    </div>
    <div class="form-group">
        <label for="user-password">Пароль</label>
        <input name="password" type="password" class="form-control {if $error.requiredFields.password}is-invalid{/if}" id="user-password" placeholder="Введите пароль">
        {if $error.requiredFields.password}<div class="invalid-feedback">Заполните обязательное поле</div>{/if}
    </div>
    <div class="form-group">
        <label for="user-password-repeat">Повторите пароль</label>
        <input name="passwordRepeat" type="password" class="form-control {if $error.requiredFields.passwordRepeat}is-invalid{/if}" id="user-password-repeat" placeholder="Введите пароль повторно">
        {if $error.requiredFields.passwordRepeat}<div class="invalid-feedback">Заполните обязательное поле</div>{/if}
    </div>
{*    <div class="form-group form-check">*}
{*        <input type="checkbox" class="form-check-input" id="user-agree">*}
{*        <label class="form-check-label" for="user-agree">Согласен на обработку персональных данных</label>*}
{*    </div>*}
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>
</p>

{include file="bottom.tpl"}

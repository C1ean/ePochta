<form method="post">
    <div class="col-md-9">
        <div class="bg-light">
            <div class="form-group">
                <label>Код подтверждения</label>
                <input type="text" class="form-control" name="ep_validation_code" value="[[+extended.nickname]]"
                       placeholder="Проверочный код"/>
                <span class="help-inline message color-red">[[+error_nickname]]</span>
                <br/>
                <small>Как правило, смс приходит не позднее,чем через 15 минут с момента отправки сообщения.</small>
            </div>

            <div class="row margin-bottom-10">
                <div class="col-md-10">
                    <button type="submit" class="btn btn-primary" name="ep_action" value="phone/check">Получить код
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<form method="post">
    <div class="col-md-9">
        <div class="bg-light">
            <div class="form-group">
                <label>Номер телефона</label>
                <input type="text" class="form-control" name="ep_mobile_phone" id="mobile_phone" value="[[+extended.nickname]]"
                       placeholder="Номер в международном формате"/>
                <span class="help-inline message color-red">[[+error_nickname]]</span>
                <br/>
                <small>Полный номер телефона,например +79601234567</small>
            </div>

            <div class="row margin-bottom-10">
                <div class="col-md-10">
                    <button type="submit" class="btn btn-primary" name="ep_action" value="phone/validate">Получить код
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
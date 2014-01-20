<div id="phone_check">

<div id="get_phone">
<form  id="get-phone-form" action="" method="post">
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
                        <input type="button" class="btn btn-primary" value="Выслать код" onclick="ePochta.phone.sendcode(this.form, this);return false;" />

                </div>
            </div>
        </div>
    </div>
</form>
</div>

<div id="check_code">
    <form method="post">
        <div class="col-md-9">
            <div class="bg-light">
                <div class="form-group">
                    <label>Код подтверждения</label>
                    <input type="text" class="form-control" name="ep_user_code" value="[[+extended.nickname]]"
                           placeholder="Проверочный код"/>
                    <span class="help-inline message color-red">[[+error_nickname]]</span>
                    <br/>
                    <small>Как правило, смс приходит не позднее,чем через 15 минут с момента отправки сообщения.</small>
                </div>

                <div class="row margin-bottom-10">
                    <div class="col-md-10">

                        <input type="button" class="btn btn-primary" value="Подтвердить код" onclick="ePochta.phone.checkcode(this.form, this);return false;" />

                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
</div>
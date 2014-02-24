var ePochta = {
    initialize: function () {

        if (typeof window['prettyPrint'] != 'function') {
            document.write('<script src="' + ePochtaConfig.jsUrl + 'lib/prettify/prettify.js"><\/script>');
            document.write('<link href="' + ePochtaConfig.jsUrl + 'lib/prettify/prettify.css" rel="stylesheet">');
        }
        if (!jQuery().ajaxForm) {
            document.write('<script src="' + ePochtaConfig.jsUrl + 'lib/jquery.form.min.js"><\/script>');
        }
        if (!jQuery().jGrowl) {
            document.write('<script src="' + ePochtaConfig.jsUrl + 'lib/jquery.jgrowl.min.js"><\/script>');
        }

        $(document).ready(function () {
            ePochta.utils.clear();
            ePochta.phone.needphone();
        });


    }, phone: {
        needphone: function () {
            $('#phone_check').ajaxSubmit({
                data: {action: 'phone/needphone'}, url: ePochtaConfig.actionUrl, dataType: 'json', success: function (response) {
                    ePochta.utils.clear();

                    if (response.success) {


                        clearInterval(window.timer);

                        var form = $('#check_code');

                        var time_left = $('.time', form);
                        time_left.text('');

                        form.append();
                        $('#check_retry', form).hide();
                        form.show();

                        var time = response.data.timeout;
                        window.timer = setInterval(function () {
                            if (time > 0) {
                                time -= 1;
                                time_left.text(ePochta.utils.timer(time));
                            }
                            else {
                                clearInterval(window.timer);
                                time_left.text('');
                                $('#check_retry', form).show();


                            }
                        }, 1000);


                    }
                    else {
                        $('#get_phone').show();
                    }
                }
            });
            return false;
        },


        sendcode: function (form, button) {
            $(form).ajaxSubmit({

                data: {action: 'phone/sendcode'}, url: ePochtaConfig.actionUrl, form: form, button: button, dataType: 'json', beforeSubmit: function () {

                    $('#check_retry', form).hide();

                    var phone = $('#mobile_phone').val().replace(/\s+/g, '');
                    if (phone == '') {
                        return false;
                    }
                    else {
                        $(button).attr('disabled', 'disabled');
                        return true;
                    }
                }, success: function (response) {
                    $(button).removeAttr('disabled');
                    if (response.success) {

                        ePochta.utils.clear();

                        ePochta.phone.needphone();
                        ePochta.Message.success(response.message);

                    }
                    else {
                        ePochta.Message.error(response.message);
                    }
                }
            });
            return true;
        },

        checkcode: function (form, button) {
            $(form).ajaxSubmit({
                data: {action: 'phone/checkcode'}, url: ePochtaConfig.actionUrl, form: form, button: button, dataType: 'json', success: function (response) {

                    if (response.success) {
                        $(button).attr('disabled', 'disabled');
                        ePochta.Message.success(response.message);


                        setTimeout(function () {
                            if (response.data.redirect) {
                                document.location.href = response.data.redirect;
                            }
                            else {
                                location.reload();
                            }
                        }, 1000);

                    }
                    else {
                        ePochta.Message.error(response.message);
                    }
                }
            });
            return false;
        }



    }, utils: {
        timer: function (diff) {
            days = Math.floor(diff / (60 * 60 * 24));
            hours = Math.floor(diff / (60 * 60));
            mins = Math.floor(diff / (60));
            secs = Math.floor(diff);

            dd = days;
            hh = hours - days * 24;
            mm = mins - hours * 60;
            ss = secs - mins * 60;

            var result = [];

            if (hh > 0) result.push(hh ? this.addzero(hh) : '00');
            result.push(mm ? this.addzero(mm) : '00');
            result.push(ss ? this.addzero(ss) : '00');

            return result.join(':');
        }, addzero: function (n) {
            return (n < 10) ? '0' + n : n;
        }, clear: function () {
            $('#check_code').hide();
            $('#get_phone').hide();

        }
    }



};


ePochta.Message = {
    success: function (message) {
        if (message) {
            $.jGrowl(message, {theme: 'ep-message-success'});
        }
    }, error: function (message) {
        if (message) {
            $.jGrowl(message, {theme: 'ep-message-error'/*, sticky: true*/});
        }
    }, info: function (message) {
        if (message) {
            $.jGrowl(message, {theme: 'ep-message-info'});
        }
    }, close: function () {
        $.jGrowl('close');
    }
};

ePochta.initialize();
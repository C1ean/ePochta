var ePochta = {
    initialize: function() {

        if (typeof window['prettyPrint'] != 'function') {
            document.write('<script src="'+ePochtaConfig.jsUrl+'lib/prettify/prettify.js"><\/script>');
            document.write('<link href="'+ePochtaConfig.jsUrl+'lib/prettify/prettify.css" rel="stylesheet">');
        }
        if(!jQuery().ajaxForm) {
            document.write('<script src="'+ePochtaConfig.jsUrl+'lib/jquery.form.min.js"><\/script>');
        }
        if(!jQuery().jGrowl) {
            document.write('<script src="'+ePochtaConfig.jsUrl+'lib/jquery.jgrowl.min.js"><\/script>');
        }

        $(document).ready(function() {
            $('#check_code').hide();
        });


        $(document).on('submit', '#phone_check', function() {
            ePochta.phone.sendcode(this, $(this).find('[type="submit"]')[0]);
            return false;
        });

    }

    ,phone: {
       sendcode: function(form,button)  {
           $(form).ajaxSubmit({
               data: {action: 'phone/sendcode'}
               ,url: ePochtaConfig.actionUrl
               ,form: form
               ,button: button
               ,dataType: 'json'
               ,beforeSubmit: function() {
                   var phone = $('#mobile_phone').val().replace(/\s+/g, '');
                   if (phone == '') {return false;}
                   else {
                       $(button).attr('disabled','disabled');
                       return true;
                   }
               }
               ,success: function(response) {
                   $(button).removeAttr('disabled');
                   if (response.success) {

                       var form = $('#check_code');
                       $('#get_phone').hide();

                       form.show();

                   }
                   else {
                       ePochta.Message.error(response.message);
                   }
               }
           });
           return false;
       },

        checkcode: function(form,button)  {
            $(form).ajaxSubmit({
                data: {action: 'phone/checkcode'}
                ,url: ePochtaConfig.actionUrl
                ,form: form
                ,button: button
                ,dataType: 'json'
                ,beforeSubmit: function() {
                    var phone = $('#mobile_phone').val().replace(/\s+/g, '');
                    if (phone == '') {return false;}
                    else {
                        $(button).attr('disabled','disabled');
                        return true;
                    }
                }
                ,success: function(response) {
                    $(button).removeAttr('disabled');
                    if (response.success) {

                        var form = $('#check_code');

                        form.hide();

                    }
                    else {
                        ePochta.Message.error(response.message);
                    }
                }
            });
            return false;
        }





    }
};


ePochta.Message = {
    success: function(message) {
        if (message) {
            $.jGrowl(message, {theme: 'tickets-message-success'});
        }
    }
    ,error: function(message) {
        if (message) {
            $.jGrowl(message, {theme: 'tickets-message-error'/*, sticky: true*/});
        }
    }
    ,info: function(message) {
        if (message) {
            $.jGrowl(message, {theme: 'tickets-message-info'});
        }
    }
    ,close: function() {
        $.jGrowl('close');
    }
};

ePochta.initialize();
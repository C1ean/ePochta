<?php


$_lang['area_epochta_setting'] = 'Сервис EPochta';


//service settings
$_lang['setting_epochta_sms_key_private']  = 'Приватный ключ';
$_lang['setting_epochta_sms_key_private_desc']  = 'Выдается в личном кабинете на закладке API v.3';

$_lang['setting_epochta_sms_key_public']  ='Публичный ключ';
$_lang['setting_epochta_sms_key_public_desc']  ='Выдается в личном кабинете на закладке APIV v.3';

$_lang['setting_epochta_url_gateway']  ='URL сервиса';
$_lang['setting_epochta_url_gateway_desc']  ='Хост сервера для приема\отправки сообщений';

$_lang['setting_epochta_test_mode'] ='Режим тестирования';
$_lang['setting_epochta_test_mode_desc'] ='При тестировании СМС не отправляются а помещаются в очередь отправки с статусом не отправлен.';


$_lang['setting_epochta_sms_identy']='От кого СМС';
$_lang['setting_epochta_sms_identy_desc'] ='Идентификатор отправителя СМС (номер или лат. слово до 11 букв)';


$_lang['setting_epochta_sms_lifetime']='Время жизни СМС';
$_lang['setting_epochta_sms_lifetime_desc'] ='Время жизни смс (0 = максимум, 1, 6, 12, 24 часа)';



//local component settings

$_lang['area_epochta_component'] = 'Настройки компонента';


$_lang['setting_epochta_ep_sms_timeout']='Таймаут отправки СМС';
$_lang['setting_epochta_ep_sms_timeout_desc']='Таймаут отправки СМС для одного юзера, в секундах.(По умолчанию 900)';

$_lang['setting_epochta_ep_sms_codelifetime']='Время жизни СМС-кода';
$_lang['setting_epochta_ep_sms_codelifetime_desc'] = 'Параметр выставляет, как долго будет жить отпралвенный,но еще не подтвержденный SMS код пользователя, в секундах. (По умолчанию 1800)';

$_lang['setting_epochta_ep_sms_check_redirect'] ='ID переадресации';
$_lang['setting_epochta_ep_sms_check_redirect_desc']='ID страницы с переадресацией,в случае успешного прохождения пользователем проверки телефона.(По умолчанию 0-обновить текущую)';


$_lang['setting_epochta_ep_sms_code_symbols']='Символы SMS кода';
$_lang['setting_epochta_ep_sms_code_symbols_desc']='Одномерный JSON массив, с перечислением символов,которые будут использоваться для генерации SMS кода.(По умолчангию - английский алфавит и цифры)';


$_lang['setting_epochta_ep_sms_code_length']='Длина кода';
$_lang['setting_epochta_ep_sms_code_length_desc']='Длина кода, отправляемого пользователю по SMS.(По умолчанию 6)';

<?php

/*
 * ,'sms_key_private' => $this->modx->getOption('epochta_sms_key_private', null, '') //private key
            ,'sms_key_public' => $this->modx->getOption('epochta_sms_key_public', null, '') //public  key
            ,'url_gateway' => $this->modx->getOption('epochta_url_gateway', null, 'http://atompark.com/api/sms/') //service addr
            ,'test_mode' => $this->modx->getOption('epochta_test_mode', null, true) //is a test or prod
            ,'sms_datetime' => $this->modx->getOption('epochta_sms_datetime', null, null) //datetime for send in future
            ,'sms_lifetime' => $this->modx->getOption('epochta_sms_lifetime', null, 0) //life time of SMS

 */

$_lang['area_epochta_main'] = 'Основные';

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


$_lang['setting_epochta_sms_lifetimee']='Время жизни СМС';
$_lang['setting_epochta_sms_lifetime_desc'] ='Время жизни смс (0 = максимум, 1, 6, 12, 24 часа)';


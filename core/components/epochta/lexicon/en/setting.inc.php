<?php


$_lang['area_epochta_setting'] = 'Service EPochta';


//service settings
$_lang['setting_epochta_sms_key_private']  = 'Private Key';
$_lang['setting_epochta_sms_key_private_desc']  = 'Get it  in personal space in API v.3';

$_lang['setting_epochta_sms_key_public']  ='Public key';
$_lang['setting_epochta_sms_key_public_desc']  ='Get it  in personal space in API v.3';

$_lang['setting_epochta_url_gateway']  ='Service URL';
$_lang['setting_epochta_url_gateway_desc']  ='Host URL for transfer sms';

$_lang['setting_epochta_test_mode'] ='Testing mode';
$_lang['setting_epochta_test_mode_desc'] ='Dont delivery SMS for users';


$_lang['setting_epochta_sms_identy']='Identifier';
$_lang['setting_epochta_sms_identy_desc'] ='Identifier of sender';


$_lang['setting_epochta_sms_lifetime']='SMS LifeTime';
$_lang['setting_epochta_sms_lifetime_desc'] ='SMS LifeTime(0 = max, 1, 6, 12, 24 hours)';



//local component settings

$_lang['area_epochta_component'] = 'Component settings';


$_lang['setting_epochta_ep_sms_timeout']='SMS timeout';
$_lang['setting_epochta_ep_sms_timeout_desc']='Sms one-by-one timeout. (in sec. 900 default)';

$_lang['setting_epochta_ep_sms_codelifetime']='Code lifetime';
$_lang['setting_epochta_ep_sms_codelifetime_desc'] = 'Code lifetime before change.(in sec. 1800 default)';

$_lang['setting_epochta_ep_sms_check_redirect'] ='ID redirect';
$_lang['setting_epochta_ep_sms_check_redirect_desc']='ID for page redirect while successful change code (default 0 -refresh self)';


$_lang['setting_epochta_ep_sms_code_symbols']='Code symbols';
$_lang['setting_epochta_ep_sms_code_symbols_desc']='JSON symbols array for generating code';


$_lang['setting_epochta_ep_sms_code_length']='Code length';
$_lang['setting_epochta_ep_sms_code_length_desc']='Length of code. (default 6 chars)';

<?php


$settings = array();

$tmp = array(
    'sms_key_private' => array(
        'xtype' => 'text-password',
        'value' => '',
        'area' => 'epochta_setting',
    ),

    'sms_key_public' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'epochta_setting',
    ),

    'url_gateway' => array(
        'xtype' => 'textfield',
        'value' => 'http://atompark.com/api/sms/',
        'area' => 'epochta_setting',
    ),


	'test_mode' => array(
		'xtype' => 'combo-boolean',
		'value' => true,
		'area' => 'epochta_setting',
	),

    'sms_identy' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'epochta_setting',
    ),


    'sms_lifetime' => array(
        'xtype' => 'numberfield',
        'value' => '0',
        'area' => 'epochta_setting',
    ),


    'ep_sms_timeout' => array(
    'xtype' => 'numberfield',
    'value' => '900',
    'area' => 'epochta_component',
    ),

    'ep_sms_codelifetime' => array(
    'xtype' => 'numberfield',
    'value' => '1800',
    'area' => 'epochta_component',
    ),



    'ep_sms_check_redirect' => array(
    'xtype' => 'numberfield',
    'value' => '0',
    'area' => 'epochta_component',
    ),

    'ep_sms_code_symbols' => array(
        'xtype' => 'textfield',
        'value' => '["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","r","s","t","u","v","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","R","S","T","U","V","X","Y","Z","1","2","3","4","5","6","7","8","9","0"]',
        'area' => 'epochta_component',
    ),

    'ep_sms_code_length' => array(
        'xtype' => 'numberfield',
        'value' => '6',
        'area' => 'epochta_component',
    ),


);

foreach ($tmp as $k => $v) {
	/* @var modSystemSetting $setting */
	$setting = $modx->newObject('modSystemSetting');
	$setting->fromArray(array_merge(
		array(
			'key' => 'epochta_'.$k,
			'namespace' => PKG_NAME_LOWER,
		), $v
	),'',true,true);

	$settings[] = $setting;
}

unset($tmp);
return $settings;

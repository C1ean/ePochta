<?php

$properties = array();

$tmp = array(
	'tplCheck' => array(
		'type' => 'textfield',
		'value' => 'tpl.epPhone.check',
	),

    'tplExists' => array(
        'type' => 'textfield',
        'value' => 'tpl.epPhone.phoneExists',
    ),

);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(
		array(
			'name' => $k,
			'desc' => PKG_NAME_LOWER . '_prop_' . $k,
			'lexicon' => PKG_NAME_LOWER . ':properties',
		), $v
	);
}

return $properties;
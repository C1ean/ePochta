<?php

if (empty($_REQUEST['action'])) {
	die('Access denied');
}
else {
	$action = $_REQUEST['action'];
}

define('MODX_API_MODE', true);
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/index.php';

$modx->getService('error','error.modError');
$modx->getRequest();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');
$modx->error->message = null;

$ctx = !empty($_REQUEST['ctx']) ? $_REQUEST['ctx'] : 'web';
if ($ctx != 'web') {$modx->switchContext($ctx);}


/* @var ePochta $ePochta */
define('MODX_ACTION_MODE', true);

$scriptProperties=array();

 $ePochta = $modx->getService('epochta', 'ePochta', $modx->getOption('epochta_core_path', null, $modx->getOption('core_path') . 'components/epochta/') . 'model/epochta/', $scriptProperties);

if ($modx->error->hasError() || !($ePochta instanceof ePochta)) {die('Error');}

switch ($action) {
	case 'phone/sendcode': $response = $ePochta->send_code($_POST); break;
	case 'phone/checkcode': $response =$ePochta->check_code($_POST); break;
    case 'phone/needphone': $response =$ePochta->is_need_phone_enter(); break;

	default:
		$message = $_REQUEST['action'] != $action ? 'epochta_err_register_globals' : 'epochta_err_unknown';
		$response = $modx->toJSON(array('success' => false, 'message' => $modx->lexicon($message)));
}

if (is_array($response)) {
	$response = $modx->toJSON($response);
}

@session_write_close();
exit($response);
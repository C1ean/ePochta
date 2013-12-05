<?php

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('epochta_core_path', null, $modx->getOption('core_path') . 'components/epochta/');
require_once $corePath . 'model/epochta/epochtavalidatenumber.class.php';
$modx->epochta = new ePochta($modx);

$modx->lexicon->load('epochta:default');

/* handle request */
$path = $modx->getOption('processorsPath', $modx->epochta->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path,
	'location' => '',
));
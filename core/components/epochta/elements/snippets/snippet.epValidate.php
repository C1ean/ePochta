<?php

$ePochta = $modx->getService('epochta', 'ePochta', $modx->getOption('epochta_core_path', null, $modx->getOption('core_path') . 'components/epochta/') . 'model/epochta/', $scriptProperties);
$ePochta->initialize($modx->context->key, $scriptProperties);
if (!($ePochta instanceof ePochta)) return '';

/* @var pdoFetch $pdoFetch */
if (!$modx->loadClass('pdofetch', MODX_CORE_PATH . 'components/pdotools/model/pdotools/', false, true)) {
    return false;
}
$pdoFetch = new pdoFetch($modx, $scriptProperties);
$pdoFetch->addTime('pdoTools loaded.');

$output = $pdoFetch->getChunk('tpl.epPhone.check');


if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
    $output .= '<pre class="msOrderLog">' . print_r($pdoFetch->getTime(), 1) . '</pre>';
}

return $output;
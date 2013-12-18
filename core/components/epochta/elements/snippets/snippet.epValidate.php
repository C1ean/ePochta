<?php

$ePochta = $modx->getService('epochta', 'ePochta', $modx->getOption('epochta_core_path', null, $modx->getOption('core_path') . 'components/epochta/') . 'model/epochta/', $scriptProperties);
if (!($ePochta instanceof ePochta)) return '';

/* @var pdoFetch $pdoFetch */
if (!$modx->loadClass('pdofetch', MODX_CORE_PATH . 'components/pdotools/model/pdotools/', false, true)) {
    return false;
}
$pdoFetch = new pdoFetch($modx, $scriptProperties);
$pdoFetch->addTime('pdoTools loaded.');


switch ($_REQUEST['ep_action']) {
    case 'phone/validate':

        $params['phone'] = $_REQUEST['ep_mobile_phone'];
        $response = $ePochta->runProcessor('web/validate/create', $params);
        if ($response->isError()) {
            return $pdoFetch->getChunk('tpl.epPhone.outer', $response->getMessage());
        }
        $output = $pdoFetch->getChunk('tpl.epPhone.validate');
        break;

    case 'phone/check':

        /**
         * @var  $response epValidateNumUpdateProcessor
         */

        $params['user_id']=$modx->user->id;
        $response = $ePochta->runProcessor('web/validate/update',$params);


       if ($response->isError()) {echo $response->getMessage();  }

      $output=$pdoFetch->getChunk('tpl.epPhone.validate',$response->getMessage());

        break;

    default:
        $output = $pdoFetch->getChunk('tpl.epPhone.outer');
        break;
}

if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
    $output .= '<pre class="msOrderLog">' . print_r($pdoFetch->getTime(), 1) . '</pre>';
}

return $output;
<?php
$output="";
//working only with auth users
if ($modx->user->isAuthenticated($modx->context->key)) {
    if ($modx->user->active || !($modx->user->Profile->blocked)) {



        $ePochta = $modx->getService('epochta', 'ePochta', $modx->getOption('epochta_core_path', null, $modx->getOption('core_path') . 'components/epochta/') . 'model/epochta/', $scriptProperties);
        $ePochta->initialize($modx->context->key, $scriptProperties);
        if (!($ePochta instanceof ePochta)) return '';

        /* @var pdoFetch $pdoFetch */
        if (!$modx->loadClass('pdofetch', MODX_CORE_PATH . 'components/pdotools/model/pdotools/', false, true)) {
            return false;
        }
        $pdoFetch = new pdoFetch($modx, $scriptProperties);
        $pdoFetch->addTime('pdoTools loaded.');



        /* prepare settings */
        if (!isset($tplCheck)){ $tplCheck='tpl.epPhone.check'; }
        if (!isset($tplExists)){ $tplExists='tpl.epPhone.exists'; }


        /* If user already have phone nothing to do */

        $profile = $modx->user->getOne('Profile');
        $userPhone=$profile->get('mobilephone');

        if (!empty($userPhone)){
            $output=$pdoFetch->getChunk($tplExists,array('mobilephone'=>$userPhone));
        }
        else
        {
            $output = $pdoFetch->getChunk($tplCheck);
        }

        if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
            $output .= '<pre class="msOrderLog">' . print_r($pdoFetch->getTime(), 1) . '</pre>';
        }
    }
}
return $output;
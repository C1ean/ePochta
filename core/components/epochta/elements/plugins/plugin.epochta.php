<?php

switch ($modx->event->name) {

	case 'OnManagerPageInit':
		$cssFile = MODX_ASSETS_URL.'components/epochta/css/mgr/main.css';
		$modx->regClientCSS($cssFile);
		break;

    case 'OnHandleRequest':
        if (empty($_REQUEST['ep_action'])) {return;}

        $action = trim($_REQUEST['ep_action']);
        $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
        $ctx = !empty($_REQUEST['ctx']) ? $_REQUEST['ctx'] : 'web';
        if ($ctx != 'web') {$modx->switchContext($ctx);}
        /* @var miniShop2 $miniShop2 */
        $ePochta = $modx->getService('epochta','ePochta',$modx->getOption('epochta_core_path',null,$modx->getOption('core_path').'components/epochta/').'model/epochta/',$scriptProperties);
        $ePochta->initialize($ctx, array('json_response' => $isAjax));
        if (($modx->error->hasError() || !($ePochta instanceof ePochta)) && $isAjax) {exit('Could not initialize ePochta!');}

        switch ($action) {
            case 'cart/add': $response = $miniShop2->cart->add(@$_POST['id'], @$_POST['count'], @$_POST['options']); break;
            case 'cart/change': $response = $miniShop2->cart->change(@$_POST['key'], @$_POST['count']); break;

            default:
                $message = ($_REQUEST['ep_action'] != $action)
                    ? 'ms2_err_register_globals'
                    : 'ms2_err_unknown';
                $response = $ePochta->error($message);
        }

        if ($isAjax) {
            @session_write_close();
            exit($response);
        }
        break;


}
<?php

switch ($modx->event->name) {

	case 'OnManagerPageInit':
		$cssFile = MODX_ASSETS_URL.'components/epochta/css/mgr/main.css';
		$modx->regClientCSS($cssFile);
		break;

    case 'OnAfterCodeValidate':
        $profile = $this->modx->user->getOne('Profile');
        $profile->set('phone',$object->data['phone']);
        $profile->save();
        break;


}
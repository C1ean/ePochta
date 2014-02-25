<?php
switch ($modx->event->name) {



    case 'OnAfterCodeValidate':

        $profile = $modx->user->getOne('Profile');
        $profile->set('mobilephone',$object->get('phone'));
        $profile->save();
        break;

    case 'OnBeforePhoneCheck':

        if ($modx->getCount('modUserProfile', array('mobilephone' => $data['phone']))) {
            $modx->event->output('Указанный номер уже был кем-то активирован.Обратитесь к администраторам сайта,если хотите использовать этот номер.');
            return "";
        }

        /** send code with SMS to user */
        $ePochta = $modx->getService('epochta', 'ePochta', $modx->getOption('epochta_core_path', null, $modx->getOption('core_path') . 'components/epochta/') . 'model/epochta/', $scriptProperties);
        $ePochta->initialize($modx->context->key, $scriptProperties);
        if (!($ePochta instanceof ePochta)) exit('Could not initialize ePochta!');

        $message='Код подтверждения:'.$object->get('code');

        if(!($ePochta->sendSMS_now($object->get('phone'), $message, 0)))
            $modx->event->output('Возникла ошибка при отправке SMS на номер  '.$object->get('phone').' Попробуйте повторить попытку позджде,или сообщите администрации сайта о проблеме.');
        return "";

        break;





}
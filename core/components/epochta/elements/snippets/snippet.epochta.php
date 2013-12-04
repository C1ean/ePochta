<?php

$ePochta = $modx->getService('epochta','ePochta',$modx->getOption('epochta_core_path',null,$modx->getOption('core_path').'components/epochta/').'model/epochta/',$scriptProperties);
if (!($ePochta instanceof ePochta)) return '';


if (!($sms=$ePochta->sendSMS_now('+79605183300test','test text',0))) echo "error!";

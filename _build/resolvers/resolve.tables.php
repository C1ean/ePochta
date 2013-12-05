<?php

if ($object->xpdo) {
	/* @var modX $modx */
	$modx =& $object->xpdo;

	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
			$modelPath = $modx->getOption('epochta_core_path',null,$modx->getOption('core_path').'components/epochta/').'model/';
			$modx->addPackage('epochta', $modelPath);

			$manager = $modx->getManager();
			$objects = array(
				'epValidateNum',
			);
			foreach ($objects as $tmp) {
				$manager->createObjectContainer($tmp);
			}
			break;




		case xPDOTransport::ACTION_UNINSTALL:
			break;
	}
}
return true;

<?php
/**
 * Remove an Item
 */
class ePochtaItemRemoveProcessor extends modObjectRemoveProcessor {
	public $checkRemovePermission = true;
	public $objectType = 'ePochtaItem';
	public $classKey = 'ePochtaItem';
	public $languageTopics = array('epochta');

}

return 'ePochtaItemRemoveProcessor';
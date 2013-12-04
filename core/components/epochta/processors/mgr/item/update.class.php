<?php
/**
 * Update an Item
 */
class ePochtaItemUpdateProcessor extends modObjectUpdateProcessor {
	public $objectType = 'ePochtaItem';
	public $classKey = 'ePochtaItem';
	public $languageTopics = array('epochta');
	public $permission = 'update_document';
}

return 'ePochtaItemUpdateProcessor';
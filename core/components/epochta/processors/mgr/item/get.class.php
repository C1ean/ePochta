<?php
/**
 * Get an Item
 */
class ePochtaItemGetProcessor extends modObjectGetProcessor {
	public $objectType = 'ePochtaItem';
	public $classKey = 'ePochtaItem';
	public $languageTopics = array('epochta:default');
}

return 'ePochtaItemGetProcessor';
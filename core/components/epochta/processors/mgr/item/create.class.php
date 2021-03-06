<?php
/**
 * Create an Item
 */
class ePochtaItemCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'ePochtaItem';
	public $classKey = 'ePochtaItem';
	public $languageTopics = array('epochta');
	public $permission = 'new_document';


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$alreadyExists = $this->modx->getObject('ePochtaItem', array(
			'name' => $this->getProperty('name'),
		));
		if ($alreadyExists) {
			$this->modx->error->addField('name', $this->modx->lexicon('epochta_item_err_ae'));
		}

		return !$this->hasErrors();
	}

}

return 'ePochtaItemCreateProcessor';
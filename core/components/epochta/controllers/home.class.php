<?php
/**
 * The home manager controller for ePochta.
 *
 */
class ePochtaHomeManagerController extends ePochtaMainController {
	/* @var ePochta $ePochta */
	public $ePochta;


	/**
	 * @param array $scriptProperties
	 */
	public function process(array $scriptProperties = array()) {
	}


	/**
	 * @return null|string
	 */
	public function getPageTitle() {
		return $this->modx->lexicon('epochta');
	}


	/**
	 * @return void
	 */
	public function loadCustomCssJs() {
		$this->addJavascript($this->ePochta->config['jsUrl'] . 'mgr/widgets/items.grid.js');
		$this->addJavascript($this->ePochta->config['jsUrl'] . 'mgr/widgets/home.panel.js');
		$this->addJavascript($this->ePochta->config['jsUrl'] . 'mgr/sections/home.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			MODx.load({ xtype: "epochta-page-home"});
		});
		</script>');
	}


	/**
	 * @return string
	 */
	public function getTemplateFile() {
		return $this->ePochta->config['templatesPath'] . 'home.tpl';
	}
}
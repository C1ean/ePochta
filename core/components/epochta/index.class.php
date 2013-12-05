<?php

/**
 * Class ePochtaMainController
 */
abstract class ePochtaMainController extends modExtraManagerController {
	/** @var ePochta $ePochta */
	public $ePochta;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('epochta_core_path', null, $this->modx->getOption('core_path') . 'components/epochta/');
		require_once $corePath . 'model/epochta/epochtavalidatenumber.class.php';

		$this->ePochta = new ePochta($this->modx);

		$this->addCss($this->ePochta->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->ePochta->config['jsUrl'] . 'mgr/epochta.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			ePochta.config = ' . $this->modx->toJSON($this->ePochta->config) . ';
			ePochta.config.connector_url = "' . $this->ePochta->config['connectorUrl'] . '";
		});
		</script>');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('epochta:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends ePochtaMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}
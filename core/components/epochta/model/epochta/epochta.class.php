<?php
/**
 * The base class for ePochta.
 */

class ePochta
{

    /* @var modX $modx */
    public $modx;
    /* @var ePochta_APISMS $gateway */
    public $gateway;

    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('epochta_core_path', $config, $this->modx->getOption('core_path') . 'components/epochta/');
        $assetsUrl = $this->modx->getOption('epochta_assets_url', $config, $this->modx->getOption('assets_url') . 'components/epochta/');
        $epLibUrl=$this->modx->getOption('core_path').'components/epochta/model/epochta/lib/';
        $connectorUrl = $assetsUrl . 'connector.php';

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl
        , 'corePath' => $corePath
        ,'processorsPath' => $corePath.'processors/'
        ,'modelPath' => $corePath . 'model/'
        , 'sms_key_private' => $this->modx->getOption('epochta_sms_key_private', null, '') //private key
        , 'sms_key_public' => $this->modx->getOption('epochta_sms_key_public', null, '') //public  key
        , 'url_gateway' => $this->modx->getOption('epochta_url_gateway', null, 'http://atompark.com/api/sms/') //service addr
        , 'test_mode' => $this->modx->getOption('epochta_test_mode', null, true) //is a test or prod
        , 'sms_datetime' => $this->modx->getOption('epochta_sms_datetime', null, null) //datetime for send in future
        , 'sms_identy' => $this->modx->getOption('epochta_sms_identy', null, null) //sender id
        , 'sms_lifetime' => $this->modx->getOption('epochta_sms_lifetime', null, 0) //life time of SMS
        , 'tplSendCode' => $this->modx->getOption('epochta_tpl_send_code', null, 'tpl.epPhone.validate') //life time of SMS



        ), $config);

        $this->modx->addPackage('epochta', $this->config['modelPath']);
        $this->modx->lexicon->load('epochta:default');



        //get class from ePochta API
        require_once $epLibUrl . 'APISMS.php';

         require_once $epLibUrl . 'Stat.php';

        $this->gateway = new ePochta_APISMS($this->config['sms_key_private'], $this->config['sms_key_public'], $this->config['url_gateway']);


        /* init in method of APIs
        $Gateway=new ePochta_APISMS($this->config['sms_key_private'],$this->config['sms_key_public'], $this->config['url_gateway']);
        $Addressbook=new ePochta_Addressbook($Gateway);
        $Exceptions=new ePochta_Exceptions($Gateway);
        $Account=new ePochta_Account($Gateway);
        $Stat = new ePochta_Stat ($Gateway);
        */


    }





    /**
     * Initializes component into different contexts.
     *
     * @param string $ctx The context to load. Defaults to web.
     * @param array $scriptProperties
     *
     * @return boolean
     */
    public function initialize($ctx = 'web', $scriptProperties = array()) {



        $this->modx->regClientStartupScript($this->config['assetsUrl'].'js/web/lib/jquery.min.js');
        $this->modx->regClientStartupScript($this->config['assetsUrl'].'js/web/lib/jquery.form.min.js');
        $this->modx->regClientStartupScript($this->config['assetsUrl'].'js/web/lib/jquery.jgrowl.min.js');
        $this->modx->regClientStartupScript($this->config['assetsUrl'].'js/web/config.js');
        $this->modx->regClientStartupScript($this->config['assetsUrl'].'js/web/default.js');


        return true;
    }






    /**
     * @param $tel
     * @param $text
     * @param $datetime
     * @return bool
     * Send single SMS for user
     */

    public function sendSMS_now($tel, $text, $datetime)
    {
        /** @var ePochta_Stat $stat */
        $stat = new ePochta_Stat ($this->gateway);

        $res = $stat->sendSMS($this->config['sms_identy'], $text, $tel, $datetime, $this->config['sms_lifetime']);

        if (isset($res["error"])) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[ePochta] Error send sms to [' . $tel . '], text [' . $text . ']');
            $this->modx->log(modX::LOG_LEVEL_ERROR, print_r($res, true));
            return false;
        } elseif (isset($res["warnings"])) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[ePochta] Warnings send sms to [' . $tel . '], text [' . $text . ']');
            $this->modx->log(modX::LOG_LEVEL_ERROR, print_r($res, true));
            return true;
        }
         else  {
             $this->modx->log(modX::LOG_LEVEL_ERROR, '[ePochta] Send OK to '.$tel.' : '.print_r($res, true));
                    return true;
         }

    }


    /**
     * @param $phone
     * @return array|string
     */
    public function send_code($data=array())
    {
        $phone=$data['ep_mobile_phone'];


        if (!empty($phone))
            $response = $this->runProcessor('web/validate/create', array('phone'=>$phone));
        else
            return $this->error($this->modx->lexicon('ep_sms_phone_empty'));

        if ($response->isError()){
            return $this->error($response->getMessage());
        }else
        {

            return $this->success($this->modx->lexicon('ep_sms_successful_send_code'), array('phone' => $phone));
        }



    }




    /**
     * @param $phone
     * @return array|string
     */
    public function check_code($data=array())
    {
        $code=$data['ep_user_code'];


        if (!empty($phone))
            $response = $this->runProcessor('web/validate/update', array('user_code'=>$code));
        else
            return $this->error($this->modx->lexicon('ep_check_code_error'));

        if ($response->isError()){
            return $this->error($response->getMessage());
        }else
        {

            return $this->success($this->modx->lexicon('ep_check_code_successful'), array('code' => $code));
        }
    }






        /**
     * Shorthand for the call of processor
     *
     * @access public
     * @param string $action Path to processor
     * @param array $data Data to be transmitted to the processor
     * @return mixed The result of the processor
     */
    public function runProcessor($action = '', $data = array()) {
        if (empty($action)) {return false;}
        return $this->modx->runProcessor($action, $data, array('processors_path' => $this->config['processorsPath']));
    }


    /**
     * Shorthand for original modX::invokeEvent() method with some useful additions.
     *
     * @param $eventName
     * @param array $params
     * @param $glue
     *
     * @return array
     */
    public function invokeEvent($eventName, array $params = array (), $glue = '<br/>') {
        if (isset($this->modx->event->returnedValues)) {
            $this->modx->event->returnedValues = null;
        }

        $response = $this->modx->invokeEvent($eventName, $params);
        if (is_array($response) && count($response) > 1) {
            foreach($response as $k => $v) {
                if (empty($v)) {
                    unset($response[$k]);
                }
            }
        }

        $message = is_array($response) ? implode($glue, $response) : trim((string) $response);
        if (isset($this->modx->event->returnedValues) && is_array($this->modx->event->returnedValues)) {
            $params = array_merge($params, $this->modx->event->returnedValues);
        }

        return array(
            'success' => empty($message)
        ,'message' => $message
        ,'data' => $params
        );
    }




    /**
     * This method returns an error of the order
     *
     * @param string $message A lexicon key for error message
     * @param array $data.Additional data, for example cart status
     * @param array $placeholders Array with placeholders for lexicon entry
     *
     * @return array|string $response
     */
    public function error($message = '', $data = array(), $placeholders = array()) {
        $response = array(
            'success' => false,
            'message' => $this->modx->lexicon($message, $placeholders),
            'data' => $data,
        );

        return $this->config['json_response'] ? $this->modx->toJSON($response) : $response;
    }


    /**
     * This method returns an success of the order
     *
     * @param string $message A lexicon key for success message
     * @param array $data.Additional data, for example cart status
     * @param array $placeholders Array with placeholders for lexicon entry
     *
     * @return array|string $response
     */
    public function success($message = '', $data = array(), $placeholders = array()) {
        $response = array(
            'success' => true,
            'message' => $this->modx->lexicon($message, $placeholders),
            'data' => $data,
        );

        return $this->config['json_response'] ? $this->modx->toJSON($response) : $response;
    }



}
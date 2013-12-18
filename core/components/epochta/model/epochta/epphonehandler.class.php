<?php

interface epPhoneInterface {

    /**
     * Initializes for context
     * Here you can load custom javascript or styles
     *
     * @param string $ctx Context for initialization
     *
     * @return boolean
     */
    public function initialize($ctx = 'web');



    /**
     * Validates field before it set
     *
     * @param string $key The key of the field
     * @param string $value.Value of the field
     *
     * @return boolean|mixed
     */
    public function validate($key, $value);



}


class epPhoneHandler implements epPhoneInterface {
    /** @var modX $modx */
    public $modx;
    /** @var miniShop2 $ms2  */
    public $ms2;
    /** @var array $order */
    protected $order;


    /**
     * @param miniShop2 $ms2
     * @param array $config
     */
    function __construct(miniShop2 & $ms2, array $config = array()) {
        $this->ms2 = & $ms2;
        $this->modx = & $ms2->modx;

        $this->config = array_merge(array(
            'order' => & $_SESSION['minishop2']['order']
        ),$config);

        $this->order = & $this->config['order'];
        $this->modx->lexicon->load('minishop2:order');

        if (empty($this->order) || !is_array($this->order)) {
            $this->order = array();
        }
    }


    /** @inheritdoc} */
    public function initialize($ctx = 'web') {
        return true;
    }



    /** @inheritdoc} */
    public function validate($key, $value) {
        if ($key != 'comment') {
            $value = preg_replace('/\s+/',' ', trim($value));
        }

        $response = $this->ms2->invokeEvent('msOnBeforeValidateOrderValue', array(
            'key' => $key,
            'value' => $value,
        ));
        $value = $response['data']['value'];

        $old_value = isset($this->order[$key]) ? $this->order[$key] : '';
        switch ($key) {
            case 'email':
                $value = preg_match('/^[^@а-яА-Я]+@[^@а-яА-Я]+(?<!\.)\.[^\.а-яА-Я]{2,}$/m', $value)
                    ? $value
                    : false;
                break;
            case 'receiver':
                // Transforms string from "nikolaj -  coster--Waldau jr." to "Nikolaj Coster-Waldau Jr."
                $tmp = preg_replace(array('/[^-a-zа-яёЁ\s\.]/iu', '/\s+/', '/\-+/', '/\.+/'), array('', ' ', '-', '.'), $value);
                $tmp = preg_split('/\s/', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                $tmp = array_map(array($this, 'ucfirst'), $tmp);
                $value = preg_replace('/\s+/', ' ', implode(' ', $tmp));
                if (empty($value)) {$value = false;}
                break;
            case 'phone':
                $value = substr(preg_replace('/[^-+0-9]/iu','',$value),0,15);
                break;
            case 'delivery':
                /* @var msDelivery $delivery */
                if (!$delivery = $this->modx->getObject('msDelivery',array('id' => $value, 'active' => 1))) {
                    $value = $old_value;
                }
                else if (!empty($this->order['payment'])) {
                    if (!$this->hasPayment($value, $this->order['payment'])) {
                        $this->order['payment'] = $delivery->getFirstPayment();
                    };
                }
                break;
            case 'payment':
                if (!empty($this->order['delivery'])) {
                    $value = $this->hasPayment($this->order['delivery'], $value) ? $value : $old_value;
                }
                break;
            case 'index':
                $value = substr(preg_replace('/[^-0-9]/iu', '',$value),0,10);
                break;
        }

        $response = $this->ms2->invokeEvent('msOnValidateOrderValue', array(
            'key' => $key,
            'value' => $value,
        ));
        $value = $response['data']['value'];

        return $value;
    }


    /**
     * Shorthand for MS2 error method
     *
     * @param string $message
     * @param array $data
     * @param array $placeholders
     *
     * @return array|string
     */
    public function error($message = '', $data = array(), $placeholders = array()) {
        return $this->ms2->error($message, $data, $placeholders);
    }


    /**
     * Shorthand for MS2 success method
     *
     * @param string $message
     * @param array $data
     * @param array $placeholders
     *
     * @return array|string
     */
    public function success($message = '', $data = array(), $placeholders = array()) {
        return $this->ms2->success($message, $data, $placeholders);
    }

}
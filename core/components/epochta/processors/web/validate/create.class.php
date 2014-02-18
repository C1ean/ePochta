<?php
class epValidateNumCreateProcessor extends modObjectCreateProcessor
{

    public $object;

    public $classKey = 'epValidateNum';
    public $languageTopics = array('epochta:default');

    public $beforeSaveEvent = 'OnBeforePhoneCheck';
    public $afterSaveEvent = 'OnAfterPhoneCheck';




    /**
     * @param $number
     * @return string
     */
    function gen_code($number)
    {
        //array of code symbols
        $arr = array('a', 'b', 'c', 'd', 'e', 'f',
            'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'o', 'p', 'r', 's',
            't', 'u', 'v', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F',
            'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'R', 'S',
            'T', 'U', 'V', 'X', 'Y', 'Z',
            '1', '2', '3', '4', '5', '6',
            '7', '8', '9', '0', '.', ',',
            '(', ')', '[', ']', '!', '?',
            '&', '^', '%', '@', '*', '$',
            '<', '>', '/', '|', '+', '-',
            '{', '}', '`', '~');

        // generate password
        $code = "";
        for ($i = 0; $i < $number; $i++) {
            // get random index
            $index = rand(0, count($arr) - 1);
            $code .= $arr[$index];
        }
        return $code;
    }

    /**
     * {@inheritDoc}
     * @return boolean|string
     */
    public function initialize()
    {


        $this->setProperties(array(
            'user_id' => $this->modx->user->id
        , 'validate' => 0
        , 'ip' => $this->modx->request->getClientIp()
        , 'createdon' => date('Y-m-d H:i:s')
        , 'updatedon' => date('Y-m-d H:i:s')

        ));
        return parent::initialize();
    }


    public function beforeSet()
    {
        //if phone is not in number then take error
        if (!is_numeric($this->getProperty('phone')))
           return $this->modx->lexicon('ep_phone_is_not_numeric');
        //get system properties
        $timeout = $this->modx->getOption('epochta_ep_sms_timeout', null, 900);
        $codelifetime = $this->modx->getOption('epochta_ep_sms_codelifetime', null, 1800);

        $query = $this->modx->newQuery('epValidateNum');
        /*get row with select all from max row with max createdon  */
        $query->select('id as id,createdon as createdon,code as code,validate as validate');
        $query->limit(1);
        $query->sortby('createdon', 'desc');
        $query->where(array('user_id:=' => $this->getProperty('user_id'),));

        //get data info previous code send for this user
        if ($query->prepare() && $query->stmt->execute()) {
            $data = $query->stmt->fetch(PDO::FETCH_ASSOC);
        }

        //get date diff from current date and created from DB
        $datediff = abs(strtotime($data['createdon']) - strtotime($this->getProperty('createdon')));

        //check timeout behind user|sms
        if ($datediff < $timeout) {
            return  $this->modx->lexicon('ep_sms_timeout_failure');

        }

        //check if we already send code to user, and he doens't validate them
        if (($data['validate'] == 0) and ($datediff < $codelifetime)) {
            //if code is not validate and lifecycle is not end -send old gen. code.
            $this->setProperties(array('code' => $data['code'],));

        } else {
            //generate new code
            $code = $this->gen_code(6);
            $this->setProperties(array('code' => $code,));
        }


        return parent::beforeSave();

    }


    public function afterSave()
    {
        //send sms in code
    //    $this->modx->epochta->sendSMS_now($this->object->get('phone'), $this->object->get('code'), 0);



        return parent::afterSave();
    }
}

return 'epValidateNumCreateProcessor';
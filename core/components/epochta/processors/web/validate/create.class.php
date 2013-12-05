<?php
class ePochtaValidateNumberCreateProcessor extends modObjectCreateProcessor {
    /** @var ePochta $object */
    public $object;

    public $classKey='epValidateNum';




    /**
     * @param $number
     * @return string
     */
    function gen_pass($number)
    {
        //array of passw symbols
        $arr = array('a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0','.',',',
            '(',')','[',']','!','?',
            '&','^','%','@','*','$',
            '<','>','/','|','+','-',
            '{','}','`','~');

        // generate password
        $pass = "";
        for($i = 0; $i < $number; $i++)
        {
            // get random index
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }

    /**
     * {@inheritDoc}
     * @return boolean|string
     */
    public function initialize() {
        $pass=$this->gen_pass(6);

        $this->setProperties(array(
            'user_id' =>$this->modx->user->id
        ,'code' =>$pass
        ,'validate' => 0
        ,'ip' => $this->modx->request->getClientIp()
        ,'createdon' => date('Y-m-d H:i:s')
        ,'updatedon' =>date('Y-m-d H:i:s')

        ));
        return parent::initialize();
    }





    public function afterSave() {

        $this->object->sendSMS_now($this->getProperties('phone'),$this->getProperties(['code']),0);

        return parent::afterSave();
    }
}

return 'ePochtaValidateNumberCreateProcessor';
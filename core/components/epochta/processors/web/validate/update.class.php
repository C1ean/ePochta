<?php

class epValidateNumUpdateProcessor extends modObjectUpdateProcessor {
    public $object;

    public $classKey = 'epValidateNum';
    public $languageTopics = array('epochta:default');

    public $beforeSaveEvent='OnBeforeCodeValidate';
    public $afterSaveEvent = 'OnAfterCodeValidate';

    private  $data;


    public function initialize() {

        $user_code=$this->getProperty('user_code');
        //check if code not empty
        if (empty($user_code)or ($user_code==''))
            return $this->modx->lexicon('ep_sms_code_is_empty');

        $query = $this->modx->newQuery('epValidateNum');
        /*get row with select all from max row with max createdon  */
        $query->select('id as id,createdon as createdon,code as code,validate as validate,phone as phone');
        $query->limit(1);
        $query->sortby('createdon', 'desc');
        $query->where(array('user_id:=' => $this->modx->user->id,));

        //get data array
        if ($query->prepare() && $query->stmt->execute()) {
            $this->data = $query->stmt->fetch(PDO::FETCH_ASSOC);        }
        //check for current code validate status for this user
        if ( $this->data['validate'] == 1)
            return $this->modx->lexicon('ep_sms_validate_already_done');

        //if code is correct - set update time and validate status
        if ($this->data ['code']==$user_code) {
            $this->setProperties(array(
                'validate' => 1,
                'updatedon' =>date('Y-m-d H:i:s'),
                'id' =>$this->data['id'],

            ));
        } else  return  $this->modx->lexicon('ep_sms_check_code_wrong');

        return parent::initialize();

    }





}

return 'epValidateNumUpdateProcessor';
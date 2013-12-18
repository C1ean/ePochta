<?php

class epValidateNumUpdateProcessor extends modObjectUpdateProcessor {
    public $object;

    public $classKey = 'epValidateNum';
    public $languageTopics = array('epochta:default');

    public $beforeSaveEvent = 'OnBeforeSaveEpValidateNum';
    public $afterSaveEvent = 'OnAfterSaveEpValidateNum';

    private  $data;


    public function initialize() {

        $query = $this->modx->newQuery('epValidateNum');
        /*get row with select all from max row with max createdon  */
        $query->select('id as id,createdon as createdon,code as code,validate as validate,phone as phone');
        $query->limit(1);


        $query->sortby('createdon', 'desc');
        $query->where(array('user_id:=' => $this->modx->user->id,));


        if ($query->prepare() && $query->stmt->execute()) {
            $this->data = $query->stmt->fetch(PDO::FETCH_ASSOC);        }


        if ( $this->data['validate'] == 1)
            return $this->failure($this->modx->lexicon('ep_sms_validate_already_done'));


        if ($this->data ['code']==$_REQUEST['ep_validation_code']) {
            $this->setProperties(array(
                'validate' => 1,
                'updatedon' =>date('Y-m-d H:i:s'),
                'id' =>$this->data['id'],

            ));
        } else  return $this->failure($this->modx->lexicon('ep_sms_validate_error_code'));




        return parent::initialize();

    }




    public function afterSave()
    {

        $profile = $this->modx->user->getOne('Profile');
        $profile->set('phone',$this->data['phone']);
        $profile->save();

        return parent::afterSave();

    }

}

return 'epValidateNumUpdateProcessor';
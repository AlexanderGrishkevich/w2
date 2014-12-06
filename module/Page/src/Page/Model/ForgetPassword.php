<?php

namespace Page\Model;

class ForgetPassword {

    public $id;
    public $user_id;
    public $email;
    public $code;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : NULL;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : NULL;
        $this->email = (isset($data['email'])) ? $data['email'] : NULL;
        $this->code = (isset($data['code'])) ? $data['code'] : NULL;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}

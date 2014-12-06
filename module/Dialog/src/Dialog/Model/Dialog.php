<?php

namespace Dialog\Model;

class Dialog {

    public $id;
    public $sender_id;
    public $recipient_id;
    public $text;
    public $create_date;
    public $is_new;
    public $deleted_by_user_id;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->sender_id = (isset($data['sender_id'])) ? $data['sender_id'] : null;
        $this->recipient_id = (isset($data['recipient_id'])) ? $data['recipient_id'] : NULL;
        $this->text = (isset($data['text'])) ? $data['text'] : null;
        $this->create_date = (isset($data['create_date'])) ? $data['create_date'] : NULL;
        $this->is_new = (isset($data['is_new'])) ? $data['is_new'] : NULL;
        $this->deleted_by_user_id = (isset($data['deleted_by_user_id'])) ? $data['deleted_by_user_id'] : NULL;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}

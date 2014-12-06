<?php

namespace Post\Model;

class Like {

    public $id;
    public $user_id;
    public $post_id;

    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->post_id = (!empty($data['post_id'])) ? $data['post_id'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }
}
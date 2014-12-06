<?php

namespace Post\Model;

class Comment {

    public $id;
    public $user_id;
    public $post_id;
    public $text;
    public $date;

    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->post_id = (!empty($data['post_id'])) ? $data['post_id'] : null;
        $this->text = (!empty($data['text'])) ? $data['text'] : null;
        $this->date = (!empty($data['date'])) ? $data['date'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }
}
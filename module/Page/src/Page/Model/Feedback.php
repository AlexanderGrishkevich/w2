<?php

namespace Page\Model;

class Feedback {

	public $id;
	public $username;
	public $userdata;
    public $text;

	public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : NULL;
        $this->username = (isset($data['username'])) ? $data['username'] : NULL;
        $this->userdata = (isset($data['userdata'])) ? $data['userdata'] : NULL;
        $this->text = (isset($data['text'])) ? $data['text'] : NULL;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }
}
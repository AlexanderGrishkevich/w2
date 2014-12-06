<?php

namespace Location\Model;

class Country {

	public $id;
	public $title;

	public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : NULL;
        $this->title = (isset($data['title'])) ? $data['title'] : NULL;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }
}
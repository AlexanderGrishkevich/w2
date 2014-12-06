<?php

namespace Location\Model;

class Region {

	public $id;
	public $title;
	public $country_id;

	public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : NULL;
        $this->title = (isset($data['title'])) ? $data['title'] : NULL;
        $this->country_id = (isset($data['country_id'])) ? $data['country_id'] : NULL;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }
}
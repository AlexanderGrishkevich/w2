<?php

namespace Location\Model;

class City {

	public $id;
	public $title;
	public $region_id;

	public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : NULL;
        $this->title = (isset($data['title'])) ? $data['title'] : NULL;
        $this->region_id = (isset($data['region_id'])) ? $data['region_id'] : NULL;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }
}
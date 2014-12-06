<?php

namespace Banner\Model;

class Banner {

	public $id;
	public $user_id;
	public $banner_url;
	public $discount;	
	public $title;
	public $price;
	public $type;

	public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : NULL;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : NULL;
        $this->banner_url = (isset($data['banner_url'])) ? $data['banner_url'] : NULL;
        $this->discount = (isset($data['discount'])) ? $data['discount'] : NULL;
        $this->title = (isset($data['title'])) ? $data['title'] : NULL;
        $this->price = (isset($data['price'])) ? $data['price'] : NULL;
        $this->type = (isset($data['type'])) ? $data['type'] : NULL;                        
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }
}
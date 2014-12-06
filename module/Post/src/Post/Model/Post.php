<?php

namespace Post\Model;

class Post {
    public $id;
    public $user_id;
    public $title;
    public $text;
    public $price;
    public $chaffer;
    public $tags;
    public $is_active;
    public $create_date;
    public $off_date;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
        $this->text = (!empty($data['text'])) ? $data['text'] : null;
        $this->price = (!empty($data['price'])) ? $data['price'] : null;
        $this->chaffer = (!empty($data['chaffer'])) ? $data['chaffer'] : null;
        $this->tags = (!empty($data['tags'])) ? $data['tags'] : null;
        $this->is_active = (!empty($data['is_active'])) ? $data['is_active'] : null;
        $this->create_date = (!empty($data['create_date'])) ? $data['create_date'] : null;
        $this->off_date = (!empty($data['off_date'])) ? $data['off_date'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
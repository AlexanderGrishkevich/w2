<?php

namespace Post\Model;

class Attachment {

    public $id;
    public $upload_id;
    public $post_id;
    
     public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->upload_id = (!empty($data['upload_id'])) ? $data['upload_id'] : null;
        $this->post_id = (!empty($data['post_id'])) ? $data['post_id'] : null;
        $this->type = (!empty($data['type'])) ? $data['type'] : null;
     }
     
     public function getArrayCopy() {
        return get_object_vars($this);
    }
}
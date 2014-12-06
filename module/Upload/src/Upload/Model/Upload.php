<?php

namespace Upload\Model;

class Upload {

    public $id;
    public $user_id;
    public $filename;
    public $filepath;
    public $full_filename;
    public $type;
    
    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->filename = (!empty($data['filename'])) ? $data['filename'] : null;
        $this->filepath = (!empty($data['filepath'])) ? $data['filepath'] : null;
        $this->full_filename = (!empty($data['full_filename'])) ? $data['full_filename'] : null;
        $this->type = (!empty($data['type'])) ? $data['type'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }
}


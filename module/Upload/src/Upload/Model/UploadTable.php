<?php

namespace Upload\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Expression,
    Zend\Db\Sql\Select;
    

use Upload\Model\Upload;

class UploadTable extends AbstractTableGateway {
    
    protected $table = 'uploads';
    
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Upload());
        $this->initialize();
    }
    
    public function getUploadsByUserId($userId) {
        $userId = (int) $userId;
        $rowset = $this->select(array('user_id' => $userId));
        return $rowset;
    } 
    
    public function getUploadById($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        return $rowset->current();
    }
    
    public function saveUpload(Upload $upload) {
        $data = array(
            'user_id' => $upload->user_id,
            'filename' => $upload->filename,
            'filepath' => $upload->filepath,
            'full_filename' => $upload->full_filename,
            'type' => $upload->type
        );
        $this->insert($data);
        
        $id = $this->lastInsertValue;
        $rowset = $this->select(array('id' => $id));
        return $rowset->current();
    }
    
    public function deleteUpload($id) {
        $this->delete(array('id' => $id));
    }
}
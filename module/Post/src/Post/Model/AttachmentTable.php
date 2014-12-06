<?php

namespace Post\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Expression,
    Zend\Db\Sql\Select;

use Post\Model\Attachment;

class AttachmentTable extends AbstractTableGateway {

    protected $table = 'attachments';
    
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Attachment());
        $this->initialize();
    }

    public function saveAttachment($upload_id, $post_id) {
        $upload_id = (int) $upload_id;
        $post_id = (int) $post_id;
        
        $data = array(
            'upload_id' => $upload_id,
            'post_id' => $post_id,
        );
        $this->insert($data);
    }
    
    public function deleteAttachment($postId, $uploadId) {
        $postId = (int) $postId;
        $uploadId = (int) $uploadId;
        $rowset = $this->delete(array('post_id' => $postId, 'upload_id' => $uploadId));
        return $rowset;
    }
    
    public function deleteAttachmentsByPostId($postId) {
        $postId = (int) $postId;
        $rowset = $this->delete(array('post_id' => $postId));
    }
    
    public function getFiles($postId) {
        $postId = (int) $postId;
        $sql = "SELECT attachments.*, uploads.full_filename FROM attachments LEFT JOIN uploads ON attachments.upload_id = uploads.id WHERE attachments.post_id = $postId";
        $rowset = $this->adapter->query($sql, array());
        return $rowset;
    }
}
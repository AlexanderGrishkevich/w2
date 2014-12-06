<?php

namespace Post\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Expression,
    Zend\Db\Sql\Select;
    

use Post\Model\Comment;

class CommentTable extends AbstractTableGateway{
    
    protected $table = 'comments';
    
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Comment());
        $this->initialize();
    }

    public function fetchAllCommentsByPostId($postId) {
        $sql = "SELECT comments.*,
                users.avatar,
                users.org_name
                FROM `comments` 
                LEFT JOIN users
                ON comments.user_id = users.id  
                WHERE comments.post_id = $postId ";
        $rowset = $this->adapter->query($sql, array());
        return $rowset;
    }

    public function saveComment(Comment $comment) {
        $data = array(
            'user_id' => $comment->user_id,
            'post_id' => $comment->post_id,
            'text' => $comment->text,
            'date' => date("Y-m-d H:i:s")
        );
        $this->insert($data);
    }
    
    public function deleteCommentsByPostId($PostId) {
        
        $this->delete(array('post_id' => $PostId));
    }
}

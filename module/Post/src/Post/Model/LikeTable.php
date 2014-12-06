<?php

namespace Post\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Expression,
    Zend\Db\Sql\Select;

use Post\Model\Like;

class LikeTable extends AbstractTableGateway {
    
    protected $table = 'likes';
    
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Like());
        $this->initialize();
    }

    public function getUserIdWithMaxLikeCount()
    {
        $sql = "SELECT user_id, sum(cnt) from ( SELECT p.user_id, l.post_id, COUNT(l.post_id) AS cnt FROM likes l, posts p WHERE l.post_id = p.id GROUP BY l.post_id ) t GROUP BY user_id LIMIT 1";
        $rowset = $this->adapter->query($sql, array());
        $row = $rowset->current();
        return ($row) ? $row->user_id : null;
    }

    public function countLikes($postId)
    {

        $rowset = $this->select(array('post_id' => $postId));
        return $rowset->count();
    }

    public function likePost($id, $user_id)
    {
        $id = (int) $id;
        $user_id = (int) $user_id;
        $sql = "SELECT COUNT(*) AS countLikes FROM likes WHERE post_id = $id AND user_id = $user_id";
        $rowset = $this->adapter->query($sql, array());
        foreach ($rowset as $like) {
            if ($like->countLikes) {
                $sql = "DELETE FROM likes WHERE post_id = $id AND user_id = $user_id";
                $this->adapter->query($sql, array());
                $like->countLikes--;
            } else {
                $sql = "INSERT INTO likes (post_id, user_id) VALUES ($id, $user_id)";
                $this->adapter->query($sql, array());
                $like->countLikes++;
            }
        }
        return $like->countLikes;
    }
}
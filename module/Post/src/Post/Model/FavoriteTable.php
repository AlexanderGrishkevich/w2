<?php

namespace Post\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Expression,
    Zend\Db\Sql\Select;

use Post\Model\Favorite;

class FavoriteTable extends AbstractTableGateway {

    protected $table = 'favorites';
    
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Favorite());
        $this->initialize();
    }

    public function fetchAllByUserId($userId) {
        $userId = (int) $userId;
        $sql = "SELECT posts.*
                FROM posts 
                LEFT JOIN favorites ON posts.id = favorites.post_id
                WHERE favorites.user_id = $userId GROUP BY favorites.id
                ORDER BY favorites.id DESC";
         
        $rowset = $this->adapter->query($sql, array());
        return $rowset;
    }

    public function saveFavorite(Favorite $favorite) {
        $data = array(
            'user_id' => $favorite->getUserId(),
            'post_id' => $favorite->getPostId(),
        );
        $this->insert($data);
    }

    public function deleteFavorites($postId) {
        $postId = (int) $postId;
        $this->delete(array('post_id' => $postId));
    }
    
    public function deleteFavorite($postId, $userId) {
        $userId = (int) $userId;
        $postId = (int) $postId;
        $rowset = $this->delete(array('post_id' => $postId, 'user_id' => $userId));
        return $rowset;
    }
    
    public function favoritePost($postId, $userId) {
        $postId = (int) $postId;
        $userId = (int) $userId;
        $sql = "SELECT COUNT(*) AS favor FROM favorites WHERE post_id = $postId AND user_id = $userId";
        $rowset = $this->adapter->query($sql, array());
        foreach ($rowset as $row) {
            if ($row->favor) {
                $sql = "DELETE FROM favorites WHERE post_id = $postId AND user_id = $userId";
                $this->adapter->query($sql, array());
                $row->favor--;
            } else {
                $sql = "INSERT INTO favorites (post_id, user_id) VALUES ($postId, $userId)";
                $this->adapter->query($sql, array());
                $row->favor++;
            }
        }
        return $row->favor;
    }
}
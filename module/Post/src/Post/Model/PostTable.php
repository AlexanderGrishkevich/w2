<?php

namespace Post\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Expression,
    Zend\Db\Sql\Select;
use Post\Model\Post;

class PostTable extends AbstractTableGateway
{
    protected $table = 'posts';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Post());
        $this->initialize();
    }

    public function getPostsByUserId($userId, $authUser, $limit = null, $offset = null) {
        $userId = (int) $userId;
        $authUser = (int) $authUser;

        //TODO refactor this shit

        $limit = $limit ? 'LIMIT ' . $limit : '';
        $offset = $offset ? 'OFFSET ' . $offset * 10 : '';

        $sql = "SELECT posts.*, 
                COUNT( Distinct comments.id) AS comments,
                COUNT( Distinct likes.id) AS likes, 
                COUNT( Distinct favorites.id) AS favorite,
                users.avatar,
                users.org_name,
                cities.title AS city
                FROM `posts` 
                LEFT JOIN `comments` ON posts.id = comments.post_id 
                LEFT JOIN `likes` ON posts.id = likes.post_id 
                LEFT JOIN `favorites` ON posts.id = favorites.post_id AND $authUser = favorites.user_id
                LEFT JOIN `users` ON users.id = posts.user_id
                LEFT JOIN `cities` ON cities.id = users.city
                WHERE posts.user_id = $userId AND posts.is_active = 1  
                GROUP BY posts.id 
                ORDER BY posts.create_date DESC " . $limit . " " . $offset;


        $rowset = $this->adapter->query($sql, array());
        return $rowset;
    }
    
    public function getPostsByTag($tag, $authUser) {
        $authUser = (int) $authUser;
        $sql = "SELECT posts.*, 
                COUNT( Distinct comments.id) AS comments,
                COUNT( Distinct likes.id) AS likes, 
                COUNT( Distinct favorites.id) as favorite,
                users.avatar,
                users.org_name,
                cities.title AS city
                FROM `posts` 
                LEFT JOIN `comments` ON posts.id = comments.post_id 
                LEFT JOIN `likes` ON posts.id = likes.post_id 
                LEFT JOIN `favorites` ON posts.id = favorites.post_id AND $authUser = favorites.user_id
                LEFT JOIN `users` ON users.id = posts.user_id
                LEFT JOIN `cities` ON cities.id = users.city
                WHERE tags LIKE '%{$tag}%' AND posts.is_active = 1 GROUP BY posts.id
                ORDER BY create_date DESC";

        $rowset = $this->adapter->query($sql, array());
        return $rowset;
    }

    public function deletePost($id, $userId) {
        $id = (int) $id;
        $userId = (int) $userId;
        $rowset = $this->delete(array('id' => $id, 'user_id' => $userId));
        return $rowset;
    }

    public function getPostById($postId, $authUser) {
        $postId = (int) $postId;
        $authUser = (int) $authUser;
        
        $sql = "SELECT posts.*, 
                COUNT( Distinct comments.id) AS comments,
                COUNT( Distinct likes.id) AS likes, 
                COUNT( Distinct favorites.id) as favorite,
                users.avatar,
                users.org_name,
                cities.title AS city
                FROM `posts` 
                LEFT JOIN `comments` ON posts.id = comments.post_id 
                LEFT JOIN `likes` ON posts.id = likes.post_id 
                LEFT JOIN `favorites` ON posts.id = favorites.post_id AND $authUser = favorites.user_id
                LEFT JOIN `users` ON users.id = posts.user_id
                LEFT JOIN `cities` ON cities.id = users.city
                WHERE posts.id = $postId GROUP BY posts.id";

        $rowset = $this->adapter->query($sql, array());
        return $rowset->current();
    }

    public function getPostByIdAndUserId($postId, $userId) {
        $postId = (int) $postId;
        $userId = (int) $userId;
        $rowset = $this->select(array('id' => $postId, 'user_id' => $userId));
        $row = $rowset->current();
        return $row;
    }

    public function savePost(Post $post) {
        $data = array(
            'user_id' => $post->user_id,
        );

        $id = (int) $post->id;

        if ($id == 0) {
            $this->insert($data);
            //return id of new post
            $sql = "SELECT LAST_INSERT_ID() FROM posts AS id";
            $rowset = $this->adapter->query($sql, array());
            return $rowset->current();
        } elseif ($this->getPostByIdAndUserId($id, $post->user_id)) {

            $data = array(
                'title' => $post->title,
                'text' => $post->text,
                'price' => (int) $post->price,
                'chaffer' => (int) $post->chaffer,
                'tags' => $post->tags,
                'is_active' => $post->is_active,
                'create_date' => date("Y-m-d H:i:s"),
            );

            $this->update(
                    $data, array(
                'id' => $id,
                    )
            );
        } else {
            throw new \Exception('Form id does not exist');
        }
    }

    public function updatePostTime($id, $userId) {
        $id = (int) $id;
        $userId = (int) $userId;
        $data = array(
            'create_date' => date("Y-m-d H:i:s"),
        );
        $this->update(
                $data, array(
            'id' => $id,
            'user_id' => $userId
                )
        );
    }

    ///////////////////////////////////////////////////////////////////////////
    public function search($input, $order_by, $order, $country, $region, $city) {
        $sql = "SELECT posts.* FROM posts LEFT JOIN users ON posts.user_id = users.id
                LEFT JOIN countries ON countries.id = users.country
                LEFT JOIN regions ON regions.id = users.region
                LEFT JOIN cities ON cities.id = users.city
                WHERE (posts.title LIKE '%$input%' OR posts.text LIKE '%$input%') ";
        
        if ($country) {
            $sql = $sql . " AND countries.title = '$country' ";
        }
        if ($region) {
            $sql = $sql . " AND regions.title = '$region' ";
        }
        if ($city) {
            $sql = $sql . " AND cities.title = '$city' ";
        }
        $sql = $sql . " ORDER BY $order_by $order LIMIT 100";
        $rowset = $this->adapter->query($sql, array());
        return $rowset;
    }
    
    public function searchAjax($input)
    {
        $sql = "SELECT * FROM posts WHERE title LIKE '%$input%' LIMIT 10";
        $rowset = $this->adapter->query($sql, array());
        return $rowset;
    }
    
    public function getImagesByPostId($postId) {
        $postId = (int) $postId;
        $sql = "SELECT uploads.*
                FROM `uploads` LEFT JOIN `attachments` 
                ON attachments.upload_id = uploads.id  
                WHERE attachments.post_id = $postId 
                AND uploads.type LIKE 'image%'";
        $rowset = $this->adapter->query($sql, array());
        return $rowset;
    }
    
    public function getFilesByPostId($postId) {
        $sql = "SELECT uploads.*
                FROM `uploads` LEFT JOIN `attachments` 
                ON attachments.upload_id = uploads.id  
                WHERE attachments.post_id = $postId 
                AND uploads.type NOT LIKE 'image%'";
        $rowset = $this->adapter->query($sql, array());
        return $rowset;
    }
    
    public function getLikeByPostIdAndUserId($postId, $authUser) {
        $postId = (int) $postId;
        $authUser = (int) $authUser;
        $sql = "SELECT *
                FROM `likes`  
                WHERE post_id = $postId 
                AND user_id = $authUser";
        $rowset = $this->adapter->query($sql, array());
        return $rowset->count();
    }    
}
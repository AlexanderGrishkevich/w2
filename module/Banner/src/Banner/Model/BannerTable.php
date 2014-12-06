<?php

namespace Banner\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Expression,
    Zend\Db\Sql\Select,
    Zend\Paginator\Adapter\DbSelect;

use Banner\Model\Banner;

class BannerTable extends AbstractTableGateway {

	protected $table = 'banners';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Banner());
        $this->initialize();
    }

    public function fetchAll() {
        $select = new Select($this->table);
        $resultSet = $this->executeSelect($select);
        return $resultSet;
    }

    public function fetchAllToArray() {
        return $this->fetchAll()->toArray();
    }

    public function getBannersByUserId($user_id) {
        $select = new Select($this->table);
        $select->where(array('user_id' => $user_id));

        return $this->executeSelect($select);        
    }

    public function getBannerByUserIdAndType($user_id, $type) {
        $rowset = $this->select(array('user_id' => $user_id, 'type' => $type));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }

    public function insertOrUpdateBanner(Banner $banner, $userId, $type) {
        $data = array(
            'user_id' => $banner->user_id,
            'banner_url' => $banner->banner_url,
            'discount' => $banner->discount,
            'title' => $banner->title,
            'price' => $banner->price,
            'type' => $banner->type
        );        
        $user_id  = (int) $userId;
        if ($this->getBannerByUserIdAndType($user_id, $type)) {
            $this->update($data, array('user_id' => $user_id, 'type' => $type));
        } else {
            $this->insert($data);
        }
    }

    public function getBannersByType($type, $limit) {
        $select = new Select($this->table);
        $select->where(array('type' => $type));
        $select->limit($limit);

        return $this->executeSelect($select);        
    }

    // TODO refactor to ZF2 sql

    public function getActiveBannersByType($type, $limit) {
        $sql = "SELECT * FROM users LEFT JOIN banners on users.id = banners.user_id WHERE users.off_date > ? AND banners.type = ? ORDER BY RAND() LIMIT ?";
        $rowset = $this->adapter->query($sql, array(time(), $type, $limit ));
        return $rowset;
    }

    public function getMainBanner() {
        $sql = "SELECT * FROM mainbanners ORDER BY RAND() LIMIT 1";
        $rowset = $this->adapter->query($sql, array());
        return $rowset;
    }
    
}
<?php

namespace Location\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Expression,
    Zend\Db\Sql\Select,
    Zend\Paginator\Adapter\DbSelect,
    Location\Model\City;

class CityTable extends AbstractTableGateway {

	protected $table = 'cities';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new City());
        $this->initialize();
    }

    public function fetchAll() {
        $select = new Select($this->table);
        return $this->executeSelect($select);
    }

    public function fetchAllByRegionId($regionId) {
        $select = new Select($this->table);
        $select->columns(array('id', 'title', 'region_id'));
        $select->join('regions', 'cities.region_id=regions.id', array(), 'left')
            ->where('regions.id='.$regionId);
        return $this->executeSelect($select);
    }
    
    public function fetchAllByRegionTitle($regionTitle) {
        $select = new Select($this->table);
        $select->columns(array('id', 'title', 'region_id'));
        $select->join('regions', 'cities.region_id=regions.id', array(), 'left')
            ->where('regions.title="'.$regionTitle.'"');
        return $this->executeSelect($select);
    }

    public function fetchAllToArray() {
        return $this->fetchAll()->toArray();
    }
}
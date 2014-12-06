<?php

namespace Location\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Expression,
    Zend\Db\Sql\Select,
    Zend\Paginator\Adapter\DbSelect,
    Location\Model\Region;

class RegionTable extends AbstractTableGateway {

	protected $table = 'regions';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Region());
        $this->initialize();
    }

    public function fetchAll() {
        $select = new Select($this->table);
        return $this->executeSelect($select);
    }

    public function fetchAllByCountryId($countryId) {
        $select = new Select($this->table);
        $select->columns(array('id', 'title', 'country_id'));
        $select->join('countries', 'regions.country_id=countries.id', array(), 'left')
            ->where('countries.id='.$countryId);
        return $this->executeSelect($select);
    }
    
    public function fetchAllByCountryTitle($countryTitle) {
        $select = new Select($this->table);
        $select->columns(array('id', 'title', 'country_id'));
        $select->join('countries', 'regions.country_id=countries.id', array(), 'left')
            ->where('countries.title="'.$countryTitle.'"');
        return $this->executeSelect($select);
    }

    public function fetchAllToArray() {
        return $this->fetchAll()->toArray();
    }
}
<?php

namespace Location\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Expression,
    Zend\Db\Sql\Select,
    Zend\Paginator\Adapter\DbSelect,
    Location\Model\Country;

class CountryTable extends AbstractTableGateway {

	protected $table = 'countries';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Country());
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
}
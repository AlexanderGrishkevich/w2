<?php

namespace Page\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Expression,
    Zend\Db\Sql\Select,
    Zend\Paginator\Adapter\DbSelect,
    Page\Model\Feedback;

class FeedbackTable extends AbstractTableGateway {

	protected $table = 'feedbacks';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Feedback());
        $this->initialize();
    }

    public function fetchAll() {
        $select = new Select($this->table);
        return $this->executeSelect($select);
    }

    public function save(Feedback $feedback) {
        $data = array(
            'username' => $feedback->username,
            'userdata' => $feedback->userdata,
            'text' => $feedback->text,
        );
        $this->insert($data);
    }
}
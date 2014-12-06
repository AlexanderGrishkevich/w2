<?php

namespace Page\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Select,
    Page\Model\ForgetPassword;

class ForgetPasswordTable extends AbstractTableGateway {

    protected $table = 'forgetpassword';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new ForgetPassword());
        $this->initialize();
    }

    public function save($userId, $email, $code) {
        $data = array(
            'user_id' => $userId,
            'email' => $email,
            'code' => $code,
        );
        $this->insert($data);
    }

    public function getByCode($code) {
        $rowset = $this->select(array('code' => $code));
        return $rowset->current();
    }

    public function delete($code) {
        $sql = "DELETE FROM forgetpassword WHERE '$code' = code";
        $this->adapter->query($sql, array());
    }

}

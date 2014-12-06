<?php

namespace Dialog\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Select;
use Dialog\Model\Dialog;

class DialogTable extends AbstractTableGateway {

    protected $table = 'dialogs';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Dialog());
        $this->initialize();
    }

    function getDialogsByUserId($id) {
        $sql = "SELECT dialogs.*, su.org_name AS sfirst_name, ru.org_name AS rfirst_name, su.avatar AS savatar, ru.avatar as ravatar FROM dialogs 
                LEFT JOIN users AS su ON su.id = dialogs.sender_id
                LEFT JOIN users AS ru ON ru.id = dialogs.recipient_id
                    WHERE dialogs.id IN ( 
                        SELECT MAX(id) id FROM (
                            SELECT MAX(id) id, recipient_id touser_id 
                                FROM dialogs 
                                WHERE sender_id = $id 
                                GROUP By recipient_id
                            UNION ALL
                            SELECT MAX(id) id, sender_id
                                FROM dialogs
                                WHERE recipient_id = $id     
                                GROUP BY sender_id ) g    
                            GROUP BY touser_id) 
                    AND (dialogs.deleted_by_user_id is null OR 
                    dialogs.deleted_by_user_id != $id) 
                    ORDER BY dialogs.create_date DESC ;  
                ";
        $rowset = $this->getAdapter()->query($sql, array());
        return $rowset;
    }

    public function getDialogsByUsers($currentUserId, $secondUserId) {
        $this->update(array('is_new' => 0), array('recipient_id' => $currentUserId,
            'sender_id' => $secondUserId));

        $sql = "SELECT dialogs.*, users.org_name AS first_name, users.avatar FROM dialogs 
                LEFT JOIN users ON users.id = dialogs.sender_id
                WHERE (dialogs.sender_id = $currentUserId AND dialogs.recipient_id = $secondUserId) OR
                (dialogs.sender_id = $secondUserId AND dialogs.recipient_id = $currentUserId)
                ORDER BY dialogs.create_date ASC;  
                ";
        $rowset = $this->getAdapter()->query($sql, array());
        return $rowset;
    }

    public function saveDialog(Dialog $dialog) {
        $data = array(
            'sender_id' => $dialog->sender_id,
            'recipient_id' => $dialog->recipient_id,
            'text' => $dialog->text,
            'create_date' => $dialog->create_date,
            'is_new' => $dialog->is_new,
        );
        $this->insert($data);
    }

    public function getNewDialogsCountByUserId($id) {
        $sql = "SELECT * FROM $this->table 
                WHERE recipient_id = $id   
                    AND is_new = 1"; // to do
        $rowset = $this->getAdapter()->query($sql, array());
        return $rowset->count();
    }

    public function deleteUsersDialogs($currentUserId, $secondUserId) {
        $sql = "DELETE FROM $this->table 
                WHERE ((recipient_id = $currentUserId AND sender_id = $secondUserId)
                    OR (recipient_id = $secondUserId AND sender_id = $currentUserId))
                    AND deleted_by_user_id IS NOT NULL"; // to do
        $rowset = $this->getAdapter()->query($sql, array());

        if (!$rowset->getAffectedRows()) {
            $sql = "UPDATE $this->table 
                SET deleted_by_user_id = $currentUserId
                WHERE ((recipient_id = $currentUserId AND sender_id = $secondUserId)
                    OR (recipient_id = $secondUserId AND sender_id = $currentUserId))";
            $this->getAdapter()->query($sql, array());
        }
    }

}

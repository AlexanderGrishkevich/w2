<?php

namespace Category\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class CategoryTable {

    protected $tableGateway;
    protected $tableName;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
        $this->tableName = $tableGateway->getTable();
    }

    public function getAllCategories() {
        $this->deleteEmptyCategories();

        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getCategoryById($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('category_id' => $id));
        $row = $rowset->current();
        return $row ? $row : null;
    }

    public function saveCategory(Category $item) {
        $data = $item->getArrayCopy();

        unset($data['category_id']);
        $id = (int) $item->get('category_id');

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCategoryById($id)) {
                $this->tableGateway->update($data, array('category_id' => $id));
            }
        }
    }

    public function getLastUserCategory($userId) {
        $result = $this->tableGateway->select(
                function (\Zend\Db\Sql\Select $select) use ($userId) {
            $select->where->
                    equalTo('user_id', $userId);
            $select->order('create_date DESC');
        });

        $row = $result->current();
        return $row ? $row : null;
    }

    public function getChildrenCategories($categoryId) {
        $categories = $this->tableGateway->select(
                function (\Zend\Db\Sql\Select $select) use ($categoryId) {
            $select->where->
                    equalTo('parent_id', $categoryId); 
        });
        return $categories;
    }

    public function getCategoryList() {
        $categories = $this->tableGateway->select(
                function (\Zend\Db\Sql\Select $select) {
            $select->where->
                    notEqualTo('parent_id', -1); //todo magic fix (not null)
        });


        $categoryArray = $categories->toArray();
        $resultList = array();
        $resultList[0] = '';

        foreach ($categoryArray as $category) {
            $resultList[$category['category_id']] = $category['title'];
        }

        return $resultList;
    }

    public function deleteEmptyCategories() {
        $this->tableGateway->delete(
                array(
                    'title' => null,
                )
        );
    }

    public function deleteCategoryById($categoryId) {
        $category = $this->getCategoryById($categoryId);
        $categoryParentId = $category->get('parent_id');
        $data = array(
            'parent_id' => $categoryParentId,
        );
        $this->tableGateway->update($data, array('parent_id' => $categoryId));

        $this->tableGateway->delete(array('category_id' => $categoryId));
    }
}

<?php
namespace Application\Model;
use Application\Model\Rowset\User;


class UsersTable extends AbstractTable
{
    public function getById($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception('user not foound with id: '.$id);
        }
        return $row;
    }
    public function getAll()
    {
        $results = $this->tableGateway->select();
        return $results;
    }
    public function save(User $userModel)
    {
        $data = [
            'username' => $userModel->getUsername()
        ];
        return parent::saveRow($userModel, $data);
    }
    public function delete($id)
    {
        parent::deleteRow($id);
    }
}



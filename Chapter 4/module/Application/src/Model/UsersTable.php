<?php
namespace Application\Model;
use Laminas\Db\TableGateway\TableGateway;

class UsersTable
{
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function getById($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception('user not found with id: '.$id);
        }
        return $row;
    }
}



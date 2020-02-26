<?php
namespace Application\Model;
use Application\Model\User;


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
    
    public function getAll()
    {
         $results = $this->tableGateway->select();

         return $results;
    }
    
    public function save(User $userModel, $extraData = null)
    {
        //prepare model's data
        $data = $userModel->getArrayCopy();

        if (!empty($extraData)) {
            $data = array_merge($data, $extraData);
        }
        //determines if we are dealing with existing or new model
        $id = $userModel->getId();
        
        //if parameter $data is not passed in, then we will update all properties
        if (empty($data)) {
            $data = $userModel->getArrayCopy();
        }
        
        if (empty($id)) {
            //insert new data
            $this->tableGateway->insert($data);
            
            return $this->tableGateway->getLastInsertValue();
        }
        
        if (!$this->getById($id)) {
            throw new RuntimeException(get_class($userModel) .' with id: '.$id.' not found');
        }

        //edit existing data
        $this->tableGateway->update($data, ['id' => $id]);
        return $id;
    }
    
    public function delete($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}





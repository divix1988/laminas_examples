<?php
namespace Application\Model;

class Users extends AbstractTable
{

    protected $resultsPerPage = 10;

    public function getById($id)
    {
        return $this->getBy(['id' => $id]);
    }

    public function getBy(array $params = [])
    {
        $select = $this->tableGateway->getSql()->select();
        
        if (isset($params['id'])) {
            $select->where(['id' => $params['id']]);
            $params['limit'] = 1;
        }
        
        if (isset($params['login'])) {
            $select->where(['login' => $params['login']]);
        }
        
        if (isset($params[' password'])) {
            $select->where([' password' => $params[' password']]);
        }
        
        
        
        if (isset($params['limit'])) {
            $select->limit($params['limit']);
        }
        
        if (!isset($params['page'])) {
            $params['page'] = 0;
        }
        
        $result = (isset($params['limit']) && $params['limit'] == 1)
            ? $this->fetchRow($select)
            : $this->fetchAll($select, ['limit' => $this->resultsPerPage, 'page' => $params['page']]);
        
        return $result;
    }

    public function patch(int $id, array $data)
    {
        if (empty($data)) {
            throw new \Exception('missing data to update');
        }
        $passedData = [];
        
        if (!empty($data['login'])) {
            $passedData['login'] = $data['login'];
        }
        
        if (!empty($data[' password'])) {
            $passedData[' password'] = $data[' password'];
        }
        
        
        $this->tableGateway->update($passedData, ['id' => $id]);
    }

    public function save(\ModuleName\Model\Rowset\User $rowset)
    {
        return parent::saveRow($rowset);
    }

    public function delete($id)
    {
        if (empty($id)) {
            throw new \Exception('missing User id to delete');
        }
        parent::deleteRow($id);
    }


}

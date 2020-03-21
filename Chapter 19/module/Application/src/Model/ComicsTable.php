<?php

namespace Application\Model;

class ComicsTable extends AbstractTable
{
    protected $resultsPerPage = 2;
    
    public function getById($id)
    {
        $id = (int) $id;
        $row = $this->getBy(['id' => $id]);
        
        if (!$row) {
            throw new \Exception('comics not foound with id: '.$id);
        }
        return $row;
    }
    
    public function getBy(array $params = array())
    {
        $select = $this->tableGateway->getSql()->select();

        if (!isset($params['page'])) {
            $params['page'] = 0;
        }
        if (isset($params['id'])) {
            $select->where(['id' => $params['id']]);
            $params['limit'] = 1;
        }
        if (isset($params['title'])) {
            $select->where(['title' => $params['title']]);
        }
        if (isset($params['thumb'])) {
            $select->where(['thumb' => $params['thumb']]);
        }
        if (isset($params['limit'])) {
           $select->limit($params['limit']);
        }
        if (isset($params['limit'])) {
            $select->limit($params['limit']);
        }

        $result = (isset($params['limit']) && $params['limit'] == 1)
            ? $this->fetchRow($select)
            : $this->fetchAll($select, ['limit' => $this->resultsPerPage, 'page' => $params['page']]);
        
        return $result;
    }
    
    public function patch($id, $data)
    {
        $passedData = [];
        if (!empty($data['title'])) {
            $passedData['title'] = $data['title'];
        }
        if (!empty($data['thumb'])) {
            $passedData['thumb'] = $data['thumb'];
        }
        $this->tableGateway->update($passedData, ['id' => $id]);
    }
    
    public function save(Rowset\Comics $comicsModel)
    {
        return parent::saveRow($comicsModel);
    }
    
    public function delete($id)
    {
        parent::deleteRow($id);
    }
}

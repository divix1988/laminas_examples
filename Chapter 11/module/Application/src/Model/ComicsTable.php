<?php

namespace Application\Model;

class ComicsTable extends AbstractTable
{
    protected $resultsPerPage = 2;
    
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
}

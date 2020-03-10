<?php
namespace ApplicationApi\V1\Rest\Comics;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;

class ComicsResource extends AbstractResourceListener
{
    protected $comicsTableGateway;
    
    public function __construct($comicsTableGateway) {
        $this->comicsTableGateway = $comicsTableGateway;
    }
    
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $arrayData = (array) $data;
        
        $model = new \Application\Model\Rowset\Comics();
        $model->exchangeArray($arrayData);
        
        return $this->comicsTableGateway->save($model);
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $this->comicsTableGateway->delete($id);
        return true;
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->comicsTableGateway->getBy(['id' => $id]);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->comicsTableGateway->getBy();
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        $arrayData = (array) $data;
        
        return $this->comicsTableGateway->patch($id, $arrayData);
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        $arrayData = (array) $data;
        
        foreach ($arrayData as $comicsRow) {
            if (empty($comicsRow['id'])) {
                return new ApiProblem(405, 'Invalid ID attribute');
            }
            $result = $this->comicsTableGateway->patch($comicsRow['id'], $comicsRow);
        }
        return $result;
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        $arrayData = (array) $data;
        
        foreach ($arrayData as $row) {
            $model = new \Application\Model\Rowset\Comics();
            $model->exchangeArray((array) $row);
            if (empty($model->getId())) {
                return new ApiProblem(405, 'Invalid ID attribute');
            }
            $result = $this->comicsTableGateway->save($model);
        }
        return $result;
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        $arrayData = (array) $data;
        
        if (empty($arrayData['id'])) {
            return new ApiProblem(405, 'Invalid ID attribute');
        }
        $arrayData['id'] = $id;
        
        $model = new \Application\Model\Rowset\Comics();
        $model->exchangeArray($arrayData);
        
        return $this->comicsTableGateway->save($model);
    }
}

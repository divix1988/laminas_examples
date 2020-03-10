<?php
namespace ApplicationApi\V1\Rest\Comics;

use Application\Model\ComicsTable;

class ComicsResourceFactory
{
    public function __invoke($services)
    {
        $comicsTableGateway = $services->get(ComicsTable::class);
        
        return new ComicsResource($comicsTableGateway);
    }
}

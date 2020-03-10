<?php

namespace Application\Controller;

use Application\Model\ComicsTable;

class ComicsController extends AbstractController
{
    private $comicsTable = null;
    public function __construct(ComicsTable $comicsTable)
    {
        $this->comicsTable = $comicsTable;
    }
    public function indexAction()
    {
        return [
            'comics' => $this->comicsTable->getBy(['page' => $this->params()->fromRoute('page')])
        ];
    }
}
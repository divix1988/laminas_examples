<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Model\UsersTable;

class IndexController extends AbstractActionController
{
    private $usersTable = null;
    
    public function __construct(UsersTable $usersTable)
    {
        $this->usersTable = $usersTable;
    }
    public function indexAction()
    {
        $view = new ViewModel();
        $model = $this->usersTable;
        
        $row = $model->getById(1);
        
        $view->setVariable('id', $row->getId());
        $view->setVariable('username', $row->getUsername());
        $view->setVariable('password', $row->getPassword());
        
        return $view;
    }

}

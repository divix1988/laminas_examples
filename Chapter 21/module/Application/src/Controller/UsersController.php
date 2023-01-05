<?php
namespace Application\Controller;

use Laminas\View\Model\ViewModel;
use Application\Model\UsersTable;
use Application\Model\UserHobbiesTable;

use Application\Form\UserForm;
use Application\Model\Rowset\User;

class UsersController  extends AbstractController
{
    private $usersTable = null;
    private $userHobbiesTable = null;
    
    public function __construct(UsersTable $usersTable, UserHobbiesTable $userHobbiesTable)
    {
        $this->usersTable = $usersTable;
        $this->userHobbiesTable = $userHobbiesTable;
    }
    public function indexAction()
    {
        $view = new ViewModel();
        $rows = $this->usersTable->getAll();
        $rows->buffer();
	$hobbies = [];
	
	foreach ($rows as $row) {
            $results = $this->userHobbiesTable->getByUserId($row->getId());
            foreach ($results as $hobby) {
                $hobbies[$row->getId()][] = $hobby->getHobby();
            }
	}
	$view->setVariable('userHobbies', $hobbies);
        $view->setVariable('userRows', $rows);
        
        return $view;
    }
    
    public function addAction()
    {
        $request = $this->getRequest();
        $userForm = new UserForm();
        $userForm->get('submit')->setValue('Add');
        
        if (!$request->isPost()) {
            return ['userForm' => $userForm];
        }
        $userModel = new User();
        $userForm->setInputFilter($userModel->getInputFilter());
        $userForm->setData($request->getPost());
        
        if (!$userForm->isValid()) {
            print_r($userForm->getMessages());
            exit('not valid');
            return ['userForm' => $userForm];
        }
        $userModel->exchangeArray($userForm->getData());
        $this->usersTable->save($userModel);
        
        return $this->redirect()->toRoute('users');
    }
    
    public function editAction()
    {
	$view = new ViewModel();
	$userId = (int) $this->params()->fromRoute('id');
	$view->setVariable('userId', $userId);
	if ($userId == 0) {
            return $this->redirect()->toRoute('users', ['action' => 'add']);
	}
	// get user data; if it doesn’t exists, then redirect back to the index
	try {
            $userRow = $this->usersTable->getById($userId);
	} catch (\Exception $e) {
            return $this->redirect()->toRoute('users', ['action' => 'index']);
	}
	$userForm = new UserForm();
	$userForm->bind($userRow);
	$userForm->populateValues(
            [
                'user_info' => [
                    'gender' => $userRow->getGender(),
                    'education' => $userRow->getEducation(),
                    'hobby' => $this->userHobbiesTable->getPlainHobbies($userId)
                ]
            ]
	);
	$userForm->get('submit')->setAttribute('value', 'Save');
	$request = $this->getRequest();
	$view->setVariable('userForm', $userForm);
	
	if (!$request->isPost()) {
            return $view;
	}
	$userForm->setInputFilter($userRow->getInputFilter());
	$userForm->setData($request->getPost());
	
	if (!$userForm->isValid()) {
            return $view;
	}
	$extraUserdata = [
            'gender' => $userForm->get('user_info')->get('gender')->getValue(),
            'education' => $userForm->get('user_info')->get('education')->getValue()
	];
	$hobbies = $userForm->get('user_info')->get('hobby')->getValue();
	$this->usersTable->save($userRow, $extraUserdata);
	$this->userHobbiesTable->save($userRow->getId(), $hobbies);
	// data saved, redirect to the users list page
	return $this->redirect()->toRoute('users', ['action' => 'index']);
    }

    public function deleteAction()
    {
	$userId = (int) $this->params()->fromRoute('id');
	
        if (empty($userId)) {
            return $this->redirect()->toRoute('users');
	}
	$request = $this->getRequest();
	
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Cancel');
            
            if ($del == 'Delete') {
                $userId = (int) $request->getPost('id');
                $this->usersTable->delete($userId);
            }
            // redirect to the users list
            return $this->redirect()->toRoute('users');
	}
	return [
            'id' => $userId,
            'user' => $this->usersTable->getById($userId),
	];
    }

}

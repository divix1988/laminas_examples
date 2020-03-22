<?php

namespace ApplicationTest\Controller;

use Application\Model\UsersTable;
use Application\Model\UserHobbiesTable;
use Application\Model\Rowset\User;
use Laminas\ServiceManager\ServiceManager;
use Prophecy\Argument;

class UsersControllerTest extends \Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase
{
    protected $tableGateway;
    protected $comicsTable;
    protected $traceError = true;
    protected $usersTable;
    protected $userHobbiesTable;

    protected function setup():void
    {
        $this->setApplicationConfig(
            include APPLICATION_PATH . '/config/application.test.config.php'
        );
        parent::setup();
    }
    
    protected function configureServiceManager(ServiceManager $services)
    {
	$services->setAllowOverride(true);
	$services->setService('config', $this->updateConfig($services->get('config')));
	$services->setService(UsersTable::class, $this->mockUsersTable()->reveal());
	$services->setService(UserHobbiesTable::class, $this->mockUserHobbiesTable()->reveal());
	$services->setAllowOverride(false);
    }

    protected function updateConfig($config)
    {
	$config['db'] = [];
	return $config;
    }

    protected function mockUsersTable()
    {
	$this->usersTable = $this->prophesize(UsersTable::class);
	return $this->usersTable;
    }

    protected function mockUserHobbiesTable()
    {
	$this->userHobbiesTable = $this->prophesize(UserHobbiesTable::class);
	return $this->userHobbiesTable;
    }

    /**
     * @group users.save
     */
    public function testAddActionSuccess()
    {
	$this->configureServiceManager($this->getApplicationServiceLocator());
	$this->usersTable
            ->save(Argument::type(User::class))
            ->shouldBeCalled();
        
	$postData = [
            'id' => '',
            'username' => 'new_user',
            'email' => 'abc@omelak.com',
            'user_info' => [
                'hobby' => ['books'],
                'gender' => 'male',
                'education' => 'primary'
            ]
	];
	$this->dispatch('/users/add', 'POST', $postData);
	$this->assertResponseStatusCode(302);
	$this->assertRedirectTo('/users');
    }

    /**
     * @group users.update
     */
    public function testUpdateActionValidate()
    {
	$this->configureServiceManager($this->getApplicationServiceLocator());
	$id = 1;
	$editData = [
            'username' => 'new_user_updated',
            'email' => 'abc@omelak.com',
            'user_info' => [
                'hobby' => ['books'],
                'gender' => 'male',
                'education' => 'primary',
                'comments' => 'test comment'
            ],
            'id' => $id
	];

	$rowset = new User();
	$rowset->exchangeArray($editData);
	$this->usersTable->getById($id)->willReturn($rowset);
	$this->dispatch('/users/edit/'.$id, 'GET');
	$this->assertResponseStatusCode(200);
	$dom = new \Laminas\Dom\Query($this->getResponse());
	$results = $dom->execute('input[name="username"]');
	$this->assertEquals($editData['username'], $results[0]->getAttribute('value'));
	$this->assertQueryContentContains('.jumbotron .zf-green', 'Edit User id: '.$editData['id']);
    }
    
    public function testUpdateActionInvalidId()
    {
        //check if when we pass non-existing user id, controller would redirect us to the index page
	$this->dispatch('/users/edit/999', 'GET');
	$this->assertResponseStatusCode(302);
	$this->assertRedirectTo('/users');
    }

    /**
     * @group users.update
     */
    public function testUpdateActionSuccess()
    {
	$this->configureServiceManager($this->getApplicationServiceLocator());
	$id = 1;
	$editData = [
            'username' => 'new_user_updated',
            'email' => 'abc@omelak.com',
            'user_info' => [
                'hobby' => ['books'],
                'gender' => 'male',
                'education' => 'primary',
                'comments' => 'test comment'
            ],
            'id' => $id
	];

	$rowset = new User();
	$rowset->exchangeArray($editData);
	$this->usersTable->getById($id)->willReturn($rowset);
	$this->usersTable->save($rowset, $editData)->willReturn(true);
	$this->userHobbiesTable->getPlainHobbies($id)->willReturn($editData['user_info']['hobby']);
	
	//let’s try to edit the just created user
	$this->usersTable
		->save(Argument::type(User::class), Argument::type('array'))
		->shouldBeCalled();
	$this->userHobbiesTable
		->save(Argument::type('int'), Argument::type('array'))
		->shouldBeCalled();
	$this->dispatch('/users/edit/'.$id, 'POST', $editData);
	$this->assertResponseStatusCode(302);
	$this->assertRedirectTo('/users');
    }
    
    /**
     * @group users.delete
     */
    public function testDeleteActionSuccess()
    {
	$this->configureServiceManager($this->getApplicationServiceLocator());
	$id = 1;
	$editData = [
            'username' => 'new_user_updated',
            'email' => 'abc@omelak.com',
            'gender' => 'male',
            'education' => 'primary',
            'id' => $id
	];

	$rowset = new User();
	$rowset->exchangeArray($editData);
	$this->usersTable->getById($id)->willReturn($rowset);
	$this->dispatch('/users/delete/'.$id, 'POST', $editData);
	$this->assertResponseStatusCode(302);
	$this->assertRedirectTo('/users');
    }
}

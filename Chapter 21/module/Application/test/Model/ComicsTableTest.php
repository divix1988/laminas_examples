<?php

namespace ApplicationTest\Model;

use Application\Model\ComicsTable;
use Application\Model\Rowset\Comics;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\Adapter\Adapter;

class ComicsTableTest extends \Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase
{
    protected $tableGateway;
    protected $comicsTable;
    protected $traceError = true;
    protected $usersTable;
    protected $baseUrl;

    protected function setup():void
    {
        $this->setApplicationConfig(include APPLICATION_PATH . '/config/application.test.config.php');
        $this->tableGateway = $this->prophesize(TableGatewayInterface::class);
        $this->comicsTable = $this->getApplicationServiceLocator()->get(ComicsTable::class);
        //let’s disable cache from paginator results
        $this->comicsTable->disableCache();
        $config = $this->getApplicationServiceLocator()->get('Config');
        $this->baseUrl = $config['view_manager']['base_url'];

        //let’s remove data from tested tables
        $this->getApplicationServiceLocator()->get(Adapter::class)->query('TRUNCATE TABLE comics')->execute();
        parent::setup();
    }
    
    public function testGetByIdNotFound()
    {
	$resultSet = $this->prophesize(ResultSetInterface::class);
	$resultSet->current()->willReturn(null);
	$id = 1;
	$this->expectException(
            \Exception::class,
            'comics with id: '.$id.' has not been found'
	);
	$this->comicsTable->getById($id);
    }

    public function testGetBySuccess()
    {
	$rowset1 = new Comics($this->baseUrl);
	$rowset1->exchangeArray(['title' => 'abc', 'thumb' => 'file.gif']);
	$rowset2 = new Comics($this->baseUrl);
	$rowset2->exchangeArray(['title' => 'abc2', 'thumb' => 'file.jpg']);
	
        $rowsetId1 = $this->comicsTable->save($rowset1);
	$rowsetId2 = $this->comicsTable->save($rowset2);
	$rowset1->setId($rowsetId1);
	$rowset2->setId($rowsetId2);
        
	$this->assertEquals([$rowset1, $rowset2], iterator_to_array($this->comicsTable->getBy()->getCurrentItems()));
    }
    
    public function testPatchInvalidData()
    {
	$id = 1;
	$this->expectException(
            \Exception::class,
            'no params sent to update'
	);
	$this->comicsTable->patch($id, []);
    }

    public function testPatchSuccess()
    {
	$rowset1 = new Comics($this->baseUrl);
	$rowset1->exchangeArray(['title' => 'abc2', 'thumb' => 'file.jpg']);
	$updatedData = [
            'thumb' => 'updated_file.jpg',
            'title' => 'updated_title'
	];

	$rowsetId1 = $this->comicsTable->save($rowset1);
	$this->comicsTable->patch($rowsetId1, $updatedData);
	//let’s check a result after new Comics object
	$expected = new Comics($this->baseUrl);
	$expected->exchangeArray($updatedData);
	$expected->setId($rowsetId1);
	$this->assertEquals([$expected], iterator_to_array($this->comicsTable->getBy()->getCurrentItems()));
    }

    public function testDeleteInvalidId()
    {
	$this->expectException(
            \Exception::class,
            'missing comics id to delete'
	);
	$this->comicsTable->delete('');
    }

    public function testDeleteSuccess()
    {
	$rowset1 = new Comics($this->baseUrl);
	$rowset1->exchangeArray(['title' => 'delete_title', 'thumb' => 'delete.jpg']);
	$rowset2 = new Comics($this->baseUrl);
	$rowset2->exchangeArray(['title' => 'normal_title', 'thumb' => 'normal.jpg']);

	//let’s add two comics
	$rowsetId1 = $this->comicsTable->save($rowset1);
	$rowsetId2 = $this->comicsTable->save($rowset2);

	//let’s delete only 1 comics
	$this->comicsTable->delete($rowsetId1);

	//let’s check a result after new Comics object
	$rowset2->setId($rowsetId2);
	$this->assertEquals([$rowset2], iterator_to_array($this->comicsTable->getBy()->getCurrentItems()));
    }
}


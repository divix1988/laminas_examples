<?php

namespace ApplicationTest\Model\Rowset;

use Application\Model\Rowset\Comics;
use Application\Form\ComicsForm;
use PHPUnit\Framework\TestCase;

class ComicsTest extends TestCase
{
    public function setup():void
    {
        parent::setup();
    }

    public function testInitialComicsValuesAreNull()
    {
        $comics = new Comics();
        $this->assertNull($comics->id, 'initial id value should be null');
        $this->assertNull($comics->title, 'initial title value should be null'); $this->assertNull($comics->thumb, 'initial thumb value should be null');
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $comics = new Comics();
        $data = $this->getComicsData();
        //let’s check an initial array
        $comics->exchangeArray($data);
        $this->assertSame(
            $data['id'],
            $comics->getId(),
            'id param has not been set properly'
        );

        $this->assertSame(
            $data['title'],
            $comics->getTitle(),
            'title param has not been set properly'
        );

        $this->assertSame(
            $data['thumb'],
            $comics->getThumb(),
            'thumb param has not been set properly'
        );
    }

    private function getComicsData()
    {
        return [
            'id' => 123,
            'title' => 'Testman',
            'thumb' => 'file.jpg'
        ];
    }
    
    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $comics = new Comics();
        $comics->exchangeArray($this->getComicsData());
        $comics->exchangeArray([]);

        $this->assertNull($comics->id, 'initial id value should be null');
        $this->assertNull($comics->title, 'initial title value should be null');
        $this->assertNull($comics->thumb, 'initial thumb value should be null');
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
	$comics = new Comics();
	$data = $this->getComicsData();
	$comics->exchangeArray($data);
	$copyArray = $comics->getArrayCopy();
	$this->assertSame($data['id'], $copyArray['id'], 'id param has not been set properly');
	
	$this->assertSame($data['title'], $copyArray['title'], 'title param has not been set properly');
	$this->assertSame($data['thumb'], $copyArray['thumb'], 'thumb param has not been set properly');
}

    public function testInputFiltersAreSetCorrectly()
    {
	$comics = new Comics();
	$inputFilter = $comics->getInputFilter();
        
	$this->assertSame(3, $inputFilter->count());
	$this->assertTrue($inputFilter->has('id'));
	$this->assertTrue($inputFilter->has('title'));
	$this->assertTrue($inputFilter->has('thumb'));
    }

    /**
    * @dataProvider getInvalidComicsData
    * @group inputFilters
    */
    public function testInputFiltersIncorrect($row)
    {
	$comics = new Comics();
	$comicsForm = new ComicsForm();
	$comicsForm->setInputFilter($comics->getInputFilter());
	$comicsForm->bind($comics);
	$comicsForm->setData($row);
        
	$this->assertFalse($comicsForm->isValid());
	$this->assertTrue(count($comicsForm->getMessages()) > 0);
    }

    public function getInvalidComicsData()
    {
	return [
            [
                [
                    'id' => null,
                    'title' => null,
                    'thumb' => null
                ],
                [
                    'id' => '',
                    'title' => 'null',
                    'thumb' => 'null'
                ],
                [
                    'id' => 123,
                    'title' => '',
                    'thumb' => 'file.jpg'
                ]
            ]
	];
    }
    
    /**
     * @group inputFilters
     * @author adam.omelak
     */
    public function testInputFiltersSuccess()
    {
        $comics = new Comics();
        $comicsForm = new ComicsForm();
        $comicsForm->setInputFilter($comics->getInputFilter());
        $comicsForm->bind($comics);
        $comicsForm->setData($this->getComicsData());

        $this->assertTrue($comicsForm->isValid());
        $this->assertCount(0, $comicsForm->getMessages());
    }

    /**
     * @group inputFilters
     */
    public function testInputFiltersFixtureSuccess()
    {
        $fixture = include __DIR__ . '/../../Fixtures/Comics.php';
        $counter = 0;

        foreach ($fixture as $comicsData) {
            $comics = new Comics();
            $comicsForm = new ComicsForm();
            $comicsForm->setInputFilter($comics->getInputFilter());
            $comicsForm->bind($comics);
            $comicsForm->setData($comicsData);
            $this->assertTrue($comicsForm->isValid());
            $counter++;
        }
        $this->assertEquals(count($fixture), $counter);
    }
}


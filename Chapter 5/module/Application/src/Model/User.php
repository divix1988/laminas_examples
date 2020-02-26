<?php
namespace Application\Model;

use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class User implements InputFilterAwareInterface
{
    protected $inputFilter;
    protected $id;
    protected $username;
    protected $password;
    public function exchangeArray($row)
    {
        $this->id = (!empty($row['id'])) ? $row['id'] : null;
        $this->username = (!empty($row['username'])) ? $row['username'] : null;
        $this->password = (!empty($row['password'])) ? $row['password'] : null;
    }
    public function getId() {
        return $this->id;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }
    
    public function getArrayCopy()
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername()
        ];
    }
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException('This class does not support adding of extra input filters');
    }
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }
        $inputFilter = new InputFilter();
        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);
        $inputFilter->add([
            'name' => 'username',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                'name' => StringLength::class,
                'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 1,
                    'max' => 100,
                    ],
                ],
            ],
        ]);
        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}

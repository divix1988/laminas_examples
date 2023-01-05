<?php
namespace Application\Model\Rowset;

use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class User extends AbstractModel implements InputFilterAwareInterface, \LmcRbacMvc\Identity\IdentityInterface
{
    protected $inputFilter;
    protected $id;
    protected $username;
    protected $password;
    protected $email;
    protected $gender;
    protected $education;
    protected $passwordSalt;
    protected $name;
    protected $role;

    public function exchangeArray($row)
    {
        $this->id = (!empty($row['id'])) ? $row['id'] : null;
        $this->username = (!empty($row['username'])) ? $row['username'] : null;
        $this->password = (!empty($row['password'])) ? $row['password'] : null;
        $this->email = (!empty($row['email'])) ? $row['email'] : null;
	$this->gender = (!empty($row['gender'])) ? $row['gender'] : null;
	$this->education = (!empty($row['education'])) ? $row['education'] : null;
        $this->passwordSalt = (!empty($row['password_salt'])) ? $row['password_salt'] : null;
        $this->name = (!empty($row['name'])) ? $row['name'] : null;
        $this->role = (!empty($row['role'])) ? $row['role'] : null;
    }
    public function getId() {
        return $this->id;
    }
    public function setId($value) {
        $this->id = $value;
        return $this;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }
    
    public function getEmail() {
	return $this->email;
    }
    public function getGender() {
	return $this->gender;
    }
    public function getEducation() {
	return $this->education;
    }
    public function getPasswordSalt() {
        return $this->passwordSalt;
    }
    public function getName() {
        return $this->name;
    }
    public function getRole() {
        return $this->role;
    }
    
    public function getRoles() {
	return [$this->getRole()];
    }

    
    public function getArrayCopy()
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'gender' => $this->getGender(),
            'education' => $this->getEducation(),
            'password' => $this->getPassword(),
            'password_salt' => $this->getPasswordSalt(),
            'name' => $this->getName(),
            'role' => $this->getRole()
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

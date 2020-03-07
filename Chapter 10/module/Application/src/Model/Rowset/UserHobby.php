<?php
namespace Application\Model\Rowset;

class UserHobby extends AbstractModel
{
    protected $userId;
    protected $hobby;

    public function exchangeArray($row)
    {
        $this->id     = (!empty($row['id'])) ? $row['id'] : null;
        $this->userId = (!empty($row['user_id'])) ? $row['user_id'] : null;
        $this->hobby  = (!empty($row['hobby'])) ? $row['hobby'] : null;
    }
     
    public function getId() {
        return $this->id;
    }
    public function setId($value) {
        $this->id = $value;
    }
     
    public function getUserId() {
        return $this->userId;
    }
     
    public function getHobby() {
        return $this->hobby;
    }
     
    public function getArrayCopy()
    {
       return [
           'id' => $this->getId(),
           'user_id' => $this->getUserId(),
           'hobby' => $this->getHobby()
       ];
    }
}


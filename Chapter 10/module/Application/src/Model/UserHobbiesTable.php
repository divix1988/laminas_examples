<?php

namespace Application\Model;

class UserHobbiesTable extends AbstractTable
{
    public function getPlainHobbies($userId)
    {
        $output = [];
        $userHobbies = $this->getByUserId($userId);
        foreach ($userHobbies as $hobbyRow) {
            $output[] = $hobbyRow->getHobby();
        }
        return $output;
    }
    public function getByUserId($userId)
    {
        $rowset = $this->tableGateway->select(array('user_id' => (int) $userId));
        return $rowset;
    }
    public function getBy(array $params = array())
    {
        $results = $this->tableGateway->select($params);
        return $results;
    }
    public function save($userId, array $hobbies)
    {
        //remove old links to hobby
        $this->deleteByUserId($userId);
        foreach ($hobbies as $hobby) {
            $data = [
                'user_id' => $userId,
                'hobby' => $hobby
            ];
            $this->tableGateway->insert($data);
        }
        return true;
    }
    public function deleteByUserId($userId)
    {
        $this->tableGateway->delete(['user_id' => (int) $userId]);
    }
}


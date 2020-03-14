<?php

namespace Application\Model\Rowset;

class Comics extends AbstractModel
{
    public $title;
    public $thumb;
    
    public function exchangeArray($row)
    {
        $this->id = (!empty($row['id'])) ? $row['id'] : null;
        $this->title = (!empty($row['title'])) ? $row['title'] : null;
        $this->thumb = (!empty($row['thumb'])) ? $row['thumb'] : null;
    }
    public function getId() {
        return $this->id;
    }
    public function setId($value) {
        $this->id = $value;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getThumb() {
        return $this->thumb;
    }
    public function getThumbUrl() {
        return $this->baseUrl.'public/uploads/'.$this->thumb;
    }
    public function getArrayCopy()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'thumb' => $this->getThumb()
        ];
    }
}
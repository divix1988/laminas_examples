<?php

namespace Utils\Laminas\Filter;

class FriendlyUrl implements \Laminas\Filter\FilterInterface
{   
    private $separator;

    public function __construct($separator = "-")
    {
        $this->separator = $separator;
    }

    /**
    * converts string into a Friendly URL format
    *
    * @param string $value value in UTF-8 format
    * @return string
    */
    public function filter($value)
    {
        $value = strtolower($value);

        if (function_exists('iconv')) {
            $value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        }
        $value = trim(preg_replace("/[^[a-z0-9]+/", ' ', $value));
        $value = preg_replace("/[\s]/", $this->separator, $value);

        return $value;
    }       
}

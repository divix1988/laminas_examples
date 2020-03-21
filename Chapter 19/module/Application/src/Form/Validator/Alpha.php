<?php

namespace Application\Form\Validator;

use Laminas\Validator\AbstractValidator;
use Laminas\Validator\Regex;

class Alpha extends AbstractValidator
{
    const STRING_EMPTY = 'alphaStringEmpty';
    const INVALID = 'alphaInvalid';
    /**
    * Static instance of Regex class, avoids creating multiple instances of the same class
    *
    * @var Laminas\Validator\Regex
    */
    protected static $regexValidator;
    /**
    * Messages about errors
    *
    * @var array
    */
    protected $messageTemplates = [
            self::STRING_EMPTY => "Element is empty",
            self::INVALID => "Invalid format, required alphanumeric characters ",
    ];
    /**
     * Returns true, if value of $value contains with just characters from a-z
     *
     * @param string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->error(self::INVALID);
            return false;
        }
        $this->setValue((string) $value);

        if (empty($this->getValue())) {
            $this->error(self::STRING_EMPTY);
            return false;
        }
        if (static::$regexValidator == null) {
            static::$regexValidator = new Regex(['pattern' => "/^[a-z]+$/"]);
        }
        if (!static::$regexValidator->isValid($this->getValue())) {
            $this->error(self::INVALID);
            return false;
        }
        return true;
    }
}

<?php

namespace Utils\Security;

class Authentication {
    
    protected $adapter;
    protected $dbAdapter;
    
    public function __construct($dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        $this->adapter = new Adapter(
            $this->dbAdapter,
            'users',
            'email',
            'password',
            'SHA2(CONCAT(password_salt, "'.Helper::SALT_KEY.'", ?), 512)'
        );
    }

    public function authenticate($email, $password) {
        if (empty($email) || empty($password)) {
            return false;
        }
        $this->adapter->setIdentity($email);
        $this->adapter->setCredential($password);
        $result = $this->adapter->authenticate();
        
        return $result;
    }

    public function getIdentity() {
        return $this->getAdapter()->getResultRowObject();
    }

    public function getIdentityArray()
    {
        return json_decode(json_encode($this->adapter->getResultRowObject()), true);
    }

    public function getAdapter() {
        return $this->adapter;
    }
}

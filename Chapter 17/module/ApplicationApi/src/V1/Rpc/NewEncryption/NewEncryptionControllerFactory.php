<?php
namespace ApplicationApi\V1\Rpc\NewEncryption;

class NewEncryptionControllerFactory
{
    public function __invoke($controllers)
    {
        return new NewEncryptionController();
    }
}

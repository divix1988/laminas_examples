<?php
namespace ApplicationApi\V1\Rpc\Encryption;

class EncryptionControllerFactory
{
    public function __invoke($controllers)
    {
        return new EncryptionController();
    }
}

<?php
namespace ApplicationApi\V1\Rpc\Polls;

class PollsControllerFactory
{
    public function __invoke($controllers)
    {
        return new PollsController($controllers->get(\Utils\Polls\Polls::class));
    }
}

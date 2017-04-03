<?php

namespace spec\Purist\Server\Router;

use Psr\Http\Message\RequestInterface;
use Purist\Server\Resource;
use Purist\Server\Router\ResourceRouter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Purist\Server\Router\Router;

class ResourceRouterSpec extends ObjectBehavior
{
    public function let(Resource $resource)
    {
        $this->beConstructedWith($resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ResourceRouter::class);
        $this->shouldImplement(Router::class);
    }

    function it_always_returns_resource(RequestInterface $request, $resource)
    {
        $this->route($request)->shouldReturn($resource);
    }
}

<?php

namespace spec\Yavin\Symfony\Controller;

require_once __DIR__ . '/NormalController.php';
require_once __DIR__ . '/SampleInitController.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class InitControllerSubscriberSpec extends ObjectBehavior
{
    public function it_should_be_event_subscriber()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    public function it_should_listen_to_kernel_controller_event()
    {
        $this::getSubscribedEvents()->shouldReturn(array(
            'kernel.controller' => 'onKernelController',
        ));
    }

    public function it_should_run_init_method(
        FilterControllerEvent $event,
        Request $request,
        SampleInitController $controller
    ) {
        $event->getRequest()->willReturn($request);
        $event->getController()->willReturn(array($controller));
        $controller->init($request)->shouldBeCalled();

        $this->onKernelController($event);
    }

    public function it_should_not_call_init_when_not_implementing_interface(
        FilterControllerEvent $event,
        Request $request,
        NormalController $controller
    ) {
        $event->getRequest()->willReturn($request);
        $event->getController()->willReturn(array($controller));

        $this->onKernelController($event);
    }

    public function it_should_do_nothing_when_controller_is_some_other_callable(
        FilterControllerEvent $event,
        Request $request
    ) {
        $event->getRequest()->willReturn($request);
        $event->getController()->willReturn(array(function() {}));

        $this->onKernelController($event);
    }

    public function it_set_controller_if_init_return_response(
        FilterControllerEvent $event,
        Request $request,
        SampleInitController $controller
    ) {
        $event->getRequest()->willReturn($request);
        $event->getController()->willReturn(array($controller));
        $controller->init($request)->willReturn(new Response('http://example.com/'));

        $event->setController(Argument::allOf(
            Argument::withEntry('0', Argument::type('Yavin\Symfony\Controller\InitControllerSubscriber')),
            Argument::withEntry('1', 'responseAction')
        ))->shouldBeCalled();

        $this->onKernelController($event);
    }
}
